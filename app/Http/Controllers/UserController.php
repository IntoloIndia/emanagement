<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Validator;
use App\MyApp;
use DNS2D;
use QrCode;

class UserController extends Controller
{
    public function index(){
        $roles = Role::all();
        $department = Department::all();                     
        $Users = User::join('roles','roles.id','=','users.role_id')
                       ->join('departments','departments.id','=','users.department_id')
                    //    ->where(['users.status' => MyApp::ACTIVE])
                       ->get(['users.*','roles.role','departments.department']);
        // $Users = User::all();
        return view('users',[
            'roles' => $roles,
            'Users' =>$Users,
            'department' => $department,
        ]);
    }


    function saveUser(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'role_id' => 'required|max:191',
            'department_id' => 'required|max:191',
            'name'=>'required|max:191',
            'code'=>'required|max:191',
            'email'=>'required|max:191',
            'password'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages("plz  all field required"),
            ]);
        }else{
            $model = new User;
            $model->role_id = $req->input('role_id');
            $model->department_id = $req->input('department_id');
            $model->code = $req->input('code');
            $model->name = $req->input('name');
            $model->email = $req->input('email');
            $model->password = Hash::make($req->input('password')); 
            $model->percentage = $req->input('percentage');
            $model->status = $req->input('status');
            
            if($model->save()){

                $id = $model->id;
                $qrcode = 'data:image/png;base64,' . DNS2D::getBarcodePNG(strval($id), 'QRCODE')  ;
                // $save_qr = User::find($id);
                $model->qrcode = $qrcode; 
                $model->save();

                return response()->json([   
                    'status'=>200,
                ]);
            }
        }
    }


    public function editUser($user_id)
    {
        $user = User::find($user_id);
        return response()->json([
            'status'=>200,
            'user'=>$user
        ]);
    }


    public function updateUser(Request $req, $user_id)
    {
        $validator = Validator::make($req->all(),[
            'role_id' => 'required|max:191',
            'department_id' => 'required|max:191',
            'code' => 'required|max:191',
            'name' => 'required|max:191',
            'email' => 'required|unique:users,email,'.$user_id,
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{
            $qrcode = 'data:image/png;base64,' . DNS2D::getBarcodePNG($user_id, 'QRCODE')  ;
            $model = User::find($user_id);
            $model->role_id = $req->input('role_id');
            $model->department_id = $req->input('department_id');
            $model->code = $req->input('code');
            $model->name = $req->input('name');
            $model->email = $req->input('email');
            if($req->input('password') !=""){
                $model->password = Hash::make($req->input('password')); 
            }
            $model->qrcode = $qrcode;
            $model->percentage = $req->input('percentage');
            
            if($model->save()){
                return response()->json([
                    'status'=>200,
                ]);
            }
        }
    }

    // public function deleteUser($user_id)
    // {
    //     $delete_user = User::find($user_id);
    //     $delete_user->delete();
    //     return response()->json([
    //         'status'=>200
    //     ]);
    // }

    public function image()

    {
        function __construct() {
            DBRInitLicense("DLS2eyJoYW5kc2hha2VDb2RlIjoiMjAwMDAxLTE2NDk4Mjk3OTI2MzUiLCJvcmdhbml6YXRpb25JRCI6IjIwMDAwMSIsInNlc3Npb25QYXNzd29yZCI6IndTcGR6Vm05WDJrcEQ5YUoifQ==");
            DBRInitRuntimeSettingsWithString("{\"ImageParameter\":{\"Name\":\"BestCoverage\",\"DeblurLevel\":9,\"ExpectedBarcodesCount\":512,\"ScaleDownThreshold\":100000,\"LocalizationModes\":[{\"Mode\":\"LM_CONNECTED_BLOCKS\"},{\"Mode\":\"LM_SCAN_DIRECTLY\"},{\"Mode\":\"LM_STATISTICS\"},{\"Mode\":\"LM_LINES\"},{\"Mode\":\"LM_STATISTICS_MARKS\"}],\"GrayscaleTransformationModes\":[{\"Mode\":\"GTM_ORIGINAL\"},{\"Mode\":\"GTM_INVERTED\"}]}}");		
        }
    
        function page()
        {
         return view('barcode_qr_reader');
        }
    
        function upload(Request $request)
        {
         $validation = Validator::make($request->all(), [
          'BarcodeQrImage' => 'required'
         ]);
         if($validation->passes())
         {
          $image = $request->file('BarcodeQrImage');
          $image->move(public_path('images'), $image->getClientOriginalName());
    
          $resultArray = DecodeBarcodeFile(public_path('images/' . $image->getClientOriginalName()), 0x3FF | 0x2000000 | 0x4000000 | 0x8000000 | 0x10000000); // 1D, PDF417, QRCODE, DataMatrix, Aztec Code
    
          if (is_array($resultArray)) {
            $resultCount = count($resultArray);
            echo "Total count: $resultCount", "\n";
            if ($resultCount > 0) {
                for ($i = 0; $i < $resultCount; $i++) {
                    $result = $resultArray[$i];
                    echo "Barcode format: $result[0], ";
                    echo "value: $result[1], ";
                    echo "raw: ", bin2hex($result[2]), "\n";
                    echo "Localization : ", $result[3], "\n";
                }
            }
            else {
                echo 'No barcode found.', "\n";
            }
          } 
    
          return response()->json([
           'message'   => 'Successfully uploaded the image.'
          ]);
         }
         else
         {
          return response()->json([
           'message'   => $validation->errors()->all()
          ]);
         }
        }
    }

    // function updateStatus($user_id)
    // {
    //     $status_data =User::find($user_id);
    //     $status_data->status = MyApp::ACTIVE;
    //     $status_data->save();
        
    //     return response()->json([
    //         'status'=>200
    //     ]);
    // }

    function updateStatus($user_id)
    {
        $status_data =User::find($user_id);
        if($status_data->status){
            $status_data->status = MyApp::DEACTIVE;
        }else{
            $status_data->status = MyApp::ACTIVE;
        }
        $status_data->save();
        
        return response()->json([
            'status'=>200,
            // 'active'=>$status_data->status
        ]);
    }
    
}
