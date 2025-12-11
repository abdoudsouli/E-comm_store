<?php

namespace App\Models;

use App\Models\Role;
use App\Helper\DateFormat;
use App\Models\Permission;
use App\Models\Notification;
use App\Models\StaffPermission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staffaccount extends Model
{
    use HasApiTokens,SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'profil_img',
        'active',
        'created_by',
        'updated_by',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

     protected $appends = ['created_at_carbon','updated_at_carbon'];

     protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

public function getCreatedAtCarbonAttribute(){
    $dateformat = new DateFormat();
    return $dateformat->datetime($this->created_at);
}


public function getUpdatedAtCarbonAttribute(){
     $dateformat = new DateFormat();
    return $dateformat->datetime($this->updated_at);
}

    public function role(){
        return $this->belongsTo(Role::class);
    }

public function permission()
{
    return $this->belongsToMany(Permission::class, 'permission_staffaccount')
                ->withPivot(['id','created_by', 'updated_by', 'deleted_at'])
                ->withTimestamps();
}

     public function notification(){
        return $this->hasMany(Notification::class);
    }
}
