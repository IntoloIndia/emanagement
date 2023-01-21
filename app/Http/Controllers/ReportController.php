<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\CustomerBillInvoice;

class ReportController extends Controller
{
    //
    public function offerReport()
    {
        $offers = Offer::all();
        $bill_invoice_items = CustomerBillInvoice::all();
        
        return view('report.offer_report',[
            'offers'=>$offers,
            'bill_invoice_items'=>$bill_invoice_items
        ]);
    }
}
