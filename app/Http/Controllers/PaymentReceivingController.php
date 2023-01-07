<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerBill;
use App\Models\PaymentReceiving;
use Validator;
use App\MyApp;

class PaymentReceivingController extends Controller
{
  public function index()
  {
    return view('payment_receiving');
  }

  public function paymentReceiving($bill_id)
  {
        $payment_receiving = CustomerBill::join('customers','customer_bills.customer_id','=','customers.id')
        ->where(['customer_bills.id'=>$bill_id])
        ->select('customer_bills.*','customers.customer_name')
        ->first();

        return response()->json([
            'status'=>200,
            'payment_receiving'=>$payment_receiving
        ]);
  }

  function savePaymentReceiving(Request $req)
  {
    // return $req;
    // die();
      $validator = Validator::make($req->all(),[
          'against_bill_id' => 'required|:payment_receivings,against_bill_id,'.$req->input('against_bill_id'),
          'customer_id' => 'required|max:191',
          'balance_amount' => 'required|max:191',
         
      ]);
      if($validator->fails())
      {
          return response()->json([
              'status'=>400,
              'errors'=>$validator->messages(),
          ]);
      }else{
          $model = new PaymentReceiving;
          $model->against_payment_date = date('Y-m-d');
          $model->against_payment_time = date('g:i A');
          $model->against_bill_id = $req->input('against_bill_id');
          $model->customer_id = $req->input('customer_id');
          $model->pay_online = $req->input('pay_online');
          $model->pay_cash = $req->input('pay_cash');
          $model->pay_card = $req->input('pay_card');
          $model->balance_amount = $req->input('balance_amount');
          $model->save();

              return response()->json([
                  'status'=>200,
              ]);
          }
    
  }



}
