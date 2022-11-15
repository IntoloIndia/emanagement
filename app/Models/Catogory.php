<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catogory extends Model
{
    use HasFactory;
    protected $table = "categories";

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}