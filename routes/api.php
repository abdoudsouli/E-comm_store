<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::any('/login',function (){
  return response()->json(['message' => 'Unauthenticated'],401);
})->name('login');

Route::prefix('v1')->group(function(){
Route::post('login',[AuthController::class,'login']);
});


Route::middleware(['auth:sanctum'])->prefix('v1')->group(function(){
     Route::get('users', function (Request $request) {
     return response()->json(
    [
        'message'=>'ok'
    ]
   );
});
});

