<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Models\Color;
use App\Models\Size;

class ColorController extends Controller
{
    public function index(){
        $allSize = Size::all();
        $allColor = Color::all();
        return view('size',[
            'allColor'=>$allColor,
            'allSize'=>$allSize
        
    ]);
    }
    function saveColor(Request $req)
    {
        // return view('employee');
        $validator = Validator::make($req->all(),[
            'color' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill color code"),
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
