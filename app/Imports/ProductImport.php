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
    AssociateDimensionProductJob
};

class ProductImport implements ToCollection, WithHeadingRow, WithEvents, WithChunkReading, WithBatchInserts
{
    protected $errors = [];

    public function collection (Collection $rows)
    {
        foreach ($rows as $key => $row) {
            Product::withoutEvents(function () use ($row) {
                $attributes = $this->getAttributeDataByRow($row);
                
                $product = Product::withoutGlobalScopes()->withTrashed()->updateOrCreate([
                    'reference' => $attributes->code,
                    'code' => $attributes->code,
                ], [
                    'name'  => $attributes->name,
                    'stock' => $attributes->stock,
                    'type'  => $attributes->type
                ]);

                $product->restore();
        
                // ASIGNAR PRODUCTOS SI ES UNA COMBINACIÓN
                if (count($attributes->codes)) {
                    $queryProduct = Product::withoutGlobalScopes()
                        ->withTrashed()
                        ->whereIn('code', $attributes->codes)
                        ->get();

                    $parts = [];
                    foreach ($queryProduct as $key => $part) {
                        $part->restore();
                        $parts[] = $part->id;
                    }
                    
                    $diff = array_diff($attributes->codes, $queryProduct->pluck('code')->toArray());

                    $product->combinedProducts()->sync($parts);

                    if (count($diff)) {
                        $this->errors[] = new Failure(count($this->errors) + 1, $product->code, ["LA COMBINACIÓN <b>'{$product->code}'</b> NO ENCONTRÓ LA(S) PARTES(S): <b>" . implode(',', $diff) . "</b>"], array([]));
                    }
                }

                // INDICAR SI EL PRODUCTO NO SE ENCONTRÓ EL TIPO
                if ($attributes->type == 'OTROS') {
                    $this->errors[] = new Failure(count($this->errors) + 1, $product->code, ["EL CÓDIGO '{$product->code}' SE ASIGNÓ COMO 'OTROS'"], array([]));
                }

                // Comprobamos que el producto fué creado recientemente para asignar el tipo de producto
                if (!$product->dimension) {
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

    protected function getAttributeDataByRow ($row)
    {
        $referencia_piezas = isset($row['referencia_piezas']) ? explode(',', $row['referencia_piezas']) : [];

        $referencia_piezas = array_map('trim', $referencia_piezas);

        return (object) [
            'type'   => $this->getTypeByString($row['tipo']),
            'code'   => trim($row['referencia_colchon'] ?? $row['referencia']),
            'name'   => trim($row['nombre']),
            'stock'  => (int) rtrim(
                str_replace('UNIDADES', '', strtoupper(
                    $row['stock'] ?? $row['stock_actual']
                ))
            ),
            'codes'  => $referencia_piezas
        ];
    }

    /**
     * Obtener el código mendiante el tipo que proviene del excel
     *
     * @param string $type
     * @return string
     */
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
            case 'NUCLEO':
                return 'NUCLEO';
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
