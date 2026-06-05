<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_FREE = 'free';
    const STATUS_BOOKED = 'booked';
    const STATUS_SOLD = 'sold';

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isFree()
    {
        return $this->status === self::STATUS_FREE;
    }

    public function isBooked()
    {
        return $this->status === self::STATUS_BOOKED;
    }
}
