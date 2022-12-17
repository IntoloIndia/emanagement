<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use Validator;
class CategoryController extends Controller
{
    //

    public function index(){
        // return view('category',[]);
        $allCategory = Category::all();
        return view('category',[
            'allCategory' => $allCategory
        ]);
    }

    function saveCategory(Request $req)
    {
        // return view('employee');
        $validator = Validator::make($req->all(),[
            "category" => 'required|unique:categories,category,'.$req->input('category'),
            'category_img' => 'required|max:191',
            
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
                $model->category_img = $req->file('category_img')->store('image/category'. $req->input('category_img'),'public');            
            
           
            if($model->save()){
                return response()->json([   
                    'status'=>200,

                ]);
                // return redirect('category');
            }
        }
    }

    
    public function editCategory($category_id)
    {
        $category = Category::find($category_id);
        return response()->json([
            'status'=>200,
            'category'=>$category
        ]);
    }


    public function updateCategory(Request $req, $category_id)
    {
        $validator = Validator::make($req->all(),[
            "category" => 'required|max:191',
            // 'category_img' => 'required|max:191',
            // 'category' => 'required|unique:categories,category,'.$category_id,
            // $item_name = 'required|unique:items,item_name,'.$item_id;

        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Category::find($category_id);
            // $model->category = $req->input('category');
            // $model->category_img = $req->input('category_img');
            
            $model->category = $req->input('category');
            if ($req->hasFile('category_img')){
                if($req->input('category') > 0)
                {   
                    $CategoryImage = public_path('storage/').$model->category_img;
                    if(file_exists($CategoryImage)){
                        @unlink($CategoryImage); 
                    }
                }
                $model->category_img = $req->file('category_img')->store('image/category'. $req->input('category_img'),'public');
            
            }
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }


    public function deleteCategory($category_id)
    {
        $delete_category = Category::find($category_id);
        $delete_category->delete();
        return response()->json([
            'status'=>200
        ]);
    }

}
