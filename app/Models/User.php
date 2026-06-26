<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function isAdmin()
    {
        return $this->role_id == 2;
    }

    public function isRealtor()
    {
        return $this->role_id == 3;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function applications()
    {
        return $this->hasMany(Application::class, 'realtor_id');
    }


    public function userApplications()
    {
        return $this->hasMany(Application::class, 'user_id');
    }
}
