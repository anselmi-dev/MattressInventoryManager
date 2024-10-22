<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;

use App\Jobs\{
    AssociateDimensionProductJob,
    AssociateProductTypeJob
};

class ProductImport implements ToCollection, WithHeadingRow, WithEvents, WithChunkReading, WithBatchInserts
{
    protected $errors = [];

    public function collection (Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if (!isset($row['referencia_colchon']) || (isset($row['referencia_colchon']) && is_null(trim($row['referencia_colchon']))) || is_null($row)) {
                continue;
            }

            Product::withoutEvents(function () use ($row) {
                $tipo = $this->getTypeByString($row['tipo']);

                $product = Product::withoutGlobalScopes()->updateOrCreate([
                    'code' => trim($row['referencia_colchon']),
                ], [
                    'reference' => trim($row['referencia_colchon']),
                    'name' => $row['nombre'],
                    'stock' => (int)str_replace(' UNIDADES', '', strtoupper(trim($row['stock']))),
                    'type' => $tipo,
                ]);
        
                if ($tipo == 'COLCHON') {
                    $codes = array_map('trim', explode(',', $row['referencia_piezas']));

                    $parts = Product::whereIn('code', $codes)->get()->pluck('id')->toArray();

                    $product->combinedProducts()->sync($parts);

                    if (count($codes) != count($parts))
                        $this->errors[] = new Failure(count($this->errors) + 1, $product->code, ["LA COMBINACIÓN '{$product->code}' NO ENCONTRÓ TODAS LAS PARTES"], array([]));
                }

                // Comprobamos que el producto fué creado recientemente para asignar el tipo de producto
                if ($product->wasRecentlyCreated) {
                    AssociateDimensionProductJob::dispatchSync($product);
                }
            });
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                if (count($this->errors))
                    throw new \Maatwebsite\Excel\Validators\ValidationException(
                        \Illuminate\Validation\ValidationException::withMessages([]),
                        $this->errors
                    );
            },
        ];
    }
    
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }

    public function getTypeByString (string $type)
    {
        switch (strtoupper($type)) {
            case 'COLCHON':
            case 'COLCHÓN':
                return 'COLCHON';
                break;
            case 'FUNDA':
                return 'FUNDA';
                break;
            case 'ALMOHADA':
                return 'ALMOHADA';
                break;
            case 'NIDO':
                return 'NIDO';
                break;
            case 'SABANA':
            case 'SÁBANA':
                return 'SABANA';
                break;
            default:
                return 'OTRO';
                break;
        }
    }
}
