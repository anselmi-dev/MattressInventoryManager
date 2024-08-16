<?php

namespace App\Imports;

use App\Models\Code;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\DB;

class SalesImport implements ToModel, WithHeadingRow, WithEvents, WithChunkReading, WithBatchInserts
{

    protected $errors = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = str_replace('ArtÍculo: ', '', $row['producto']);
    
        list($code, $description) = explode(" - ", $product);

        $model_code = Code::where('value', $code)->first();

        if (!$model_code) {
            $this->errors[] = new Failure(count($this->errors) + 1, $code, ["No se encontró registro para el código '{$code}'"], array([]));
        }

        return new Sale([
            'code' => $code,
            'description' => $description,
            'quantity' => $row['unidades'],
        ]);
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
