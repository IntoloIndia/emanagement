<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;
class CategoryController extends Controller
{
    //

    public function index(){
        return view('category',[]);
    }

    function saveCategory(Request $req)
    {
        // return view('employee');
        $validator = Validator::make($req->all(),[
            "category" => 'required|max:191',
            'category_img' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz fill all field required"),
            ]);
        }else{
            $model = new Category;
            $model->category = $req->input('category');
            // $model->category_img = $req->input('category_img');
            
            // $model->category_name = strtolower($req->input('category_name'));
            // if ($req->hasFile('category_img')){
            //     if($req->input('category_id') > 0)
            //     {   
                    $CategoryImage = public_path('storage/').$model->category_img;
                    if(file_exists($CategoryImage)){
                        @unlink($CategoryImage); 
                    }
            //     }
                $model->category_img = $req->file('category_img')->store('category-image'. $req->input('category_img'),'public');            
            
           
            if($model->save()){
                return response()->json([   
                    'status'=>200,

                ]);
                // return redirect('category');
            }
        }
    }

}
