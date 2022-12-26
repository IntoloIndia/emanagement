<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Purchase;
use App\Models\PurchaseEntry;
use App\MyApp;

class ManageStockController extends Controller
{
    //
    public function index(){

        $categories = Category::all();
        $sub_categories = SubCategory::all();
        // $reserve = PurchaseEntry::all()->groupBy('category_id')->count();

        $category_qty = array();
        foreach ($categories as $key => $list) {
            $count = PurchaseEntry::where(['category_id'=> $list->id])->get()->count();
            $category_qty[] = collect([
                'id' => $list->id,
                'category' => $list->category,
                'count' => $count
            ]);
        }

        $sub_category_qty = array();
        foreach ($sub_categories as $key => $list) {
            $count = PurchaseEntry::where(['sub_category_id'=> $list->id])->get()->count();
            $sub_category_qty[] = collect([
                'id' => $list->id,
                'category_id' => $list->category_id,
                'sub_category' => $list->sub_category,
                'count' => $count,
            ]);
        }

     

        $purchase_entry = PurchaseEntry::join('categories','purchase_entries.category_id','=','categories.id')
            ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
            ->join('style_nos','purchase_entries.style_no_id','=','style_nos.id')
            ->get(['purchase_entries.*','categories.category','sub_categories.sub_category','style_nos.style_no' ]);

        // $stock = PurchaseEntry::join('suppliers','purchase_entries.supplier_id','=','suppliers.id')
        // ->where(['status'=> MyApp::AVAILABLE])
        // ->get(['purchase_entries.*', 'suppliers.supplier_name']);

        return view('manage_stock', [
            'categories'=>$categories,
            'category_qty'=>$category_qty,
            'sub_category_qty'=>$sub_category_qty,
            'purchase_entry'=>$purchase_entry
        ]);
    }
}
