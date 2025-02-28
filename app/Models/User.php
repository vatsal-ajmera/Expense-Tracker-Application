<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Authenticatable implements AuthorizableContract, AuthenticatableContract
{
    use HasFactory, Notifiable, \Illuminate\Auth\Authenticatable, Authorizable, \Illuminate\Auth\MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google2fa_secret'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    CONST USER_TYPE_SUPER_ADMIN = 1;
    CONST USER_TYPE_ADMIN = 2;
    CONST USER_TYPE_CLIENT = 2;
    CONST USER_TYPE_SUPPLIER = 3;
    CONST AUTH_VERIFIED = true;
    CONST AUTH_VERIFIED_FALSE = false;

    protected function google2faSecret()
    {
        return new Attribute(
            get: fn ($value) =>  decrypt($value),
            set: fn ($value) =>  encrypt($value),
        );
    }

    public static function getUserRole($value)
    {
        return [
            self::USER_TYPE_SUPER_ADMIN => 'Super Admin',
            self::USER_TYPE_ADMIN => 'Admin',
            self::USER_TYPE_CLIENT => 'Client',
            self::USER_TYPE_SUPPLIER => 'Supplier',
        ][$value
        ];
    }
}
