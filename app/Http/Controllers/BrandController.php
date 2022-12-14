<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use Validator;

class BrandController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('brand',[
            'categories'=>$categories,
            'brands'=>$brands,
        ]);

    }

    function saveBrand(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'brand_name' => 'required|max:191',
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
                $brands = Brand::all();
                return response()->json([   
                    'status'=>200,
                    'brands'=>$brands,
                ]);
            }
        }
    }

    public function editBrand($brand_id)
    {
        $brand = Brand::find($brand_id);
        return response()->json([
            'status'=>200,
            'brand'=>$brand
        ]);
    }

    public function updateBrand(Request $req, $brand_id)
    {
       

        $validator = Validator::make($req->all(),[
            'brand_name' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Brand::find($brand_id);
            $model->brand_name = $req->input('brand_name'); 
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function deleteBrand($brand_id)
    {
        $delete_brand = Brand::find($brand_id);
        $delete_brand->delete();
        return response()->json([
            'status'=>200
        ]);
    }
}
