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
        $roles = Role::all();
        return view('admin',[
            'roles' => $roles
        ]);
    }
}
