<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    //
    public function index()
    {

        return view('product',[]);
    }
}
