<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Разрешаем массовое присвоение ЛЮБЫХ полей
    protected $guarded = [];

    public function isAdmin()
    {
        return $this->role_id == 2;
    }

    /**
     * Проверка: является ли пользователь Риэлтором (role_id = 3)
     */
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
}
