<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Validator;

class ProductController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        return view('product',[
            "categories"=>$categories
        ]);
    }
}
