<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerBillInvoice;
use App\Models\AlterationVoucher;
use App\Models\CustomerBill;
use App\Models\AlterationItem;

use Validator;

class AlterationVoucherController extends Controller
{
        public function index(){
            $customers_billing = Customer::all();
            $alteration_items = AlterationItem::all();

            // $alteration_items = AlterationItem::join('alteration_vouchers','alteration_items.alteration_voucher_id','=','alteration_vouchers.id')
            // ->select('alteration_items.*','alteration_vouchers.customer_id')->get();
            // $alteration_items = AlterationVoucher::join('alteration_items','alteration_vouchers.id','=','alteration_items.alteration_voucher_id')
            // ->join('customer_bills','customer_bills.id','=','alteration_vouchers.customer_id')
            // dd($alteration_items);
            // ->select('alteration_vouchers.*','alteration_items.alteration_date','alteration_items.alteration_time','alteration_items.product_id')->get();
            // ->select('alteration_vouchers.*','alteration_items.alteration_date','alteration_items.alteration_time','alteration_items.product_id','customer_bills.invoice_no')->get();

      
            // $order_items =CustomerBillInvoice::join('customers','customers.id','=','customer_bill_invoices.customer_id')->
            //             join('purchase_entries','purchase_entries.id','=','customer_bill_invoices.product_id')
            //             // ->where('customer_bill_invoices.customer_id',$order->id)
            //             ->select(['customer_bill_invoices.*','customers.total_amount','purchase_entries.product'])->get(); 

            return view('alteration_voucher',[
                'customers_billing' => $customers_billing,
                'alteration_items'=>$alteration_items
                // 'order_items' => $order_items,
            ]);
        }

