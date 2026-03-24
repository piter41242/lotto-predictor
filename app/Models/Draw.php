<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    use HasFactory;

    protected $fillable = [
        'lottery_id',
        'draw_date',
        'draw_number',
        'results'
    ];

    protected $casts = [
        'draw_date' => 'date',
    ];
    public function getDigitsAttribute(): array
    {
        return str_split($this->results);
    }
    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }
}
