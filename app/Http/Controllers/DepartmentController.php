<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Validator;

class DepartmentController extends Controller
{
    //
    public function index(){
        // return view('category',[]);
        $departments = Department::all();
        return view('department',[
            'departments' => $departments
        ]);
    }

    function saveDepartment(Request $req)
    {
        // return view('employee');
        $validator = Validator::make($req->all(),[
            'department' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = new Department;
            $model->department = $req->input('department');
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }

    public function editDepartment($department_id)
    {
        $department = Department::find($department_id);
        return response()->json([
            'status'=>200,
            'department'=>$department
        ]);
    }

    public function updateDepartment(Request $req, $department_id)
    {
       

        $validator = Validator::make($req->all(),[
            'department' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Department::find($department_id);
            $model->department = $req->input('department');
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }


    public function deleteDepartment($department_id)
    {
        $delete_department = Department::find($department_id);
        $delete_department->delete();
        return response()->json([
            'status'=>200
        ]);
    }


}
