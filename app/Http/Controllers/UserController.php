<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function index(){
        $roles = Role::all();
        $allUser = User::all();
        return view('users',[
            'roles' => $roles,
            'allUser' =>$allUser
        ]);
    }

    function saveUser(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'role_id' => 'required|max:191',
            'name'=>'required|max:191',
            'email'=>'required|max:191',
            'password'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz  all field required"),
            ]);
        }else{
            $model = new User;
            $model->role_id = $req->input('role_id');
            $model->name = $req->input('name');
            $model->email = $req->input('email');
            $model->password = Hash::make($req->input('password')); 
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }


    public function editUser($user_id)
    {
        $user = User::find($user_id);
        return response()->json([
            'status'=>200,
            'user'=>$user
        ]);
    }


    public function updateUser(Request $req, $user_id)
    {
        $validator = Validator::make($req->all(),[
            'role_id' => 'required|max:191',
            'name' => 'required|max:191',
            'email' => 'required|unique:users,email,'.$user_id,
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = User::find($user_id);
            $model->role_id = $req->input('role_id');
            $model->name = $req->input('name');
            $model->email = $req->input('email');
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

    public function deleteUser($user_id)
    {
        $delete_user = User::find($user_id);
        $delete_user->delete();
        return response()->json([
            'status'=>200
        ]);
    }


    
}
