<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\StyleNo;
use App\Models\Offer;
use App\Models\Category;
use App\Models\SubCategory;
use Validator;
use App\MyApp;


class OfferController extends Controller
{
    public function index(){
        $brands = Brand::all();
        $get_style_no= StyleNo::all();
        $Categories = Category::all();
        // $get_date = Offer::whereBetween('date', ['offer_from' , 'offer_to'] )->get();

        $offers = Offer::leftjoin('brands','brands.id','=','offers.brand_id')   
            ->leftjoin('sub_categories','offers.sub_category_id','=','sub_categories.id')           
            ->orderBy('offer_from','DESC')
            ->orderBy('offer_to','DESC')
            ->orderBy('status','DESC')
            ->select(['offers.*','brands.brand_name','sub_categories.sub_category'])
            ->get();
            // print_r($offers);

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
            $offer_section =  $req->input('offer_section');
            $offer_type =  $req->input('offer_type');
            $model = new Offer;

            if ($offer_section == MyApp::PRODUCT) {
                $model->category_id = $req->input('category_id');
                $model->sub_category_id = $req->input('sub_category_id');
                $model->style_no_id = implode(",",$req->input('style_no_id'));
                $model->brand_id = $req->input('brand_id');
            }

            $model->offer_section = $req->input('offer_section');
            $model->offer_type = $req->input('offer_type');
            $model->summary = $req->input('summary');
            $model->discount_offer = $req->input('discount_offer');
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
                $model->status = INACTIVE;
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
        $sub_categories = SubCategory::where(['id' => $offer->sub_category_id])->get();
        $html = "";
        foreach ($sub_categories as $key => $sub_category) {
            if($offer->sub_category_id == $sub_category->id){
                $html .= "<option value='".$sub_category->id."' selected>" . $sub_category->sub_category  . "</option>" ;
            }        
        }
        return response()->json([
            'status'=>200,
            'offer'=>$offer,
            'sub_categories'=>$html
        ]);
    }

    public function updateOffer(Request $req, $offer_id)
    {
        $validator = Validator::make($req->all(),[
            // 'brand_id' => 'required|max:191',
          
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
            $model->offer_type = $req->input('offer_type');
            $model->category_id = $req->input('category_id');
            $model->sub_category_id = $req->input('sub_category_id');
            $model->brand_id = $req->input('brand_id');
            $model->discount_offer = $req->input('discount_offer');
            $model->style_no_id = implode(",",$req->input('style_no_id'));
            // $model->style_no_id = explode(',',$req->input('style_no_id'));
            $model->brand_id = $req->input('brand_id');
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
