<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\PurchaseEntry;
use App\Models\Salesinvoice;
use App\MyApp;

class ProductAPIController extends Controller
{
    //
    public function availableStock()
    {
        $products = PurchaseEntry::join('categories', 'purchase_entries.category_id','=','categories.id')
            ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
            ->where('purchase_entries.status', MyApp::AVAILABLE)
            ->get(['purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price', 'purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category']);

        return response()->json([
            'data'=>$products,
            'count'=>$products->count(),
        ]); 
    }

    public function filterAvailableStock($category_id)
    {
        $products = PurchaseEntry::join('categories', 'purchase_entries.category_id','=','categories.id')
            ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
            ->where('purchase_entries.category_id', $category_id)
            ->where('purchase_entries.status', MyApp::AVAILABLE)
            ->get(['purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price','purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category']);

        return response()->json([
            'data'=>$products,
            'count'=>$products->count(),
        ]); 
    }

    public function salesInvoice()
    {
        $date = date('Y-m-d');
        // $sales = Salesinvoice::where('date', $date)->get();

        $sales = Salesinvoice::join('purchase_entries', 'sales_invoices.product_id','=','purchase_entries.id')
            ->where('sales_invoices.date', $date)
            ->get(['sales_invoices.*','purchase_entries.product']);

        return response()->json([
            'data'=>$sales,
            'count'=>$sales->count(),
        ]); 
    }

}
