<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lottery_id',
        'predicted_numbers',
        'algorithm_metadata'
    ];

    protected $casts = [
        'predicted_numbers' => 'array',
        'algorithm_metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }
}