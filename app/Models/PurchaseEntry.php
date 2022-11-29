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
}
