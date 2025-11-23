<?php

namespace App\Models;


use App\Models\Staffaccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'role_name'
    ];

    public function staffaccounts(){
        return $this->hasMany(Staffaccount::class);
    }
}
