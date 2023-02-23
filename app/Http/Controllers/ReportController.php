<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Category;
use App\Models\Brand;
use App\Models\StyleNo;
use App\Models\CustomerBillInvoice;
use App\Models\Customer;
use App\Models\CustomerBill;
use App\Models\ApplyOffer;
use App\Models\Month;
use App\MyApp;
use DB;

class ReportController extends Controller
{
    //
    public function offerReport()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $offers = Offer::all();
        $style_nos = StyleNo::all();
        $bill_invoice_items = CustomerBillInvoice::all();
        
        return view('report.offer_report',[
            'offers'=>$offers,
            'categories'=>$categories,
            'brands'=>$brands,
            'style_nos'=>$style_nos,
            'bill_invoice_items'=>$bill_invoice_items
        ]);
    }

    public function salesReport()
    {
        return view('report.sales_report',[
         
        ]);
    }

    // public function salesReportDetail()
    public function salesReportDetail($month)
    {
        // dd($month);
        if($month != "")
        {
            $month = date('Y-m-d');
            // dd($month);
         }
        // $customers = Customer::whereDate('date', date('Y-m-d', strtotime($month)))
                $customers = Customer::whereDate('date', '=', $month)
                    ->orderBy('date','DESC')
                    ->orderBy('time','DESC')       
                    ->get();
                // $customers = Customer::whereMonth('created_at', '=', '02')
                // ->get(); 
                    
        
// dd($customers);
        $html = "";
       
            // $html .="<div class='row'>";
            //         $html .="<div class='col-md-3'>";                    
            //              $html .="<h2'><b>Sales Report</b></h2>"; 
            //          $html .="</div>";
            //         $html .="<div class='col-md-3'>";                    
            //              $html .="<input type='date'  id='from_date' class='form-control form-control-sm' value='date('d-m-Y', strtotime('-3 months'))'>"; 
            //          $html .="</div>";
            // $html .="</div>";
                    // <div class="col-md-3">
                    //     <input type="date"  id="to_date" class="form-control form-control-sm">
                    // </div>
                    // <div class="col-md-3">
                    //     <input type="month"  id="month" class="form-control form-control-sm">
                    // </div>
         $html .="<div class='accordion accordion-flush table-responsive' id='accordionFlushExample' style='max-height: 500px;'>";
             $html .="<table class='table table-striped table-head-fixed'>";
                 $html .="<thead>";
                     $html .="<tr>";
                         $html .="<th>SN</th>";
                         $html .="<th>Date</th>"; 
                         $html .="<th>Time</th>";
                         $html .="<th>Customer name</th>";
                         $html .="<th>Mobile</th>";                                
                     $html .="</tr>";
                 $html .="</thead>";          
                 $html .="<tbody>";
                 $total_qty = 0;    
                 $total_price = 0;   
                 $total_discount = 0;   
                 $online = 0;    
                 $cash = 0;    
                 $card = 0;    
                 $amount = 0;    
                 $total_balance_amount = 0;    
                 $received_amount = 0;    
                //  $month = date('d-m-Y');
                 foreach ($customers as $key => $list) 
                 {                          
                     $html .="<tr class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#collapse_".$list->id."' aria-expanded='false' aria-controls='flush-collapseOne'>";                             
                     
                                $sales_payments = getSalesPayment($list->id);  
                                // echo "<pre>";
                                // print_r($sales_payments);
                                // $sales_payments = getSalesPayment($list->id ,$month);  
                                
                                // $yesterday_date= date('d-m-Y',strtotime("-4 months"));
                                // $current_date = date('d-m-Y');
                                // if($from_date == '')
                                // {
                                //     $from_date = date('Y-m-d', strtotime($yesterday_date));
                                // }else{
                                //     $from_date = date('Y-m-d', strtotime($from_date));
                                // }
                        
                                // if($to_date == '')
                                // {
                                //     $to_date = date('Y-m-d', strtotime($current_date));
                                // }else{
                                //     $to_date = date('Y-m-d', strtotime($to_date));
                                // }            
                                
                             $html .="<td>".++$key."</td>";                     
                             $html .="<td>".date('d-m-Y',strtotime($list->date))."</td>";
                             $html .="<td>".$list->time."</td>";
                             $html .="<td>".$list->customer_name."</td>";
                             $html .="<td>".$list->mobile_no."</td>";                                  
                             $html .="</tr>";        
                             $html .="<tr>";
                             $html .="<td colspan='7'>";
                                 $html .="<div id='collapse_".$list->id."' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>";
                                 $html .="<div class='accordion-body'>";
                                         $html .="<table class='table'>";
                                             $html .="<thead>";
                                                 $html .="<tr>";
                                                     $html .="<th>SNo</th>";
                                                     $html .="<th>Product</th>";
                                                     $html .="<th>Qty</th>";
                                                     $html .="<th>Size</th>";
                                                     $html .="<th>Price</th>";
                                                     $html .="<th>Discount</th>";
                                                     $html .="<th>Amount</th>";
                                                     $html .="</tr>";
                                                     $html .="</thead>";
                                                     $html .="<tbody>";                                                                                  
                                                      
                                                     foreach ($sales_payments as $key => $list)  
                                                     {
                                                        $total_qty = $total_qty + $list->qty;
                                                        $total_price = $total_price + $list->price;
                                                        $total_discount = $total_discount + $list->discount_amount;
                                                        $pay_online = $list->pay_online;
                                                        $pay_cash = $list->pay_cash;
                                                        $pay_card = $list->pay_card;
                                                        
                                                        $total_amount = $list->total_amount;
                                                        $balance_amount =$list->balance_amount;
                                                        $html .="<tr>";  
                                                        $html .="<td>".++$key."</td>";
                                                        $html .="<td>".$list->sub_category."</td>";
                                                        $html .="<td>".$list->qty."</td>";
                                                        $html .="<td>".$list->size."</td>";
                                                        $html .="<td>".$list->price."</td>";
                                                        $html .="<td>".$list->discount_amount."</td>";
                                                        $html .="<td>".$list->amount."</td>";
                                                        $html .="</tr>";  
                                                    }               
                                                    $online = $online + $pay_online ;
                                                    $cash = $cash + $pay_cash;
                                                    $card = $card + $pay_card;
                                                    $amount = $amount + $total_amount;
                                                    $received_amount = $online +$cash + $card; 
                                                    $total_balance_amount = $total_balance_amount + $balance_amount;
                                            $html .="</tbody>";
                                        $html .="</table>";
                                    $html .="</div>";
                                $html .="</div>";                                   
                            $html .="</td>";
                        $html .="</tr>";
                    }                                   
                $html .="</tbody>";
            $html .="</table>";
        $html .="</div>";
        // $html .="<h2>".$received_amount."</h2>";
       
        return response()->json([
            'status'=>200,
            'customers'=>$customers,
            'html'=>$html,
            'total_qty'=>$total_qty,
            'total_price'=>$total_price,
            'total_discount'=>$total_discount,
            'online'=>$online,
            'cash'=>$cash,
            'card'=>$card,
            'received_amount'=>$received_amount,
            'amount'=>$amount,
            'total_balance_amount'=>$total_balance_amount            
        ]);
    }

    public function brandReport($month_id=0)
    {
        if($month_id > 0){
            $selected_month = $month_id;
        }else {
            $selected_month = date('m');
        }

        $months = Month::all();
        $all_brand = Brand::all();

        $brands = ApplyOffer::whereMonth('offer_to', $selected_month)
            ->join('brands','brands.id','=','apply_offers.brand_id')
            ->select('apply_offers.brand_id','brands.brand_name')
            ->groupBy('apply_offers.brand_id','brands.brand_name')
            ->get();

       
        $brand_detail = array();
        foreach($brands as $key => $list)   
        {
            $offers = ApplyOffer::where(['brand_id'=>$list->brand_id])
                ->select('apply_offers.*')
                ->get();
                
        
                foreach($offers as $key1 => $offer_list){
                    $brand_detail[] = CustomerBillInvoice::where(['offer_id'=>$offer_list->id])
                    ->join('sub_categories','customer_bill_invoices.product_id','=','sub_categories.id')               
                    ->groupBy(['id','offer_id','product_id','qty','size','price','amount','discount_amount','discount_percentage','sgst','cgst','igst','sub_category'])                               
                    ->select('customer_bill_invoices.id','customer_bill_invoices.offer_id','customer_bill_invoices.product_id','customer_bill_invoices.qty','customer_bill_invoices.size','customer_bill_invoices.price','customer_bill_invoices.amount','customer_bill_invoices.discount_amount','customer_bill_invoices.discount_percentage','customer_bill_invoices.cgst','customer_bill_invoices.sgst','customer_bill_invoices.igst','sub_categories.sub_category')
                    ->get(['customer_bill_invoices.*']); 
                    
                }                
            }
            // dd($brand_detail);
            // dd($offer_list);
            
        return view('report.brand_report',[
            'status'=>200,
            'all_brand'=>$all_brand,
            'brands'=>$brands,
            'brand_detail'=>$brand_detail,
            'months'=>$months,
            'selected_month'=>$selected_month,
        ]);

    }
    // function filterOfferReport(){
    //    $months = CustomerBillInvoice::whereMonth('date', date('m'))->get();
    // //    dd($months);


    //    return response()->json([
    //     'status'=>200,
    //     'months'=>$months,
        
    //    ]);
    // }

}
   