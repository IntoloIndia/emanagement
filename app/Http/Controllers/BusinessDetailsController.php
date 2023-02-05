<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessDetails;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Validator;

class BusinessDetailsController extends Controller
{
    public function index(){

        $business_detail = BusinessDetails::join('countries','countries.id','=','business_details.country_id')
            ->join('states','states.id','=','business_details.state_id')
            ->join('cities','cities.id','=','business_details.city_id')
            ->orderBy('business_details.id', 'DESC')
            ->select('business_details.*','countries.country','states.state','cities.city')->get();

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('business_details',[
            'business_detail' => $business_detail,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities
        ]);
    }

    function saveCompanyDetail(Request $req)
    {
        $validator = Validator::make($req->all(),[
            
            'business_name'=>'required|max:191',
            'owner_name'=>'required|max:191',
            'mobile_no'=>'required|max:191',
            'country_id'=>'required|max:191',
            'state_id'=>'required|max:191',
            'city_id'=>'required|max:191',
            'company_address'=>'required|max:191',
            'email'=>'required|max:191',
            'pincode'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz  all field required"),
            ]);
        }else{
            $model = new BusinessDetails;
            $model->business_name = $req->input('business_name');
            $model->owner_name = $req->input('owner_name');
            $model->mobile_no = $req->input('mobile_no');
            $model->ladline_no = $req->input('ladline_no');
            $model->gst = $req->input('gst');
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
            $model->company_address = $req->input('company_address');
            $model->email = $req->input('email');
            $model->pincode = $req->input('pincode');
            // $modal->date=date('');
            // $modal->time=date('');
 
           
            if($model->save()){
                return response()->json([   
                    'status'=>200,
                   
                ]);
            }
        }
    }

    public function editCompanyDetails($company_id)
    {
        $company = BusinessDetails::find($company_id);
        $state = State::where(['country_id'=>$company->country_id])->get();
        $city = City::where(['state_id'=>$company->state_id])->get();

        $html = "";
        $html .= "<option disabled>Choose...</option>";
        foreach ($state as $key => $list) {
            if ($list->id == $company->state_id) {
                $html .= "<option selected value='".$list->id."'>".ucwords($list->state)."</option>";
            } else {
                $html .= "<option value='".$list->id."'>".ucwords($list->state)."</option>";
            }
        }

        $htmlcity = "";
        $htmlcity.= "<option disabled>Choose...</option>";
        foreach ($city as $key => $list) {
            if ($list->id == $company->city_id) {
                $htmlcity .= "<option selected value='".$list->id."'>".ucwords($list->city)."</option>";
            } else {
                $htmlcity .= "<option value='".$list->id."'>".ucwords($list->city)."</option>";
            }
        }
        return response()->json([
            'status'=>200,
            'company'=>$company,
            'html'=>$html,
            'htmlcity'=>$htmlcity
        ]);
    }


    public function updateCompanyDetails(Request $req, $company_id)
    {
        $validator = Validator::make($req->all(),[
            
            // 'company_name'=>'required|max:191',
            // 'business_name'=>'required|max:191',
            // 'email' => 'required|unique:business_details,email,'.$company_id,
            // 'mobile_no'=>'required|max:191',

        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            
            $model = BusinessDetails::find($company_id);

            $model->business_name = $req->input('business_name');
            $model->owner_name = $req->input('owner_name');
            $model->mobile_no = $req->input('mobile_no');
            $model->ladline_no = $req->input('ladline_no');
            $model->gst = $req->input('gst');
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
            $model->company_address = $req->input('company_address');
            $model->email = $req->input('email');
            $model->pincode = $req->input('pincode');
            // $modal->date=date('');
            // $modal->time=date('');
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function deleteCompanyDetail($company_id)
    {
        $delete_company = BusinessDetails::find($company_id);
        $delete_company->delete();
        return response()->json([
            'status'=>200
        ]);
    }

}
