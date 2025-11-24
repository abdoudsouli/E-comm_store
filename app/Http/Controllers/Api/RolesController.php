<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponsesApi;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
public function index(){
    try {
    $roles = Role::get();
    return ResponsesApi::data($roles);
    } catch (\Exception $e) {
    return ResponsesApi::error('Could not get data info ,please try again!',500);
    }
}

public function create(Request $request){
    try {
    $user = $request->user();
    $validator = Validator::make(
        $request->all(),
        [
            'role_name'=>[
            'required',
            'regex:/^[_a-z]{3,20}$/',
            'unique:roles,role_name',
            ],
            'display_name'=>'required|string|max:250|min:3',
        ]
    );
    if ($validator->fails()) return ResponsesApi::error($validator->errors());
   $fullname =strtoupper($user->first_name) .'-'.strtoupper($user->last_name);
    $rolecreate = Role::create([
        'role_name'=>$request->role_name,
        'display_name'=>$request->display_name,
        'created_by'=>$fullname,
    ]);

    if($rolecreate) return ResponsesApi::success('Role has been creted successfully');
    } catch (\Exception $e) {
    return ResponsesApi::error('Could not create, please try again!'.$e->getMessage(),500);
    }
}
}
