<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class passwordReset extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'email';
    public $incrementing = false; 
    protected $keyType = 'string';
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    public $timestamps = false;
}
