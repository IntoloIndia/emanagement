<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserAPIController extends Controller
{
    //
    public function getUsers(Request $req){
        $users = User::all();
        return response()->json([
            'status'=>200,
            'data'=>$users,
            'user_count'=>$users->count()
        ]); 
    }
}
