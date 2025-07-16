<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Fetch products and calculate total stock value
        return Product::select('name','num_of_sale', 'stock', 'sell_price')
            ->get()
            ->map(function($product) {
                return [
                    'name' => $product->name,
                    'num_of_sale' => $product->num_of_sale,
                    'stock' => $product->stock,
                    'sell_price' => $product->sell_price,
                    'total_stock_value' => $product->stock * $product->sell_price
                ];
            });
    }

    // Add headings to the export file
    public function headings(): array
    {
        return [
            'Product Name',
            'Num Of Sale',
            'Total Stock',
            'Unit Price',
            'Total Stock Value'
        ];
    }
}


