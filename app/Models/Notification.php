<?php

namespace App\Models;

use App\Models\Staffaccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
  // use SoftDeletes;
   protected $fillable = [
    'title',
     'content',
      'seen',
       'notification_expiry_date',
        'receive_time',
   ];

 public function staffaccount(){
    return $this->belongsTo(Staffaccount::class);
 }
}
