<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsByCategoryExport implements FromCollection, WithHeadings
{
    protected $category_id;

    // Accept category_id through the constructor
    public function __construct($category_id)
    {
        $this->category_id = $category_id;
    }

    public function collection()
    {
        // Get the category and its descendants
        $category = Category::with('descendants')->find($this->category_id);
        $categoryIds = $category->descendants->pluck('id')->toArray();
        $categoryIds[] = $this->category_id;

        // Fetch products where category_id is in the list of category and its descendants
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('status', 1) // Assuming 'status' is the field for active products
            ->get();

        // Map the products and calculate total stock value
        return $products->map(function($product) {
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

