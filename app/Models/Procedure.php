<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];


    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];


    public function getLocalizedNameAttribute($value)
    {
        return $this->name[app()->getLocale()] ?? $this->name['en'];
    }
}
