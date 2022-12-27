<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;
use App\Models\CustomerBillInvoice;
use App\Models\CustomerBill;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\Customer;
use App\MyApp;
use Validator;

class SalesReturnController extends Controller
{
    public function index(){
        $sales_return = SalesReturn::join('customer_bills','customer_bills.id','=','sales_returns.bill_id')
                    ->where(['sales_returns.release_status' => MyApp::RELEASE_PANDDING_STATUS])
                    ->select('customer_bills.customer_id','sales_returns.*')->get();

         $sales_return_items = array();

            foreach ($sales_return as $key => $list) {
                $sales_return_items[] = SalesReturnItem::join('sub_categories','sub_categories.id','=','sales_return_items.sub_category_id')
                ->where(['sales_return_id'=>$list->id])
                ->select('sales_return_items.*','sub_categories.sub_category')->get();     
        }
        $sales_return_data = SalesReturn::join('customers','customers.id','=','sales_returns.customer_id')
                            ->where(['sales_returns.release_status' => MyApp::RELEASE_STATUS])
                            ->select('customers.customer_name','sales_returns.*')->get();

            // dd($sales_return_data);

        return view('sales-return',[
            'sales_return' => $sales_return,
            'sales_return_items' => $sales_return_items,
            'sales_return_data' => $sales_return_data,
        ]);
    }

    public function getCustomerDetails($bill_no){
        $customer_details = CustomerBill::join('customers','customers.id','=','customer_bills.customer_id')
                        // ->join('customer_bill_invoices','customer_bill_invoices.bill_id','=','customer_bills.id')
                        ->where(['customer_bills.id'=>$bill_no])
                        ->select(['customer_bills.*','customers.customer_name','customers.mobile_no',
                        // 'customer_bill_invoices.product_code'
                        ])
                        ->first();
                if($customer_details){
                    return response()->json([
                       'status'=> 200,
                       'customer_details'=>$customer_details
                    ]);
                }else{
                    return response()->json([
                        'status'=> 400,
                        'customer_details'=>"data no found"
                     ]);
                }
    }
    
    public function getSalesReturnData($bill_no,$barcode_code)
    {
        
        $bill = CustomerBill::where(['id'=>$bill_no])->first('id');
        $customer_return_product = CustomerBillInvoice::join('sub_categories','sub_categories.id','=','customer_bill_invoices.product_id')
                                    ->where(['bill_id'=>$bill->id,'product_code'=>$barcode_code ])
                                    ->select(['customer_bill_invoices.*','sub_categories.sub_category'])
                                    ->first();
                                    
        return response()->json([
            'bill'=>$bill,
            'customer_return_product'=>$customer_return_product
        ]);
    }

    function saveSalesReturnProduct(Request $req)
        {
        
        $validator = Validator::make($req->all(),[
            'bill_id' => 'required|max:191',
            'customer_id' => 'required|max:191'
           
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all filed"),
            ]);
        }else{

            $bill_id = 0;
            $release_status = 0;
            $data = SalesReturn::where(['bill_id'=>$req->input('bill_id'),'release_status'=>0])->first(['id','release_status']);
            
            if ($data == null ) {
                
                $model = new SalesReturn;
                $model->bill_id = $req->input('bill_id');
                $model->customer_id = $req->input('customer_id');
                $model->create_date = date('Y-m-d');
                $model->create_time = date('g:i A');
                $model->save();
    
                        $bill_id = $model->id;
                    }else if($data->release_status > 0){

                        $model = SalesReturn::find($data->id);
                        $model->bill_id = $req->input('bill_id');
                        $model->customer_id = $req->input('customer_id');
                        $model->create_date = date('Y-m-d');
                        $model->create_time = date('g:i A');
                        $model->save();

                        $bill_id = $model->id;
                    }else{
                        
                        $bill_id = $data->id;
                    }

                    $sub_category_id = $req->input('sub_category_id');
                    $barcode = $req->input('barcode');
                    $sub_category_id = $req->input('sub_category_id');
                    $mrp = $req->input('mrp');
                    $qty = $req->input('qty');
                    $size = $req->input('size');
                    $amount = $req->input('amount');


          
                foreach ($sub_category_id as $key => $list) {
                   
                    $item = new SalesReturnItem;

                    $item->sales_return_id = $bill_id;
                    $item->sub_category_id = $sub_category_id[$key];
                    $item->barcode = $barcode[$key];
                    $item->mrp = $mrp[$key];
                    $item->qty = $qty[$key];
                    $item->size = $size[$key];
                    $item->amount = $amount[$key];
                    $item->create_date = date('Y-m-d');
                    $item->create_time = date('g:i A');
                    $item->save();
                } 

                return response()->json([   
                    'status'=>200,
                ]);
            
        }
    }

    function updateSalesReleaseStatus($sales_return_id)
    {
        $release_status_data =SalesReturn::find($sales_return_id);
        $release_status_data->release_status = MyApp::RELEASE_STATUS;
        $release_status_data->release_date = date('Y-m-d');
        $release_status_data->release_time = date('g:i A');
        $release_status_data->save();
        
        return response()->json([
            'status'=>200
        ]);
    }
    

}
