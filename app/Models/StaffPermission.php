<?php

namespace App\Models;

use App\Helper\DateFormat;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StaffPermission extends Pivot
{
    use SoftDeletes;
     protected $table = 'permission_staffaccount';

    protected $fillable = [
        'staffaccount_id',
        'permission_id',
        'created_by',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
         'updated_at',
    ];

    protected $appends=[
    'created_at_carbon','updated_at_carbon'
    ];

    public function getCreatedAtCarbonAttribute(){
    $dateformat = new DateFormat();
    return $dateformat->datetime($this->created_at);
    }

    public function getUpdatedAtCarbonAttribute(){
        $dateformat = new DateFormat();
        return $dateformat->datetime($this->updated_at);
    }
}
