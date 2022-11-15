<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\Admin;
use App\MyApp;

class AuthController extends Controller
{
    //
    public function index(Request $req)
    {
        if($req->session()->has('LOGIN'))
        {
            //apply role condition
            if (session('LOGIN_ROLE') == MyApp::ADMINISTRATOR ) {
                return redirect('admin/dashboard');
            }elseif ( session('LOGIN_ROLE') == MyApp::BILLING) {
                return redirect('/billing');
            }
        }
        return view('/login');
    }

    public function loginAuth(Request $req)
    {
        $email = $req->input('email');
        $password = $req->input('password');

        $result = Admin::where(['email'=>$email])->first();
        if($result)
        {
            if(Hash::check($req->input('password'),$result->password))
            {
                // $req->session()->put('LOGIN', true);
                $req->session()->put('LOGIN_ID', $result->id);
                $req->session()->put('LOGIN_NAME', $result->name);
                $req->session()->put('LOGIN_ROLE', $result->role_id);
                //return redirect('admin/dashboard');

                if($result->role_id == MyApp::ADMINISTRATOR){
                    $req->session()->put('ADMIN_LOGIN', true);
                    return redirect('admin/dashboard');
                }elseif ($result->role_id == MyApp::BILLING) {
                    $req->session()->put('BILLING_LOGIN', true);
                    return redirect('/billing');
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
        if(session('LOGIN_ROLE') == MyApp::ADMINISTRATOR){
            session()->forget('ADMIN_LOGIN');
        }elseif (session('LOGIN_ROLE') == MyApp::BILLING) {
            session()->forget('BILLING_LOGIN');
        }
        // session()->forget('LOGIN');
        session()->forget('LOGIN_ID');
        session()->forget('LOGIN_NAME');
        session()->forget('LOGIN_ROLE');
        session()->flash('msg','Logout successfully'); 
        return redirect('/login');
    }

    

}
