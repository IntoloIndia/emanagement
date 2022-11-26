<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Size;
use App\Models\Billing;
use App\Models\Customer;
use Validator;

class BillingController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        $sizes = Size::all();
        $customers_billing = Customer::all();
        // $customers_billing = Customer::join('billings','billings.customer_id','=','customers.id')
        // $customers_billing = Billing::join('customers','customers.id','=','billings.customer_id')
        // $customers_billing = Billing::join('products','products.id','=','billings.product_id')
                        // ->groupBy('customers.customer_name')
                    // ->get(['customers.*','billings.amount','billings.qty']);
                    // ->get(['customers.*','billings.amount','billings.qty']);
                    // print_r($customers_billing);
                    
        return view('billing',[ 
            'products'=> $products,
            'sizes' => $sizes,
            'customers_billing' => $customers_billing
        ]);
        
    }


    function saveOrder(Request $req)
    {
        // return $req;
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
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
 
            $product_id = $req->input('product_id');
            $product_code = $req->input('product_code');
            $price = $req->input('price');
            $qty = $req->input('qty');
            $size_id = $req->input('size_id');
            $amount = $req->input('amount');
            

            if($model->save()){

                foreach ($product_id as $key => $list) {
                    
                    // $categories = Customer::find($product_code[$key]);

                    $item = new Billing;

                    $item->customer_id = $model->id;
                    $item->product_id = $product_id[$key];
                    $item->product_code = $product_code[$key];
                    $item->price = $price[$key];
                    $item->qty = $qty[$key];
                    $item->amount = $amount[$key];
                    $item->size_id = $size_id[$key];
                    $item->date = date('Y-m-d');
                    $item->time = date('g:i A');
 

                    $item->save();
                } 

                return response()->json([   
                    'status'=>200
                    

                ]);
            }
        }
    }
            

    public function getItemPrice($product_code)
    {
        $product = Product::where(['product_code'=>$product_code])->first();
        // print_r($product);
        // $product = Product::find($product_code);
                        
        return response()->json([
            'product'=>$product
        ]);

    }



    public function generateInvoice($customer_id)
    {
        

                 $order =Customer::find($customer_id);
        
                $order_items =Billing::join('customers','customers.id','=','billings.customer_id')
                        ->where('billings.customer_id',$order->id)
                            ->get(['billings.*',]); 
                            
                    //  print_r($order_items);     
                    // print_r($order_items);    
        //         ->get(['order_items.*','items.item_name','items.price' ]);

        //         if($order->payment_mode == MyApp::ONLINE){
        //             $payment_mode = "Online";
        //         }else{
        //             $payment_mode = "Cash";
        //         }


        $html = "";
        $html .="<div class='modal-dialog modal-sm'>";
            $html .="<div class='modal-content'>";
                $html .="<div class='modal-header'>";
                    $html .="<h5 class='modal-title' id='staticBackdropLabel'><b>$order->customer_name</b></h5>";
                    $html .="<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                $html .="</div>";

                    $html .="<div class='modal-body-wrapper'>";


                    $html .="<div class='modal-body' id='invoiceModalPrint'>";

                        $html .="<div class='row text-center'>";
                            $html .="<h5><b>Mangaldeep </b></h5>";
                            $html .="<small>Jabalpur</small>";
                        $html .="</div>";
                        $html .="<hr>";

                        $html .="<div class='row'>";
                            $html .="<div class='col-md-6'>";
                                // $html .="<span>Bill No : <small>".$order->invoice_no."</small></span><br>";
                                // $html .="<span>Payment : <small>".$payment_mode."</small></span> ";
                            $html .="</div>";
                            $html .="<div class='col-md-6 '>";
                                $html .="<span class='float-end'>Date : <small>".date('d/M/Y', strtotime($order->date))."</small></span><br>";
                                $html .="<span class='float-end'>Time : <small>".$order->time."</small></span> ";
                            $html .="</div>";
                        $html .="</div>";
                        $html .="<hr>";

                        $html .="<div class='row'>";
                            $html .="<table class='table table-striped'>";
                                $html .="<thead>";
                                    $html .="<tr>";
                                        $html .="<th>#</th>";
                                        $html .="<th>Item Name</th>";
                                        $html .="<th>Rate</th>";
                                        $html .="<th>Qty</th>";
                                        $html .="<th>Amount</th>";
                                    $html .="</tr>";
                                $html .="</thead>";
                                $html .="<tbody>";
                                foreach ($order_items as $key => $list) {
                                    $html .="<tr>";
                                        $html .="<td>".++$key."</td>";
                                        $html .="<td>".ucwords($list->product_id)."</td>";
                                        $html .="<td>".$list->price."</td>";
                                        $html .="<td>".$list->qty."</td>";
                                        $html .="<td>".$list->amount."</td>";
                                    $html .="</tr>";
                                }
                                    
                                $html .="</tbody>";
                                $html .="<tfoot>";
                                    $html .="<tr>";
                                        $html .="<td colspan='2'></td>";
                                        $html .="<td><b>Total :</b></td>";
                                        $html .="<td>".$key."</td>";
                                        $html .="<td>".$order->total_amount."</td>";
                                    $html .="</tr>";
                                $html .="</tfoot>";
                            $html .="</table>";
                        $html .="</div>";
                        $html .="<hr>";
                        $html .="<div class='row text-center'>";
                            $html .="<h6><b>Thank You Have a Nice Day </b></h6>";
                            $html .="<small>Visit Again !</small>";
                        $html .="</div>";

                    $html .="</div>";


                    $html .="</div>";

                $html .="<div class='modal-footer'>";
                    $html .="<button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Close</button>";
                    $html .="<button type='button' id='printBtn' class='btn btn-primary btn-sm' order-id='".$order->id."'>Print</button>";
                $html .="</div>";

            $html .="</div>";
        $html .="</div>";

        return response()->json([
            'status'=>200,
            'html'=>$html
        ]);
  }   

}