        function saveAlterationVoucher(Request $req)
        {
            $validator = Validator::make($req->all(),[
                // 'product_id' => 'required|max:191'
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages("plz fill size"),
                ]);
            }else{
                $model = new AlterationVoucher;
                $model->checked_alt_voucher = $req->input('checked_alt_voucher');
                $model->customer_id = $req->input('customer_id');
                $model->product_id = $req->input('product_id');
   
                
                if($model->save()){
                    return response()->json([   
                        'status'=>200
                        
                    ]);
                }
            }
        }
        
        public function generateAlerationItem($bill_id)
        {
            $customer_detail = CustomerBill::where(['id'=>$bill_id])->first(['customer_id','total_amount']);
            $customer = Customer::where(['id'=>$customer_detail->customer_id])->first(['customer_name','mobile_no','date']);
            $customer_name = $customer->customer_name;

            $customer_bill_detail = CustomerBillInvoice::join('customer_bills','customer_bill_invoices.bill_id','=','customer_bills.customer_id')
                ->join('customers','customer_bills.customer_id','=','customers.id')
                ->where(['bill_id'=>$bill_id])
                ->select('customer_bill_invoices.*','customers.customer_name','customers.mobile_no')
                ->get();

            $html = "";
            $html .="<div class='modal-dialog modal-lg'>";
            $html .="<div class='modal-content'>";
                $html .="<div class='modal-header'>";
                    $html .="<h5 class='modal-title' id='staticBackdropLabel'><b>Alter Voucher</b></h5>";
                    $html .="<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                $html .="</div>";
                $html .="<div class='modal-body' id='invoiceModalPrint' style='border:1px solid black'>";
                    $html .="<form id='alterationVoucherForm'>";
                        $html .="<div class='alterationvoucher_err'></div>";
                            $html .="<div class='row mb-1'>";
                                    $html .="<div class='col-md-3 '>";
                                        $html .="<span></span><br>";
                                        $html .="<span>GST NO: <small>4125666</small></span><br>";
                                        $html .="<span></span><br>";
                                    $html .="</div>";
                                $html .="<div class='col-md-6 text-center'>";
                                        $html .="<span>SALES INVOICE</span><br>";
                                        $html .="<span>ERENOWN CLOTHING CO </span><br>";
                                        $html .="<span>Shop no.8-9,Ground Floor Samdariya Mall </span><br>";
                                        $html .="<span>Jabalpur -482002 </span><br>";
                                $html .="</div>";
                                $html .="<div class='col-md-3' >";
                                        $html .="<span>Phone no: 0761-4047699</span><br>";
                                        $html .="<span></span><br>";
                                        $html .="<span>Mobile no : 09826683399<small></small></span><br>";
                                        $html .="<span></span><br>";
                                $html .="</div>";
                            $html .="<div class='row '>";
                                $html .="<div class='col-md-5' style='border:1px solid black'>";
                                    $html .="<span>Customer name: <small name='customer_id'>".$customer_name."</small></span><br>";
                                    $html .="<input type='hidden' id='customer_id' value='".$customer->id."' class='form-control form-control-sm'>";
                                    $html .="<span>Location : <small>Jabalpur</small></span><br>";
                                    $html .="<span>Mobile no : <small>".$customer->mobile_no."</small></span><br>";
                                    // $html .="<span>State code  : <small>0761</small></span><br>";
                                $html .="</div>";
                                $html .="<div class='col-md-3' style='border:1px solid black'>";
                                    $html .="<span class=''>CASH : <small><b>10000</b></small></span> ";
                                $html .="</div>";
                                $html .="<div class='col-md-4' style='border:1px solid black'>";
                                    $html .="<span>Invoice No : <small class='float-end'>".$customer->invoice_no."</small></span><br>";
                                    $html .="<span class=''>Date : <small class='float-end'>".date('d/M/Y', strtotime($customer->date))."</small></span><br>";
                                    $html .="<span class=''>Attent By : <small class='float-end'></small></span> ";
                                $html .="</div>";
                                $html .="</div>";
                          
                                    $html .="<div class='row mt-2'>";
                                        $html .="<div class='table-responsive'>";
                                            $html .="<table class='table table-bordered'>";
                                                $html .="<thead>";
                                                    $html .="<tr>";
                                                        $html .="<th>#</th>";
                                                        $html .="<th>Check</th>";
                                                        $html .="<th>Item Name</th>";
                                                        $html .="<th>Qty</th>";
                                                        $html .="<th>Size</th>";
                                                        // $html .="<th>Color</th>";
                                                        $html .="<th>MRP</th>";
                                                        $html .="<th>Rate</th>";
                                                        $html .="<th>Disc</th>";
                                                        $html .="<th>Total</th>";
                                                        $html .="<th>Taxable</th>";
                                                        $html .="<th>CGST%</th>";
                                                        $html .="<th>SGST%</th>";
                                                        $html .="<th>IGST%</th>";
                                                    $html .="</tr>";
                                                $html .="</thead>";
                                                    $html .="<tbody>";
                                                        $total_amount = 0;
                                                        $total_cgst = 0;
                                                        $total_sgst = 0;
                                                        $total_igst = 0;
                                                        foreach ($customer_bill_detail as $key => $list) {
                                                            $customer_name = $list->customer_name;
                                                            $html .="<tr>";
                                                                $html .="<td>".++$key."</td>";
                                                            
                                                                $html .="<td><div class='form-check text-center'>
                                                                <input class='form-check-input product_id' type='checkbox' name='product_id[]' value='".$list->id."' >
                                                                </div></td>";
                                                                $html .="<td>".$list->product_id."</td>";
                                                                $html .="<td>".$list->qty."</td>";
                                                                $html .="<input type='hidden' id='item_qty' name='item_qty' value='".$list->qty."' class='form-control form-control-sm' >";
                                                                $html .="<td>".$list->size."</td>";
                                                                // $html .="<td>".$list->color."</td>";
                                                                $html .="<td>".$list->price."</td>";
                                                                $html .="<td>".$list->price."</td>";
                                                                $html .="<td>0</td>";
                                                                $html .="<td>".$list->amount."</td>";
                                                                $html .="<td>".$list->taxfree_amount."</td>";
                                                                $html .="<td>".$list->cgst."</td>";
                                                                $html .="<td>".$list->sgst."</td>";
                                                                $html .="<td>".$list->igst."</td>";
                                                            $html .="</tr>";
                                                            $total_amount =  $list->total_amount;
                                                        
                                                            $total_cgst =  $total_cgst + $list->cgst;
                                                            $total_sgst =  $total_sgst+ $list->sgst;
                                                            $total_igst =  $total_igst+ $list->igst;

                                                        }
                                            
                                                    $html .="</tbody>";
                                                $html .="<tfoot>";
                                                    $html .="<tr>";
                                                        $html .="<td colspan='3'></td>";
                                                        $html .="<td>".$key."</td>";
                                                        $html .="<td colspan='3'></td>";
                                                        $html .="<td><b>Total :</b></td>";
                                                        $html .="<td>".$total_amount."</td>";
                                                        $html .="<td>".$total_amount."</td>";
                                                        $html .="<td>".$total_sgst."</td>";
                                                        $html .="<td>".$total_cgst."</td>";
                                                        $html .="<td>".$total_igst."</td>";
                                                    $html .="</tr>";
                                                $html .="</tfoot>";
                                            $html .="</table>";
                                        $html .="</div>";
                                    $html .="</div>";
                                
                            $html .="</div>";
                            $html .="<div class='row'>";
                                $html .="<div class='col-md-8'>";
                                    $html .="<span class='float-start'>Amount of Tax Subject to Reverse Change :</span><br>";
                                $html .="</div>";
                                $html .="<div class='col-md-2'>";
                                    $html .="<span class='float-end'>GROSS AMOUNT:</span><br>";
                                    $html .="<span class='float-end'>LESS DISCOUNT:</span><br>";
                                    $html .="<span class='float-end'>ADD CGST :</span> <br>";
                                    $html .="<span class='float-end'>ADD SGST : </span><br>";
                                
                                    $html .="<span class='float-end'>G.TOTAL : </span><br>";

                                $html .="</div>";
                                $html .="<div class='col-md-2'>";
                                    $html .="<b class='text-center'>".$customer_detail->total_amount."</b><br>";
                                    $html .="<b class='text-center'>0.00</b><br>";
                                    $html .="<b class='text-center'>".$total_cgst."</b><br>";
                                    $html .="<b class='text-center'>".$total_sgst."</b><br>";
                                    $html .="<b class='text-center'>".$customer_detail->total_amount."</b><br>";

                                $html .="</div>";
                            $html .="</div>";
                            // $html .="<hr>";
                            // $html .="<div class='row text-center'>";
                            //     $html .="<h6><b>Thank  Have a Nice Day </b></h6>";
                            //     $html .="<small>Visit Again !</small>";
                            // $html .="</div>";
                        $html .="</div>";
                        $html .="<input type='hidden' id='alteration_voucher_id' name='alteration_voucher_id' value='".$list->id."' class='form-control form-control-sm' >";

                        $html .="<div class='modal-footer'>";
                            $html .="<button type='button' id='generateAltertionVoucher' generate-product-id='generate_product_id' class='btn btn-success btn-sm'>save</button>";
                        $html .="</div>";
                    $html .="</div>";
                $html .="</div>";

         
            return response()->json([
                'status'=>200,
                'html'=>$html,
                'customer_bill_detail'=>$customer_bill_detail,
                'customer'=>$customer,
                'customer_detail'=>$customer_detail
          
            ]);
        }

        function saveAlterationItem(Request $req)
        {
            $validator = Validator::make($req->all(),[
                'product_id' => 'required|max:191'
            ]);
    
            if($validator->fails())
            {
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages("plz fill size"),
                ]);
            }else{
                // $count = 1;
                for ($i=0; $i < count($req->product_id); $i++) { 
            
                    // $count = $count + 1;
                    $model = new AlterationItem;
                    $model->alteration_voucher_id = $req->input('alteration_voucher_id');
                    $model->alteration_date = date('Y-m-d');
                    $model->alteration_time = date('g:i A');
                    $model->product_id = $req->product_id[$i];
                    $model->item_qty = $req->input('item_qty');
                    // $model->status = $req->input('status');
                    $model->save();
                
                }
                return response()->json([   
                    'status'=>200
                ]);
            }
               
            
        }

            // public function generateAlerationVoucher($customer_id)
            // {
                // Previous coding
                //  $customers =Customer::find($customer_id);
                //  $order_items = CustomerBillInvoice::join('customers','customers.id','=','customer_bill_invoices.customer_id')->
                //     join('purchase_entries','purchase_entries.id','=','customer_bill_invoices.product_id')
                //     ->where('customer_bill_invoices.customer_id',$customers->id)
                //     ->select(['customer_bill_invoices.*'])->get(); 

        // $html = "";
        // $html .="<div class='modal-dialog modal-lg'>";
        //     $html .="<div class='modal-content'>";
        //         $html .="<div class='modal-header'>";
        //             $html .="<h5 class='modal-title' id='staticBackdropLabel'><b>$customers->customer_name</b></h5>";
        //             $html .="<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        //         $html .="</div>";
        //             $html .="<div class='modal-body' id='invoiceModalPrint' style='border:1px solid black'>";
        //             $html .="<form id='alterationVoucherForm'>";
        //             $html .="<div class='alterationvoucher_err'></div>";
        //                 $html .="<div class='row mb-1'>";
        //                         $html .="<div class='col-md-3 '>";
        //                             $html .="<span></span><br>";
        //                             $html .="<span>GST NO: <small>4125666</small></span><br>";
        //                             $html .="<span></span><br>";
        //                         $html .="</div>";
        //                     $html .="<div class='col-md-6 text-center'>";
        //                             $html .="<span>SALES INVOICE</span><br>";
        //                             $html .="<span>ERENOWN CLOTHING CO </span><br>";
        //                             $html .="<span>Shop no.8-9,Ground Floor Samdariya Mall </span><br>";
        //                             $html .="<span>Jabalpur -482002 </span><br>";
        //                     $html .="</div>";
        //                     $html .="<div class='col-md-3' >";
        //                             $html .="<span>Phone no: 0761-4047699</span><br>";
        //                             $html .="<span></span><br>";
        //                             $html .="<span>Mobile no : 09826683399<small></small></span><br>";
        //                             $html .="<span></span><br>";
        //                     $html .="</div>";
        //                 $html .="</div>";
        //                 $html .="<div class='row '>";
        //                     $html .="<div class='col-md-6' style='border:1px solid black'>";
        //                     $html .="<span>Customer name: <small name='customer_id'>".$customers->customer_name."</small></span><br>";
        //                     $html .="<input type='hidden' id='customer_id' value='".$customers->id."' class='form-control form-control-sm' >";
        //                     $html .="<span>Location : <small>Jabalpur</small></span><br>";
        //                     $html .="<span>Mobile no : <small>".$customers->mobile_no."</small></span><br>";
        //                     $html .="<span>State code  : <small>0761</small></span><br>";
        //                     // $html .="<span>Payment : <small>".$payment_mode."</small></span> ";
        //                     $html .="</div>";
        //                     $html .="<div class='col-md-2' style='border:1px solid black'>";
        //                     $html .="<span class=''>CASH :<br/> <small><b>10000</b></small></span> ";
        //                     $html .="</div>";
        //                     $html .="<div class='col-md-4' style='border:1px solid black'>";
        //                     $html .="<span>Invoice No : <small class='float-end'>".$customers->invoice_no."</small></span><br>";
        //                         $html .="<span class=''>Date : <small class='float-end'>".date('d/M/Y', strtotime($customers->date))."</small></span><br>";
        //                         $html .="<span class=''>Attent By : <small class='float-end'></small></span> ";
        //                     $html .="</div>";
        //                 $html .="</div>";
        //                 // $html .="<hr>";

        //                 $html .="<div class='row mt-2'>";
        //                     $html .="<div class='table-responsive'>";
        //                     $html .="<table class='table table-bordered'>";
                        
        //                         $html .="<thead>";
        //                             $html .="<tr>";
        //                                 $html .="<th>#</th>";
        //                                 $html .="<th>Check</th>";
        //                                 $html .="<th>Item Name</th>";
        //                                 $html .="<th>Qty</th>";
        //                                 $html .="<th>Size</th>";
        //                                 $html .="<th>Color</th>";
        //                                 $html .="<th>MRP</th>";
        //                                 $html .="<th>Rate</th>";
        //                                 $html .="<th>Disc</th>";
        //                                 $html .="<th>Total</th>";
        //                                 $html .="<th>Taxable</th>";
        //                                 $html .="<th>CGST%</th>";
        //                                 $html .="<th>SGST%</th>";
        //                             $html .="</tr>";
        //                         $html .="</thead>";
        //                         $html .="<tbody>";
        //                         foreach ($order_items as $key => $list) {
        //                             $html .="<tr>";
        //                                 $html .="<td>".++$key."</td>";

                                       
        //                                 // <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        




        //                                 $html .="<td><div class='form-check text-center'>
        //                                     <input class='form-check-input' type='checkbox'  name='checked_alt_voucher' id='checked_alt_voucher' value='1'>
        //                                 </div></td>";
        //                                 $html .="<td>".ucwords($list->product)."</td>";
        //                                 $html .="<td><input type='hidden' id='product_id' value='".$list->product_id."' class='form-control form-control-sm' ></td>";
        //                                 $html .="<td>".$list->qty."</td>";
        //                                 $html .="<td>".$list->size."</td>";
        //                                 $html .="<td>".$list->color."</td>";
        //                                 $html .="<td>".$list->price."</td>";
        //                                 $html .="<td>".$list->price."</td>";
        //                                 $html .="<td>".$list->price."</td>";
        //                                 $html .="<td>".$list->amount."</td>";
        //                                 $html .="<td>".$list->amount."</td>";
        //                                 $html .="<td>".$list->amount."</td>";
        //                                 $html .="<td>".$list->amount."</td>";
        //                             $html .="</tr>";
        //                         }
                                    
        //                         $html .="</tbody>";
        //                         $html .="<tfoot>";
        //                             $html .="<tr>";
        //                             $html .="<td colspan='3'></td>";
        //                             $html .="<td>".$key."</td>";
        //                                 $html .="<td colspan='4'></td>";
        //                                 $html .="<td><b>Total :</b></td>";
        //                                 // $html .="<td>".$customers->total_amount."</td>";
        //                                 // $html .="<td>".$customers->total_amount."</td>";
        //                                 // $html .="<td>".$customers->total_amount."</td>";
        //                                 // $html .="<td>".$customers->total_amount."</td>";
        //                             $html .="</tr>";
        //                         $html .="</tfoot>";
        //                     $html .="</table>";
        //                     $html .="</div>";
        //                 $html .="</div>";

        //                 $html .="<div class='row'>";
        //                 $html .="<div class='col-md-8'>";
        //                 $html .="<span class='float-start'>Amount of Tax Subject to Recvers Change :</span><br>";
                           
        //                 $html .="</div>";
        //                 $html .="<div class='col-md-2'>";

        //                         $html .="<span class='float-end'>GROSS AMOUNT:</span><br>";
        //                         $html .="<span class='float-end'>LESS DISCOUNT:</span><br>";
        //                         $html .="<span class='float-end'>ADD CGST :</span> <br>";
        //                         $html .="<span class='float-end'>ADD SGST : </span><br>";
        //                         $html .="<span class='float-end'>OTHER ADJ :</span> <br>";
        //                         $html .="<span class='float-end'>R/OFF AMT :</span> <br>";
        //                         $html .="<span class='float-end'>G.TOTAL : </span><br>";

        //                 $html .="</div>";
        //                 $html .="<div class='col-md-2'>";

        //                     // $html .="<small class='text-center'>".$customers->total_amount."</small><br>";
        //                     // $html .="<small class='text-center'>".$customers->total_amount."</small><br>";
        //                     // $html .="<small class='text-center'>".$customers->total_amount."</small><br>";
        //                     // $html .="<small class='text-center'>".$customers->total_amount."</small><br>";
        //                     // $html .="<small class='text-center'>".$customers->total_amount."</small><br>";
        //                     // $html .="<small class='text-center'>".$customers->total_amount."</small><br>";
        //                     // $html .="<small class='text-center'>".$customers->total_amount."</small><br>";

        //             $html .="</div>";
        //             $html .="</div>";

                    
        //                 $html .="<hr>";
        //                 $html .="<div class='row text-center'>";
        //                     $html .="<h6><b>Thank  Have a Nice Day </b></h6>";
        //                     $html .="<small>Visit Again !</small>";
        //                 $html .="</div>";

        //             // $html .="</div>";
                


        //      $html .="</div>";

        //         $html .="<div class='modal-footer'>";
        //             // $html .="<button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Close</button>";
        //             // $html .="<button type='button' id='printBtn' class='btn btn-primary btn-sm' order-id='".$order->id."'>Print</button>";
        //             $html .="<button type='button' id='saveAltertion' class='btn btn-success btn-sm'>save</button>";
        //         $html .="</div>";
        //         $html .="</form>";

        //     $html .="</div>";
        // $html .="</div>";
        // return response()->json([
        //     'status'=>200,
        //     'html'=>$html,
        //     ' $customers'=>$customers
        // ]);
    // }
    

  
