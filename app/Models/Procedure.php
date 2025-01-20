<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedure extends Model
{
    use HasFactory, SoftDeletes;

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
