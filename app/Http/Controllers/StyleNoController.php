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
            $supplier_id = 'required|unique:style_nos,supplier_id,'.$req->input('style_id');
            $style_no = 'required|unique:style_nos,style_no,'.$req->input('style_id');
            // $category_img = 'mimes:jpeg,png,jpg|max:1024|dimensions:max-width=480,max-height=336';
            $model = StyleNo::find($req->input('style_id'));
        }else{
            $supplier_id = 'required|unique:style_nos,supplier_id,'.$req->input('supplier_id');
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
}
