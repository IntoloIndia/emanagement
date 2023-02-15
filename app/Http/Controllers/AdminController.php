<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Role;
use App\Models\Admin;
use App\MyApp;



class AdminController extends Controller
{
    //
    public function index(){
        // $admins = Admin::all()->sortBy('role');
        $roles = Role::where(['active'=>MyApp::ACTIVE])->get();
        $admins = Admin::join('roles','admins.role_id','=','roles.id')->get(['admins.*', 'roles.role']);
        return view('admin',[
            'admins' => $admins,
            'roles' => $roles
        ]);
    }

    public function saveAdmin(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'role_id' => 'required|max:191',
            'name' => 'required|max:191',
            'email' => 'required|unique:admins,email,'.$req->input('email'),
            'password' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = new Admin ;
            $model->role_id = $req->input('role_id');
            $model->name = strtolower($req->input('name'));
            $model->email = strtolower($req->input('email'));
            $model->password = Hash::make($req->input('password')); 
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function editAdmin($admin_id)
    {
        $admin = Admin::find($admin_id);
        return response()->json([
            'status'=>200,
            'admin'=>$admin
        ]);
    }

    public function updateAdmin(Request $req, $admin_id)
    {
        $validator = Validator::make($req->all(),[
            'role_id' => 'required|max:191',
            'name' => 'required|max:191',
            'email' => 'required|unique:admins,email,'.$admin_id,
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Admin::find($admin_id);
            $model->role_id = $req->input('role_id');
            $model->name = strtolower($req->input('name'));
            $model->email = strtolower($req->input('email'));
            if($req->input('password') !=""){
                $model->password = Hash::make($req->input('password')); 
            }
        
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function deleteAdmin($admin_id)
    {
        $model = Admin::find($admin_id);
        $model->delete();
        return response()->json([
            'status'=>200
        ]);
    }


}
