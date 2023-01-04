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

   public function filterProduct($sub_category_id="0", $brand_id="0", $style_no_id="0", $color="")
   {
            $stock = ManageStock::groupBy(['purchase_entry_id'])
            ->where('total_qty','>', 0)
            ->selectRaw('purchase_entry_id')
            ->get();

            $Barcodes_data = array();
            foreach ($stock as $key => $list) {
                $data= PurchaseEntryItem::join('purchase_entries','purchase_entries.id','=','purchase_entry_items.purchase_entry_id')
                ->join('brands','brands.id','=','purchase_entries.brand_id')
                ->join('style_nos','style_nos.id','=','purchase_entries.style_no_id')
                ->join('sub_categories','sub_categories.id','=','purchase_entries.sub_category_id')
                ->select(['purchase_entry_items.*','purchase_entries.*','sub_categories.sub_category','brands.brand_name','style_nos.style_no']);
                // ->get();  
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
                    $Barcodes_data[] = $stock_data;
                }
            }

            $html ="";
            $html .= "<div class='row'>";
            foreach ($Barcodes_data as $list){
            $html .= "<div class='col-md-3'>";
                $html .= "<div class='card' id='div1'>";
                        $html .= "<div class='card-body' >";
             $html .= "<div class='row mb-2'></div>";
             $html .= "<div class='row'>";
                 $html .= "<div class='col-md-12'>";
                 $html .= "<span class='tect-center business_title ml-2' style='letter-spacing: 3px;'><b>MANGALDEEP CLOTHS LLP</b></span><br/>";
                 $html .= "<span class='product_detail ml-3'>Product : </span> <span  class='ml-5 filter_row ' row-value='".$list->id."'>".ucwords($list->sub_category)."</span> <br/>";
                 $html .= "<span class='product_detail ml-3'>Brand : </span> <span class='ml-5 '>".ucwords($list->brand_name)."</span> <br/>";
                 $html .= "<span class='product_detail ml-3'>Style: </span> <span  class='ml-5 '>".$list->style_no."</span> <br/>";
                 $html .= "<span class='product_detail ml-3'>Color : </span> <span class='ml-5 colorbox '>".ucwords($list->color)."</span> <br/>";
                 $html .= "<span class='product_detail ml-3'>Size : </span> <span  class='ml-5'>".ucwords($list->size)."</span> <br/>";
                 $html .= "<span class='product_detail ml-3' style='font-size: 20px;'>MRP </span>: <b  class='ml-5' style='font-size: 20px;'>".$list->mrp."</b> <br/>";
             $html .= "</div>";
                 $html .= "<div class='col-md-12'>";
                     $html .= "<img src=".$list->barcode_img." class='barcode_image barcode img-fluid'><br/>";
                     $html .= "<span class='product_detail'><b style='letter-spacing: 15px;'>".$list->barcode."</b></span> <br/>";
                  $html .= "</div>";
             $html .= "</div>";
             $html .= "<button class='btn btn-success btn-sm float-right' onclick='myFun('div1')'><i class='fas fa-file-invoice'></i></button>";
         $html .= "</div>";
         $html .= "</div>";
         $html .= "</div>";
        }
        $html .= "</div>";
     
            return response()->json([
                'status'=>200,
                'html'=>$html,
            ]);
        
   }



}
