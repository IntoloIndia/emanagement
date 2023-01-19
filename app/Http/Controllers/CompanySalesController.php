<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySupplier;

class CompanySalesController extends Controller
{
    //
    public function index(){

        $companySuppliers = CompanySupplier::all();

        return view('company.company_sales',[
            'companySuppliers' =>$companySuppliers,
        ]);
    }
}
