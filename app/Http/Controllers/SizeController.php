<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Models\Size;
use App\Models\Color;

class SizeController extends Controller
{
    public function index(){
        $allSize = Size::all();
        $allColor = Color::all();
        return view('size',[
            'allSize'=>$allSize,
            'allColor'=>$allColor,
        ]);
    }

    function saveSize(Request $req)
    {
        // return view('employee');
        $validator = Validator::make($req->all(),[
            'size' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill size"),
            ]);
        }else{
            $model = new Size;
            $model->size = $req->input('size');
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }

    public function editSize($Size_id)
    {
        $sizeData = Size::find($Size_id);
        return response()->json([
            'status'=>200,
            'sizeData'=>$sizeData,
        ]);
    }

}
