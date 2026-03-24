<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'api_url',
        'draw_schedule',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function draws()
    {
        return $this->hasMany(Draw::class);
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }
}