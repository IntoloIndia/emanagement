<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExcalProductDataController extends Controller
{
    public function index(){
        return view('excel_data',[]);
    }
}
