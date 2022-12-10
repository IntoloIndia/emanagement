<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Validator;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::all();
        return view('customer',[
            'customers' => $customers

        ]);
    }

    public function getCustomerData($customer_id)
    {
        $customers = Customer::where(['id'=>$customer_id])->get();
        
        $html = "";

        //$html .= "<table class='table table-striped'>";

            $html .= "<thead>";
                $html .= "<tr>";
                    $html .= "<th>SN</th>";
                    $html .= "<th>Customer name</th>";
                    $html .= "<th>mobile no</th>";
                    $html .= "<th>Action</th>";
                $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
                foreach ($customers as $key => $list) {
                    $html .= "<tr class='client_project_row' project-id='".$list->id."'>";
                        $html .= "<td>" . ++$key . "</td>";
                        $html .= "<td>" . $list->customer_name ."</td>";
                        $html .= "<td>" . $list->mobile_no ."</td>";
                        $html .= "<td> 
                        <button type='button' class='btn btn-info btn-sm editStyleNoBtn mr-1'  value='".$list->id."'>Edit</button>
                         <button type='button' class='btn btn-danger btn-sm deleteStyleNoBtn ml-1'  value='".$list->id."'>delete</button>
                        </td>";
                    $html .= "</tr>";
                }
            $html .= "<tbody>";
           

        // $html .= "</table>";

        return response()->json([
            'status'=>200,
            'customers'=>$customers,
            'html'=>$html
        ]);

    }
}