<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\StyleNo;
use App\Models\Offer;
use Validator;


class OfferController extends Controller
{
    public function index(){
        $brands = Brand::all();
        $get_style_no= StyleNo::all();
       
        $offers = Offer::join('brands','brands.id','=','offers.brand_id')
            ->join('style_nos','style_nos.id','=','offers.style_no_id')
            ->select(['offers.*','brands.brand_name','style_nos.style_no'])
            ->select(['offers.*','brands.brand_name'])
            // ->groupBy('offers.id','offers.brand_id')
            ->get();
            // print($offers);
        return view('offer',[
            'brands' => $brands,
            'get_style_no' => $get_style_no,
            'offers' => $offers
        ]);
    }
    public function saveOffer(Request $req)
    {
        $validator = Validator::make($req->all(),[
            // 'brand_id' => 'required|max:191',
            'discount_offer' => 'required|max:191',
           
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = new Offer;
            $model->brand_id = $req->input('brand_id');
            $model->style_no_id = $req->input('style_no_id');
            $model->discount_offer = $req->input('discount_offer');
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function editOffer($offer_id)
    {
        $offer = Offer::find($offer_id);
        return response()->json([
            'status'=>200,
            'offer'=>$offer
        ]);
    }

    public function updateOffer(Request $req, $offer_id)
    {
        $validator = Validator::make($req->all(),[
            // 'brand_id' => 'required|max:191',
             'discount_offer' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Offer::find($offer_id);
            $model->brand_id = $req->input('brand_id');
            $model->style_no_id = $req->input('style_no_id');
            $model->discount_offer = $req->input('discount_offer');
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
        
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }
    
    public function deleteOffer($offer_id)
    {
        $model = Offer::find($offer_id);
        $model->delete();
        return response()->json([
            'status'=>200
        ]);
    }

}
