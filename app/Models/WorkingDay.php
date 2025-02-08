<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'from',
        'to',
    ];

    protected $casts = [
        'name' => 'array',
    ];

    public function getLocalizedNameAttribute($value)
    {
        return $this->name[app()->getLocale()] ?? $this->name['en'];
    }
}
