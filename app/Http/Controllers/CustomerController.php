<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerBill;
use App\Models\CustomerBillInvoice;
use App\Models\CustomerPoint;
use App\Models\City;
use Validator;
use App\MyApp;

class CustomerController extends Controller
{
    public function index(){
        $cities = City::all();
        $customers = Customer::join('cities','customers.city_id','=','cities.id')
            ->select('customers.*','cities.city')
            ->get();
        $customer_points = CustomerPoint::all();
        
        return view('customer',[
            'cities' => $cities,
            'customers' => $customers,
            'customer_points' => $customer_points
        ]);
    }


    // function saveCustomerAdvanceAmount(Request $req)
    // {
    //     $validator = Validator::make($req->all(),[
    //         'customer_name' => 'required',
    //         'mobile_no' => 'required|unique:customers,mobile_no,'.$req->input('mobile_no'),
    //         'city_id' => 'required',
    //         'advance_amount' => 'required',
    //     ]);

    //     if($validator->fails())
    //     {
    //         return response()->json([
    //             'status'=>400,
    //             'errors'=>$validator->messages(),
    //         ]);
    //     }else{
    //         $model = new Customer ;
    //         $model->customer_name = $req->input('customer_name');
    //         $model->mobile_no = $req->input('mobile_no');
    //         $model->city_id = $req->input('city_id');
    //         $model->advance_amount = $req->input('advance_amount');
            
    //         if($model->save()){
    //             return response()->json([
    //                 'status'=>200,
    //             ]);
    //         }
    //     }
    // }

    
    public function CustomerDetail($customer_id)
    {
        $customer_detail = Customer::join('cities','customers.city_id','=','cities.id')
        ->join('customer_points','customers.id','=','customer_points.customer_id')
        ->where(['customers.id'=>$customer_id])
        ->first(['customers.id','customers.customer_name' ,'customers.date','customers.birthday_date','customers.month_id','cities.city','customers.gst_no','customers.anniversary_date','customer_points.total_points']);
        
        $customer_bills = CustomerBill::where(['customer_id'=>$customer_id])
            ->orderBy('bill_date','DESC')
            ->orderBy('bill_time','DESC')->get();

        $html = "";
        $html .= "<div class='row'>";
            $html .= "<div class='col-md-12 text-center'><b>".ucwords($customer_detail->customer_name)."</b><br></div>";
            $member = getMemberShip($customer_detail->id);
            if($member == MyApp::SILVER)
            {
                $html .= "<div class='col-md-12 text-center' style='color:#454545';><b>".MyApp::SILVER."</b><br></div>";
            }
            else if($member == MyApp::GOLDEN)
            {
                $html .= "<div class='col-md-12 text-center' style='color:#D35400';><b>".MyApp::GOLDEN."</b><br></div>";
            }
            else{
                $html .= "<div class='col-md-12 text-center' style='color:#5D6D7E';><b>".MyApp::PLATINUM."</b><br></div>";
                
            }
            // $html .= "<div class='col-md-12 text-center text-red'><b>".($member)."</b><br></div>";
            $html .= "</div>";
        $html .= "<div class='row'>";
            $html .= "<div class='col-md-4'><b>Point : </b>$customer_detail->total_points<br><b>DOB : </b>".$customer_detail->birthday_date. " " .date('M',strtotime($customer_detail->month_id))."<br><b>Anniversary : </b>".date('d-m-Y',strtotime($customer_detail->anniversary_date))."</div>";
            // $html .= "<div class='col-md-4'><b>Point : </b><br><b>DOB : </b>".$customer_detail->birthday_date. " " .date('M',strtotime($customer_detail->month_id))."<br><b>Anniversary : </b>$customer_detail->anniversary_date</div>";
            $html .= "<div class='col-md-8 text-end'><b>City : </b>".ucwords($customer_detail->city). "</br><b>GSTNO :</b>  ".$customer_detail->gst_no. "</div></br>";
        $html .= "</div>";
        $html .= "<hr>";
        $html .="<div class='table-responsive p-0' style='height:300px;'>";
        $html .="<table class='table  table-striped table-head-fixed text-nowrap'>";
            $html .="<thead>";
                $html .="<tr>";
                    $html .="<th>S No</th>";
                    $html .="<th>Date</th>";
                    $html .="<th>Time</th>";
                    $html .="<th>Bill No</th>";
                    $html .="<th>Total amount</th>";
                    $html .="<th>Action</th>";
                $html .="</tr>";
            $html .="</thead>";
                $html .="<tbody>";
                $total_amount = 0; 
                    foreach ($customer_bills as $key => $bills) {
                        $html .="<tr>";
                            $html .="<td>".++$key."</td>";
                            $html .="<td>".date('d-m-Y',strtotime($bills->bill_date))."</td>";
                            $html .="<td>".$bills->bill_time."</td>";
                            $html .="<td>".$bills->id."</td>";
                            $html .="<td>".$bills->total_amount."</td>";
                            $html .="<td><i class='fas fa-file-invoice' id='showGenerateInvoiceModal' bill-id='".$bills->id."' style='font-size:24px'></i></td>";
                        $html .="</tr>";

                        $total_amount =  $total_amount + $bills->total_amount;

                    }
                        $html .="<tr>";
                        $html .=" <td colspan='3'></td>";
                        $html .=" <td><b>Grand Total</b></td>";
                        $html .=" <td><b>$total_amount<b></td>";
                        $html .=" <td> </td>";
                        $html .="</tr>";
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
            'html'=>$html,
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