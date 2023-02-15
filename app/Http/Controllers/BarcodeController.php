<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseEntryItem;
use App\Models\PurchaseEntry;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\StyleNo;
use App\Models\Color;
use App\Models\ManageStock;

class BarcodeController extends Controller
{
   public function index(){

       $categories= Category::all();
       $sub_categories= SubCategory::all();
       $brands= Brand::all();
       $get_style_no= StyleNo::all();
       $colors = Color::all();
    $Barcodes_data= PurchaseEntryItem::join('purchase_entries','purchase_entries.id','=','purchase_entry_items.purchase_entry_id')
                                        ->join('brands','brands.id','=','purchase_entries.brand_id')
                                        ->join('style_nos','style_nos.id','=','purchase_entries.style_no_id')
                                        ->join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                                    ->select(['purchase_entry_items.*','purchase_entries.*','sub_categories.sub_category','brands.brand_name','style_nos.style_no'])
                                    ->get();
    return view('barcode',[
        'Barcodes_data' => $Barcodes_data,
        'categories' => $categories,
        'sub_categories' => $sub_categories,
        'brands' => $brands,
        'get_style_no' => $get_style_no,
        'colors'=>$colors
    ]);
   }

   public function filterBarcode($sub_category_id="0", $brand_id="0", $style_no_id="0", $color="")
   {
            $stock = ManageStock::groupBy(['purchase_entry_id'])
                ->where('total_qty','>', 0)
                ->selectRaw('purchase_entry_id')
                ->get();

            $purchase_entry = array();
            foreach ($stock as $key => $list) {

                $data = PurchaseEntry::join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                    ->join('brands','brands.id','=','purchase_entries.brand_id')
                    ->join('style_nos','style_nos.id','=','purchase_entries.style_no_id')
                    ->where('purchase_entries.id', $list->purchase_entry_id)
                    ->select(['purchase_entries.id','purchase_entries.sub_category_id','purchase_entries.brand_id','purchase_entries.style_no_id','purchase_entries.color','sub_categories.sub_category', 'brands.brand_name', 'style_nos.style_no']);
                    // ->first();
                if($sub_category_id > 0){
                    $data->where(['purchase_entries.sub_category_id'=> $sub_category_id]);
                }
                if($brand_id > 0){
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

            $html ="";
            foreach ($purchase_entry as $key => $list){
                $html .= "<div class='row'>";

                $purchase_entry_items = $this->getPurchaseEntryItems($list->id);
                foreach ($purchase_entry_items['items'] as $key1 => $item) {
                    
                    $html .= "<div class='col-md-3'>";
                        $html .= "<div class='card' >";
                            $html .= "<div class='card-body' >";
                                $html .= "<div class='row' id='barcode_".$key1."'>";
                                    $html .= "<div class='col-md-12'>";
                                        $html .= "<span class='tect-center business_title ml-2' style='letter-spacing: 3px;'><b>MANGALDEEP CLOTHS LLP</b></span><br/>";
                                        $html .= "<span class='product_detail ml-3'>Product : </span> <span  class='ml-5 filter_row ' row-value='".$list->id."'>".ucwords($list->sub_category)."</span> <br/>";
                                        $html .= "<span class='product_detail ml-3'>Brand : </span> <span class='ml-5 '>".ucwords($list->brand_name)."</span> <br/>";
                                        $html .= "<span class='product_detail ml-3'>Style: </span> <span  class='ml-5 '>".$list->style_no."</span> <br/>";
                                        $html .= "<span class='product_detail ml-3'>Color : </span> <span class='ml-5 colorbox '>".ucwords($list->color)."</span> <br/>";
                                        $html .= "<span class='product_detail ml-3'>Size : </span> <span  class='ml-5'>".strtoupper($item['size'])."</span> <br/>";
                                        $html .= "<span class='product_detail ml-3' style='font-size: 20px;'>MRP </span>: <b  class='ml-5' style='font-size: 20px;'>".$item['mrp']."</b> <br/>";
                                    $html .= "</div>";
                                    $html .= "<div class='col-md-12'>";
                                        $html .= "<img src=".$item['barcode_img']." class='barcode_image barcode img-fluid'><br/>";
                                        $html .= "<span class='product_detail'><b style='letter-spacing: 15px;'>".$item['barcode']."</b></span> <br/>";
                                    $html .= "</div>";
    
                                $html .= "</div>";
    
                                $html .= "<button class='btn btn-success btn-sm float-right print' print-section='barcode_".$key1."'><i class='fas fa-file-invoice'></i></button>";
                            $html .= "</div>";
                        $html .= "</div>";
                    $html .= "</div>";
                }

                $html .= "</div>";
            }
     
        return response()->json([
            'status'=>200,
            'html'=>$html,
        ]);
        
   }

   public function getPurchaseEntryItems($purchase_entry_id)
    {
        $items = PurchaseEntryItem::where(['purchase_entry_id'=>$purchase_entry_id])->get();

        return $result = [
            'status'=>200,
            'items'=>$items
        ] ;
    }

    public function getBarcodeByPurchaseEntry($purchase_entry_id)
    {
        
        $purchase_entry = PurchaseEntry::join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                ->join('brands','brands.id','=','purchase_entries.brand_id')
                ->join('style_nos','style_nos.id','=','purchase_entries.style_no_id')
                ->where('purchase_entries.id', $purchase_entry_id)
                ->select(['purchase_entries.id','purchase_entries.sub_category_id','purchase_entries.brand_id','purchase_entries.style_no_id','purchase_entries.color','sub_categories.sub_category', 'brands.brand_name', 'style_nos.style_no'])
                ->first();

        $purchase_entry_items = PurchaseEntryItem::where(['purchase_entry_id'=>$purchase_entry_id])->get(['id','size', 'qty', 'mrp','barcode','barcode_img']);
        // dd($purchase_entry_items);
        $html ="";

        $html .= "<div class='row' id='print_barcode'>";
        foreach ($purchase_entry_items as $key => $list){
            for ($i=0; $i < $list->qty; $i++) { 
                $html .= "<div class='col-md-3'>";
                    $html .= "<div class='card' >";
                        $html .= "<div class='card-body' >";
                            $html .= "<div class='row' >";
                                $html .= "<div class='col-md-12'>";
                                    $html .= "<span class='tect-center business_title ml-2'><b>Mangaldeep Clothing LLP</b></span><br/>";
                                    $html .= "<span class='product_detail ml-3'>Product : </span> <span  class='ml-5 filter_row'>".ucwords($purchase_entry->sub_category)."</span> <br/>";
                                    $html .= "<span class='product_detail ml-3'>Brand : </span> <span class='ml-5 '>".ucwords($purchase_entry->brand_name)."</span> <br/>";
                                    $html .= "<span class='product_detail ml-3'>Style: </span> <span  class='ml-5 '>".$purchase_entry->style_no."</span> <br/>";
                                    $html .= "<span class='product_detail ml-3'>Color : </span> <span class='ml-5 colorbox '>".ucwords($purchase_entry->color)."</span> <br/>";
                                    $html .= "<span class='product_detail ml-3'>Size : </span> <span  class='ml-5'>".strtoupper($list['size'])."</span> <br/>";
                                    $html .= "<span class='product_detail ml-3' style='font-size: 20px;'>MRP </span>: <b  class='ml-5' style='font-size: 20px;'>".$list['mrp']."</b> <br/>";
                                $html .= "</div>";
                                $html .= "<div class='col-md-10 text-center'>";
                                    $html .= "<img src=".$list['barcode_img']." class='barcode_image barcode img-fluid'><br/>";
                                    $html .= "<span class='product_detail'><b style='letter-spacing: 5px;'>".$list['barcode']."</b></span> <br/>";
                                $html .= "</div>";

                            $html .= "</div>";

                        $html .= "</div>";
                    $html .= "</div>";
                $html .= "</div>";
            }
        }
        $html .= "</div>";

        return response()->json([
            'status'=>200,
            'html'=>$html,
            
        ]);
    }

        public function getAllBarcodeByPurchaseEntry($purchases_id)
        {

           
            $purchase_entry = PurchaseEntry::join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                ->join('brands','brands.id','=','purchase_entries.brand_id')
                ->join('style_nos','style_nos.id','=','purchase_entries.style_no_id')
                ->where('purchase_id', $purchases_id)
                ->select(['purchase_entries.id','purchase_entries.sub_category_id','purchase_entries.brand_id','purchase_entries.style_no_id','purchase_entries.color','sub_categories.sub_category', 'brands.brand_name', 'style_nos.style_no'])
                ->get();

            $result5 = array();
            foreach ($purchase_entry as $key => $list) {
                $purchase_entry_items[] = PurchaseEntryItem::where(['purchase_entry_id'=>$list->id])->get();
                
                foreach ($purchase_entry_items[$key] as $key1 => $item) {
                    $data =  PurchaseEntryItem::find($item->id);

                    // $result[] = $data;
                    $result_item[] = collect([
                        'id' => $item->id,
                        'brand_name' => $list->brand_name,
                        'sub_category' => $list->sub_category,
                        'style_no' => $list->style_no,
                        'color' => $list->color,
                        'qty' => $data->qty,
                        'barcode_img' => $item->barcode_img,
                        'barcode' => $item->barcode,
                        'mrp' => $item->mrp,
                        'size' => $item->size,
                        
                    ]);
                }
            }

            
            $html ="";

            $html .= "<div class='row' id='print_barcode'>";
            foreach ($result_item as $key1 => $list){
                // $count++;   
                for ($i=0; $i < $list['qty']; $i++) { 
                    $html .= "<div class='col-md-3'>";
                        $html .= "<div class='card'>";
                            $html .= "<div class='card-body' >";

                                $html .= "<div class='row'>" ;
                                    $html .= "<div class='col-md-12'>";
                                        $html .= "<span class='tect-center business_title'><b>MANGALDEEP CLOTHING LLP</b></span><br/>";
                                    $html .= "</div>";
                                $html .= "</div>";

                                $html .= "<div class='row'>";
                                    $html .= "<div class='col-md-5'>";
                                        $html .= "<span class='product_detail'>Product</span><span class='float-end'> - </span>";
                                    $html .= "</div>";
                                    $html .= "<div class='col-md-7'>";
                                        $html .= "<span  class='filter_row product_detail'>".ucwords($list['sub_category'])."</span>";
                                    $html .= "</div>";
                                $html .= "</div>";

                                $html .= "<div class='row'>";
                                    $html .= "<div class='col-md-5'>";
                                        $html .= "<span class='product_detail'>Brand</span></span><span class='float-end'> - </span>";
                                    $html .= "</div>";
                                    $html .= "<div class='col-md-7'>";
                                        $html .= "<span  class='filter_row product_detail'>".ucwords($list['brand_name'])."</span>";
                                    $html .= "</div>";
                                $html .= "</div>";

                                $html .= "<div class='row'>";
                                    $html .= "<div class='col-md-5'>";
                                        $html .= "<span class='product_detail'>Style</span></span><span class='float-end'> - </span>";
                                    $html .= "</div>";
                                    $html .= "<div class='col-md-7'>";
                                        $html .= "<span  class='filter_row product_detail'>".strtoupper($list['style_no'])."</span>";
                                    $html .= "</div>";
                                $html .= "</div>";

                                $html .= "<div class='row'>";
                                    $html .= "<div class='col-md-5'>";
                                        $html .= "<span class='product_detail'>Color</span></span><span class='float-end'> - </span>";
                                    $html .= "</div>";
                                    $html .= "<div class='col-md-7'>";
                                        $html .= "<span  class='filter_row product_detail'>".ucwords($list['color'])." ( ".strtoupper($list['size'])." )</span>";
                                    $html .= "</div>";
                                $html .= "</div>";

                                $html .= "<div class='row'>";
                                    $html .= "<div class='col-md-5'>";
                                        $html .= "<span class='product_detail' style='font-size: 20px;'>MRP</span></span><span class='float-end'> - </span>";
                                    $html .= "</div>";
                                    $html .= "<div class='col-md-7'>";
                                        $html .= "<span  class='filter_row product_detail' style='font-size: 20px;'>".$list['mrp']."</span>";
                                    $html .= "</div>";
                                $html .= "</div>";

                                $html .= "<div class='row'>";
                                    $html .= "<img src=".$list['barcode_img']." class='barcode_image barcode img-fluid'><br/>";
                                    // $html .= "<input type='text' value='".$list['id']."'>";
                                    $html .= "<span class='product_detail'><b style='letter-spacing: 5px;'>".$list['barcode']."</b></span> <br/>";
                                $html .= "</div>";

                                // $html .= "<div class='row'>" ;
                                //     $html .= "<div class='col-md-12'>";
                                //         $html .= "<span class='tect-center business_title ml-2'><b>Mangaldeep Clothing LLP</b></span><br/>";
                                //         $html .= "<span class='product_detail ml-3'>Product : </span> <span  class='ml-4 filter_row'>".ucwords($list['sub_category'])."</span> <br/>";
                                //         $html .= "<span class='product_detail ml-3'>Brand : </span> <span class='ml-4 '>".ucwords($list['brand_name'])."</span> <br/>";
                                //         $html .= "<span class='product_detail ml-3'>Style : </span> <span  class='ml-5 '>".$list['style_no']."</span> <br/>";
                                //         $html .= "<span class='product_detail ml-3'>Color : </span> <span class='ml-5 colorbox '>".ucwords($list['color'])." ( ".strtoupper($list['size'])." ) </span> <br/>";
                                //         // $html .= "<span class='product_detail ml-3'>Size : </span> <span  class='ml-5'>".strtoupper($list['size'])."</span> <br/>";
                                //         $html .= "<span class='product_detail ml-3' style='font-size: 20px;'>MRP </span>: <b  class='ml-5' style='font-size: 20px;'>".$list['mrp']."</b> <br/>";
                                //     $html .= "</div>";
                            
                                //     $html .= "<div class='col-md-10 text-center'>";
                                //         $html .= "<img src=".$list['barcode_img']." class='barcode_image barcode img-fluid'><br/>";
                                //         // $html .= "<input type='text' value='".$list['id']."'>";
                                //         $html .= "<span class='product_detail'><b style='letter-spacing: 5px;'>".$list['barcode']."</b></span> <br/>";
                                //     $html .= "</div>";
                                
                                // $html .= "</div>";

                            $html .= "</div>";
                        $html .= "</div>";
                    $html .= "</div>";
                }

            }
            $html .= "</div>";

            return response()->json([
                'status'=>200,
                'html'=>$html,
                'purchase_entry'=>$purchase_entry,
                'purchase_entry_items'=>$purchase_entry_items,
                // 'count'=>$count,
                // 'result'=>$result,
                'result_item'=>$result_item,
                
            ]);

        }
    

}
