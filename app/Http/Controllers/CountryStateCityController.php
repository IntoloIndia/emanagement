<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountryStateCityController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('country_state_city',[
            "countries"=>$countries,
            'states' => $states,
            'cities'=> $cities
        ]);
    }

    public function manageCountry(Request $req)
    {
        if($req->input('country_id') > 0)
        {
            $country = 'required|unique:countries,country,'.$req->input('country_id');
            $country_short = 'required|unique:countries,country_short,'.$req->input('country_id');
            // $category_img = 'mimes:jpeg,png,jpg|max:1024|dimensions:max-width=480,max-height=336';
            $model = Country::find($req->input('country_id'));
        }else{
            $country = 'required|unique:countries,country,'.$req->input('country');
            $country_short = 'required|unique:countries,country_short,'.$req->input('country_short');
            $model = new Country ;
        }

        $validator = Validator::make($req->all(),[
            'country' => $country,
            'country_short' => $country_short
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model->country = strtolower($req->input('country'));
            $model->country_short = strtolower($req->input('country_short'));

            // if ($req->hasFile('category_img')){
            //     if($req->input('category_id') > 0)
            //     {   
            //         $CategoryImage = public_path('storage/').$model->category_img;
            //         if(file_exists($CategoryImage)){
            //             @unlink($CategoryImage); 
            //         }
            //     }
            //     $model->category_img = $req->file('category_img')->store('item-category'. $req->input('category_img'),'public');            
            // }

            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }

        }
    }

    public function editCountry($country_id)
    {
        $country = Country::find($country_id);
        return response()->json([
            'status'=>200,
            'country'=>$country,
        ]);
    }

    public function deleteCountry($country_id)
    {
        $model = Country::find($country_id);
        $model->delete();
        return response()->json([
            'status'=>200,
        ]);
    }

    public function manageState(Request $req)
    {
        if($req->input('state_id') > 0)
        {
            $country_id = 'required|max:191';
            $state = 'required|unique:states,state,'.$req->input('state');
            $state_short = 'required|unique:states,state_short,'.$req->input('state_short');
            $model = State::find($req->input('state_id'));
        }else{
            $country_id = 'required|max:191';
            $state = 'required|unique:states,state,'.$req->input('state');
            $state_short = 'required|unique:states,state_short,'.$req->input('state_short');
            $model = new State ;
        }

        $validator = Validator::make($req->all(),[
            'country_id' => $country_id,
            'state' => $state,
            'state_short' => $state_short
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model->country_id = $req->input('country_id');
            $model->state = strtolower($req->input('state'));
            $model->state_short = strtolower($req->input('state_short'));

            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }

        }
    }


}
