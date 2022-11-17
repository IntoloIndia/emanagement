<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\User;

class AuthAPIController extends Controller
{
    //
    public function getAdmin(Request $req){
        $admin = Admin::all();
        return response()->json([
            'status'=>400,
            'admin'=>$admin
        ]); 
    }

    public function adminLogin(Request $req)
    {
        $email = $req->input('email');
        $password = $req->input('password');

        $result = Admin::where(['email'=>$email])->first();
        if($result)
        {
            if(Hash::check($req->input('password'),$result->password))
            {
                // $data = [
                //     'status'=>200,
                //     'login_id'=>$result->id,
                //     'login_name'=>$result->name,
                //     'login_role'=>$result->role_id,
                //     'message'=>'Login successfully'
                // ];
                return response()->json([
                    'status'=>200,
                    'login_id'=>$result->id,
                    'login_name'=>$result->name,
                    'login_role'=>$result->role_id,
                    'message'=>'Login successfully'
                ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'Please enter valid password'
                ]);
            }
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'Please enter valid login details'
            ]);
        }
    }

    public function userLogin(Request $req)
    {
        $email = $req->input('email');
        $password = $req->input('password');

        $result = User::where(['email'=>$email])->first();
        if($result)
        {
            if(Hash::check($req->input('password'),$result->password))
            {
                // $data = [
                //     'status'=>200,
                //     'login_id'=>$result->id,
                //     'login_name'=>$result->name,
                //     'login_role'=>$result->role_id,
                //     'message'=>'Login successfully'
                // ];
                return response()->json([
                    'status'=>200,
                    'login_id'=>$result->id,
                    'login_name'=>$result->name,
                    'login_role'=>$result->role_id,
                    'message'=>'Login successfully'
                ]);
            }else{
                return response()->json([
                    'status'=>400,
                    'message'=>'Please enter valid password'
                ]);
            }
        }else{
            return response()->json([
                'status'=>400,
                'message'=>'Please enter valid login details'
            ]);
        }
    }
}
