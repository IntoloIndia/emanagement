<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;

class SalesReturnController extends Controller
{
    public function index(){
        return view('sales-return',[]);
    }

    public function getSalesReturnData($barcode_code)
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
}
