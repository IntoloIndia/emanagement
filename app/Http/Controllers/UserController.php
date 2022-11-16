<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('users',[
            'roles' => $roles
        ]);
    }

    function saveUser(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'user_role' => 'required|max:191',
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
            $model->user_role = $req->input('user_role');
            $model->name = $req->input('name');
            $model->email = $req->input('email');
            $model->password = $req->input('password');
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }
    
}
