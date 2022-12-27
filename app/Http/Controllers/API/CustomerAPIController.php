<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerBill;
use App\MyApp;

class CustomerAPIController extends Controller
{
    //
    public function getCustomer()
    {
        $customers = Customer::all(['id','customer_name','mobile_no']);
        return response()->json([
            'customers'=>$customers,
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
    
}
