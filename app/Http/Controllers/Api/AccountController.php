<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponsesApi;
use App\Models\Staffaccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
       public function index(Request $request){
    try {
         $staffaccountinfo = Staffaccount::select('first_name','last_name','phone_number','email','profil_img','active')
         ->where('id',$request->user()->id)->first();
         if(!$staffaccountinfo) return ResponsesApi::error('User not found',404);
         return ResponsesApi::data($staffaccountinfo);
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!',500);
    }

   }

   function edite(Request $request){
    try {
    $user = $request->user();

$validator = Validator::make(
    $request->all(),
    [
        'first_name' => 'required|min:3|max:50',
        'last_name' => 'required|min:3|max:50',
        'phone_number' => [
            'required',
            'regex:/^\d{8,14}$/'
        ],
        'phone_number_code' => [
            'required',
            'regex:/^\d{1,3}$/'
        ],
    ],
    [
        'phone_number.regex' => 'Phone number is incorrect. Example: 06xxxxxxxx',
         'phone_number_code.regex' => 'Phone number Code is incorrect. Example: 212,1'
    ]
);

    if($validator->fails()){
        return ResponsesApi::error($validator->errors());
    }

    $phone = $request->phone_number;
    if (preg_match('/^0\d+$/', $phone)) {
    $phone = substr($phone, 1);
    }
    $phone_code = $request->phone_number_code;
    $phone_code = str_replace('+','',$phone_code);
    $phone = '+'.$phone_code.''.$phone;
    $fullname = strtoupper($user->first_name).'-'.strtoupper($user->last_name);
    $data = $user->update([
        'first_name'=>$request->first_name,
         'last_name'=>$request->last_name,
          'phone_number'=>$phone,
          'updated_by'=>$fullname
    ]);

    if(!$data){
 return ResponsesApi::error('Could not update info ,please try again!');
    }
     return ResponsesApi::success('Your info has been updated successfully');
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!'.$e->getMessage(),500);
    }
}

public function change_password(Request $request){
    try {
       $user = $request->user();
       $validator = Validator::make(
        $request->all(),
        [
            'old_password'=>'required|min:6|max:15',
            'password'=>'required|min:6|max:15|confirmed',
            'password_confirmation'=>'required'
        ]
        );
        if($validator->fails()){
            return ResponsesApi::error($validator->errors());
        }

    $password_test = Hash::check($request->old_password, $user->password);
    if (!$password_test) {
      return ResponsesApi::error('old Password is incorrect!');
    }
    $new_password = Hash::make($request->password);
    $save_pass = $user->update(
        [
            'password'=>$new_password
        ]
    );
    if(!$save_pass){
     return ResponsesApi::error('Could not update password ,please try again!');
    }

     return ResponsesApi::success('Your info has been updated successfully');

    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!',500);
    }
}
}
