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

    public function filterAvailableStock(Request $req )
    {
        $products = PurchaseEntry::join('categories', 'purchase_entries.category_id','=','categories.id')
            ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
            ->where('purchase_entries.status', MyApp::AVAILABLE)
            ->select('purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price','purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category');
            
            if ($req->category_id > 0) {
                $products->where('purchase_entries.category_id', '=', $req->category_id);
            }
            if ($req->sub_category_id > 0) {
                $products->where('purchase_entries.sub_category_id', '=', $req->sub_category_id);
            }
            if ($req->size != '') {
                $products->where('purchase_entries.size', '=', $req->size);
            }
            if ($req->color != '') {
                $products->where('purchase_entries.color', '=', $req->color);
            }
            if ($req->brand != '') {
                $products->where('purchase_entries.brand', '=', $req->brand);
            }

            $data = $products->get();

            
            // $users = User::where('is_active', true);
            // if ($request->has('age_more_than')) {
            //     $users->where('age', '>', $request->age_more_than);
            // }
            // if ($request->has('gender')) {
            //     $users->where('gender', $request->gender);
            // }
            // if ($request->has('created_at')) {
            //     $users->where('created_at','>=', $request->created_at);
            // }
            // return $users->get();
        
        return response()->json([
            'data'=>$data,
            'count'=>$data->count(),
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

    public function filterSalesInvoice(Request $req)
    {
        $date = date('Y-m-d');

        $sales = Salesinvoice::join('purchase_entries', 'sales_invoices.product_id','=','purchase_entries.id')
            // ->where('sales_invoices.date', $date)
            ->select('sales_invoices.*','purchase_entries.product','purchase_entries.category_id','purchase_entries.sub_category_id','purchase_entries.size','purchase_entries.color');

            if ($req->category_id > 0) {
                $sales->where('purchase_entries.category_id', '=', $req->category_id);
            }
            if ($req->sub_category_id > 0) {
                $sales->where('purchase_entries.sub_category_id', '=', $req->sub_category_id);
            }
            if ($req->size != '') {
                $sales->where('purchase_entries.size', '=', $req->size);
            }
            if ($req->color != '') {
                $sales->where('purchase_entries.color', '=', $req->color);
            }
            if ($req->brand != '') {
                $products->where('purchase_entries.brand', '=', $req->brand);
            }

            $data = $sales->get();

        return response()->json([
            'data'=>$data,
            'count'=>$data->count(),
        ]); 
    }

}
