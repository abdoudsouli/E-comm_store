<?php

namespace App\Models;


use App\Models\Staffaccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'role_name',
        'display_name',
        'created_by',
        'updated_by'
    ];

    public function staffaccounts(){
        return $this->hasMany(Staffaccount::class);
    }
}
