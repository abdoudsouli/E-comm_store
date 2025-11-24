<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponsesApi;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificatiosController extends Controller
{
   public function index(Request $request){
    try {
       $notification = Notification::find($request->user()->id)->with(
        [
        'staffaccount'=> function($q){
            $q->select('id','first_name','last_name');
        }
        ]
        )->limit(50)->get();
       return ResponsesApi::data($notification);
    } catch (\Exception $e) {
        return ResponsesApi::error('Could not get notification info ,please try again!');
    }
   }
}
