<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $getAllRole = Role::all();
        // print_r($getAllRole);
        return view('role',[
            'getAllRole'=>$getAllRole
        
        ]);
    }
    
}
