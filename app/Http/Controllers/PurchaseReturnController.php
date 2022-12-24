<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;
use App\Models\Size;
use App\Models\Color;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\MyApp;
use Validator;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        // $purchase_return = PurchaseReturn::all();
        $purchase_return = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
                                        ->where(['purchase_returns.release_status' => MyApp::RELEASE_PANDDING_STATUS])
                                        ->select('suppliers.supplier_name','purchase_returns.*')->get();
        $purchase_return_items = array();
        foreach ($purchase_return as $key => $list) {
            $purchase_return_items[] = PurchaseReturnItem::join('sub_categories','sub_categories.id','=','purchase_return_items.sub_category_id')
                                ->where(['purchase_return_id'=>$list->id])
                                ->select('purchase_return_items.*','sub_categories.sub_category')->get();     
        }


        $purchase_return_data = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
                                        ->where(['purchase_returns.release_status' => MyApp::RELEASE_STATUS])
                                        ->select('suppliers.supplier_name','purchase_returns.*')->get();
                




        return view('purchase-return',[
            'purchase_return' =>$purchase_return,
            'purchase_return_items' =>$purchase_return_items,
            'purchase_return_data' =>$purchase_return_data

        ]);
    }

    // saveReturnProduct
    function saveReturnProduct(Request $req)
    {
        
        $validator = Validator::make($req->all(),[
            // 'color' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all filed"),
            ]);
        }else{

            $supplier_id = 0;
            $data = PurchaseReturn::where(['supplier_id'=>$req->input('supplier_id')])->first(['id','release_status']);
            if ($data == null) {
                // if($release_status > 0){

                    $model = new PurchaseReturn;
                    $model->supplier_id = $req->input('supplier_id');
                    $model->create_date = date('Y-m-d');
                    $model->create_time = date('g:i A');
                    $model->save();
        
                    $supplier_id = $model->id;
                    }else{
                        $supplier_id = $data->id;
                    }
                // }


            $returnitemmodel = new PurchaseReturnItem;
            $returnitemmodel->purchase_return_id = $supplier_id;
            $returnitemmodel->sub_category_id = $req->input('sub_category_id');
            $returnitemmodel->color = $req->input('color');
            $returnitemmodel->size = $req->input('size');
            $returnitemmodel->qty = $req->input('qty');
            $returnitemmodel->date = date('Y-m-d');
            $returnitemmodel->time = date('g:i A');
            $returnitemmodel->save();


           
            // if($model->save()){
                return response()->json([   
                    'status'=>200,
                    
                ]);
            // }
        }
    }

    public function getReturnData($barcode_code)
    {
        $return_product = PurchaseEntryItem::join('purchase_entries','purchase_entries.purchase_id','=','purchase_entry_items.id')->
                                        join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')->
                                        join('purchases','purchases.id','=','purchase_entries.purchase_id')->
                                        join('suppliers','suppliers.id','=','purchases.supplier_id')->
                                        where(['purchase_entry_items.barcode'=>$barcode_code])
                                       ->select('purchase_entry_items.*','purchase_entries.id',
                                       'purchase_entries.sub_category_id','purchase_entries.color',
                                       'sub_categories.sub_category',
                                       'suppliers.supplier_name','suppliers.id')
                                        ->first();
                // dd($return_product);  
        // print_r($product);
        // $product = Product::find($product_code);
                        
        return response()->json([
            'return_product'=>$return_product
        ]);
    }

    function updateReleaseStatus($supplier_id)
    {
        $release_status_data =PurchaseReturn::find($supplier_id);
        $release_status_data->release_status = MyApp::RELEASE_STATUS;
        $release_status_data->release_date = date('Y-m-d');
        $release_status_data->release_time = date('g:i A');
        $release_status_data->save();
        
        return response()->json([
            'status'=>200
        ]);
    }
}
// 'purchases.suppler_id'