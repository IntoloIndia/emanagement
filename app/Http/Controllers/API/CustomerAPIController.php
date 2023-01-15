<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerBill;
use App\Models\CustomerPoint;
use App\MyApp;

class CustomerAPIController extends Controller
{
    //
    public function getCustomer()
    {
        $customers = Customer::get('id');
        $customer_detail = array();
        foreach($customers as $customer){
            $customer_id = $customer->id;
            $data = Customer::join('customer_points','customers.id','=','customer_points.customer_id')
                ->where(['customers.id'=>$customer_id])
                ->select('customers.id','customers.customer_name','customers.mobile_no','customer_points.total_points')->first();
            
                $total_amount = CustomerBill::where(['customer_id'=>$customer_id])->sum('total_amount');

                if($total_amount  <= MyApp::SILVER_AMOUNT){
                    $membership = MyApp::SILVER;
                }elseif($total_amount > MyApp::SILVER_AMOUNT && $total_amount  <= MyApp::GOLDEN_AMOUNT){
                    $membership = MyApp::GOLDEN;
                }else{
                    $membership = MyApp::PLATINUM;
                } 
                

                $detail = [
                    'data'=>$data,
                    'total_amount'=>$total_amount,
                    'membership'=>$membership,
                ];
                $customer_detail[] = $detail;
        }
        
        return response()->json([
            // 'customers'=>$customers,
            'customer_detail'=>$customer_detail,
            'count'=>$customers->count(),
        ]); 
        
        
    }

    public function getCustomerBill($customer_id)
    {
        $customer_bills = CustomerBill::where(['customer_id'=>$customer_id])->get();
        return response()->json([
            'customer_bills'=>$customer_bills,
            'count'=>$customer_bills->count(),
        ]);
    }
    public function todaySales()
    {
        $today_sales = CustomerBill::join('customers','customer_bills.customer_id','=','customers.id')
        ->join('customer_bill_invoices','customer_bills.id','=','customer_bill_invoices.bill_id')
        ->join('states','customers.state_type','=','states.id')
        ->join('cities','customers.city_id','=','cities.id')
        ->join('sub_categories','customer_bill_invoices.product_id','=','sub_categories.id')
        ->where(['customer_bills.bill_date'=>date('Y-m-d')])
        ->select(['customer_bills.*','customers.customer_name','customers.mobile_no','customers.birthday_date','customers.anniversary_date','states.state','cities.city','customers.gst_no','customer_bill_invoices.product_code','sub_categories.sub_category','customer_bill_invoices.qty','customer_bill_invoices.size','customer_bill_invoices.price','customer_bill_invoices.taxfree_amount','customer_bill_invoices..cgst','customer_bill_invoices.sgst','customer_bill_invoices.igst'])
        ->get();
        return response()->json([
            'status'=>200,
            'today_sales'=>$today_sales
            
        ]);
    }
}
