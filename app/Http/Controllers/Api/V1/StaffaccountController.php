<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\ResponsesApi;
use App\Models\Staffaccount;
use Illuminate\Http\Request;
use App\Mail\NewPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class StaffaccountController
{

public function index(){
    try {
     $staff = Staffaccount::with(['permission','role'])->paginate(10);
     return ResponsesApi::data($staff);
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again! '.$e->getMessage(),500);
    }
}

public function  show(Request $request,$id){
    try {
     $request->merge(['id'=>$id]);
     $validator = Validator::make(
        $request->all(),
        [
            'id'=>'required|exists:Staffaccounts,id'
        ]
     );
     if($validator->fails()) return ResponsesApi::error($validator->errors());
     $staff = Staffaccount::with(['permission','role'])->find($id);
     return ResponsesApi::data($staff);
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again! '.$e->getMessage(),500);
    }
}

public function  refreshpassword(Request $request){
        try {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $user = $request->user();
        $fullname = strtoupper($user->first_name).'-'.strtoupper($user->last_name);
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
        }
        $pass = implode($pass);

        $validator = Validator::make(
            $request->all(),
            ['staff_id'=>'required|integer|exists:staffaccounts,id']
        );

        if($validator->fails()){
            return ResponsesApi::error($validator->errors());
        }
        $passhach = Hash::make($pass);
        $staff = Staffaccount::findOrFail($request->staff_id);

        $updatepass = $staff->update([
        'password'=>$passhach,
        'updated_by'=>$fullname
        ]);

        if(!$updatepass){
        return ResponsesApi::error('Could not change password code:542 ,please try again!',500);
        }

        Mail::to($staff->email)->send(new NewPasswordMail($pass,$staff->first_name,$staff->last_name));

        return ResponsesApi::success('The password was successfully changed and sent to his email address.');

        } catch (\Exception $e) {
        return ResponsesApi::error('Could not change password code:245 ,please try again! '.$e->getMessage(),500);
        }
}

public function  inactive(Request $request){
            try {
            $user = $request->user();
            $fullname = strtoupper($user->first_name).'-'.strtoupper($user->last_name);
            $validator = Validator::make(
            $request->all(),
            ['staff_id'=>'required|integer|exists:staffaccounts,id']
            );

            if($validator->fails()){
            return ResponsesApi::error($validator->errors());
            }

            $staff = Staffaccount::findOrFail($request->staff_id);
            if($staff->active =='inactive'){
            return ResponsesApi::error('This account is already inactive!',500);
            }
            $updateinactive = $staff->update([
            'active'=>'inactive',
            'updated_by'=>$fullname
            ]);

            if(!$updateinactive){
            return ResponsesApi::error('Could not inactived code:542 ,please try again!',500);
            }

            return ResponsesApi::success('The staff account has been disabled.');


            } catch (\Exception $e) {
            return ResponsesApi::error('Could not change password code:245 ,please try again! '.$e->getMessage(),500);
            }
}

public function  active(Request $request){
            try {
            $user = $request->user();
            $fullname = strtoupper($user->first_name).'-'.strtoupper($user->last_name);
            $validator = Validator::make(
            $request->all(),
            ['staff_id'=>'required|integer|exists:staffaccounts,id']
            );

            if($validator->fails()){
            return ResponsesApi::error($validator->errors());
            }

            $staff = Staffaccount::findOrFail($request->staff_id);

            if($staff->active =='active'){
            return ResponsesApi::error('This account is already active!',500);
            }

            $updateinactive = $staff->update([
            'active'=>'active',
            'updated_by'=>$fullname
            ]);

            if(!$updateinactive){
            return ResponsesApi::error('Could not change password code:542 ,please try again!',500);
            }

            return ResponsesApi::success('Staff Account has been activated');


            } catch (\Exception $e) {
            return ResponsesApi::error('Could not change password code:245 ,please try again! '.$e->getMessage(),500);
            }

}

}
