<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerBillInvoice;
use App\Models\AlterationVoucher;
use App\Models\CustomerBill;
use App\Models\AlterationItem;
use App\MyApp;

use Validator;

class AlterationVoucherController extends Controller
{
        public function index(){
            $customers_billing = Customer::all();
            $alteration_vouchers = AlterationVoucher::join('customers','alteration_vouchers.customer_id','=','customers.id')
                ->where('voucher_status','MyApp::STATUS')
                ->select('alteration_vouchers.*','customers.customer_name')
                ->orderBy('alteration_date', 'DESC')
                ->orderBy('alteration_time', 'DESC')
                ->get();

            $delivered_vouchers = AlterationVoucher::join('customers','alteration_vouchers.customer_id','=','customers.id')
                ->where(['alteration_vouchers.voucher_status'=>MyApp::DELIVERY])
                ->orderBy('alteration_date', 'DESC')
                ->orderBy('alteration_time', 'DESC')
                ->select('alteration_vouchers.*','customers.customer_name')
                ->get();

            return view('alteration_voucher',[
                'customers_billing' => $customers_billing,
                'alteration_vouchers'=>$alteration_vouchers,
                'delivered_vouchers'=>$delivered_vouchers,
            ]);
        }

        public function getCustomerBills($customer_id)
        {
            $customer_bills = CustomerBill::where(['customer_id'=>$customer_id])->get();
            
            $html = "";

            $html .= "<table class='table table-striped'>";

                $html .= "<thead>";
                    $html .= "<tr>";
                        $html .= "<th>SN</th>";
                        $html .= "<th>Date</th>";
                        $html .= "<th>Time</th>";
                        $html .= "<th>Bill no</th>";
                        $html .= "<th>Amount</th>";
                        $html .= "<th>Action</th>";
                    $html .= "</tr>";
                $html .= "</thead>";
                $html .= "<tbody>";
                    foreach ($customer_bills as $key => $list) {
                        $html .= "<tr class='client_project_row ' project-id='".$list->id."'>";
                            $html .= "<td>" . ++$key . "</td>";
                            $html .= "<td>" . date('d-m-Y', strtotime($list->bill_date))."</td>";
                            $html .= "<td>" . $list->bill_time ."</td>";
                            $html .= "<td>" . $list->invoice_no ."</td>";
                            $html .= "<td>" . $list->total_amount ."</td>";
                            $html .= "<td> 
                            <button type='button' class='btn btn-info btn-sm alterBillsBtn mr-1'  value='".$list->id."'>Alter</button>
                            </td>";
                        $html .= "</tr>";
                    }
                $html .= "<tbody>";
            $html .= "</table>";

            return response()->json([
                'status'=>200,
                'customer_bills'=>$customer_bills,
                'html'=>$html
            ]);

        }
        
        function alterVoucher($bill_id)
        {
            $bill_date = CustomerBill::where(['id'=>$bill_id])->first(['bill_date','customer_id']);
          
            $alter_voucher = CustomerBillInvoice::join('sub_categories','customer_bill_invoices.product_id','=','sub_categories.id')
                ->where('bill_id',$bill_id)
                ->select('customer_bill_invoices.*','sub_categories.sub_category')
                ->get();
          
            $html = "";
            $html .="<div class='card'>";
                $html .="<div class='card-body'>";
                    $html .="<div class='row'>";
                        $html .="<div class='col-md-8'>Bill No : " .$bill_id."</div>";
                        $html .="<div class='col-md-4 '>Delivery Date";
                          
                        $html .= "</div>";
                    $html .="</div>";
                    $html .="<div class='row'>";
                        $html .="<div class='col-md-8'>Bill No : "  .date('d-m-Y',strtotime($bill_date->bill_date))."</div>";
                        $html .="<div class='col-md-4 text-end'>";
                             $html .= "<input type='date' id='delivery_date' name='delivery_date' class='form-control form-control-sm'>";
                        $html .="</div>";
                    $html .="</div>";
                    $html .="<div class='row mt-3'>";
                        $html .="<div class='col-md-12'>";
                        $html .= "<table class='table table-striped'>";
                        $html .= "<thead>";
                            $html .= "<tr>";
                                $html .= "<th></th>";
                                $html .= "<th></th>";
                                $html .= "<th>SN</th>";
                                $html .= "<th>Product</th>";
                                $html .= "<th>Qty</th>";
                                $html .= "<th>Remark</th>";
                                $html .= "<input type='hidden' id='customer_id' name='customer_id' value='".$bill_date->customer_id."' class='form-control form-control-sm'>";
                                $html .= "<input type='hidden' id='bill_id' name='bill_id' value='".$bill_id."' class='form-control form-control-sm'>";
                                $html .= "</tr>";
                                $html .= "</thead>";
                                $html .= "<tbody>";
                                foreach ($alter_voucher as $key => $list) {
                                    $html .= "<tr>";
                                    $html .= "<td></td>";
                                    $html .= "<td><input class='form-check-input product_id' id='product_id_".$list->product_id."' type='checkbox' name='product_id[]' value='$list->product_id'></td>";
                                    $html .= "<td>" . ++$key . "</td>";
                                    $html .= "<td>" . $list->sub_category ."</td>";
                                    $html .= "<td><input  type='number' class='form-control form-control-sm item_qty' id='item_qty_".$list->product_id."' name='item_qty[]' min='1' max='$list->qty' value='$list->qty' style='width:60px;' disabled='disabled'></td>";
                                    $html .= "<td><input  type='text' class='form-control form-control-sm remark'  id='' name='remark[]' value='$list->remark'></td>";
                                $html .= "</tr>";
                                $html .= "<tr><p id='show_alert'></p></tr>";
                            }
                        $html .= "<tbody>";
                    $html .= "</table>";
            
                            $html .="</div>";
                        $html .="</div>";
                    $html .="</div>";
                $html .="</div>";
            $html .="</div>";
          
            return response()->json([
                'status'=>200,
                'alter_voucher'=>$alter_voucher,
                'html'=>$html
            ]);
        }

