<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerPoint;
use Validator;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::all();
        $customer_points = CustomerPoint::all();
        
        return view('customer',[
            'customers' => $customers,
            'customer_points' => $customer_points
        ]);
    }
    public function CustomerDetail($customer_id)
    {
        $customer_detail = Customer::where(['id'=>$customer_id])->get();
        
        $html = "";

        //$html .= "<table class='table table-striped'>";

            $html .= "<thead>";
                $html .= "<tr>";
                    $html .= "<th>Date</th>";
                    $html .= "<th>Time</th>";
                    $html .= "<th>Gst No</th>";
                    // get customer_id
                    //  $html .= "<th><input type='hidden' id='customer_id' value='".$customer->id."' class='form-control form-control-sm'></th>";
                    // $html .= "<th>mobile no</th>";
                    // $html .= "<th>Action</th>";
                $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
                foreach ($customer_detail as $key => $list) {
                    $html .= "<tr class='client_project_row'  project-id='".$list->id."'>";
                        $html .= "<td>" . ++$key . "</td>";
                        $html .= "<td>" . $list->date ."</td>";
                        // $html .= "<td>" . $list->id ."</td>";
                        $html .= "<td>" . $list->time ."</td>";
                        $html .= "<td>" . $list->gst_no ."</td>";
                        // $html .= "<td> 
                        // <button type='button' class='btn btn-info btn-sm editStyleNoBtn mr-1'  value='".$list->id."'>Edit</button>
                        //  <button type='button' class='btn btn-danger btn-sm deleteStyleNoBtn ml-1'  value='".$list->id."'>delete</button>
                        // </td>";
                    $html .= "</tr>";
                }
            $html .= "<tbody>";

        // $html .= "</table>";

        return response()->json([
            'status'=>200,
            'customer_detail'=>$customer_detail,
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