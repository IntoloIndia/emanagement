<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use Validator;

class DiscountController extends Controller
{
    public function index(){
        $discounts = Discount::all();
        return view('discount',[
            'discounts' => $discounts
        ]);
    }

    function saveDiscount(Request $req)
    {
        // return view('employee');
        $validator = Validator::make($req->all(),[
            'discount' => 'required|max:191'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = new Discount;
            $model->discount = $req->input('discount');
           
            if($model->save()){
                return response()->json([   
                    'status'=>200
                ]);
            }
        }
    }

    public function editDiscount($discount_id)
    {
        $discount = Discount::find($discount_id);
        return response()->json([
            'status'=>200,
            'discount'=>$discount
        ]);
    }

    public function updateDiscount(Request $req, $discount_id)
    {
       

        $validator = Validator::make($req->all(),[
            'discount' => 'required|max:191',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $model = Discount::find($discount_id);
            $model->discount = $req->input('discount');
           
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }


    public function deleteDiscount($discount_id)
    {
        $delete_discount = Discount::find($discount_id);
        $delete_discount->delete();
        return response()->json([
            'status'=>200
        ]);
    }
}
