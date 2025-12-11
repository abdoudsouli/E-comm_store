<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\ResponsesApi;
use App\Models\Staffaccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StaffaccountPermissionController extends Controller
{
  public function index(Request $request,$id){

        try {
          $user = $request->user();
          $request->merge(['staff_id'=>$id]);

          $validator = Validator::make(
            $request->all(),
            [
                'staff_id'=>'required|integer|exists:staffaccounts,id'
            ]
          );
          if($validator->fails()){
              return ResponsesApi::error($validator->errors());
          }

          $getstaff = Staffaccount::select('id','first_name','last_name','email')->with(['permission'=>function($q){
            $q->select('permissions.id','permissions.permission_name','permissions.display_name');
          }])->find($request->staff_id);

          return ResponsesApi::data($getstaff);

        }  catch (\Exception $e) {
        return ResponsesApi::error('Could not change password code:245 ,please try again! ',500);
        }
        }

        public function  create(Request $request){
        try{
        $user = $request->user();
        $full_name = $user->first_name . ' ' . $user->last_name;
        $validator = Validator::make(
        $request->all(),
        [
        'staff_id'=>'required|integer|exists:staffaccounts,id',
        'permission'=>'required|array|min:1',
        'permission.*'=>'integer|exists:permissions,id'
        ],
        [
        'permission.required' => 'Permissions is required',
        'permission.array'    => 'Permissions must be an array',
        'permission.*.integer'=> 'Each permission must be integer',
        ]);

        if($validator->fails()){
        return ResponsesApi::error($validator->errors());
        }

        $staff = Staffaccount::findOrFail($request->staff_id);

        $existing = $staff->permission()->pluck('permission_id')->toArray();

        $duplicates = array_intersect($request->permission, $existing);

        if (!empty($duplicates)) {
        return ResponsesApi::error(
        "Some permissions already assigned: " . implode(',', $duplicates)
        );
        }

        $dataToAttach = [];
        foreach ($request->permission as $permission) {
        $dataToAttach[$permission] = [
        'created_by' => $full_name
        ];
        }

        $staff->permission()->attach($dataToAttach);

        return ResponsesApi::success("Permissions assigned successfully");

        }catch(\Exception $e){
        return ResponsesApi::error('Could not change password code:245 ,please try again! '.$e->getMessage(),500);
        }
        }


        public function delete(Request $request,$staff_id,$permission_id){
        try {
        $user = $request->user();
        $full_name = $user->first_name . ' ' . $user->last_name;
        $request->merge(['staff_id'=>$staff_id,'permission_id'=>$permission_id]);
        $validator = Validator::make(
        $request->all(),
        [
        'staff_id'=>'required|integer|exists:staffaccounts,id',
        'permission_id'=>'required|integer|exists:permissions,id',
        ]);

          if($validator->fails()){
        return ResponsesApi::error($validator->errors());
        }

        $staff = Staffaccount::findOrFail($request->staff_id);

        $exists = $staff->permission()
        ->wherePivot('permission_id', $request->permission_id)
        ->wherePivotNull('deleted_at')
        ->exists();

        if(!$exists){
        return ResponsesApi::error('The specified permission is not assigned to this staff or already deleted.',400);
        }

        $delete = $staff->permission()->updateExistingPivot($request->permission_id, [
            'deleted_at' => now(),
            'updated_by' =>$full_name
        ]);

        if(!$delete){
        return ResponsesApi::error('Failed to delete the permission.',500);
        }

        return ResponsesApi::success('Permission deleted successfully');

        } catch (\Exception $e) {
        return ResponsesApi::error('Could not change permission code:245 ,please try again! ',500);
        }
        }
}
