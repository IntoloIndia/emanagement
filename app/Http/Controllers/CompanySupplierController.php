<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\CompanySupplier;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CompanySupplierController extends Controller
{
    //
    public function index(){
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        $suppliers = CompanySupplier::join('countries','countries.id','=','company_suppliers.country_id')
        ->join('states','states.id','=','company_suppliers.state_id')
        ->join('cities','cities.id','=','company_suppliers.city_id')
        ->orderBy('company_suppliers.id', 'DESC')
        ->select('company_suppliers.*','countries.country','states.state','cities.city')->get();
        // print_r($suppliers);

        // return(supplierCode());
        
        return view('company.company_supplier',[
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'suppliers' => $suppliers,
            'supplier_code'=>supplierCode(),
        ]);
    }

    public function saveCompanySupplier(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'supplier_name' => 'required|max:191',
            'mobile_no' => 'required|unique:company_suppliers,mobile_no,'.$req->input('mobile_no'),
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

            $model = new CompanySupplier;
            // $model->supplier_code = strtoupper($supplier_code);
            $model->supplier_name = $req->input('supplier_name');
            $model->mobile_no = $req->input('mobile_no');
            $model->phone_no = $req->input('phone_no');
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
            $model->address = $req->input('address');
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

    public function editCompanySupplier($supplier_id)
    {
        $supplier = CompanySupplier::find($supplier_id);

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

    public function updateCompanySupplier(Request $req, $supplier_id)
    {
        $validator = Validator::make($req->all(),[
            'supplier_name' => 'required|max:191',
            // 'mobile_no' => 'required|max:12',
            'mobile_no' => 'required|unique:company_suppliers,mobile_no,'.$supplier_id,
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
            $model = CompanySupplier::find($supplier_id);
            $model->supplier_name = $req->input('supplier_name');
            $model->mobile_no = $req->input('mobile_no');
            $model->phone_no = $req->input('phone_no');
            $model->country_id = $req->input('country_id');
            $model->state_id = $req->input('state_id');
            $model->city_id = $req->input('city_id');
            $model->address = $req->input('address');
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

    public function deleteCompanySupplier($supplier_id)
    {
        $delete_supplier = CompanySupplier::find($supplier_id);
        $delete_supplier->delete();

        return response()->json([
            'status'=>200
        ]);
    }

    public function companySupplierDetail($supplier_id)
    {
        $companySupplier = CompanySupplier::find($supplier_id);
        return response()->json([
            'status'=>200,
            'companySupplier'=>$companySupplier
        ]);
    }
}
