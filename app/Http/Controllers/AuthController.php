<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Admin;
use App\Models\User;
use App\Models\SystemKey;
use App\MyApp;

class AuthController extends Controller
{
    //
    public function index(Request $req)
    {
        if($req->session()->has('LOGIN') == true)
        {
            //apply role condition
            // if (session('LOGIN_ROLE') == MyApp::ADMINISTRATOR ) {
            //     return redirect('admin/dashboard');
            // }elseif ( session('LOGIN_ROLE') == MyApp::BILLING) {
            //     return redirect('/billing');
            // }
            if (session('LOGIN_ROLE') == MyApp::ADMINISTRATOR ) {
                return redirect('admin/dashboard');
            }else {
                return redirect('/dashboard');
            }
        }
        return view('/login');
    }

    public function loginAuth(Request $req)
    {
        $email = $req->input('email');
        $password = $req->input('password');
        $key = $req->input('key');
        
        $data = Admin::where(['email'=>$email])->first();
        if ($data) {
            $result = $data;
        }else {
            $data = User::where(['email'=>$email])->first();
            $result = $data;
        }

        // if ($result->role_id != MyApp::BARCODE) {
        //     if ($key == null) {
        //         $req->session()->flash('error','Network error please relaunch app again.');
        //         return redirect('/login');
        //     }
        // }
         
        if($result)
        {
            // if ($result->role_id != MyApp::BARCODE) {
                
            //     $system_data = SystemKey::where(['user_id'=>$result->id, 'user_role_id'=>$result->role_id ,'key'=>$key])->first();
            //     if ($system_data == null) {
            //         $model = new SystemKey ;
            //         $model->user_id = $result->id;
            //         $model->user_role_id = $result->role_id;
            //         $model->key = $key;
            //         if ($result->role_id == MyApp::ADMINISTRATOR) {
            //             $model->is_active = 1; 
            //         }else{
            //             $model->is_active = 0; 
            //         }
            //         $model->save();
            //         $key_data = $model;
            //     }else{
            //         $key_data = $system_data;
            //     }

            //     if ($key_data->is_active == 0) {
            //         $req->session()->flash('error','User is not active please contact admin');
            //         return redirect('/login');
            //     }

            // }

            if(Hash::check($req->input('password'),$result->password))
            {
                $req->session()->put('LOGIN', true);
                $req->session()->put('LOGIN_ID', $result->id);
                $req->session()->put('LOGIN_NAME', $result->name);
                $req->session()->put('LOGIN_ROLE', $result->role_id);

                if($result->role_id == MyApp::ADMINISTRATOR){
                    $req->session()->put('ADMIN_LOGIN', true);
                    return redirect('admin/dashboard');
                }else {
                    $req->session()->put('USER_LOGIN', true);
                    return redirect('/dashboard');
                }
            }else{
                $req->session()->flash('error','Please enter valid password');
                return redirect('/login');
            }
        }else{
            $req->session()->flash('error','Please enter valid login details');
            return redirect('/login');
        }
 
    }

    public function logout(Request $req)
    { 
        // if(session('LOGIN_ROLE') == MyApp::ADMINISTRATOR){
        //     session()->forget('ADMIN_LOGIN');
        // }elseif (session('LOGIN_ROLE') == MyApp::BILLING) {
        //     session()->forget('BILLING_LOGIN');
        // }
        if(session('LOGIN_ROLE') == MyApp::ADMINISTRATOR){
            session()->forget('ADMIN_LOGIN');
        }else {
            session()->forget('USER_LOGIN');
        }

        session()->forget('LOGIN');
        session()->forget('LOGIN_ID');
        session()->forget('LOGIN_NAME');
        session()->forget('LOGIN_ROLE');
        session()->flash('msg','Logout successfully'); 
        return redirect('/login');
    }

    

}

// other login
// OlCIKVcI0zBPBt4EmbkkO/vWjRSHhhXFMfDjRvR7OJ0=
// OlCIKVcI0zBPBt4EmbkkO/vWjRSHhhXFMfDjRvR7OJ0=
// OlCIKVcI0zBPBt4EmbkkO/vWjRSHhhXFMfDjRvR7OJ0=
