<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $sales = Product::all();
        $categories = Category::all();
        return view('dashboard',[
            "sales"=>$sales,
            "categories"=>$categories
        ]);
        

        // return response()->json([
        //     'status'=>200,
        //     'messege'=>"ok",
        // ]);
    }
}
