<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\RolesController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\NotificatiosController;
use App\Http\Controllers\Api\V1\StaffaccountController;
use App\Http\Controllers\Api\V1\StaffaccountPermissionController;

Route::any('/login',function (){
  return response()->json(['message' => 'Unauthenticated'],401);
})->name('login');

Route::post('login',[AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){
   //logout
    Route::post('logout',[AuthController::class,'logout']);
     //Notification
    Route::get('notification',[NotificatiosController::class,'index']);
     //SatffAccounts (staff profil)
Route::prefix('account')->group(function(){
Route::get('/',[AccountController::class,'index']);
Route::patch('/',[AccountController::class,'edite']);
Route::post('/change_password',[AccountController::class,'change_password']);
Route::post('/avatar',[AccountController::class,'avatar']);
Route::post('/email',[AccountController::class,'email']);
});

Route::middleware('CheckRole:super_admin')->group(function(){
     //staff Accounts
       Route::prefix('staffaccount')->group(function(){
       Route::get('/',[StaffaccountController::class,'index']);
       Route::get('/{id}',[StaffaccountController::class,'show']);
       Route::post('/refreshpassword',[StaffaccountController::class,'refreshpassword']);
       Route::post('/inactive',[StaffaccountController::class,'inactive']);
       Route::post('/active',[StaffaccountController::class,'active']);
     });
    //SatffAccountPermission
    Route::prefix('satffaccountpermission')->group(function(){
       Route::get('/{id}',[StaffaccountPermissionController::class,'index']);
       Route::post('/',[StaffaccountPermissionController::class,'create']);
       Route::patch('/staff/{staff_id}/permissions/{permission_id}/delete',[StaffaccountPermissionController::class,'delete']);
    });
     //Permission
     Route::prefix('permission')->group(function(){
       Route::get('/',[PermissionController::class,'index']);
       Route::get('/{id}',[PermissionController::class,'show']);
       Route::patch('/{id}/update',[PermissionController::class,'update']);
       Route::post('/create',[PermissionController::class,'create']);
       Route::post('/delete',[PermissionController::class,'delete_permission']);
       Route::post('/recover',[PermissionController::class,'recover_permission']);
     });

      //Roles
        Route::prefix('role')->group(function(){
        Route::get('/',[RolesController::class,'index']);
        Route::post('/create',[RolesController::class,'create']);
        Route::get('/{id}',[RolesController::class,'show']);
        Route::patch('/{id}/update',[RolesController::class,'update']);
        Route::post('/delete',[RolesController::class,'delete_role']);
        Route::post('/recover ',[RolesController::class,'recover_role']);
      });
});

Route::middleware('CheckRole:admin')->group(function(){

});


Route::middleware('CheckRole:customer')->group(function(){

});
});

