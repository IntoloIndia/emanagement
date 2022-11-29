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
        $suppliers = Supplier::all();
        // $suppliers = Supplier::join('countries','countries.id','=','suppliers.country_id')
                                    // ->join('states','states.id','=','suppliers.state_id')
                        // ->get('suppliers.*','countries.country','states.state');
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
            $model = new Supplier;
            $model->supplier_name = $req->input('supplier_name');
            $model->mobile_no = $req->input('mobile_no');
            $model->address = $req->input('address');
            $model->gst_no = $req->input('gst_no');
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
        return response()->json([
            'status'=>200,
            'supplier'=>$supplier
        ]);
    }


    public function updateSupplier(Request $req, $supplier_id)
    {
        $validator = Validator::make($req->all(),[
            // 'supplier_name' => 'required|max:191',
            // 'mobile_no' => 'required|max:191',
            // // 'address' => 'required|unique:admins,email,'.$req->input('email'),
            // 'address' => 'required|max:200',
            // 'gst_no' => 'required|max:191',
            // 'country_id' => 'required|max:191',
            // 'state_id' => 'required|max:191',
            // 'city_id' => 'required|max:191',
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
            $model->gst_no = $req->input('gst_no');
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

    
}
