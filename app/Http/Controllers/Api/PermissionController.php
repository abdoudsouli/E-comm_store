<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponsesApi;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
   public function index(){
    try {
    $permission = Permission::get();
    return ResponsesApi::data($permission);
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!',500);
    }
   }


     public function create(Request $request){
    try {
    $user = $request->user();
    $fullname=strtoupper($user->first_name)."-".strtoupper($user->first_name);
    $validator = Validator::make(
        $request->all(),
        [
            'name'=>
            [
            'required',
            'unique:permissions,permission_name',
            'regex:/^[_a-z]{3,25}$/',
            ],
            'display'=>'required|max:50|min:3'
        ]
    );
    if($validator->fails()) return ResponsesApi::error($validator->errors());
    $permission = Permission::create([
        'permission_name'=>$request->name,
        'display_name'=>$request->display,
        'created_by'=>$fullname
    ]);
    return ResponsesApi::success('Permission added successfully');
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!'.$e->getMessage(),500);
    }
   }
         public function show(Request $request,$id){
    try {
    $request->merge(['id'=>$id]);
    $validator = Validator::make(
        $request->all(),
        [
        'id'=>'required|integer|exists:permissions,id'
        ]
    );
    if($validator->fails()) return ResponsesApi::error($validator->errors());
    $permission = Permission::find($id);
    return ResponsesApi::data($permission);
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!',500);
    }
   }
      public function update(Request $request,$id){
    try {
    $user = $request->user();
    $fullname=strtoupper($user->first_name)."-".strtoupper($user->first_name);
    $request->merge(['id'=>$id]);
    $validator = Validator::make(
        $request->all(),
        [
            'id'=>'required|exists:permissions,id',
            'name'=>
            [
            'required',
            'unique:permissions,permission_name,'.$id,
            'regex:/^[_a-z]{3,25}$/',
            ],
            'display'=>'required|max:50|min:3'
        ]
    );
    if($validator->fails()) return ResponsesApi::error($validator->errors());
    $permission = Permission::find($id);
    $permission->update([
        'permission_name'=>$request->name,
        'display_name'=>$request->display,
        'updated_by'=>$fullname
    ]);
    return ResponsesApi::success('Permission updated successfully');
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!',500);
    }
   }



      public function delete_permission(Request $request){
    try {
      $validator = Validator::make(
        $request->all(),
        [
        'id'=>'required|integer|exists:permissions,id'
        ]);
        if($validator->fails()) return ResponsesApi::error($validator->errors());
        $permission = Permission::find($request->id);
        $permission->delete();
        return ResponsesApi::success('The permission has been deleted successfully');
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!',500);
    }
   }

      public function recover_permission(Request $request){
    try {
        $validator = Validator::make(
        $request->all(),
        [
        'id'=>'required|integer'
        ]);
        if($validator->fails()) return ResponsesApi::error($validator->errors());
        $permission = Permission::onlyTrashed()->find($request->id);
        if(!$permission) return ResponsesApi::error('Permission id not found');
        $permission->restore();
        return ResponsesApi::success('The permission has been recovered successfully');
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get data info ,please try again!',500);
    }
   }


}
