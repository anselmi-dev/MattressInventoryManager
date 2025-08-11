<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithStrictNullComparison, WithColumnFormatting
{
    public function collection()
    {
        return Product::averageSalesForLastDays()->get();
    }

    public function headings(): array
    {
        return [
            'Código',
            'Referencia',
            'Nombre',
            'Ventas Promedio',
            'Stock',
            'Tipo',
            'Creado',
            'Actualizado'
        ];  
    }

    public function map($product): array
    {
        return [
            $product->code,
            $product->reference . ' ',
            $product->name,
            $product->TOTAL_SALES ?? 0,
            $product->stock ?? 0,
            $product->type,
            $product->created_at->format('Y-m-d H:i:s'),
            $product->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => '@',
            'B' => '@',
            'C' => '@',
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_NUMBER,
            'F' => '@',
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
