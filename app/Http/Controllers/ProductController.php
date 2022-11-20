<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use Validator;
use Picqer;

class ProductController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('product',[
            "categories"=>$categories,
            'sizes' => $sizes,
            'colors'=> $colors
        ]);
    }

    function saveProduct(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'category_id' => 'required|max:191',
            'sub_category_id'=>'required|max:191',
            'product_name'=>'required|max:191',
            'price'=>'required|max:191',
            'size_id'=>'required|max:191',
            'color_id'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz  all field required"),
            ]);
        }else{

            $product_code = rand(0000000001,9999999999);
            $generate = new Picqer\Barcode\BarcodeGeneratorHTML();
            $barcode = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 2, 60);
            return $barcode;
            
            $model = new Product;
            $model->category_id = $req->input('category_id');
            $model->sub_category_id = $req->input('sub_category_id');
            $model->product = $req->input('product_name');
            $model->price = $req->input('price');
            $model->size = $req->input('size_id');
            $model->color = $req->input('color_id');
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }

}
