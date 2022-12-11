<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;

class BrandController extends Controller
{
    public function index()
    {
        $Categories = Category::all();
        return view('brand',[
            'Categories'=>$Categories
        ]);

    }

    function saveBrand(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'brand' => 'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all field required"),
            ]);
        }else{
            $model = new Brand;
            $model->brand_name = $req->input('brand_name');         
            if($model->save()){
                return response()->json([   
                    'status'=>200,
                ]);
            }
        }
    }
}
