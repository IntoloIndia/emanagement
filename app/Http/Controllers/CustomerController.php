<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerBill;
use App\Models\CustomerBillInvoice;
use App\Models\CustomerPoint;
use Validator;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::join('cities','customers.city_id','=','cities.id')
        ->select('customers.*','cities.city')
        ->get();
        $customer_points = CustomerPoint::all();
        
        return view('customer',[
            'customers' => $customers,
            'customer_points' => $customer_points
        ]);
    }
    public function CustomerDetail($customer_id)
    {
        $customer_detail = Customer::join('states','customers.state_type','=','states.id')
        ->join('cities','customers.city_id','=','cities.id')
        ->where(['customers.id'=>$customer_id])
        ->first(['customers.customer_name' ,'customers.date','customers.birthday_date','customers.month_id','states.state','cities.city','customers.gst_no']);
        
        
        // $customer_detail = Customer::join('states','customers.state_type','=','states.id')->join('cities','customers.city_id','=','cities.id')
        // ->where(['customers.id'=>$customer_id])->select('customers.*','states.state','cities.city')->get();
        $customer_bills = CustomerBill::where(['customer_id'=>$customer_id])
            ->orderBy('bill_date','DESC')
            ->orderBy('bill_time','DESC')->get();

        // $customer_bills = CustomerBill::join('customer_bill_invoices','customer_bills.id','=','customer_bill_invoices.bill_id')
        // ->where(['customer_bills.customer_id'=>$customer_id])
        // ->select('customer_bills.*','customer_bill_invoices.product_code','customer_bill_invoices.product_id','customer_bill_invoices.qty','customer_bill_invoices.size','customer_bill_invoices.price','customer_bill_invoices.taxfree_amount','customer_bill_invoices.sgst','customer_bill_invoices.cgst','customer_bill_invoices.igst','customer_bill_invoices.amount')->get();

        $html = "";
        $html .= "<div class='row'>";
            $html .= "<div class='col-md-12 text-center'><b>".ucwords($customer_detail->customer_name)."</b></div>";
            $html .= "</div>";
        $html .= "<div class='row'>";
            $html .= "<div class='col-md-3'>".$customer_detail->birthday_date. " " .date('M',strtotime($customer_detail->month_id))."</div>";
            $html .= "<div class='col-md-9 text-end'>".ucwords($customer_detail->state).", ".ucwords($customer_detail->city). "</br>GST No - ".$customer_detail->gst_no. "</div></br>";
        $html .= "</div>";
        $html .= "<hr>";
        $html .="<div class='table-responsive p-0' style='height:300px;'>";
        $html .="<table class='table  table-striped table-head-fixed text-nowrap'>";
            $html .="<thead>";
                $html .="<tr>";
                    $html .="<th>S No</th>";
                    $html .="<th>Date</th>";
                    $html .="<th>Time</th>";
                    $html .="<th>Invoice No</th>";
                    $html .="<th>Total amount</th>";
                    $html .="<th>Action</th>";
                
                $html .="</tr>";
            $html .="</thead>";
                $html .="<tbody>";
                    foreach ($customer_bills as $key => $bills) {
                    
                        $html .="<tr>";
                            $html .="<td>".++$key."</td>";
                            $html .="<td>".date('d-m-Y',strtotime($bills->bill_date))."</td>";
                            $html .="<td>".$bills->bill_time."</td>";
                            $html .="<td>".$bills->invoice_no."</td>";
                            $html .="<td>".$bills->total_amount."</td>";
                            $html .="<td ><i class='fas fa-file-invoice' id='showGenerateInvoiceModal' bill-id='".$bills->id."' style='font-size:24px'></i></td>";
                            
                        $html .="</tr>";
                    }
                $html .="</tbody>";
            $html .="<tfoot>";
                $html .="<tr>";
               
                $html .="</tr>";
            $html .="</tfoot>";
        $html .="</table>";
    $html .="</div>";

        return response()->json([
            'status'=>200,
            'customer_detail'=>$customer_detail,
            'customer_bills'=>$customer_bills,
            'html'=>$html
        ]);
    }

    // public function getCustomerData($customer_id)
    // {
    //     $customers = Customer::where(['id'=>$customer_id])->get();
        
    //     $html = "";

    //     //$html .= "<table class='table table-striped'>";

    //         $html .= "<thead>";
    //             $html .= "<tr>";
    //                 $html .= "<th>SN</th>";
    //                 $html .= "<th>Customer name</th>";
    //                 // get customer_id
    //                 //  $html .= "<th><input type='hidden' id='customer_id' value='".$customer->id."' class='form-control form-control-sm'></th>";
    //                 $html .= "<th>mobile no</th>";
    //                 // $html .= "<th>Action</th>";
    //             $html .= "</tr>";
    //         $html .= "</thead>";
    //         $html .= "<tbody>";
    //             foreach ($customers as $key => $list) {
    //                 $html .= "<tr class='client_project_row'  project-id='".$list->id."'>";
    //                     $html .= "<td>" . ++$key . "</td>";
    //                     $html .= "<td>" . $list->customer_name ."</td>";
    //                     // $html .= "<td>" . $list->id ."</td>";
    //                     $html .= "<td>" . $list->mobile_no ."</td>";
    //                     // $html .= "<td> 
    //                     // <button type='button' class='btn btn-info btn-sm editStyleNoBtn mr-1'  value='".$list->id."'>Edit</button>
    //                     //  <button type='button' class='btn btn-danger btn-sm deleteStyleNoBtn ml-1'  value='".$list->id."'>delete</button>
    //                     // </td>";
    //                 $html .= "</tr>";
    //             }
    //         $html .= "<tbody>";

    //     // $html .= "</table>";

    //     return response()->json([
    //         'status'=>200,
    //         'customers'=>$customers,
    //         'html'=>$html
    //     ]);
    // }

    // public function getCustomerPoints($customer_id)
    // {
        // $customer_points = Customer::where(['id'=>$customer_id])->get();
        // return response()->json([
        //     'status'=>200,
        //     'customer_points'=>$customer_points,
        //     'html'=>$html
        // ]);
    // }
    
}