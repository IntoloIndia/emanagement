<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportProduct;
use App\Exports\ExportProduct;

use Maatwebsite\Excel\Facades\Excel;


class ExcalProductDataController extends Controller
{
    public function index(){
        return view('excel_data',[]);
    }

    public function import(){
        return Excel::download(new ExportProduct,'size.xlsx');
    }

    public function export(){
        Excel::import(new ImportProduct,request()->file('file'));
        return back();
    }
}
