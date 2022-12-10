<?php

namespace App\Imports;

use App\Models\PurchaseEntry;
// use App\Models\Month;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProduct implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PurchaseEntry([
            'supplier_id' => $row['supplier_id'],
            'product_code' => $row['product_code'],
            'category_id' => $row['category_id'],
            'sub_category_id' => $row['sub_category_id'],
            'product' => $row['product'],
            'qty' => $row['qty'],
            'purchase_price' => $row['purchase_price'],
            'sales_price' => $row['sales_price'],
            'gst_no' => $row['gst_no'],
            'bill_no' => $row['bill_no'],
            'hsn_code' => $row['hsn_code'],
            'size_id' => $row['size_id'],
            'color_id' => $row['color_id'],
            
        ]);
    }
}
