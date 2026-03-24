<?php

namespace Database\Seeders;

use App\Models\Lottery;
use Illuminate\Database\Seeder;

class LotterySeeder extends Seeder
{
    public function run(): void
    {
        $lotteries = [
            ['name' => 'Lotería de Medellín', 'code' => 'medellin', 'draw_schedule' => 'Lunes a Domingo 22:30'],
            ['name' => 'Lotería del Huila', 'code' => 'huila', 'draw_schedule' => 'Miércoles y Sábado 23:00'],
            ['name' => 'Lotería de Bogotá', 'code' => 'bogota', 'draw_schedule' => 'Jueves y Domingo 22:30'],
            ['name' => 'Dorado Día', 'code' => 'dorado_dia', 'draw_schedule' => 'Lunes a Domingo 14:30'],
            ['name' => 'Dorado Tarde', 'code' => 'dorado_tarde', 'draw_schedule' => 'Lunes a Domingo 18:00'],
            ['name' => 'Dorado Noche', 'code' => 'dorado_noche', 'draw_schedule' => 'Lunes a Domingo 22:30'],
        ];

        foreach ($lotteries as $lottery) {
            Lottery::create($lottery);
        }
    }
}