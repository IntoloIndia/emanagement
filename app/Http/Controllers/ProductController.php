<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
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
        // $product_code = rand(0000000001,9999999999);
        // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // $barcode = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 2, 40);
        // return $barcode;
        $products = Product::Join('categories','categories.id','=','products.category_id')
                ->join('sub_categories','sub_categories.id','=','products.sub_category_id')
                ->join('sizes','sizes.id','=','products.size_id')
                ->join('colors','colors.id','=','products.color_id')
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
            'qty'=>'required|max:191',
            'price'=>'required|max:191',
            'size_id'=>'required|max:191',
            'color_id'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{

<<<<<<< HEAD
            $product_code = rand(0000000001,9999999999);
            // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
            // $barcode = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 2, 60);
=======
            $product_code = rand(0000000001,9999999999); 
            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
            $barcode = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 2, 60);
>>>>>>> 42abccd2fb762907d6c56fdab90c70b01774b0a1
            // $product_code = (rand(00000001,99999999));

            $model = new Product;
            $model->product_code = $product_code;
            $model->category_id = $req->input('category_id');
            $model->sub_category_id = $req->input('sub_category_id');
            $model->product = $req->input('product_name');
            $model->qty = $req->input('qty');
            $model->price = $req->input('price');
            $model->size_id = $req->input('size_id');
            $model->color_id = $req->input('color_id');
<<<<<<< HEAD
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');

=======
>>>>>>> 42abccd2fb762907d6c56fdab90c70b01774b0a1
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }

    
    public function editProduct($product_id)
    {
        $product = Product::find($product_id);

        $sub_category = SubCategory::where(['category_id'=>$product->category_id])->get();

        $html = "";
        $html .= "<option disabled>Choose...</option>";
        foreach ($sub_category as $key => $list) {
            if ($list->id == $product->sub_category_id) {
                $html .= "<option selected value='".$list->id."'>".ucwords($list->sub_category)."</option>";
            } else {
                $html .= "<option value='".$list->id."'>".ucwords($list->sub_category)."</option>";
            }
        }

        return response()->json([
            'status'=>200,
            'product'=>$product,
            'html'=>$html
        ]);
    }


    public function updateProduct(Request $req, $product_id)
    {
        $validator = Validator::make($req->all(),[
            'category_id' => 'required|max:191',
            'sub_category_id'=>'required|max:191',
            'product_name'=>'required|max:191',
            'price'=>'required|max:191',
            'size_id'=>'required|max:191',
            'color_id'=>'required|max:191',
            'qty'=>'required|max:191',
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
            $model->qty = $req->input('qty');
            $model->price = $req->input('price');
            $model->size_id = $req->input('size_id');
            $model->color_id = $req->input('color_id');
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');

           
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
