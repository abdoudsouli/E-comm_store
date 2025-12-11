<?php

namespace App\Models;

use App\Helper\DateFormat;
use App\Models\Staffaccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

   protected $fillable = [
    'permission_name',
    'display_name',
    'created_by',
    'updated_by'
   ];

   protected $hidden =[
    'updated_at',
    'created_at'
   ];

   protected $appends =[
    'updated_at_carbon',
    'created_at_carbon'
   ];

   public function getCreatedAtCarbonAttribute(){
     $dateformat = new DateFormat();
    return $dateformat->datetime($this->created_at);
   }

   public function getUpdatedAtCarbonAttribute(){
    $dateformat = new DateFormat();
    return $dateformat->datetime($this->updated_at);
   }

   public function staffaccounts(){
    return $this->belongsToMany(Staffaccount::class);
   }

   
}
