<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'specialization',
        'phone',
        'whatsapp',
        'user_id',
        'age',
    ];

    protected $casts = [
        'name' => 'array',
    ];

    public function getLocalizedNameAttribute($value)
    {
        return $this->name[app()->getLocale()] ?? $this->name['en'];
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function workingDays()
    {
        return $this->hasMany(WorkingDay::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($doctor) {
            \App\Events\DoctorCreated::dispatch($doctor);
        });
    }
}
