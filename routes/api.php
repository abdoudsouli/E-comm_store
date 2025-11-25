<?php

use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RolesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\NotificatiosController;
use App\Http\Controllers\Api\SatffaccountController;
use App\Http\Controllers\Api\StaffaccountPermissionController;

Route::any('/login',function (){
  return response()->json(['message' => 'Unauthenticated'],401);
})->name('login');

Route::prefix('v1')->group(function(){
Route::post('login',[AuthController::class,'login']);
});


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function(){
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
       Route::get('/',[SatffaccountController::class,'index']);
       Route::patch('/{id}/edit',[SatffaccountController::class,'edit']);
       Route::post('/create',[SatffaccountController::class,'create']);
     });
     //SatffAccountPermission
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

