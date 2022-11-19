<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Size;
use App\Models\Color;

class SizeColorController extends Controller
{
    //
    public function index(){
        $sizes = Size::all();
        $colors = Color::all();

        return view('size_color',[
            'sizes'=>$sizes,
            'colors'=>$colors
        ]);
    }

    //Size
    function saveSize(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'size' => 'required|unique:sizes,size,'.$req->input('size'),
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
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

    public function editSize($size_id)
    {
        $size = Size::find($size_id);
        return response()->json([
            'status'=>200,
            'size'=>$size,
        ]);
    }

    //color
    function saveColor(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'color' => 'required|unique:colors,color,'.$req->input('color'),
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = new Color;
            $model->color = $req->input('color');
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }

}
