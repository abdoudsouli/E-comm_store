<?php

namespace App\Http\Controllers\Api;

use App\Models\Staffaccount;
use Illuminate\Http\Request;

use App\Helper\ResponsesApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   public function login(Request $request){
     try {
        $validator = Validator::make(
            $request->all(),
            [
              'email'=>'required|email',
              'password'=>'required|min:6|max:15'
            ]
        );

        if ($validator->fails()) {
           return ResponsesApi::error($validator->errors(),422);
        }

        $staff = Staffaccount::where('email',$request->email)->first();

        if (!$staff) {
           return ResponsesApi::error('Your Password Or Email is incorrect!',422);
        }
        $test_pass = Hash::check($request->password, $staff->password);
          if (!$test_pass) {
           return ResponsesApi::error('Your Password Or Email is incorrect!',422);
        }
    $staff->tokens()->delete();

    $token = $staff->createToken('staff-token')->plainTextToken;

    return ResponsesApi::data(null,'token',$token);

     } catch (\Exception $e) {
     return ResponsesApi::error('Error : could not login!',500);
     }
   }

   public function logout(Request $request){
        try {
          $request->user()->tokens()->delete();
          return ResponsesApi::success(null,'Logged out from all devices successfully');
        }  catch (\Exception $e) {
        return ResponsesApi::error('Error : could not login!',500);
        }
        }


}
