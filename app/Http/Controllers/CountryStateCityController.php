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
        if($req->input('update_state_id') > 0)
        {
            $country_id = 'required|max:191';
            $state = 'required|unique:states,state,'.$req->input('update_state_id');
            $state_short = 'required|unique:states,state_short,'.$req->input('update_state_id');
            $model = State::find($req->input('update_state_id'));
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

    public function editState($state_id)
    {
        $state = State::find($state_id);
        return response()->json([
            'status'=>200,
            'state'=>$state,
        ]);
    }

    public function deleteState($state_id)
    {
        $model = State::find($state_id);
        $model->delete();
        return response()->json([
            'status'=>200,
        ]);
    }

    public function manageCity(Request $req)
    {
        if($req->input('city_id') > 0)
        {
            $country_id = 'required|max:191';
            $state_id = 'required|max:191';
            $city = 'required|unique:cities,city,'.$req->input('city_id');
            $city_short = 'required|unique:cities,city_short,'.$req->input('city_id');
            $model = City::find($req->input('city_id'));
        }else{
            $country_id = 'required|max:191';
            $state_id = 'required|max:191';
            $city = 'required|unique:cities,city,'.$req->input('city');
            $city_short = 'required|unique:cities,city_short,'.$req->input('city_short');
            $model = new City ;
        }

        $validator = Validator::make($req->all(),[
            'country_id' => $country_id,
            'state_id' => $state_id,
            'city' => $city,
            'city_short' => $city_short
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city = strtolower($req->input('city'));
            $model->city_short = strtolower($req->input('city_short'));

            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }

        }
    }

    public function editCity($city_id)
    {
        $city = City::find($city_id);
        $states = State::where(['country_id' => $city->country_id])->get();

        $html = "";
        foreach ($states as $key => $state) {
            if($city->state_id == $state->id){
                $html .= "<option value='".$state->id."' selected>" . $state->state  . "</option>" ;
            }else{
                $html .= "<option value='".$state->id."'>" . $state->state  . "</option>";
            }
        }

        return response()->json([
            'status'=>200,
            'city'=>$city,
            'states'=>$html
        ]);
    }

    public function deleteCity($city_id)
    {
        $model = City::find($city_id);
        $model->delete();
        return response()->json([
            'status'=>200,
        ]);
    }

    public function getStateByCountry($country_id)
    {
        $data = State::where(['country_id'=>$country_id])->get(['id', 'state',]);

        $html = "";
        $html .= "<option selected disabled >State</option>";
        foreach($data as $list)
        {
            $html.= "<option value='" . $list->id . "'>" . ucwords($list->state) . "</option>";
        }
        return response()->json([
            'status'=> 200,
            'html'=> $html,
        ]);
    }

    public function getCityByState($state_id)
    {
        $data = City::where(['state_id'=>$state_id])->get(['id', 'city',]);

        $html = "";
        $html .= "<option selected disabled >City</option>";
        foreach($data as $list)
        {
            $html.= "<option value='" . $list->id . "'>" . ucwords($list->city) . "</option>";
        }
        return response()->json([
            'status'=> 200,
            'html'=> $html,
        ]);
    }


}