        function saveAlterationVoucher(Request $req)
        {
            // return response()->json([   
            //     'status'=>$req->product_id,
            //     'qty'=>$req->item_qty
                
            // ]);
            $validator = Validator::make($req->all(),[
                'customer_id' => 'required|max:191',
                'bill_id' => 'required|max:191',
                'delivery_date' => 'required|max:191',
                'remark' => 'required|max:191'
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages(),
                ]);
            }else{
                $model = new AlterationVoucher;

                $model->alteration_date = date('Y-m-d');
                $model->alteration_time = date('g:i A');
                $model->customer_id = $req->input('customer_id');
                $model->bill_id = $req->input('bill_id');

                if($model->save()){

                    for ($i=0; $i < count($req->product_id); $i++) { 
                        $alter_model = new AlterationItem;
                        $alter_model->alteration_voucher_id =  $model->id;
                        $alter_model->product_id = $req->product_id[$i];
                        $alter_model->item_qty = $req->item_qty[$i];
                        $alter_model->delivery_date = $req->delivery_date;
                        $alter_model->remark = $req->remark[$i];
                        $alter_model->save();
                      
                    }

                }
                // if($model->save()){
                    return response()->json([   
                        'status'=>200,
                        
                    ]);
                // }
            }
        }
// get cutomer bills
      
        public function getAlterItem($alteration_voucher_id)
        {
            $alteration_voucher = AlterationVoucher::join('customers','alteration_vouchers.customer_id','=','customers.id')
                ->where('alteration_vouchers.id', $alteration_voucher_id)
                ->first(['alteration_vouchers.*','customers.customer_name','customers.gst_no','customers.mobile_no']);

            $alteration_items = AlterationItem::join('sub_categories','alteration_items.product_id','=','sub_categories.id')
                ->where('alteration_voucher_id',$alteration_voucher_id)
                ->get(['alteration_items.*','sub_categories.sub_category']);
               
            $html = "";
             $html .= "<div class='row'>";
                 $html .= "<div class='col-6'><h6>Name :  ".$alteration_voucher->customer_name."</h6><h6>Mobile No : ".$alteration_voucher->mobile_no."</h6>
                 <h6>Date : ".date('d-m-Y',strtotime($alteration_voucher->alteration_date))."</h6></div>";
                 $html .= "<div class='col-6 text-end'><h6>Bill No : ".$alteration_voucher->bill_id."</h6><h6>Enquiry : 8587587545</h6></div>";
             $html .= "</div>"; 
             $html .= "<div class='row mt-2'>";
                $html .= "<table class='table table-striped'>";
                    $html .= "<thead>";
                        $html .= "<tr>";
                            $html .= "<th></th>";
                            $html .= "<th>SN</th>";
                            $html .= "<th>Item</th>";
                            $html .= "<th>Qty</th>";
                            // $html .= "<th>Size</th>";
                            // $html .= "<th>Color</th>";
                        $html .= "</tr>";
                    $html .= "</thead>";
                    $html .= "<tbody>";
                        foreach ($alteration_items as $key => $list) {
                            $html .= "<tr>";
                                $html .= "<td></td>";
                                $html .= "<td>" . ++$key . "</td>";
                                $html .= "<td>" . $list->sub_category ."</td>";
                                $html .= "<td>" . $list->item_qty ."</td>";
                                // $html .= "<td>" . $list->item_qty ."</td>";
                                // $html .= "<td>" . $list->item_qty ."</td>";
                            $html .= "</tr>";
                        }
                    $html .= "<tbody>";
                $html .= "</table>";
            $html .= "</div>"; 
         
       
            return response()->json([
                'status'=>200,
                'alteration_voucher'=>$alteration_voucher,
                'alteration_items'=>$alteration_items,
                'html'=>$html
            ]);

        }
        function updateDeliveryStatus($alteration_voucher_id)
        {
            $delivery_status = AlterationVoucher::find($alteration_voucher_id);
            $delivery_status->voucher_status = MyApp::DELIVERY;
            $delivery_status->save();
            
            return response()->json([
                'status'=>200
            ]);
        }

}


