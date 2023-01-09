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
use App\MyApp;
use Validator;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        // $purchase_return = PurchaseReturn::all();
        $purchase_return = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
                                        ->where(['purchase_returns.release_status' => MyApp::RELEASE_PANDDING_STATUS])
                                        ->select('suppliers.supplier_name','purchase_returns.*')->get();
        $purchase_return_items = array();
        foreach ($purchase_return as $key => $list) {
            $purchase_return_items[] = PurchaseReturnItem::join('style_nos','style_nos.id','=','purchase_return_items.style_no_id')
            // join('sub_categories','sub_categories.id','=','purchase_return_items.sub_category_id')
                                ->where(['purchase_return_id'=>$list->id])
                                ->select('purchase_return_items.*','style_nos.style_no')->get();     
        }


        $purchase_return_data = PurchaseReturn::join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
                                        ->where(['purchase_returns.release_status' => MyApp::RELEASE_STATUS])
                                        ->select('suppliers.supplier_name','purchase_returns.*')->get();
                

        return view('purchase-return',[
            'purchase_return' =>$purchase_return,
            'purchase_return_items' =>$purchase_return_items,
            'purchase_return_data' =>$purchase_return_data

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
            // $returnitemmodel->purchase_return_id = $model->id;
            // $returnitemmodel->sub_category_id = $req->input('sub_category_id');
            $returnitemmodel->style_no_id = $req->input('style_no_id');
            $returnitemmodel->color = $req->input('color');
            $returnitemmodel->size = $req->input('size');
            $returnitemmodel->qty = $req->input('qty');
            $returnitemmodel->price = $req->input('price');
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

        $purchase_entry_item = PurchaseEntryItem::where(['barcode'=> $barcode_code])->first(['purchase_entry_id','size','qty','price']);
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
        $purchase_return = PurchaseReturn::join('purchase_return_items','purchase_return_items.purchase_return_id','=','purchase_returns.id')
                         ->join('suppliers','suppliers.id','=','purchase_returns.supplier_id')
                        ->where('purchase_returns.id', $purchase_return_id)
                        ->first(['purchase_returns.*','suppliers.*']);
            // dd($purchase_return);

        $purchase_return_item = PurchaseReturnItem::join('style_nos','style_nos.id','=','purchase_return_items.style_no_id')
                    ->where('purchase_return_items.purchase_return_id',$purchase_return_id)
                    ->select(['purchase_return_items.*','style_nos.style_no'])->get();

            // dd($purchase_return_item);
           
        $html = "";
         $html .= "<div class='row'>";
             $html .= "<div class='col-8'><h6 style='text-transform: capitalize;'>".$purchase_return->supplier_name."</h6><h6 style='text-transform: capitalize;'> ".$purchase_return->address."</h6><h6>GSTNO : ".$purchase_return->gst_no."</h6><h6>Mobile No : ".$purchase_return->mobile_no."</h6></div>";
             $html .= "<div class='col-4 text-end'><h6>Time : ".$purchase_return->release_time."</h6>
                        <h6>Date : ".date('d-m-Y',strtotime($purchase_return->release_date))."</h6></div>";
         $html .= "</div>"; 
         $html .= "<div class='row mt-2'>";
            $html .= "<table class='table table-striped'>";
                $html .= "<thead>";
                    $html .= "<tr>";
                        $html .= "<th></th>";
                        $html .= "<th>SN</th>";
                        $html .= "<th>Style no</th>";
                        $html .= "<th>Color</th>";
                        $html .= "<th>Qty</th>";
                        $html .= "<th>Size</th>";
                        $html .= "<th>Price</th>";
                    $html .= "</tr>";
                $html .= "</thead>";
                $html .= "<tbody>";
                $totalQty = 0;
                $totalAmount = 0;
                    foreach ($purchase_return_item as $key => $list) {
                        $html .= "<tr>";
                            $html .= "<td></td>";
                            $html .= "<td>" . ++$key . "</td>";
                            $html .= "<td>" . ucwords($list->style_no)."</td>";
                            $html .= "<td>" . $list->color ."</td>";
                            $html .= "<td>" . $list->qty ."</td>";
                            $html .= "<td>" . $list->size ."</td>";
                            $html .= "<td>" . $list->price ."</td>";
                        $html .= "</tr>";
                        $totalQty= $totalQty+$list->qty;
                        $totalAmount= $totalAmount+$list->price;
                    }
                $html .= "<tbody>";
                    $html .="<tfoot>";
                    $html .="<tr>";
                        $html .="<td colspan='4'></td>";
                        $html .="<td colspan=''><b>".$totalQty."</b></td>";
                        $html .="<td><b>Total :</b></td>";
                        $html .="<td><b>".$totalAmount."</b></td>";
                    $html .="</tr>";
                $html .="</tfoot>";
            $html .= "</table>";
        $html .= "</div>"; 
     
   
        return response()->json([
            'status'=>200,
            'purchase_return'=>$purchase_return,
            'purchase_return_item'=>$purchase_return_item,
            'html'=>$html
        ]);

    }
}
