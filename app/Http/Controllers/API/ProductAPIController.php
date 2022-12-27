<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;
use App\Models\CustomerBillInvoice;
use App\MyApp;

class ProductAPIController extends Controller
{
    //
    public function availableStock()
    {
        $products = PurchaseEntryItem::all(['id','purchase_entry_id','size','qty']);

        // $products = PurchaseEntryItem::join(['id','purchase_entry_id','size','qty']);

            // ->get(['purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price', 'purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category']);
       
        // $products = PurchaseEntry::join('categories', 'purchase_entries.category_id','=','categories.id')
        //     ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
        //     ->where('purchase_entries.status', MyApp::AVAILABLE)
        //     ->get(['purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price', 'purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category']);


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
        // $date = "2022-12-26";
        // $sales = CustomerBillInvoice::where('date', $date)->get();


        // $SubCategories = SubCategory::join('categories','categories.id','=','sub_categories.category_id')
        //         ->select('sub_categories.category_id','categories.category')
        //             ->groupBy('sub_categories.category_id','categories.category')
        //             ->get();

        // join('sub_categories','sub_categories.id','=','customer_bill_invoices.product_id')

        $sales = CustomerBillInvoice::join('sub_categories','customer_bill_invoices.product_id','=','sub_categories.id')
                ->groupBy(['customer_bill_invoices.product_id', 'sub_categories.sub_category', 'customer_bill_invoices.product_code', 'customer_bill_invoices.qty','customer_bill_invoices.size'])
                ->where('customer_bill_invoices.date', $date)
                ->selectRaw('customer_bill_invoices.product_id,customer_bill_invoices.product_code,sum(customer_bill_invoices.qty) as qty,customer_bill_invoices.size,sub_categories.sub_category')
                ->get();

        // $sales = CustomerBillInvoice::groupBy(['product_code','size','price','product_id'])
        //     ->where('date', $date)
        //     ->selectRaw('sum(qty) as qty,price,product_id, product_code, size')
        //     ->get();

        // $sales = CustomerBillInvoice::groupBy(['product_code','size'])
        //     ->where('date', $date)
        //     ->selectRaw('sum(qty) as qty, product_code, size')
        //     ->get();

      


        return response()->json([
            'data'=>$sales,
            'count'=>$sales->count(),
        ]); 
    }

    public function filterSalesInvoice(Request $req)
    {
        $date = date('Y-m-d');

        $sales = CustomerBillInvoice::join('purchase_entries', 'customer_bill_invoices.product_id','=','purchase_entries.id')
            // ->where('customer_bill_invoices.date', $date)
            ->select('customer_bill_invoices.*','purchase_entries.product','purchase_entries.category_id','purchase_entries.sub_category_id','purchase_entries.size','purchase_entries.color');

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
