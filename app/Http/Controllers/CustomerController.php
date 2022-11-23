<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Validator;

class CustomerController extends Controller
{
    public function index(){
        return view('customer',[]);
    }

    function saveOrderCustomer(Request $req)
    {
        $validator = Validator::make($req->all(),[
            
            'customer_name'=>'required|max:191',
            'mobile_no'=>'required|max:191',

        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz  all field required"),
            ]);
        }else{
            $model = new Customer;
            $model->customer_name = $req->input('customer_name');
            $model->mobile_no = $req->input('mobile_no');
 
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    
}
}