<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Supplier;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class SupplierController extends Controller
{
    public function index(){
        $allcountries = Country::all();
        $allStates = State::all();
        $allCity = City::all();
        // $suppliers = Supplier::all();
        $suppliers = Supplier::join('countries','countries.id','=','suppliers.country_id')
                        ->join('states','states.id','=','suppliers.state_id')
                        ->join('cities','cities.id','=','suppliers.city_id')
                        ->select('suppliers.*','countries.country','states.state','cities.city','cities.city_short')->get();
                        // print_r($suppliers);
        return view('supplier',[
            'allcountries' => $allcountries,
            'allStates' => $allStates,
            'suppliers' => $suppliers,
            'allCity' => $allCity,
        ]);
    }

    public function saveSupplier(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'supplier_name' => 'required|max:191',
            'mobile_no' => 'required|max:191',
            // 'address' => 'required|unique:admins,email,'.$req->input('email'),
            'address' => 'required|max:200',
            'gst_no' => 'required|max:191',
            'supplier_code' => 'required|max:191',
            'country_id' => 'required|max:191',
            'state_id' => 'required|max:191',
            'city_id' => 'required|max:191',
            
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
            $model->address = $req->input('address');
            $model->gst_no = strtoupper($req->input('gst_no'));
            $model->supplier_code = strtoupper($req->input('supplier_code'));
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
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
            'mobile_no' => 'required|max:12',
            // 'address' => 'required|unique:admins,email,'.$req->input('email'),
            'address' => 'required|max:200',
            'gst_no' => 'required|max:20',
            'supplier_code' => 'required|max:20',
            'country_id' => 'required|max:191',
            'state_id' => 'required|max:191',
            'city_id' => 'required|max:191',
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
            $model->address = $req->input('address');
            $model->gst_no = strtoupper($req->input('gst_no'));
            $model->supplier_code = strtoupper($req->input('supplier_code'));
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
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

    public function getStateByCountry($country_id)
    {
        $data = State::where(['country_id'=>$country_id])->get(['id', 'state',]);

        $html = "";
        $html .= "<option selected disabled >Select...</option>";
        foreach($data as $list)
        {
            $html.= "<option value='" . $list->id . "'>" . $list->state . "</option>";
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
        $html .= "<option selected disabled >Select...</option>";
        foreach($data as $list)
        {
            $html.= "<option value='" . $list->id . "'>" . $list->city . "</option>";
        }
        return response()->json([
            'status'=> 200,
            'html'=> $html,
        ]);
    }
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

    
}