//   public function getCustomerBillData($customer_id)
//   {
//       $customers = Customer::where(['id'=>$customer_id])->get();
      
//       $html = "";

//       //$html .= "<table class='table table-striped'>";

//           $html .= "<thead>";
//               $html .= "<tr>";
//                   $html .= "<th>SN</th>";
//                   $html .= "<th>Customer name</th>";
//                   $html .= "<th>mobile no</th>";
//                   $html .= "<th>Action</th>";
//               $html .= "</tr>";
//           $html .= "</thead>";
//           $html .= "<tbody>";
//               foreach ($customers as $key => $list) {
//                   $html .= "<tr class='client_project_row ' project-id='".$list->id."'>";
//                       $html .= "<td>" . ++$key . "</td>";
//                       $html .= "<td>" . $list->customer_name ."</td>";
//                       $html .= "<td>" . $list->mobile_no ."</td>";
//                       $html .= "<td> 
//                      <button type='button' class='btn btn-info btn-sm orderInvoiceBtn mr-1'  value='".$list->id."'>bills</button>
//                      </td>";
//                   $html .= "</tr>";
//               }
//           $html .= "<tbody>";
         

//       // $html .= "</table>";

//       return response()->json([
//           'status'=>200,
//           'customers'=>$customers,
//           'html'=>$html
//       ]);

//   }


// get cutomer bills
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

}


