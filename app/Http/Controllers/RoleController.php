<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use App\MyApp;

class RoleController extends Controller
{
    function index()
    {
        $roles = Role::all();
        return view('role' ,[
            'roles'=>$roles
        ]);
    }

    function saveRole(Request $req)
    {
        $validator = Validator::make($req->all(),[
            // 'role' => 'required|max:191',
            'role' => 'required|unique:roles,role,'.$req->input('role'),
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = new Role ;
            $model->role = $req->input('role');
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    function editRole($role_id)
    {
        $role_id = Role::find($role_id);
        return response()->json([
            'status'=>200,
            'role_id'=>$role_id
        ]);
    }
    
    public function updateRole(Request $req, $role_id)
    {
        $validator = Validator::make($req->all(),[
            'role' => 'required|unique:roles,role,'.$role_id,
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Role::find($role_id);
            $model->role = $req->input('role');         
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function activeDeactiveRole($role_id)
    {
        $role = Role::find($role_id);
        if($role->active == MyApp::INACTIVE)
        {
            $role->active = MyApp::ACTIVE;
        }else{
            $role->active = MyApp::INACTIVE;
        }
        $role->save();
        return response()->json([
            'status'=>200,
            'role'=>$role
        ]);
    }

    public function deleteRole($role_id)
    {
        $role = Role::find($role_id);
        $role->delete();
        return response()->json([
            'status'=>200,
            'role'=>$role
        ]);
    }
}
