<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\PurchaseEntry;
use App\Models\PurchaseEntryItem;
use App\Models\Size;
use App\Models\Color;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Supplier;
use App\Models\BusinessDetails;
use App\MyApp;
use Validator;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        // $purchase_return = PurchaseReturn::all();
        $suppliers = Supplier::all();
            // $purchase_return = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
            //                                 ->where(['purchase_returns.release_status' => MyApp::RELEASE_PANDDING_STATUS])
            //                                 ->select('suppliers.supplier_name','purchase_returns.*')->get();
            // $purchase_return_items = array();
            // foreach ($purchase_return as $key => $list) {
            //     $purchase_return_items[] = PurchaseReturnItem::join('style_nos','style_nos.id','=','purchase_return_items.style_no_id')
            //     // join('sub_categories','sub_categories.id','=','purchase_return_items.sub_category_id')
            //                         ->where(['purchase_return_id'=>$list->id])
            //                         ->select('purchase_return_items.*','style_nos.style_no')->get();     
            // }


        $purchase_return_data = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
                                        ->where(['purchase_returns.release_status' => MyApp::RELEASE_STATUS])
                                        ->select('suppliers.supplier_name','purchase_returns.*')->get();
                

        return view('purchase-return',[
            // 'purchase_return' =>$purchase_return,
            // 'purchase_return_items' =>$purchase_return_items,
            'purchase_return_data' =>$purchase_return_data,
            'suppliers' =>$suppliers,
            

        ]);
    }



    function purchaseReturnShowData()
    {
        $purchase_return = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
            ->where(['purchase_returns.release_status' => MyApp::RELEASE_PANDDING_STATUS])
            ->select('suppliers.supplier_name','purchase_returns.*')->get();

        $purchase_return_items = array();

        foreach ($purchase_return as $key => $list) {

            $purchase_return_items[] = PurchaseReturnItem::join('style_nos','style_nos.id','=','purchase_return_items.style_no_id')
                                ->where(['purchase_return_id'=>$list->id])
                                ->select('purchase_return_items.*','style_nos.style_no')->get();     
        }
        


        $html = "";
         $html .= "<div class='row'>";
            foreach ($purchase_return as $key1 => $list){
            $html .= "<div class='col-md-12'>";
                $html .= "<div class='card'>";
                    $html .= "<div class='card-header'>";
                    $html .= "<h3 class='card-title'><b>".ucwords($list->supplier_name)."</b></h3>";
                    $html .= "<button type='button' class='btn btn-success btn-sm ml-2 float-right generatePurchaseInvoice'  value=".$list->id. "data-bs-toggle='tooltip' data-bs-placement='top' title='Invoice'><i class='fas fa-file-invoice'></i></button>";
                    $html .= "<button type='button' class='btn btn-warning btn-sm btn-sm  float-right releaseStatusBtn' id='release_date' value=".$list->id.">Relese</button>";
                    $html .= "</div>";
                    $html .= "<div class='card-body'>";
                            $html .= "<table class='table table-striped'>";
                            $html .= "<thead>";
                                $html .= "<tr>";
                                    $html .= "<th></th>";
                                    $html .= "<th>SN</th>";
                                    $html .= "<th>Style no</th>";
                                    $html .= "<th>Color</th>";
                                    $html .= "<th>Qty</th>";
                                    $html .= "<th>Date</th>";
                                    $html .= "<th>Time</th>";
                                $html .= "</tr>";
                            $html .= "</thead>";
                            $html .= "<tbody>";

                            foreach($purchase_return_items[$key1] as $key => $item) {
                                $html .= "<tr>";
                                    $html .= "<td></td>";
                                    $html .= "<td>" . ++$key . "</td>";
                                    $html .= "<td>" . ucwords($item->style_no)."</td>";
                                    $html .= "<td>" . ucwords($item->color) ."</td>";
                                    $html .= "<td>" . $item->qty ."</td>";
                                    $html .= "<td>" . $item->date ."</td>";
                                    $html .= "<td>" . $item->time ."</td>";
                                $html .= "</tr>";
                                
                            }
                            $html .= "<tbody>";
                        $html .= "</table>";
                    $html .= "</div>";
                $html .= "</div>";
             $html .= "</div>";
            }
        $html .= "</div>"; 

        return response()->json([   
            'status'=>200,
            //  'purchase_return' =>$purchase_return,
            // 'purchase_return_items' =>$purchase_return_items,
            'html'=>$html
            
        ]);
        
    }

    // saveReturnProduct
    function saveReturnProduct(Request $req)
    {
        
        $validator = Validator::make($req->all(),[
            'color' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all filed"),
            ]);
        }else{

            $supplier_id = 0;
            $release_status = 0;
            $data = PurchaseReturn::where(['supplier_id'=>$req->input('supplier_id'),'release_status'=>0])->first(['id','release_status']);
            

            
            if ($data == null ) {
                
                $model = new PurchaseReturn;
                $model->supplier_id = $req->input('supplier_id');
                // $model->supplier_code = $req->input('supplier_code');
                // $model->supplier_address = $req->input('supplier_address');
                // $model->gst_no = $req->input('gst_no');
                $model->create_date = date('Y-m-d');
                $model->create_time = date('g:i A');
                $model->save();
    
                $supplier_id = $model->id;
            }else if($data->release_status > 0){

                $model = PurchaseReturn::find($data->id);
                $model->supplier_id = $req->input('supplier_id');
                $model->create_date = date('Y-m-d');
                $model->create_time = date('g:i A');
                $model->save();

                $supplier_id = $model->id;

            }else{
                
                $supplier_id = $data->id;
            }


            $returnitemmodel = new PurchaseReturnItem;
            $returnitemmodel->purchase_return_id = $supplier_id;
            $returnitemmodel->style_no_id = $req->input('style_no_id');
            $returnitemmodel->color = $req->input('color');
            $returnitemmodel->qty = $req->input('qty');
            $returnitemmodel->barcode = $req->input('barcode');
            // $returnitemmodel->size = $req->input('size');
            // $returnitemmodel->price = $req->input('price');
            // $returnitemmodel->discount = $req->input('discount');
            // $returnitemmodel->taxable = $req->input('taxable');
            // $returnitemmodel->total_igst = $req->input('total_igst');
            // $returnitemmodel->total_sgst = $req->input('total_sgst');
            // $returnitemmodel->total_cgst = $req->input('total_cgst');
            // $returnitemmodel->total_amount = $req->input('total_amount');
          
            $returnitemmodel->date = date('Y-m-d');
            $returnitemmodel->time = date('g:i A');
            $returnitemmodel->save();


           
            // if($model->save()){
                return response()->json([   
                    'status'=>200,
                    
                ]);
            // }
        }
    }

    public function getReturnData($barcode_code)
    {
       
        // $return_product = PurchaseEntryItem::join('suppliers','suppliers.id','=','purchases.supplier_id')
        //                 ->join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
        //                 ->join('purchases','purchases.id','=','purchase_entries.purchase_id')
        //                 ->where(['purchase_entry_items.barcode'=> $barcode_code])
        //                 ->select('purchase_entry_items.*','purchase_entries.id',
        //                 'purchase_entries.sub_category_id','purchase_entries.color',
        //                 'sub_categories.sub_category',
        //                 'suppliers.supplier_name','suppliers.id')
        //                 ->first();

        // $purchase_entry_item = PurchaseEntryItem::where(['barcode'=> $barcode_code])->first(['purchase_entry_id','size','qty','price']);
        $purchase_entry_item = PurchaseEntryItem::where(['barcode'=> $barcode_code])->first(['purchase_entry_items.*']);
        // dd($purchase_entry_item);
            if($purchase_entry_item){

        $purchase_entry = PurchaseEntry::join('style_nos','purchase_entries.style_no_id','=','style_nos.id')
        // join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')         
                ->where(['purchase_entries.id'=> $purchase_entry_item->purchase_entry_id])
                ->first(['purchase_entries.id','purchase_entries.purchase_id','purchase_entries.color','purchase_entries.style_no_id','style_nos.style_no']);
        // dd($purchase_entry);

        $purchase = Purchase::join('suppliers','suppliers.id','=','purchases.supplier_id')
                ->where(['purchases.id'=> $purchase_entry->purchase_id])
                ->first(['purchases.id','purchases.supplier_id','suppliers.supplier_name']);

        $result = collect([
            'supplier_id' => $purchase->supplier_id,
            'supplier_name' => $purchase->supplier_name,
            'style_no_id' => $purchase_entry->style_no_id,
            'style_no' => $purchase_entry->style_no,
            // 'sub_category_id' => $purchase_entry->sub_category_id,
            // 'sub_category' => $purchase_entry->sub_category,
            'size' => $purchase_entry_item->size,
            'qty' => $purchase_entry_item->qty,
            'color' => $purchase_entry->color,
            'price' => $purchase_entry_item->price,
            'taxable' => $purchase_entry_item->taxable,
            'discount' => $purchase_entry_item->discount,
            'sgst' => $purchase_entry_item->sgst,
            'cgst' => $purchase_entry_item->cgst,
            'igst' => $purchase_entry_item->igst,
            'amount' => $purchase_entry_item->amount,
        ]);
               
            return response()->json([
                'status'=>200,
                'return_product'=>$result
            
            ]);
        }else{
            return response()->json([
                'status'=>400,
                'return_product'=>"data not found"
            ]);
        }
    }

    function updateReleaseStatus($supplier_id)
    {
        $release_status_data =PurchaseReturn::find($supplier_id);
        $release_status_data->release_status = MyApp::RELEASE_STATUS;
        $release_status_data->release_date = date('Y-m-d');
        $release_status_data->release_time = date('g:i A');
        $release_status_data->save();
        
        return response()->json([
            'status'=>200
        ]);
    }

    

    public function purchaseReturnInvoice($purchase_return_id)
    {
        
            $business_detail = BusinessDetails::first();
            $purchase_return = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
                    ->where('purchase_returns.id', $purchase_return_id)
                    ->first(['purchase_returns.*','suppliers.supplier_name',
                    'suppliers.address','suppliers.mobile_no',
                    'suppliers.gst_no','suppliers.state_type']);
                    

                    $purchase_return_item = PurchaseReturnItem::join('style_nos','style_nos.id','=','purchase_return_items.style_no_id')
                            ->join('purchase_entry_items','purchase_return_items.barcode','=','purchase_entry_items.barcode')
                            ->where('purchase_return_items.purchase_return_id',$purchase_return_id)
                            ->select(['purchase_return_items.*','style_nos.style_no','purchase_entry_items.size',
                            'purchase_entry_items.discount','purchase_entry_items.price','purchase_entry_items.taxable',
                            ])->get();

                    
            // dd($purchase_return_item);


        $html = "";

        $html .= "<div class='row'>";
            $html .= "<div class='col-sm-12 text-center'>";
                $html .= "<small class='modal-title'>";
                    $html .= "<h5><b>".$business_detail->business_name."</b> <h5>";                   
                $html .= "</small>";
            $html .= "</div>";
        $html .= "</div>";

        $html .= "<div class='row'>";
            $html .= "<div class='col-sm-4 offset-3 text-center'>";
                $html .= "<p style='inline-size:400px;'>".$business_detail->company_address."</p>";
            $html .= "</div>"; 
        $html .= "</div>"; 

        $html .= "<div class='row'>";
            $html .= "<div class='col-md-6'><b>GSTNO - </b>".$business_detail->gst."</div>";
            $html .= "<div class='col-md-6'><p class=' float-right'><b>Mobile no - </b>".$business_detail->mobile_no."</p></div>";
        $html .= "</div>";

        $html .= "<div class='row'>";
            $html .= "<div class='card text-dark bg-light mt-2' >";
                $html .= "<div class='card-header text-center'><b>TAX INVOICE</b></div>";
                $html .= "<div class='card-body'>";
                    $html .= "<div class='row'>";
                        $html .= "<div class='col-md-6'>";
                        $html .= "<small class='modal-title'>";
                        $html .= "<b> ".strtoupper($purchase_return->supplier_name)." </b><br>";
                        $html .= "<b>".$purchase_return->address."</b>";
                         $html .= "<b>".ucwords($purchase_return->city)."</b><br>";
                         $html .= "<b>GSTNO -  </b> ".$purchase_return->gst_no."<br>";
                         $html .= "<b>Mobile -  </b> ".$purchase_return->mobile_no."<br>";
                         $html .= "</small>";
                        $html .= "</div>";
                        $html .= "<div class='col-md-6'>";
                        $html .= "<small class='modal-title'>";
                            $html .= "<b> Note id -  </b> ".$purchase_return->bill_id." <br>";
                            $html .= "<b>Note Date -  </b> ". date('d-m-Y', strtotime($purchase_return->release_date)) ."<br>";
                        $html .= "</small>";
                        $html .= "</div>";
                    $html .= "</div>";
                $html .= "</div>";
            $html .= "</div>";
            
        $html .= "</div>";

        $html .= "<div class='row'>";
            $html .= "<table class='table table-bordered border-dark'>";
                $html .= "<thead>";
                    $html .= "<tr>";
                        $html .= "<th style='width: 5%;'>SN</th>";
                        // $html .= "<th style='width: 25%;'>Description</th>";
                        $html .= "<th style='width: 20%;'>Style No</th>";
                        $html .= "<th style='width: 10%;'>Color</th>";
                        $html .= "<th style='width: 5%;'>Size</th>";
                        $html .= "<th style='width: 5%;'>Qty</th>";
                        $html .= "<th >Price</th>";
                        $html .= "<th >Dis.</th>";
                        $html .= "<th >Taxable</th>";
                        $html .= "<th >SGST</th>";
                        $html .= "<th >CGST</th>";
                        $html .= "<th >IGST</th>";
                        $html .= "<th >Amount</th>";
                    $html .= "</tr>";
                $html .= "</thead>";
                $html .= "<tbody>";
                $total_sgst = 0;
                $total_cgst = 0;
                $total_igst = 0;
                $discount_amount = 0;
                $total_taxable = 0;
                $grand_total = 0;

                // foreach ($purchase_return_item as $key => $list) {
                    
                //     $data = $this->getPurchaseEntryItems($list->id);
                //     $row_count = count($data['items']);

                //     $html .= "<tr >";
                        
                //         $html .= "<td rowspan='". ($row_count + 1) ."'>".++$key."</td>";
                //         $html .= "<td rowspan='". ($row_count + 1) ."'>".ucwords($list->sub_category)."</td>";
                //         $html .= "<td rowspan='". ($row_count + 1) ."'>".$list->style_no."</td>";
                //         $html .= "<td rowspan='". ($row_count + 1) ."'>".ucwords($list->color)."</td>";
                //         $html .= "<td >";

                //         $sgst = 0;
                //         $cgst = 0;
                //         $igst = 0;
                //         $discount = 0;
                //         $taxable = 0;
                //         $amount = 0;
                        
                //         foreach ($data['items'] as $item) {
                               
                //             $html .= "<tr>"; 
                //                 $html .= "<td >".$item->size."</td>";
                //                 $html .= "<td >".$item->qty."</td>";
                //                 $html .= "<td >".$item->price."</td>";
                //                 $html .= "<td >".$item->discount."</td>";
                //                 $html .= "<td >".$item->taxable."</td>";
                //                 $html .= "<td >".$item->sgst."</td>";
                //                 $html .= "<td >".$item->cgst."</td>";
                //                 $html .= "<td >".$item->igst."</td>";
                //                 $html .= "<td >".$item->amount."</td>";
                //             $html .= "</tr>";

                //             $sgst = $sgst + $item->sgst;
                //             $cgst = $cgst + $item->cgst;
                //             $igst = $igst + $item->igst;
                //             $discount = $discount + $item->discount_amount;
                //             $taxable = $taxable + $item->taxable;
                //             $amount = $amount + $item->amount;
                //         }

                //         $total_sgst = $total_sgst + $sgst ;
                //         $total_cgst = $total_cgst + $cgst ;
                //         $total_igst = $total_igst + $igst ;
                //         $discount_amount = $discount_amount + $discount ;
                //         $grand_total = $grand_total + $amount ;
                //         $total_taxable = $total_taxable + $taxable ;

                //         $html .= "</td>";
                        
                //     $html .= "</tr>";
                // }

                            $totalDiscount = 0;
                            $totalAmount = 0;
                            $grand_total = 0;
                            $grand_taxable_amount = 0;
                            $grand_total_sgst = 0;
                            $grand_total_cgst = 0;
                            $grand_total_igst = 0;
                            $totalAllGst = 0;
                                foreach ($purchase_return_item as $key => $list) {


                                    $dis_data = calculateDiscount($list->price, $list->discount,$list->qty);
                                    $gst = calculateGst($purchase_return->state_type,$dis_data['taxable']);

                                        $totalAllGst = $gst['sgst'] +  $gst['cgst'] +  $gst['igst'];

                                    $totalAmount = $totalAllGst + $dis_data['taxable'];
                            
                                    $html .= "<tr>";
                                        // $html .= "<td></td>";
                                        $html .= "<td>" . ++$key . "</td>";
                                        $html .= "<td>" . ucwords($list->style_no)."</td>";
                                        $html .= "<td>" . ucwords($list->color) ."</td>";
                                        $html .= "<td>" . strtoupper($list->size) ."</td>";
                                        $html .= "<td>" . $list->qty ."</td>";
                                        $html .= "<td>" . $list->price ."</td>";
                                        $html .= "<td>" . $list->discount."</td>";
                                        $html .= "<td>" . $dis_data['taxable'] ."</td>";
                                        $html .= "<td>" . $gst['sgst'] ."</td>";
                                        $html .= "<td>" . $gst['cgst'] ."</td>";
                                        $html .= "<td>" . $gst['igst'] ."</td>";
                                        $html .= "<td>" . $totalAmount ."</td>";
                                    $html .= "</tr>";

                                    $totalDiscount = $totalDiscount +  $dis_data['total_discount_amount'];

                                    $grand_taxable_amount = $grand_taxable_amount +  $dis_data['taxable'];
                                    $grand_total = $grand_total +  $totalAmount;
                                    $grand_total_sgst =  $grand_total_sgst +  $gst['sgst'];
                                    $grand_total_cgst =  $grand_total_cgst +  $gst['cgst'];
                                    $grand_total_igst =  $grand_total_igst +  $gst['igst'];
                                }

                $html .= "</tbody>";
    
                $html .= "<tfoot>";

                    // $html .= "<tr>";
                    //     $html .= "<td colspan='5' class='align-top'></td>";
                    //     $html .= "<td  >Total Qty</td>";
                    //     $html .= "<td  >Total Price</td>";
                    // $html .= "</tr> ";

                    $html .= "<tr>";
                        $html .= "<td colspan='8' rowspan='6'  class='align-top'> Amount in Words : ";
                            $html .= "<textarea class='form-control' name='amount_in_words' id='amount_in_words'></textarea>";
                        $html .= "</td>  ";
                        $html .= "<td colspan='3' ><b>Total Amount :</b></td>";
                        $html .= "<td colspan='2'><input type='text' class='form-control form-control-sm' value='". $grand_taxable_amount."' readonly></td>";
                    $html .= "</tr> ";
                    $html .= "<tr>";
                        $html .= "<td colspan='3'><b>Discount :</b></td>";
                        $html .= "<td colspan='2'><input class='form-control form-control-sm' type='text' value='".$totalDiscount."' readonly></td>";
                    $html .= "</tr>";
                    $html .= "<tr>";
                        $html .= "<td colspan='3'><b>SGST : </b></td>";
                        $html .= "<td colspan='2'><input class='form-control form-control-sm' type='text' value='".$grand_total_sgst."' readonly></td>";
                    $html .= "</tr>";
                    $html .= "<tr> ";
                        $html .= "<td colspan='3'><b>CGST : </b></td>";
                        $html .= "<td colspan='2'><input class='form-control form-control-sm' type='text' value='".$grand_total_cgst."' readonly></td>";
                    $html .= "</tr>";
                    $html .= "<tr>";
                        $html .= "<td colspan='3'><b>IGST : </b></td>";
                        $html .= "<td colspan='2'><input class='form-control form-control-sm' type='text' value='".$grand_total_igst."' readonly></td>";
                    $html .= "</tr>";
                    $html .= "<tr>";
                        $html .= "<td colspan='3'><b>Grand Total : </b></td>";
                        $html .= "<td colspan='2'><input class='form-control form-control-sm' type='text' value='".$grand_total."' readonly ></td>";
                    $html .= "</tr>";
                    
                $html .= "</tfoot>";
    
            $html .= "</table>";
        $html .= "</div>";


        // return response()->json([
        //     'status'=>200,
        //     'html'=>$html,
        //     'purchase'=>$purchase,
        //     'supplier'=>$supplier,
        //     // 'purchase_entry_items'=>$purchase_entry_items
        // ]);

        return response()->json([
            'status'=>200,
            'purchase_return'=>$purchase_return,
            'purchase_return_item'=>$purchase_return_item,
            'html'=>$html,
        ]);

    }
}
