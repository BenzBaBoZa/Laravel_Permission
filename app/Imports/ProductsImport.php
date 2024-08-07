<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'title'       => $row['title'],
            'price'       => $row['price'],
            'product_code'=> $row['product_code'],
            'description' => $row['description'],
            // เพิ่มฟิลด์อื่น ๆ ที่ต้องการนำเข้า
        ]);
    }
}
