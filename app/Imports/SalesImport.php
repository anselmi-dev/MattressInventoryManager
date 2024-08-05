<?php

namespace App\Imports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = str_replace('ArtÍculo: ', '', $row['producto']);
    
        list($code, $description) = explode(" - ", $product);

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
}
