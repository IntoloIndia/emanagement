<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessDetails;
use Validator;

class BusinessDetailsController extends Controller
{
    public function index(){
        $businesiesDetails = BusinessDetails::all();
        return view('business_details',[
            'businesiesDetails' => $businesiesDetails
        ]);
    }

    function saveCompanyDetail(Request $req)
    {
        $validator = Validator::make($req->all(),[
            
            'company_name'=>'required|max:191',
            'business_name'=>'required|max:191',
            'email'=>'required|max:191',
            'mobile_no'=>'required|max:191',

        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz  all field required"),
            ]);
        }else{
            $model = new BusinessDetails;
            $model->company_name = $req->input('company_name');
            $model->business_name = $req->input('business_name');
            $model->email = $req->input('email');
            $model->mobile_no = $req->input('mobile_no');
            // $modal->date=date('');
            // $modal->time=date('');
 
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }

    public function editCompanyDetails($company_id)
    {
        $company = BusinessDetails::find($company_id);
        return response()->json([
            'status'=>200,
            'company'=>$company
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

            $model->company_name = $req->input('company_name');
            $model->business_name = $req->input('business_name');
            $model->email = $req->input('email');
            $model->mobile_no = $req->input('mobile_no');
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
