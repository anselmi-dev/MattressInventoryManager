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
            if (!isset($row['referencia']) || (isset($row['referencia']) && is_null(trim($row['referencia']))) || is_null($row)) {
                continue;
            }

            $product = Product::withoutGlobalScopes()->firstOrCreate([
                'code' => trim($row['referencia']),
            ], [
                'reference' => trim($row['referencia']),
                'name' => $row['nombre'],
                'stock' => (int)str_replace(' UNIDADES', '', strtoupper(trim($row['tipo']))),
                'type' => $row['tipo'],
            ]);
    
            // Comprobamos que el producto fué creado recientemente para asignar el tipo de producto
            if ($product->wasRecentlyCreated) {
                AssociateDimensionProductJob::dispatchSync($product);
            } else {
                $this->errors[] = new Failure(count($this->errors) + 1, $product->code, ["La parte '{$product->code}' ya estaba creada"], array([]));
            }
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
}
