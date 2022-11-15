<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    //
    public function index()
    {

        return view('billing',[]);
        
        // return response()->json([
        //     'status'=>200,
        //     'messege'=>"ok",
        // ]);
    }
}
