<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        // 'name',
        'email',
        'password',
    ];

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }
}
