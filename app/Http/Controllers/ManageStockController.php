<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Purchase;
use App\Models\PurchaseEntry;
use App\Models\StyleNo;
use App\Models\ManageStock;
use App\MyApp;

class ManageStockController extends Controller
{
    //
    public function index(){

        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $get_style_no = StyleNo::all();
        // $reserve = PurchaseEntry::all()->groupBy('category_id')->count();

        $category_qty = array();
        foreach ($categories as $key => $list) {
            $count = PurchaseEntry::where(['category_id'=> $list->id])->get()->count();
            $category_qty[] = collect([
                'id' => $list->id,
                'category' => $list->category,
                'count' => $count
            ]);
        }

        $sub_category_qty = array();
        foreach ($sub_categories as $key => $list) {
            $count = PurchaseEntry::where(['sub_category_id'=> $list->id])->get()->count();
            $sub_category_qty[] = collect([
                'id' => $list->id,
                'category_id' => $list->category_id,
                'sub_category' => $list->sub_category,
                'count' => $count,
            ]);
        }

        $purchase_entry = PurchaseEntry::join('categories','purchase_entries.category_id','=','categories.id')
            ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
            ->join('style_nos','purchase_entries.style_no_id','=','style_nos.id')
            ->get(['purchase_entries.*','categories.category','sub_categories.sub_category','style_nos.style_no' ]);
        
        return view('manage_stock', [
            'categories'=>$categories,
            'sub_categories'=>$sub_categories,
            'get_style_no'=>$get_style_no,
            'category_qty'=>$category_qty,
            'sub_category_qty'=>$sub_category_qty,
            'purchase_entry'=>$purchase_entry
        ]);
    }   

    public function showProduct($category_id, $sub_category_id="0" , $style_no_id="0" )
    {

        $stock = ManageStock::groupBy(['purchase_entry_id'])
                ->where('total_qty','>', 0)
                ->selectRaw('purchase_entry_id')
                ->get();

        $stock_entry = array();
        // $purchase_entry = array();
        foreach ($stock as $key => $list) {
            // $stock_entry[] = $list->purchase_entry_id;
            $stock_entry = PurchaseEntry::join('categories','purchase_entries.category_id','=','categories.id')
                    ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
                    ->join('style_nos','purchase_entries.style_no_id','=','style_nos.id')
                    ->where('purchase_entries.id', $list->purchase_entry_id)
                    ->select('purchase_entries.*','categories.category','sub_categories.sub_category','style_nos.style_no');
                    // ->first();

                    if($category_id > 0){
                        $stock_entry->where('purchase_entries.category_id', $category_id);
                    }
                    // if($sub_category_id > 0){
                    //     $stock_entry->where(['purchase_entries.sub_category_id'=> $sub_category_id]);
                    // }
                    // if($style_no_id > 0 ){
                    //     $stock_entry->where(['purchase_entries.style_no_id'=> $style_no_id]);
                    // }
                    $purchase_entry[] = $stock_entry->first();
                }

        

        // $data = PurchaseEntry::join('categories','purchase_entries.category_id','=','categories.id')
        //         ->join('sub_categories','purchase_entries.sub_category_id','=','sub_categories.id')
        //         ->join('style_nos','purchase_entries.style_no_id','=','style_nos.id')
        //         ->select('purchase_entries.*','categories.category','sub_categories.sub_category','style_nos.style_no');
            
        //         if($category_id > 0){
        //             $data->where(['purchase_entries.category_id'=>$category_id]);
        //         }
        //         if($sub_category_id > 0){
        //             $data->where(['purchase_entries.sub_category_id'=>$sub_category_id]);
        //         }
        //         if($style_no_id > 0 ){
        //             $data->where(['purchase_entries.style_no_id'=>$style_no_id]);
        //         }

        // $purchase_entry = $data->get();

        $html ="";

        $html .= "<div class='accordion accordion-flush table-responsive' id='accordionFlushExample' style='height: 500px;'>";
            $html .= "<table class='table table-striped table-head-fixed'>";
                $html .= "<thead>";
                    $html .= "<tr style='position: sticky;z-index: 1;'>";
                        $html .= "<th scope='col'>SN</th>";
                        $html .= "<th scope='col'>Category</th>";
                        $html .= "<th scope='col'>Sub Category</th>";
                        $html .= "<th scope='col'>Style No</th>";
                        $html .= "<th scope='col'>Color</th>";
                    $html .= "</tr>";
                $html .= "</thead>";
                $html .= "<tbody >";

                foreach ($purchase_entry as $key => $list){
                    // echo($list->id);
                    // $html .= "<tr class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#collapse_".$list->id."' aria-expanded='false' aria-controls='flush-collapseOne'>";
                    //     $html .= "<td>" .++$key. "</td>";
                    //     $html .= "<td>".ucwords($list->category)."</td>";
                    //     $html .= "<td>".ucwords($list->sub_category)."</td>";
                    //     $html .= "<td>".ucwords($list->style_no)."</td>";
                    //     $html .= "<td>".ucwords($list->color)."</td>";
                    // $html .= "</tr>"; 

                    // $purchase_entry_item = getPurchaseEntryItems($list->id);

                    // $html .= "<tr>";
                    //     $html .= "<td colspan='5'>";
                    //         $html .= "<div id='collapse_".$list->id."' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>";
                    //             $html .= "<div class='accordion-body'>";
                    //                 $html .= "<table class='table'>";
                    //                     $html .= "<thead>";
                    //                         $html .= "<tr>";
                    //                             $html .= "<th> SN</th>";
                    //                             $html .= "<th> Size</th>";
                    //                             $html .= "<th> Qty</th>";
                    //                             // $html .= "<th> Price</th>";
                    //                         $html .= "</tr>";
                    //                     $html .= "</thead>";
                    //                     $html .= "<tbody>";
                    //                         foreach ($purchase_entry_item['items'] as $key1 => $item){
                    //                             $html .= "<tr>";
                    //                                 $html .= "<td>".++$key1."</td>";
                    //                                 $html .= "<td>".$item->size."</td>";
                    //                                 $html .= "<td>".$item->qty."</td>";
                    //                                 // $html .= "<td>".$item->price."</td>";
                    //                             $html .= "</tr>";
                    //                         }
                    //                     $html .= "</tbody>";
                    //                 $html .= "</table>";
                    //             $html .= "</div>";
                    //         $html .= "</div>";
                    //     $html .= "</td>";
                    // $html .= "</tr>";
                }                                          
                $html .= "</tbody>";
            $html .= "</table>";  
        $html .= "</div>";


        return response()->json([
            'status'=>200,
            'html'=>$html,
            'purchase_entry'=>$purchase_entry,
            'stock'=>$stock,
            'stock_entry'=>$stock_entry
        ]);
    
    }

}
