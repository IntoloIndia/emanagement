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
            'size'=>$size
        ]);
    }


    public function updateSize(Request $req, $size_id)
    {
        $validator = Validator::make($req->all(),[
            'size' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Size::find($size_id);
            $model->size = $req->input('size');
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function deleteSize($size_id)
    {
        $delete_size = Size::find($size_id);
        $delete_size->delete();
        return response()->json([
            'status'=>200
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

    public function editColor($color_id)
    {
        $color = Color::find($color_id);
        return response()->json([
            'status'=>200,
            'color'=>$color
        ]);
    }


    public function updateColor(Request $req, $color_id)
    {
        $validator = Validator::make($req->all(),[
            'color' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Color::find($color_id);
            $model->color = $req->input('color');
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }
    
    // color delete 
    public function deleteColor($color_id)
    {
        $delete_color = Color::find($color_id);
        $delete_color->delete();
        return response()->json([
            'status'=>200
        ]);
    }

}
