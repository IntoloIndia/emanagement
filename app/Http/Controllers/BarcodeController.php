<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseEntryItem;

class BarcodeController extends Controller
{
   public function index(){
    $allBarcodes= PurchaseEntryItem::all();
    return view('barcode',[
        'allBarcodes' => $allBarcodes
    ]);
   }
}
