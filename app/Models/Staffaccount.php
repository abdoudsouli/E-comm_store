<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staffaccount extends Authenticatable
{

        /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firt_name',
        'last_name',
        'phone_number',
        'email',
        'profil_img',
        'active',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

     public function notification(){
        return $this->hasMany(Notification::class);
    }
}
