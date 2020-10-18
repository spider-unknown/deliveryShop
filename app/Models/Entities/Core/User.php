<?php

namespace App\Models\Entities\Core;

use App\Models\Entities\UserAddress;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    public const PLATFORM_ANDROID = 2;
    public const PLATFORM_IOS = 1;

    public const AVATAR_DIRECTORY = "images/avatars";


    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phone',
        'surname', 'birth_date', 'sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isAdmin()
    {
        return $this->role_id == Role::ADMIN_ID;
    }

    public function devices() {
        return $this->hasMany(PushUser::class, 'user_id', 'id');
    }

    public function addresses(){
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }
}
