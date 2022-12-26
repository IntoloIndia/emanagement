<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;
use App\Models\CustomerBillInvoice;
use App\Models\CustomerBill;
use App\Models\Customer;

class SalesReturnController extends Controller
{
    public function index(){
        return view('sales-return',[]);
    }

    public function getCustomerDetails($bill_no){
        $customer_details = CustomerBill::join('customers','customers.id','=','customer_bills.customer_id')
                        ->where(['customer_bills.id'=>$bill_no])
                        ->select(['customer_bills.*','customers.customer_name','customers.mobile_no'])
                        ->first();
                if($customer_details){
                    return response()->json([
                       'status'=> 200,
                       'customer_details'=>$customer_details
                    ]);
                }else{
                    return response()->json([
                        'status'=> 400,
                        'customer_details'=>"data no found"
                     ]);
                }
    }
    
    public function getSalesReturnData($barcode_code)
    {
        $customer_return_product = CustomerBillInvoice::where(['customer_bill_invoices.product_code'=>$barcode_code])
                                        ->select(['customer_bill_invoices.*'])->first();
                                       
             
                        dd($customer_return_product);
        return response()->json([
            'customer_return_product'=>$customer_return_product
        ]);
    }

    public function getSalesProductDetail()
    {
        
    }


}
