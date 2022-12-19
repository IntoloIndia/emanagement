<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        return view('purchase-return');
    }
}
