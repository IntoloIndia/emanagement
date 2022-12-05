<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseEntry extends Model
{
    use HasFactory;
    protected $table = "purchase_entries";

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = ['supplier_id','product_code',
    'category_id','sub_category_id',
    'product','qty','purchase_price','sales_price',
    'gst_no','bill_no','hsn_code','size_id','color_id'
];
}
