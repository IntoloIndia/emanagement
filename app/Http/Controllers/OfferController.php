<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\StyleNo;
use App\Models\Offer;
use App\Models\ApplyOffer;
use App\Models\Category;
use App\Models\SubCategory;
use Validator;
use App\MyApp;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        $get_style_no= StyleNo::all();
        $Categories = Category::all();

        $offer_types_data = Offer::groupBy('offer_type')->get('offer_type');
        // $offers = array();
        // foreach ($offer_types_data as $key => $list) {
        //     $data = Offer::where(['offer_type'=> $list->offer_type])->get();
        //     $offers[] = $data;
        // }

        // $apply_offers = ApplyOffer::all();
        $apply_offers = ApplyOffer::leftjoin('brands', 'brands.id', '=', 'apply_offers.brand_id')
                                // ->join('offers', 'offers.id', '=', 'apply_offers.offer_id')
            ->leftjoin('sub_categories', 'apply_offers.sub_category_id', '=', 'sub_categories.id')
            ->orderBy('offer_from', 'DESC')
            ->orderBy('offer_to', 'DESC')
            ->orderBy('status', 'DESC')
            ->select(['apply_offers.*','brands.brand_name','sub_categories.sub_category'])
            ->get();

            // $currentDate = Carbon::now()->format('Y-m-d');
            //  $getOfferTime = ApplyOffer::where(['status'=>MyApp::ACTIVE,])->get('apply_offers.time');
                // dd($currentDate);
                // if($getOfferTime){

                // }
        

        return view('offer', [
            'brands' => $brands,
            'get_style_no' => $get_style_no,
            'Categories' => $Categories,
            'offer_types_data' => $offer_types_data,
            'apply_offers' => $apply_offers,
        ]);
    }

    public function saveCreateOffers(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'offer_type' => 'required|max:191',
            'discount_offer' => 'required|max:191',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
            
        } else {
            $offer_type = $req->input('offer_type');
            $discount_offer = $req->input('discount_offer');
            $summary = $req->input('summary');

            foreach ($discount_offer as $key => $list) {
                $model = new Offer();
                $model->offer_type = $offer_type;
                if ($summary != null) {
                    $model->summary = $summary[$key];
                }
                $model->discount_offer = $discount_offer[$key];
                $model->save();
            }

            return response()->json([
                'status'=>200,
            ]);
        }
    }


    public function saveApplyOffer(Request $req)
    {

        // return $req;
        // dd();
        $validator = Validator::make($req->all(), [
            // 'offer_type' => 'required|max:191',
            // 'discount_offer' => 'required|max:191',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        } else {
            $offer_section =  $req->input('offer_section');
            $offer_type =  $req->input('offer_type');
            $model_data = new ApplyOffer();


            if ($offer_section == MyApp::PRODUCT) {
                if ($req->input('category_id') != null) {
                    $model_data->category_id = $req->input('category_id');
                }
                if ($req->input('sub_category_id') != null) {
                    $model_data->sub_category_id = $req->input('sub_category_id');
                }
                if ($req->input('brand_id') != null) {
                    $model_data->brand_id = $req->input('brand_id');
                }
                $model_data->barcode = implode(",", $req->input('barcode'));
            }

            $model_data->offer_section = $req->input('offer_section');
            $model_data->offer_type = $req->input('offer_type');
            $model_data->offer_type_id = implode(",", $req->input('offer_type_id'));
            $model_data->offer_from = $req->input('offer_from');
            $model_data->offer_to = $req->input('offer_to');
            $model_data->offer_start_time = $req->input('offer_start_time');
            $model_data->offer_end_time = $req->input('offer_end_time');
            $model_data->date = date('Y-m-d');
            $model_data->time = date('g:i A');
            $model_data->save();
            if ($model_data->date) {
                $get_date = ApplyOffer::whereBetween('date', [$model_data->offer_from , $model_data->offer_to])->get();
            }
            if ($get_date) {
                $model_data->status = MyApp::ACTIVE;
            } else {
                $model_data->status = INACTIVE;
            }
            $model_data->save();
            return response()->json([
                'status'=>200,
                'message' => "data save"
            ]);
        }
    }



    public function editOffer($offer_id)
    {
        $offer = Offer::find($offer_id);
        return response()->json([
            'status'=>200,
            'offer'=>$offer,
           
        ]);
    }

    public function updateOffer(Request $req, $offer_id)
    {
        $validator = Validator::make($req->all(), [
            'discount_offer' => 'required|max:191',
            'discount_offer' => 'required|unique:offers,discount_offer,'.$req->input('discount_offer[]'),

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        } else {
            $offer_type = $req->input('offer_type');
            $discount_offer = $req->input('discount_offer');
            $summary = $req->input('summary');

            foreach ($discount_offer as $key => $list) {
                $model = Offer::find($offer_id);
                $model->offer_type = $offer_type;
                if ($summary != null) {
                    $model->summary = $summary[$key];
                }
                $model->discount_offer = $discount_offer[$key];
                $model->save();
            }


            if ($model->save()) {
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

    public function getOfferType($offer_type)
    {
        // $offer_type = "";
        $data = Offer::where(['offer_type'=> $offer_type])->get();

    //    $summary = "";
    //    $discount_offer = "";

        $html = "";
        $label = "";
        $html .="<div class='card'>";
            $html .="<div class='card-body'>";
            foreach ($data as $key => $list) {
                // $summary = $list->summary;
                // $discount_offer = $list->discount_offer;

                    if($offer_type==MyApp::PERCENTAGE){
                        $summary = "<span> % off</span>";
                        $offer_data = "<label class='form-check-label' >".$list->discount_offer."". $summary ."</label>";
                    }
                    if($offer_type==MyApp::VALUES){
                        $summary = "<span>".$list->summary." /-</span>";
                        $offer_data = "<label class='form-check-label' >$summary<span class='ml-2'>$list->discount_offer</span><span> % off</span></label>";
                    }
                    if($offer_type==MyApp::PICES){
                        $summary = "<span>Buy</span><span class='ml-1'>" .$list->summary."</span>";
                        $offer_data = "<label class='form-check-label' >$summary<span class='ml-1'>Get</span><span class='ml-1'>$list->discount_offer</span><span class='ml-1'>Free</span></label>";
                    }
                    if($offer_type==MyApp::SLAB){
                        $summary = "<span>".$list->summary."</span><span class='ml-1'>pices</span>";
                        $offer_data = "<label class='form-check-label' >$summary <span class='ml-3'>$list->discount_offer</span><span> % off</span></label>";
                    }
                    
                    if($offer_type==MyApp::PERCENTAGE){
                    $html .="<div class='form-check'>";
                        $html .="<input class='form-check-input' type='radio' name='offer_type_id[]' value='".$list->id."'>";
                        $html .= $offer_data;
                    $html .="</div>";
                    }
                    else{
                        $html .="<div class='form-check'>";
                        $html .="<input class='form-check-input' type='checkbox' name='offer_type_id[]' value='".$list->id."'>";
                        $html .= $offer_data;
                    $html .="</div>";
                    }    
                }

                $html .="</div>";
        $html .="</div>";
        return response()->json([
            'status'=>200,
            'html'=>$html
        ]);
    }

    function applyOfferUpdateStatus($apply_offer_id)
    {
        $apply_offer_status =ApplyOffer::find($apply_offer_id);
        if($apply_offer_status->status){
            $apply_offer_status->status = MyApp::INACTIVE;
        }else{
            
            $apply_offer_status->status = MyApp::ACTIVE;
        }
        $apply_offer_status->save();
        
        return response()->json([
            'status'=>200,
            // 'active'=>$status_data->status
        ]);
    }
    // function offerEnd(){

    //     $currentDate = Corbon::now()->format('Y-m-d');
    //     $getOfferTime = ApplyOffer::where(['status'=>MyApp::ACTIVE,])->get();
    //     dd($currentDate);
       
    // }
}
