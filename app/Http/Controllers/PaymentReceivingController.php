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
    $all_receiving_payment = PaymentReceiving::join('customers','payment_receivings.customer_id','=','customers.id')
      ->orderBy('against_payment_date','DESC')
      ->orderBy('against_payment_time','DESC')
      ->select('payment_receivings.*','customers.customer_name')
      ->get();

    $pending_recevings = CustomerBill::join('customers','customer_bills.customer_id','=','customers.id')
      ->where(['customer_bills.pending_amount_status'=>MyApp::STATUS])
      ->select('customer_bills.*','customers.customer_name')
      ->get();
   
    return view('payment_receiving',[
        'all_receiving_payment'=>$all_receiving_payment,
        'pending_recevings'=>$pending_recevings
       
    ]);
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
        //   'against_bill_id' => 'required|:payment_receivings,against_bill_id,'.$req->input('against_bill_id'),
        'against_bill_id' => 'required|max:191',
        'customer_id' => 'required|max:191',
        'balance_amount' => 'required|max:191',
        // 'pay_online' => 'sometimes|required|max:191',
        // 'pay_cash' => 'sometimes|required|max:191',
        // 'pay_card' => 'sometimes|required|max:191',

        // 'pay_online' => 'required_without_all:pay_cash,pay_card',
        // 'pay_cash' => 'required_without_all:pay_online,pay_card',
        // 'pay_card' => 'required_without_all:pay_online,pay_cash',
      ]);
      if($validator->fails())
      {
          return response()->json([
              'status'=>400,
              'errors'=>$validator->messages("all field required"),
          ]);
      }else{
          
          $model = new PaymentReceiving;
          $against_bill_id = $req->input('against_bill_id');
          $model->against_payment_date = date('Y-m-d');
          $model->against_payment_time = date('g:i A');
          $model->against_bill_id = $against_bill_id;
          $model->customer_id = $req->input('customer_id');
          $model->pay_online = $req->input('pay_online');
          $model->pay_cash = $req->input('pay_cash');
          $model->pay_card = $req->input('pay_card');
          $model->balance_amount = $req->input('balance_amount');
          
          if($model->save())
          {
            $customer_bills = CustomerBill::find($against_bill_id);
            $customer_bills->pending_amount_status = MyApp::PENDING_AMOUNT;
            $customer_bills->save();

              return response()->json([
                  'status'=>200,                
              ]);
            }
          }
    
  }

  // public function pendingAmountStatus($bill_id)
  // {
  //   $pending_amount_status = CustomerBill::find($bill_id);
    
  //   return response()->json([
  //     'status'=>200,
  //     'pending_amount_status'=>$pending_amount_status
  // ]);
  // }



}
