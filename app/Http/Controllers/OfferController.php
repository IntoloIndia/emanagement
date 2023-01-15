<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\StyleNo;
use App\Models\Offer;
use App\Models\Category;
use Validator;
use App\MyApp;


class OfferController extends Controller
{
    public function index(){
        $brands = Brand::all();
        $get_style_no= StyleNo::all();
        $Categories = Category::all();

        $offers = Offer::join('brands','brands.id','=','offers.brand_id')
           
            ->select(['offers.*','brands.brand_name',])
            // ->groupBy('offers.id','offers.brand_id')
            ->get();
            // dd($offers);


        return view('offer',[
            'brands' => $brands,
            'get_style_no' => $get_style_no,
            'offers' => $offers,
            'Categories' => $Categories,
        ]);
    }
    public function saveOffer(Request $req)
    {
        $validator = Validator::make($req->all(),[
            // 'brand_id' => 'required|max:191',
            // 'discount_offer' => 'required|max:191',
           
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $offer_type =  $req->input('offer_type');
            $model = new Offer;
            if($offer_type==1){
                $model->offer_type = $req->input('offer_type');
                $model->purcentage = $req->input('purcentage');
              

            }elseif($offer_type==2){
                $model->offer_type = $req->input('offer_type');
                $model->summary = $req->input('summary');
                $model->purcentage = $req->input('purcentage');
              
            }elseif($offer_type==3){
                $model->offer_type = $req->input('offer_type');
                $model->summary = $req->input('summary'); 
              
            }elseif($offer_type==4){
                $model->offer_type = $req->input('offer_type');
                $model->summary = $req->input('summary');
                $model->purcentage = $req->input('purcentage');
            }

            $model->offer_on = $req->input('offer_on');
            $model->brand_id = $req->input('brand_id');
            $model->style_no_id = implode(",",$req->input('style_no_id'));
            // $model->discount_offer = $req->input('discount_offer');
            $model->offer_from = $req->input('offer_from');
            $model->offer_to = $req->input('offer_to');
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
            $model->save();
            if($model->date)
            
            $get_date = Offer::whereBetween('date', [$model->offer_from , $model->offer_to] )->get();
            if($get_date){
                $model->status = MyApp::ACTIVE;
            }
            else{
                $model->status = STATUS;
            }
            $model->save();
            return response()->json([
                'status'=>200,  
            ]);
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
            $model->offer_on = $req->input('offer_on');
            $model->brand_id = $req->input('brand_id');
            $model->style_no_id = $req->input('style_no_id');
            $model->discount_offer = $req->input('discount_offer');
            $model->offer_from = $req->input('offer_from');
            $model->offer_to = $req->input('offer_to');
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
            $model->status = MyApp::STATUS;
            
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
