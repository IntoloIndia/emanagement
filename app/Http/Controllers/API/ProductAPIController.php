<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class ProductAPIController extends Controller
{
    //
    public function getProduct()
    {
        $products = Product::join('categories', 'products.category_id','=','categories.id')
                ->join('sub_categories','products.sub_category_id','=','sub_categories.id')
                ->join('sizes','products.size_id','=','sizes.id')
                ->join('colors','products.color_id','=','colors.id')
    //             ->where('projects.user_id', $user_id)
                ->get(['products.id','products.product_code', 'products.product', 'products.price','categories.category', 'sub_categories.sub_category', 'sizes.size', 'colors.color']);

        return response()->json([
            'data'=>$products,
        ]); 
    }

}
