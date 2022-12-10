<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\StyleNo;
use App\Models\Supplier;
use App\MyApp;

class StyleNoController extends Controller
{
    //
    public function index(){
        $styles = StyleNo::all();
        $suppliers = Supplier::all();
        return view('style_no',[
            'styles' => $styles,
            'suppliers' => $suppliers,
        ]);
    }

    public function manageStyleNo(Request $req)
    {
        if($req->input('style_id') > 0)
        {
            $supplier_id = 'required|max:191';
            $style_no = 'required|unique:style_nos,style_no,'.$req->input('style_id');
            // $category_img = 'mimes:jpeg,png,jpg|max:1024|dimensions:max-width=480,max-height=336';
            $model = StyleNo::find($req->input('style_id'));
        }else{
            $supplier_id = 'required|max:191';
            $style_no = 'required|unique:style_nos,style_no,'.$req->input('style_no');
            $model = new  StyleNo;
        }

        $validator = Validator::make($req->all(),[
            'supplier_id' => $supplier_id,
            'style_no' => $style_no
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model->supplier_id = $req->input('supplier_id');
            $model->style_no = strtoupper($req->input('style_no'));


            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }

        }
    }

     public function styleNoBySupplier($supplier_id)
    {
        $styles_no = StyleNo::where(['supplier_id'=>$supplier_id])->get();
        
        $html = "";

        //$html .= "<table class='table table-striped'>";

            $html .= "<thead>";
                $html .= "<tr>";
                    $html .= "<th>SN</th>";
                    $html .= "<th>Style no</th>";
                    $html .= "<th>Action</th>";
                $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
                foreach ($styles_no as $key => $list) {
                    $html .= "<tr class='client_project_row' project-id='".$list->id."'>";
                        $html .= "<td>" . ++$key . "</td>";
                        $html .= "<td>" . $list->style_no ."</td>";
                        $html .= "<td> 
                            <button type='button' class='btn btn-info btn-sm editStyleNoBtn mr-1'  value='".$list->id."'><i class='fas fa-edit'></i></button>
                            <button type='button' class='btn btn-danger btn-sm deleteStyleNoBtn ml-1'  value='".$list->id."'><i class='fas fa-trash'></i></button>
                            </td>";
                        $html .= "</tr>";
                }
            $html .= "<tbody>";
           

        // $html .= "</table>";

        return response()->json([
            'status'=>200,
            'styles_no'=>$styles_no,
            'html'=>$html
        ]);

    }

    // edit style no 

    public function editStyleNo($style_id)
    {
        $style_no = StyleNo::find($style_id);
        return response()->json([
            'status'=>200,
            'style_no'=>$style_no
        ]);
    }

    // delete style_no data 

    public function deleteStyleNo($style_no_id)
    {
        $delete_style_no = StyleNo::find($style_no_id);
        $delete_style_no->delete();
        return response()->json([
            'status'=>200
        ]);
    }


    public function supplierStyleNo($supplier_id)
    {
        $data = StyleNo::where(['supplier_id'=>$supplier_id])->get();

        $html = "";
        $html .= "<option selected disabled value='0' >Style no</option>";
        foreach($data as $list)
        {
            $html.= "<option value='" . $list->id . "'>" . $list->style_no . "</option>";
        }
        return response()->json([
            'status'=> 200,
            'html'=> $html,
        ]);
    }

}
