<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $sales = Product::all();
        $categories = Category::all();

        Storage::disk('partitionE')->put('newfile.txt', 'w');
        $filename_with_extension = 'demo.txt';
        $content = "dssdhfjshffdshfhdsfjfhdsfjsd";
        $url = Storage::url('C:\Users\inten\Downloads\4.jpg');
                // dd($url);
        
        return view('dashboard',[
            "sales"=>$sales,
            "categories"=>$categories,
        ]);
        
        
    }
}
