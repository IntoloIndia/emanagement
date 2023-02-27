<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseEntry;
use App\Models\StyleNo;
use App\Models\PurchaseEntryItem;

class FindProductController extends Controller
{
    public function index()
    {
        $style_no = StyleNO::all();
        return view('find_product',[
            'status'=>200,
            'style_no'=>$style_no
        ]);
    }
    public function searchStyleNo($style_no)
    {
        $style_no_id = StyleNo::where(['style_no'=>$style_no])->value('id');
        $purchase_entry_id = PurchaseEntry::where(['style_no_id'=>$style_no_id])->get(['id']);
      
        foreach ($purchase_entry_id as $key => $list) {
            $purchase_entry_items = PurchaseEntryItem::where(['purchase_entry_id'=>$list->id])->get();
        }
           

    $html ="";
    
        $html .="<div class='row'>";
             $html .="<div class='col-md-12'>";
                $html .="<div class='col-md-12 table-responsive p-0' style='height: 550px;'>";
                    $html .="<table class='table table-head-fixed'>";
                        $html .="<thead>";
                            $html .="<tr>";
                                $html .="<th scope='col'>Sno</th>"; 
                            $html .="</tr>";
                        $html .="</thead>";
                        $html .="<tbody>";
                            foreach ($purchase_entry_items as $item){
                                $html .="<tr>";
                                    // $html .="<td>{{ ++$count }}</td>";
                                    $html .="<td>".$item->size."</td>";                                    
                                $html .="</tr>";
                            }
                        $html .="</tbody>";
                    $html .="</table>";
                $html .="</div>";
             $html .="</div>";
         $html .="</div>";

       
        return response()->json([
            'status'=>200,
            'html'=>$html
        ]);

    }

}
