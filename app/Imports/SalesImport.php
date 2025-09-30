<?php

namespace App\Imports;

use App\Models\Code;
use App\Models\Product;
use App\Models\FactusolSale;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;

class SalesImport implements ToCollection, WithHeadingRow, WithEvents, WithChunkReading, WithBatchInserts
{
    protected $errors = [];

    public function collection (Collection $rows)
    {
        foreach ($rows as $key => $row) {
            $product = str_replace('ArtÍculo: ', '', $row['producto']);

            list($code, $description) = explode(" - ", $product);

            $product = Product::where('code', $code)->first();

            $sale = new Sale([
                'description' => $description,
                'quantity' => $row['unidades'],
            ]);

            if (!$product) {
                $this->errors[] = new Failure(count($this->errors) + 1, $code, ["No se encontró registro para el código '{$code}'"], array([]));
            }

            $sale->save();

            if ($product) {
                $sale->products()->attach($product, ['quantity' => $row['unidades']]);
                foreach ($product->combinedProducts as $key => $combinedProduct) {
                    $sale->products()->attach($combinedProduct, ['quantity' => $row['unidades']]);
                }
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
