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
use DNS1D;
use DNS2D;
use QrCode;

class ProductController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();

        //  DNS2D::getBarcodeHTML('4445645656', 'QRCODE');

        // $barcode = 'data:image/png;base64,' . DNS2D::getBarcodePNG('4', 'PDF417')  ;
        // return $barcode;
        // $product_code = rand(0000000001,9999999999);
        // // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        // // $barcode = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 40);
        // $barcode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';
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


            $product_code = rand(000001,999999);
            // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
            // $barcode = $generator->getBarcode($product_code, $generator::TYPE_STANDARD_2_5, 1, 40);

            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            // $barcode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';
            $barcode = 'data:image/png;base64,' . base64_encode($generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 50)) ;


            $model = new Product;
            $model->product_code = $product_code;
            $model->category_id = $req->input('category_id');
            $model->sub_category_id = $req->input('sub_category_id');
            $model->product = $req->input('product_name');
            $model->qty = $req->input('qty');
            $model->price = $req->input('price');
            $model->size_id = $req->input('size_id');
            $model->color_id = $req->input('color_id');
            $model->barcode = $barcode;
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
           
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
            $product_code = rand(000001,999999);
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            // $barcode = $generator->getBarcode($product_code, $generator::TYPE_STANDARD_2_5, 1, 40);

            
            $barcode = 'data:image/png;base64,' . base64_encode($generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 50)) ;


            $model =  Product::find($product_id);
            $model->product_code = $product_code;
            $model->category_id = $req->input('category_id');
            $model->sub_category_id = $req->input('sub_category_id');
            $model->product = $req->input('product_name');
            $model->qty = $req->input('qty');
            $model->price = $req->input('price');
            $model->size_id = $req->input('size_id');
            $model->color_id = $req->input('color_id');
            $model->date = date('Y-m-d');
            $model->barcode = $barcode;
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

    public function getBarcode()
    {
        $products = Product::Join('categories','categories.id','=','products.category_id')
                ->join('sub_categories','sub_categories.id','=','products.sub_category_id')
                ->join('sizes','sizes.id','=','products.size_id')
                ->join('colors','colors.id','=','products.color_id')
                ->get(['products.*','categories.category',
                    'sub_categories.sub_category',
                    'sizes.size',
                    'colors.color'
                ]);


                $html = "";
                $html .="<div class='modal-dialog modal-sm'>";
                    $html .="<div class='modal-content'>";
                        $html .="<div class='modal-header'>";
                            $html .="<h5 class='modal-title' id='staticBackdropLabel'>Invoice</h5>";
                            $html .="<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        $html .="</div>";
        
                            $html .="<div class='modal-body-wrapper'>";
        
        
                                $html .="<div class='modal-body' id='show_barcode_body'>";
            
                                    $html .="<div class='row text-center'>";
                                        $html .="<h5><b>Shivhare Hotel</b></h5>";
                                        $html .="<small>Dhuma</small>";
                                    $html .="</div>";
                                    $html .="<hr>";
                                    foreach ($products as $key => $list) {
                                        $html .="<div class='row' style='page-break-after: always;'>";
                                            $html .="<div class='col-md-6'>";
                                                $html .="<span>Bill No : <small>1</small></span><br>";
                                                $html .="<span>Payment : <small>2</small></span> ";
                                                $html .="</div>";
                                                $html .="<div class='col-md-6 '>";
                                                // $html .="<span class='float-end'>Date : <small>3</small></span><br>";
                                                // $html .="<span class='float-end'>Time : <small>4</small></span> ";
                                                $html .="<img src='".asset('public/assets/barcodes/barcode.gif')."' > ";
                                            $html .="</div>";
                                        $html .="</div>";
                                        $html .="<hr>";
                                    }
                                    // $html .="<div class='row'>";
                                    //     $html .="<table class='table table-striped'>";
                                    //         $html .="<thead>";
                                    //             $html .="<tr>";
                                    //                 $html .="<th>#</th>";
                                    //                 $html .="<th>Item Name</th>";
                                    //                 $html .="<th>Rate</th>";
                                                    
                                    //             $html .="</tr>";
                                    //         $html .="</thead>";
                                    //         $html .="<tbody>";
                                    //         foreach ($products as $key => $list) {
                                    //             $html .="<tr>";
                                    //                 $html .="<td>".++$key."</td>";
                                    //                 // $html .="<td>".ucwords($list->item_name)."</td>";
                                    //                 // $html .="<td>".$list->price."</td>";
                                    //                 // $html .="<td>".$list->qty."</td>";
                                    //                 // $html .="<td>".$list->amount."</td>";
                                    //             $html .="</tr>";
                                    //         }
                                                
                                    //         $html .="</tbody>";
                                    //         $html .="<tfoot>";
                                    //             $html .="<tr>";
                                    //                 $html .="<td colspan='2'></td>";
                                    //                 $html .="<td><b>Total :</b></td>";
                                    //                 // $html .="<td>".$key."</td>";
                                    //                 // $html .="<td>".$order->total_amount."</td>";
                                    //             $html .="</tr>";
                                    //         $html .="</tfoot>";
                                    //     $html .="</table>";
                                    // $html .="</div>";

                                    // $html .="<hr>";

                                    // $html .="<div class='row text-center'>";
                                    //     $html .="<h6><b>Thank You Have a Nice Day </b></h6>";
                                    //     $html .="<small>Visit Again !</small>";
                                    // $html .="</div>";
            
                                $html .="</div>";
            
        
                            $html .="</div>";
        
                            $html .="<div class='modal-footer'>";
                                $html .="<button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Close</button>";
                                $html .="<button type='button' id='printBtn' class='btn btn-primary btn-sm' order-id=''>Print</button>";
                            $html .="</div>";
        
                    $html .="</div>";
                $html .="</div>";

            return response()->json([
                'status'=>200,
                'html'=>$html
            ]);

        // return view('barcode',[
        //     'products' => $products
        // ]);
    }

    public function getcolorcode($color_code)
    {
        // $color = Color::where(['color_code'=>$color_code])->first('color');
        // print_r($product);
        $color = Color::find($color_code);
                        
        return response()->json([
            'color'=>$color
        ]);

    }

}
