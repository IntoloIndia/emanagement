<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;
use App\Models\CustomerBillInvoice;
use App\Models\ManageStock;
use App\MyApp;

class ProductAPIController extends Controller
{
    //
    public function availableStock()
    {
        // $products = PurchaseEntryItem::all(['id','purchase_entry_id','size','qty']);



        $products = PurchaseEntry::join('purchase_entry_items','purchase_entries.id','=','purchase_entry_items.purchase_entry_id')
            ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
            ->select('purchase_entries.id','purchase_entries.color','purchase_entry_items.purchase_entry_id','purchase_entry_items.size','purchase_entry_items.qty','sub_categories.sub_category')
            ->get();


        // $products = PurchaseEntryItem::join(['id','purchase_entry_id','size','qty']);

            // ->get(['purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price', 'purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category']);
       
        // $products = PurchaseEntry::join('categories', 'purchase_entries.category_id','=','categories.id')
        //     ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
        //     ->where('purchase_entries.status', MyApp::AVAILABLE)
        //     ->get(['purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price', 'purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category']);


        return response()->json([
            'data'=>$products,
            'count'=>$products->count(),
        ]); 
    }

    public function filterAvailableStock(Request $req )
    {
        $products = PurchaseEntry::join('categories', 'purchase_entries.category_id','=','categories.id')
            ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
            ->where('purchase_entries.status', MyApp::AVAILABLE)
            ->select('purchase_entries.id','purchase_entries.product_code', 'purchase_entries.product', 'purchase_entries.sales_price','purchase_entries.size', 'purchase_entries.color','categories.category', 'sub_categories.sub_category');
            
            if ($req->category_id > 0) {
                $products->where('purchase_entries.category_id', '=', $req->category_id);
            }
            if ($req->sub_category_id > 0) {
                $products->where('purchase_entries.sub_category_id', '=', $req->sub_category_id);
            }
            if ($req->size != '') {
                $products->where('purchase_entries.size', '=', $req->size);
            }
            if ($req->color != '') {
                $products->where('purchase_entries.color', '=', $req->color);
            }
            if ($req->brand != '') {
                $products->where('purchase_entries.brand', '=', $req->brand);
            }

            $data = $products->get();

            // $users = User::where('is_active', true);
            // if ($request->has('age_more_than')) {
            //     $users->where('age', '>', $request->age_more_than);
            // }
            // if ($request->has('gender')) {
            //     $users->where('gender', $request->gender);
            // }
            // if ($request->has('created_at')) {
            //     $users->where('created_at','>=', $request->created_at);
            // }
            // return $users->get();
        
        return response()->json([
            'data'=>$data,
            'count'=>$data->count(),
        ]); 
    }

    public function salesInvoice()
    {
        $date = date('Y-m-d');
        // $date = "2022-12-26";
        // $sales = CustomerBillInvoice::where('date', $date)->get();


        // $SubCategories = SubCategory::join('categories','categories.id','=','sub_categories.category_id')
        //         ->select('sub_categories.category_id','categories.category')
        //             ->groupBy('sub_categories.category_id','categories.category')
        //             ->get();

        // join('sub_categories','sub_categories.id','=','customer_bill_invoices.product_id')

        $sales = CustomerBillInvoice::join('sub_categories','customer_bill_invoices.product_id','=','sub_categories.id')
                ->groupBy(['customer_bill_invoices.product_id', 'sub_categories.sub_category', 'customer_bill_invoices.product_code', 'customer_bill_invoices.qty','customer_bill_invoices.size'])
                ->where('customer_bill_invoices.date', $date)
                ->selectRaw('customer_bill_invoices.product_id,customer_bill_invoices.product_code,sum(customer_bill_invoices.qty) as qty,customer_bill_invoices.size,sub_categories.sub_category')
                ->get();

        // $sales = CustomerBillInvoice::groupBy(['product_code','size','price','product_id'])
        //     ->where('date', $date)
        //     ->selectRaw('sum(qty) as qty,price,product_id, product_code, size')
        //     ->get();

        // $sales = CustomerBillInvoice::groupBy(['product_code','size'])
        //     ->where('date', $date)
        //     ->selectRaw('sum(qty) as qty, product_code, size')
        //     ->get();

      


        return response()->json([
            'data'=>$sales,
            'count'=>$sales->count(),
        ]); 
    }

    public function filterSalesInvoice(Request $req)
    {
        $date = date('Y-m-d');

        $sales = CustomerBillInvoice::join('purchase_entries', 'customer_bill_invoices.product_id','=','purchase_entries.id')
            // ->where('customer_bill_invoices.date', $date)
            ->select('customer_bill_invoices.*','purchase_entries.product','purchase_entries.category_id','purchase_entries.sub_category_id','purchase_entries.size','purchase_entries.color');

            if ($req->category_id > 0) {
                $sales->where('purchase_entries.category_id', '=', $req->category_id);
            }
            if ($req->sub_category_id > 0) {
                $sales->where('purchase_entries.sub_category_id', '=', $req->sub_category_id);
            }
            if ($req->size != '') {
                $sales->where('purchase_entries.size', '=', $req->size);
            }
            if ($req->color != '') {
                $sales->where('purchase_entries.color', '=', $req->color);
            }
            if ($req->brand != '') {
                $products->where('purchase_entries.brand', '=', $req->brand);
            }

            $data = $sales->get();

        return response()->json([
            'data'=>$data,
            'count'=>$data->count(),
        ]); 
    }

    // show filter product

