<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\StyleNo;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class SupplierController extends Controller
{
    public function index(){
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $categories = Category::all();
        // $suppliers = Supplier::all();
        $suppliers = Supplier::join('countries','countries.id','=','suppliers.country_id')
                        ->join('states','states.id','=','suppliers.state_id')
                        ->join('cities','cities.id','=','suppliers.city_id')
                        ->select('suppliers.*','countries.country','states.state','cities.city','cities.city_short')->get();
                        // print_r($suppliers);
        return view('supplier',[
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'supplier_code'=>supplierCode(),
        ]);
    }

    public function saveSupplier(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'supplier_name' => 'required|max:191',
            'mobile_no' => 'required|unique:suppliers,mobile_no,'.$req->input('mobile_no'),
            // 'address' => 'required|unique:admins,email,'.$req->input('email'),
            'address' => 'required|max:200',
            'gst_no' => 'required|max:191',
            'supplier_code' => 'required|max:191',
            'country_id' => 'required|max:191',
            'state_id' => 'required|max:191',
            'city_id' => 'required|max:191',
            'payment_days' => 'required|max:191',
            
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $supplier_code = rand(000001,999999);

            $model = new Supplier;
            // $model->supplier_code = strtoupper($supplier_code);
            $model->supplier_name = $req->input('supplier_name');
            $model->mobile_no = $req->input('mobile_no');
            $model->phone_no = $req->input('phone_no');
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
            $model->address = $req->input('address');
            $model->state_type = $req->input('state_type');
            $model->payment_days = $req->input('payment_days');
            $model->supplier_code = strtoupper($req->input('supplier_code'));
            $model->gst_no = strtoupper($req->input('gst_no'));
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    public function editSupplier($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);

        $state = State::where(['country_id'=>$supplier->country_id])->get();
        $city = City::where(['state_id'=>$supplier->state_id])->get();

        $html = "";
        $html .= "<option disabled>Choose...</option>";
        foreach ($state as $key => $list) {
            if ($list->id == $supplier->state_id) {
                $html .= "<option selected value='".$list->id."'>".ucwords($list->state)."</option>";
            } else {
                $html .= "<option value='".$list->id."'>".ucwords($list->state)."</option>";
            }
        }

        $htmlcity = "";
        $htmlcity.= "<option disabled>Choose...</option>";
        foreach ($city as $key => $list) {
            if ($list->id == $supplier->city_id) {
                $htmlcity .= "<option selected value='".$list->id."'>".ucwords($list->city)."</option>";
            } else {
                $htmlcity .= "<option value='".$list->id."'>".ucwords($list->city)."</option>";
            }
        }
        // print_r($state);

        return response()->json([
            'status'=>200,
            'html'=>$html,
            'htmlcity'=>$htmlcity,
            'supplier'=>$supplier
        ]);
    }


    public function updateSupplier(Request $req, $supplier_id)
    {
        $validator = Validator::make($req->all(),[
            'supplier_name' => 'required|max:191',
            // 'mobile_no' => 'required|max:12',
            'mobile_no' => 'required|unique:suppliers,mobile_no,'.$supplier_id,
            'address' => 'required|max:200',
            'gst_no' => 'required|max:20',
            'supplier_code' => 'required|max:20',
            'country_id' => 'required|max:191',
            'state_id' => 'required|max:191',
            'city_id' => 'required|max:191',
            'payment_days' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Supplier::find($supplier_id);
            $model->supplier_name = $req->input('supplier_name');
            $model->mobile_no = $req->input('mobile_no');
            $model->phone_no = $req->input('phone_no');
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
            $model->address = $req->input('address');
            $model->state_type = $req->input('state_type');
            $model->payment_days = $req->input('payment_days');
            $model->supplier_code = strtoupper($req->input('supplier_code'));
            $model->gst_no = strtoupper($req->input('gst_no'));
            $model->date = date('Y-m-d');
            $model->time = date('g:i A');
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }


    public function deleteSupplier($supplier_id)
    {
        $delete_supplier = Supplier::find($supplier_id);
        $delete_supplier->delete();

        return response()->json([
            'status'=>200
        ]);
    }

    public function supplierDetail($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);
        return response()->json([
            'status'=>200,
            'supplier'=>$supplier
        ]);
    }

    // public function getStateByCountry($country_id)
    // {
    //     $data = State::where(['country_id'=>$country_id])->get(['id', 'state',]);

    //     $html = "";
    //     $html .= "<option selected disabled >State</option>";
    //     foreach($data as $list)
    //     {
    //         $html.= "<option value='" . $list->id . "'>" . ucwords($list->state) . "</option>";
    //     }
    //     return response()->json([
    //         'status'=> 200,
    //         'html'=> $html,
    //     ]);
    // }

    // public function getCityByState($state_id)
    // {
    //     $data = City::where(['state_id'=>$state_id])->get(['id', 'city',]);

    //     $html = "";
    //     $html .= "<option selected disabled >Select...</option>";
    //     foreach($data as $list)
    //     {
    //         $html.= "<option value='" . $list->id . "'>" . $list->city . "</option>";
    //     }
    //     return response()->json([
    //         'status'=> 200,
    //         'html'=> $html,
    //     ]);
    // }

    


    public function getCityShortName($city_id)
    {
        // $city_short_name = City::where(['city_id'=>$city_id])->first();
        // print_r($product);
        $city_short_name = City::find($city_id);
        // print_r($city_short_name);
                        
        // return response()->json([
        //     'city_short'=>$city_short_name->city_short
        // ]);
    }

    // public function manageCity(Request $req)
    // {
    //     if($req->input('city_id') > 0)
    //     {
    //         $country_id = 'required|max:191';
    //         $state_id = 'required|max:191';
    //         $city = 'required|unique:cities,city,'.$req->input('city_id');
    //         $city_short = 'required|unique:cities,city_short,'.$req->input('city_id');
    //         $model = City::find($req->input('city_id'));
    //     }else{
    //         $country_id = 'required|max:191';
    //         $state_id = 'required|max:191';
    //         $city = 'required|unique:cities,city,'.$req->input('city');
    //         $city_short = 'required|unique:cities,city_short,'.$req->input('city_short');
    //         $model = new City ;
    //     }

    //     $validator = Validator::make($req->all(),[
    //         'country_id' => $country_id,
    //         'state_id' => $state_id,
    //         'city' => $city,
    //         'city_short' => $city_short
    //     ]);
    //     if($validator->fails())
    //     {
    //         return response()->json([
    //             'status'=>400,
    //             'errors'=>$validator->messages(),
    //         ]);
    //     }else{
    //         $model->country_id = $req->input('country_id');
    //         $model->state_id = $req->input('state_id');
    //         $model->city = strtolower($req->input('city'));
    //         $model->city_short = strtolower($req->input('city_short'));

    //         if($model->save()){
    //             return response()->json([
    //                 'status'=>200,
    //             ]);
    //         }

    //     }
    // }

  
    

    
}
