<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseEntryItem;
use App\Models\PurchaseEntry;
use App\Models\Category;
use App\Models\StyleNo;

class BarcodeController extends Controller
{
   public function index(){

    $get_style_no= StyleNo::all();
    $categories= Category::all();
    $Barcodes_data= PurchaseEntryItem::join('purchase_entries','purchase_entries.id','=','purchase_entry_items.purchase_entry_id')
                                        ->join('brands','brands.id','=','purchase_entries.brand_id')
                                        ->join('style_nos','style_nos.id','=','purchase_entries.style_no_id')
                                        ->join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                                    ->select(['purchase_entry_items.*','purchase_entries.*','sub_categories.sub_category','brands.brand_name','style_nos.style_no'])
                                    ->get();
    return view('barcode',[
        'Barcodes_data' => $Barcodes_data,
        'categories' => $categories,
        'get_style_no' => $get_style_no
    ]);
   }
}
