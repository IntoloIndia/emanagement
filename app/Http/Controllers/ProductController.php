<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use Validator;
class ProductController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $products = Product::Join('categories','categories.id','=','products.category_id')
                    ->join('sub_categories','sub_categories.id','=','products.sub_category_id')
                    ->join('sizes','sizes.id','=','products.size')
                    ->join('colors','colors.id','=','products.color')
    
        ->get(['products.*','categories.category',
        'sub_categories.sub_category',
        'sizes.size',
        'colors.color'
    ]);
        return view('product',[
            "categories"=>$categories,
            'sizes' => $sizes,
            'colors'=> $colors,
            'products' => $products
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
            $product_code = (rand(00000001,99999999));

            $model = new Product;
            $model->product_code = $product_code;
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

    
    public function editProduct($product_id)
    
    {
        // alert($product_id);
        $product = Product::find($product_id);
        return response()->json([
            'status'=>200,
            'product'=>$product
        ]);
    }


    public function updateProduct(Request $req, $product_id)
    {
        $validator = Validator::make($req->all(),[
            // 'category_id' => 'required|max:191',
            // 'sub_category_id'=>'required|max:191',
            // 'product_name'=>'required|max:191',
            // 'price'=>'required|max:191',
            // 'size_id'=>'required|max:191',
            // 'color_id'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model =  Product::find($product_id);
            // $model->product_code = $product_code;
            $model->category_id = $req->input('category_id');
            $model->sub_category_id = $req->input('sub_category_id');
            $model->product = $req->input('product_name');
            $model->price = $req->input('price');
            $model->size = $req->input('size_id');
            $model->color = $req->input('color_id');
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function deleteProduct($product_id)
    {
        $delete_product = Product::find($product_id);
        $delete_product->delete();
        return response()->json([
            'status'=>200
        ]);
    }

}
