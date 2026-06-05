<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ← ДОБАВИТЬ ИМПОРТ

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Связь с клиентом
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Связь с квартирой
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    // Связь с риэлтором
    public function realtor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'realtor_id');
    }
}
