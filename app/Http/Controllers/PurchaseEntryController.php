<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\StyleNo;
use App\Models\Size;
use App\Models\Color;
use App\Models\Supplier;
use App\Models\Brand;

use Validator;
use Picqer;
use DNS1D;
use DNS2D;
use QrCode;

use App\Imports\ImportProduct;
use App\Exports\ExportProduct;

use Maatwebsite\Excel\Facades\Excel;


class PurchaseEntryController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();

        //  DNS2D::getBarcodeHTML('4445645656', 'QRCODE');

        // $barcode = 'data:image/png;base64,' . DNS2D::getBarcodePNG('4', 'PDF417')  ;
        // return $barcode;
        // $product_code = rand(0000000001,9999999999);
        // // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        // $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        // // $barcode = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 40);
        // $barcode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';
        // return $barcode;



        // $products = PurchaseEntry::Join('suppliers','suppliers.id','=','purchase_entries.supplier_id')
                // ->Join('categories','categories.id','=','purchase_entries.category_id')
                // ->join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                // ->get(['purchase_entries.*',
                //     'suppliers.supplier_name',
                //     'categories.category',
                //     'sub_categories.sub_category',
                // ]);

        return view('purchase_entry',[
            "categories"=>$categories,
            'sizes' => $sizes,
            'colors'=> $colors,
            'brands'=> $brands,
            // 'products' => $products,
            'suppliers' => $suppliers
        ]);
    }

    function savePurchaseEntry(Request $req)
    {
        // if ($req->input('xs_qty') == null || $req->input('s_qty'); ) {
        //     # code...
        // }

        // if($req->input('country_id') > 0)
        // {
        //     $country = 'required|unique:countries,country,'.$req->input('country_id');
        //     $country_short = 'required|unique:countries,country_short,'.$req->input('country_id');
        //     // $category_img = 'mimes:jpeg,png,jpg|max:1024|dimensions:max-width=480,max-height=336';
        //     $model = Country::find($req->input('country_id'));
        // }else{
        //     $country = 'required|unique:countries,country,'.$req->input('country');
        //     $country_short = 'required|unique:countries,country_short,'.$req->input('country_short');
        //     $model = new Country ;
        // }



        $validator = Validator::make($req->all(),[
            'supplier_id' => 'required|max:191',
            'bill_no'=>'required|max:191',
            // 'bill_no'=>'required|unique:purchase_entries,bill_no,'.$req->input('bill_no'),
            'bill_date'=>'required|max:191',
            'payment_days'=>'required|max:191',
            'category_id'=>'required|max:191',
            'sub_category_id'=>'required|max:191',
            'brand_id'=>'required|max:191',
            'style_no_id'=>'required|max:191',
            'color'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $purchase_id = 0;

            $data = Purchase::where(['supplier_id'=>$req->input('supplier_id'),'bill_no'=>$req->input('bill_no')])->first('id');
            
            if ($data == null) {
                $model = new Purchase;
                
                $model->supplier_id = $req->input('supplier_id');
                $model->bill_no = $req->input('bill_no');
                $model->bill_date = $req->input('bill_date');
                $model->payment_days = $req->input('payment_days');
                $model->time = date('g:i A');
                $model->save();
                
                $purchase_id = $model->id;
            }else{
                $purchase_id = $data->id;
            }
            
            $category_id = $req->input('category_id');
            $sub_category_id = $req->input('sub_category_id');
            $brand_id = $req->input('brand_id');
            $style_no_id = $req->input('style_no_id');
            $color = $req->input('color');
            $product_image = $req->input('product_image');
            
            $purchase_entry_data = PurchaseEntry::where(['purchase_id'=>$purchase_id,'style_no_id'=>$style_no_id, 'color'=>$color])->first('id');
            $purchase_entry_id = 0;
            if ($purchase_entry_data == null) {
                $purchase_entry = new PurchaseEntry;

                $purchase_entry->purchase_id = $purchase_id;
                $purchase_entry->category_id = $category_id;
                $purchase_entry->sub_category_id = $sub_category_id;
                $purchase_entry->brand_id = $brand_id;
                $purchase_entry->style_no_id = $style_no_id;
                $purchase_entry->color = $color;
                if ($product_image != " ") {
                    $purchase_entry->img = $product_image;
                }

                $purchase_entry->save();

                $purchase_entry_id = $purchase_entry->id;
            }else{
                $purchase_entry_id = $purchase_entry_data->id;
            }

            $xs_qty = $req->input('xs_qty');
            $s_qty = $req->input('s_qty');
            $m_qty = $req->input('m_qty');
            $l_qty = $req->input('l_qty');
            $xl_qty = $req->input('xl_qty');
            $xxl_qty = $req->input('xxl_qty');

            $xs_price = $req->input('xs_price');
            $s_price = $req->input('s_price');
            $m_price = $req->input('m_price');
            $l_price = $req->input('l_price');
            $xl_price = $req->input('xl_price');
            $xxl_price = $req->input('xxl_price');

            $xs_mrp = $req->input('xs_mrp');
            $s_mrp = $req->input('s_mrp');
            $m_mrp = $req->input('m_mrp');
            $l_mrp = $req->input('l_mrp');
            $xl_mrp = $req->input('xl_mrp');
            $xxl_mrp = $req->input('xxl_mrp');

            $qty = 0;
            $size = "";
            $price = 0;
            $mrp = 0;

            if ($xs_qty > 0) {
                $qty = $xs_qty;
                $size = 'xs';
                $price = $xs_price;
                $mrp = $xs_mrp;
                $result = $this->saveItem($purchase_entry_id, $qty, $size, $price, $mrp);                
            }

            if ($s_qty > 0) {
                $qty = $s_qty;
                $size = 's';
                $price = $s_price;
                $mrp = $s_mrp;
                $result = $this->saveItem($purchase_entry_id, $qty, $size, $price, $mrp);             
            }

            if ($m_qty > 0) {
                $qty = $m_qty;
                $size = 'm';
                $price = $m_price;
                $mrp = $m_mrp;
                $result = $this->saveItem($purchase_entry_id, $qty, $size, $price, $mrp); 
            }

            if ($l_qty > 0) {
                $qty = $l_qty;
                $size = 'l';
                $price = $l_price;
                $mrp = $l_mrp;
                $result = $this->saveItem($purchase_entry_id, $qty, $size, $price, $mrp); 
            }

            if ($xl_qty > 0) {
                $qty = $xl_qty;
                $size = 'xl';
                $price = $xl_price;
                $mrp = $xl_mrp;
                $result = $this->saveItem($purchase_entry_id, $qty, $size, $price, $mrp); 
            }

            if ($xxl_qty > 0) {
                $qty = $xxl_qty;
                $size = 'xxl';
                $price = $xxl_price;
                $mrp = $xxl_mrp;
                $result = $this->saveItem($purchase_entry_id, $qty, $size, $price, $mrp); 
            }
            

            // $qty = $req->input('qty');
            // for ($i=0; $i < $qty; $i++) 
            // { 
            //     $product_code = rand(000001,999999);
               
            //     $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
               
            //     $barcode = 'data:image/png;base64,' . base64_encode($generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 50)) ;
                
            //     $model = new PurchaseEntry;
            //     $model->product_code = $product_code;
            //     $model->category_id = $req->input('category_id');
            //     $model->supplier_id = $req->input('supplier_id');
            //     $model->sub_category_id = $req->input('sub_category_id');
            //     $model->product = $req->input('product_name');
            //     $model->qty = 1;
            //     $model->sales_price = $req->input('sales_price');
            //     $model->purchase_price = $req->input('purchase_price');
            //     $model->bill_no = $req->input('bill_no');
            //     $model->size = $req->input('size');
            //     $model->color = $req->input('color');
            //     $model->barcode = $barcode;
            //     $model->date = date('Y-m-d');
            //     $model->time = date('g:i A');

            //     if ($model->save()) {
            //         $imageModal = new ProductImage;
            //         $imageModal->product_id = $model->id;
            //         $imageModal->product_image = $req->input('product_image');
            //         $imageModal->save();
            //     }
            // }

            $purchase_entry_html = $this->getPurchaseEntry($req->input('supplier_id'), $req->input('bill_no'));

            return response()->json([   
                'status'=>200,
                'html'=>$purchase_entry_html['html'],
            ]);
        }
    }

    public function saveItem($purchase_entry_id, $qty, $size, $price, $mrp){

        for ($i=0; $i < $qty; $i++) 
        { 
            $purchase_item = new PurchaseEntryItem;
            $purchase_item->purchase_entry_id = $purchase_entry_id;
            $purchase_item->size = $size;
            $purchase_item->price = $price;
            $purchase_item->mrp = $mrp;
            // $purchase_item->time = date('g:i A');
            $purchase_item->save();
        }

        return 'ok';
    }

    public function getPurchaseEntry($supplier_id, $bill_no){

        $data = Purchase::where(['supplier_id'=>$supplier_id, 'bill_no'=>$bill_no])->first('id');

        $html = "";
        if ($data == null) {
            $html .="<div class='alert alert-warning text-light my-2' role='alert'>";
                $html .="<span>Purchase entry is not available</span>";
            $html .="</div>";

            return $result = [
                'status'=>200,
                'html'=>$html
            ] ;
        }                       

            $purchase_entry = PurchaseEntry::Join('style_nos','style_nos.id','=','purchase_entries.style_no_id')
                // ->Join('categories','categories.id','=','purchase_entries.category_id')
                // ->join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                ->where('purchase_entries.purchase_id', '=', $data->id)
                ->get(['purchase_entries.*','style_nos.style_no']);

                $html .="<table class='table table-bordered'>";
                    $html .="<thead>";
                    $html .="<tr>";
                        $html .="<th>SN</th>";
                        $html .="<th>Style</th>";
                        $html .="<th>Color</th>";
                        $html .="<th>Qty</th>";
                        $html .="<th>Action</th>";
                        
                    $html .="</tr>";
                $html .="</thead>";
                $html .="<tbody>";
                    foreach ($purchase_entry as $key => $list) {
                        // dd($list);
                        $html .="<tr>";
                            $html .="<td>".++$key."</td>";
                            $html .="<td>".ucwords($list->style_no)."</td>";
                            $html .="<td>".ucwords($list->color)."</td>";
                            // $html .="<td>".$list->size."</td>";
                           
                        $html .="</tr>";
                    }
                $html .="</tbody>";
                $html .="</table>";

                return $result = [
                    'status'=>200,
                    'html'=>$html
                ] ;

                // return response()->json([
                //     'status'=>200,
                //     'html'=>$html
                // ]);


    }

    // function saveProduct(Request $req)
    // {

    //     $validator = Validator::make($req->all(),[
    //         'category_id' => 'required|max:191',
    //         'supplier_id' => 'required|max:191',
    //         'sub_category_id'=>'required|max:191',
    //         'product_name'=>'required|max:191',
    //         'qty'=>'required|max:191',
    //         'purchase_price'=>'required|max:191',
    //         'sales_price'=>'required|max:191',
    //         'bill_no'=>'required|max:191',
    //         'size'=>'required|max:191',
    //         'color'=>'required|max:191',
    //     ]);

    //     if($validator->fails())
    //     {
    //         return response()->json([
    //             'status'=>400,
    //             'errors'=>$validator->messages(),
    //         ]);
    //     }else{

    //         $qty = $req->input('qty');
    //         for ($i=0; $i < $qty; $i++) 
    //         { 
    //             $product_code = rand(000001,999999);
    //             //------------------------------------------------------
    //             // $generator = new Picqer\Barcode\BarcodeGeneratorHTML();//commented
    //             // $barcode = $generator->getBarcode($product_code, $generator::TYPE_STANDARD_2_5, 1, 40);//commented
    //             //-----------------------------------------------
    //             $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                
    //             //------------------------------------------------------
    //             // $barcode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';//commented
    //             //------------------------------------------------------
    //             $barcode = 'data:image/png;base64,' . base64_encode($generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 50)) ;
                
    //             $model = new PurchaseEntry;
    //             $model->product_code = $product_code;
    //             $model->category_id = $req->input('category_id');
    //             $model->supplier_id = $req->input('supplier_id');
    //             $model->sub_category_id = $req->input('sub_category_id');
    //             $model->product = $req->input('product_name');
    //             $model->qty = 1;
    //             $model->sales_price = $req->input('sales_price');
    //             $model->purchase_price = $req->input('purchase_price');
    //             $model->bill_no = $req->input('bill_no');
    //             $model->size = $req->input('size');
    //             $model->color = $req->input('color');
    //             $model->barcode = $barcode;
    //             $model->date = date('Y-m-d');
    //             $model->time = date('g:i A');
    //             if ($model->save()) {
    //                 $imageModal = new ProductImage;
    //                 $imageModal->product_id = $model->id;
    //                 $imageModal->product_image = $req->input('product_image');
    //                 $imageModal->save();
    //             }
    //         }

    //         return response()->json([   
    //             'status'=>200
    //         ]);
    //     }
    // }

    
    public function editProduct($product_id)
    {
        $product = PurchaseEntry::find($product_id);
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
            // 'price'=>'required|max:191',
            'size'=>'required|max:191',
            'color'=>'required|max:191',
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

            $model =  PurchaseEntry::find($product_id);
            $model->product_code = $product_code;
            $model->category_id = $req->input('category_id');
            $model->supplier_id = $req->input('supplier_id');
            $model->sub_category_id = $req->input('sub_category_id');
            $model->product = $req->input('product_name');
            // $model->qty = $req->input('qty');
            $model->sales_price = $req->input('sales_price');
            $model->purchase_price = $req->input('purchase_price');
            // $model->gst_no = $req->input('gst_no');
            // $model->hsn_code = $req->input('hsn_code');
            $model->bill_no = $req->input('bill_no');
            $model->size = $req->input('size');
            $model->color = $req->input('color');
            $model->barcode = $barcode;
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');

            if($model->save()){

                $imageModal = ProductImage::find($product_id);
                $imageModal->product_id = $model->id;
                $imageModal->product_image = $req->input('product_image');
                $imageModal->save();

                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function deleteProduct($product_id)
    {
        $delete_product = PurchaseEntry::find($product_id);
        $delete_product->delete();
        return response()->json([
            'status'=>200
        ]);
    }

    public function getBarcode()
    {
        $products = PurchaseEntry::Join('categories','categories.id','=','purchase_entries.category_id')
                ->join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                ->join('sizes','sizes.id','=','purchase_entries.size_id')
                ->join('colors','colors.id','=','purchase_entries.color_id')
                ->get(['purchase_entries.*','categories.category',
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

    public function importProduct(){
        return Excel::download(new ExportProduct,'Purchase_entry.xlsx');
    }

    public function exportProduct(){
        Excel::import(new ImportProduct,request()->file('file'));
        return back();
    }

    // save category of purchase entry
    function saveCategory(Request $req)
    {
        // return view('employee');
        $validator = Validator::make($req->all(),[
            "category" => 'required|unique:categories,category,'.$req->input('category'),
            'category_img' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all field required"),
            ]);
        }else{
            $model = new Category;
            $model->category = $req->input('category');
                    $CategoryImage = public_path('storage/').$model->category_img;
                    if(file_exists($CategoryImage)){
                        @unlink($CategoryImage); 
                    }
                $model->category_img = $req->file('category_img')->store('image/category'. $req->input('category_img'),'public');
            if($model->save()){
                return response()->json([   
                    'status'=>200,
                ]);
            }
        }
    }

    // save subcategory of purchase entry
    function saveSubCategory(Request $req)
    {
        $validator = Validator::make($req->all(),[
            "category_id" => 'required|max:191',
            "sub_category" => 'required|unique:sub_categories,sub_category,'.$req->input('sub_category'),
            'sub_category_img' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all field required"),
            ]);
        }else{
            $model = new SubCategory;
            $model->category_id = $req->input('category_id');
            $model->sub_category = $req->input('sub_category');
                    $subCategoryImage = public_path('storage/').$model->subcategory_img;
                    if(file_exists($subCategoryImage)){
                        @unlink($subCategoryImage); 
                    }
                $model->sub_category_img = $req->file('sub_category_img')->store('image/subcategory'. $req->input('sub_category_img'),'public'); 
            if($model->save()){
                return response()->json([   
                    'status'=>200,
                ]);
            }
        }
    }
// save style no of purchase entry
    public function manageStyleNo(Request $req)
    {
        if($req->input('style_id') > 0)
        {
            $supplier_id = 'required|max:191';
            $style_no = 'required|unique:style_nos,style_no,'.$req->input('style_id');
            $model = StyleNo::find($req->input('style_id'));
        }else{
            $supplier_id = 'required|max:191';
            $style_no = 'required|unique:style_nos,style_no,'.$req->input('style_no');
            $model = new  StyleNo;
        }

        $validator = Validator::make($req->all(),[
            'supplier_id' => $supplier_id,
            'style_no' => $style_no
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model->supplier_id = $req->input('supplier_id');
            $model->style_no = strtoupper($req->input('style_no'));

            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    function saveBrand(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'brand_name' => 'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all field required"),
            ]);
        }else{
            $model = new Brand;
            $model->brand_name = $req->input('brand_name');         
            if($model->save()){
                return response()->json([   
                    'status'=>200,
                ]);
            }
        }
    }

    public function editBrand($brand_id)
    {
        $brand = Brand::find($brand_id);
        return response()->json([
            'status'=>200,
            'brand'=>$brand
        ]);
    }

    public function updateBrand(Request $req, $brand_id)
    {
       

        $validator = Validator::make($req->all(),[
            'brand_name' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Brand::find($brand_id);
            $model->brand_name = $req->input('brand_name'); 
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function deleteBrand($brand_id)
    {
        $delete_brand = Brand::find($brand_id);
        $delete_brand->delete();
        return response()->json([
            'status'=>200
        ]);
    }

    

}
