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
    return ResponsesApi::error('Could not create, please try again!',500);
    }
}

public function show(Request $request, $id){
    try {
    $request->merge(['id'=>$id]);
    $validator = Validator::make(
        $request->all(),
        [
            'id'=>'required|integer|exists:roles,id'
        ]
    );
    if($validator->fails()) return ResponsesApi::error($validator->errors());
    $roles = Role::select('id','role_name','display_name')->where('id',$request->id)->get();
    return ResponsesApi::data($roles);
    } catch (\Exception $e) {
 return ResponsesApi::error('Could not create, please try again!',500);
    }
}

public function update(Request $request,$id){
    try{
    $user = $request->user();
    $fullname = strtoupper($user->first_name).'-'.strtoupper($user->last_name);
    $request->merge(['id'=>$id,'updated_by'=>$fullname]);

    $validator = Validator::make(
        $request->all(),
        [
            'id'=>'required|integer|exists:roles,id',
            'role_name'=>
            [
                'required',
                'unique:roles,role_name,'.$id,
                'regex:/^[_a-z]{3,20}$/',
            ],
            'display_name'=>'required|string|min:3|max:250'
        ]
    );

  if ($validator->fails()) return ResponsesApi::error($validator->errors());
    $role = Role::findOrFail($request->id);
    $role->update($request->all());
    return ResponsesApi::success('Role Updated successfully');
    } catch (\Exception $e) {
 return ResponsesApi::error('Could not create, please try again!',500);
    }
}

public function delete_role (Request $request){
  try {
   $validator =Validator::make(
    $request->all(),
    [
       'id'=>'required|integer|exists:roles,id'
    ]);
   if($validator->fails()) return ResponsesApi::error($validator->errors());
   $role = Role::findOrFail($request->id);
   if(!$role) return ResponsesApi::error('role not found, please try again!');
   $role->delete();
   return ResponsesApi::success('Role deleted successfully');
   } catch (\Exception $e) {
   return ResponsesApi::error('Could not create, please try again!');
   }
}

public function recover_role(Request $request){
    try {
    $validator =Validator::make(
    $request->all(),
    [
       'id'=>'required|integer'
    ]);

   if($validator->fails()) return ResponsesApi::error($validator->errors());
    $role_removed = role::onlyTrashed()->find($request->id);
    if(!$role_removed) return ResponsesApi::error('Role id not found');
    $role_removed->restore();
    return ResponsesApi::success('Role recovered successfully');
    } catch (\Exception $e) {
       return ResponsesApi::error('Could not create, please try again!'.$e->getMessage());
    }
}


}