    public function showProduct($category_id, $sub_category_id="0" ,$brand_id ="0", $style_no_id="0", $color="")
    {

        $stock = ManageStock::groupBy(['purchase_entry_id'])
                ->where('total_qty','>', 0)
                ->selectRaw('purchase_entry_id')
                ->get();

        $purchase_entry = array();
        foreach ($stock as $key => $list) {
            $data = PurchaseEntry::join('categories','purchase_entries.category_id','=','categories.id')
                    ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
                    ->join('brands','purchase_entries.brand_id','=','brands.id')
                    ->join('style_nos','purchase_entries.style_no_id','=','style_nos.id')
                    ->where('purchase_entries.id', $list->purchase_entry_id)
                    ->select('purchase_entries.*','categories.category','sub_categories.sub_category','brands.brand_name','style_nos.style_no');
                    // ->first();

                    if($category_id > 0){
                        $data->where('purchase_entries.category_id', $category_id);
                    }
                    if($sub_category_id > 0){
                        $data->where(['purchase_entries.sub_category_id'=> $sub_category_id]);
                    }
                    if($brand_id > 0 ){
                        $data->where(['purchase_entries.brand_id'=> $brand_id]);
                    }
                    if($style_no_id > 0 ){
                        $data->where(['purchase_entries.style_no_id'=> $style_no_id]);
                    }
                    if($color != null){
                        $data->where(['purchase_entries.color'=> $color]);
                    }
                  
                  
                    $stock_data = $data->first();
                    if( $stock_data != null ){
                        $purchase_entry[] = $stock_data;
                    }
        }

        // $html ="";

        // $html .= "<div class='accordion accordion-flush table-responsive' id='accordionFlushExample' style='max-height: 500px;'>";
        //     $html .= "<table class='table table-striped table-head-fixed'>";
        //         $html .= "<thead>";
        //             $html .= "<tr style='position: sticky;z-index: 1;'>";
        //                 $html .= "<th scope='col'>SN</th>";
        //                 $html .= "<th scope='col'>Category</th>";
        //                 $html .= "<th scope='col'>Sub Category</th>";
        //                 $html .= "<th scope='col'>Brand</th>";
        //                 $html .= "<th scope='col'>Style No</th>";
        //                 $html .= "<th scope='col'>Color</th>";
        //                 $html .= "<th scope='col'>Qty</th>";
        //             $html .= "</tr>";
        //         $html .= "</thead>";
        //         $html .= "<tbody >";

        //         $total_quantity = 0;
        //         $total_amount = 0;

        //         foreach ($purchase_entry as $key => $list){
        //             $stock_items = getStockItems($list->id);
                   
        //             $html .= "<tr class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#collapse_".$list->id."' aria-expanded='false' aria-controls='flush-collapseOne'>";
        //                 $html .= "<td>" .++$key. "</td>";
        //                 $html .= "<td>".ucwords($list->category)."</td>";
        //                 $html .= "<td>".ucwords($list->sub_category)."</td>";
        //                 $html .= "<td>".ucwords($list->brand_name)."</td>";
        //                 $html .= "<td>".ucwords($list->style_no)."</td>";
        //                 $html .= "<td>".ucwords($list->color)."</td>";
        //                 $html .= "<td>".$stock_items['total_quantity']."</td>";
        //             $html .= "</tr>"; 

        //             $html .= "<tr>";
        //                 $html .= "<td colspan='7'>";
        //                     $html .= "<div id='collapse_".$list->id."' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>";
        //                         $html .= "<div class='accordion-body'>";
        //                             $html .= "<table class='table'>";
        //                                 $html .= "<thead>";
        //                                     $html .= "<tr>";
        //                                         $html .= "<th> SN</th>";
        //                                         $html .= "<th> Size</th>";
        //                                         $html .= "<th> Qty</th>";
        //                                         $html .= "<th> Price</th>";
        //                                         $html .= "<th> Amount</th>";
        //                                     $html .= "</tr>";
        //                                 $html .= "</thead>";
        //                                 $html .= "<tbody>";
        //                                     $total = 0;
        //                                     foreach ($stock_items['items'] as $key1 => $item){
        //                                         $item_detail = getItemsDetail($item->purchase_entry_id, $item->size);
                                             
        //                                         $html .= "<tr>";
        //                                             $html .= "<td>".++$key1."</td>";
        //                                             $html .= "<td>".strtoupper($item->size)."</td>";
        //                                             $html .= "<td>".$item->total_qty."</td>";
        //                                             $html .= "<td>".$item_detail['price']."</td>";
        //                                             $html .= "<td>".( $item->total_qty * $item_detail['price'] )."</td>";
                                                                                                  
        //                                         $html .= "</tr>";
        //                                         $total = $item->total_qty * $item_detail['price'];
        //                                         $total_quantity = $total_quantity + $item->total_qty;
        //                                         $total_amount = $total_amount + $total;
        //                                     }
        //                                 $html .= "</tbody>";
        //                             $html .= "</table>";
        //                         $html .= "</div>";
        //                     $html .= "</div>";
        //                 $html .= "</td>";
        //             $html .= "</tr>";
        //         }                                          
        //         $html .= "</tbody>";
        //     $html .= "</table>";
            
        //     $html .= "<div class='card-footer '>";
            
        //         $html .= "<div class='row'>";
        //             $html .= "<div class='col-md-6'>";
        //             $html .= "</div>";

        //             $html .= "<div class='col-md-3'>";
        //                 $html .= "<b><span>Quantity : ".$total_quantity."</span></b>";
        //             $html .= "</div>";
        //             $html .= "<div class='col-md-3'>";
        //                 $html .= "<b><span>Amount : ".$total_amount."</span></b>";
        //             $html .= "</div>";
        //         $html .= "</div>";

        //     $html .= "</div>";

        // $html .= "</div>";


        return response()->json([
            'status'=>200,
            // 'html'=>$html,
            // 'stock_data'=>$stock_data,
            'purchase_entry'=>$purchase_entry,
            
        ]);
    
    }

}
