<?php

namespace Database\Seeders;

use App\Models\Lottery;
use Illuminate\Database\Seeder;

class AllLotteriesSeeder extends Seeder
{
    public function run(): void
    {
        $lotteries = [
            // ========== LOTERÍAS TRADICIONALES ==========
            [
                'name' => 'Lotería de Medellín',
                'code' => 'medellin',
                'draw_schedule' => 'Lunes a Domingo 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Bogotá',
                'code' => 'bogota',
                'draw_schedule' => 'Jueves y Domingo 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Huila',
                'code' => 'huila',
                'draw_schedule' => 'Martes y Sábado 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Tolima',
                'code' => 'tolima',
                'draw_schedule' => 'Martes y Viernes 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Manizales',
                'code' => 'manizales',
                'draw_schedule' => 'Miércoles y Domingo 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Boyacá',
                'code' => 'boyaca',
                'draw_schedule' => 'Martes y Viernes 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Quindío',
                'code' => 'quindio',
                'draw_schedule' => 'Miércoles y Sábado 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Cundinamarca',
                'code' => 'cundinamarca',
                'draw_schedule' => 'Lunes 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Santander',
                'code' => 'santander',
                'draw_schedule' => 'Lunes y Jueves 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Valle',
                'code' => 'valle',
                'draw_schedule' => 'Miércoles y Sábado 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de la Cruz Roja',
                'code' => 'cruz_roja',
                'draw_schedule' => 'Martes 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Risaralda',
                'code' => 'risaralda',
                'draw_schedule' => 'Viernes 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Cauca',
                'code' => 'cauca',
                'draw_schedule' => 'Sábado 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Nariño',
                'code' => 'narino',
                'draw_schedule' => 'Miércoles y Sábado 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Atlántico',
                'code' => 'atlantico',
                'draw_schedule' => 'Jueves y Domingo 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Meta',
                'code' => 'meta',
                'draw_schedule' => 'Martes y Viernes 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Sucre',
                'code' => 'sucre',
                'draw_schedule' => 'Miércoles 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Córdoba',
                'code' => 'cordoba',
                'draw_schedule' => 'Jueves 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Casanare',
                'code' => 'casanare',
                'draw_schedule' => 'Viernes 23:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería del Magdalena',
                'code' => 'magdalena',
                'draw_schedule' => 'Domingo 23:00',
                'is_active' => true,
            ],

            // ========== CHANCES DORADO ==========
            [
                'name' => 'Dorado Día',
                'code' => 'dorado_dia',
                'draw_schedule' => 'Lunes a Domingo 14:30',
                'is_active' => true,
            ],
            [
                'name' => 'Dorado Tarde',
                'code' => 'dorado_tarde',
                'draw_schedule' => 'Lunes a Domingo 18:00',
                'is_active' => true,
            ],
            [
                'name' => 'Dorado Noche',
                'code' => 'dorado_noche',
                'draw_schedule' => 'Lunes a Domingo 22:30',
                'is_active' => true,
            ],

            // ========== CHANCES ANTIOQUEÑITA ==========
            [
                'name' => 'Antioqueñita Día',
                'code' => 'antioquenita_dia',
                'draw_schedule' => 'Lunes a Domingo 12:00',
                'is_active' => true,
            ],
            [
                'name' => 'Antioqueñita Tarde',
                'code' => 'antioquenita_tarde',
                'draw_schedule' => 'Lunes a Domingo 17:00',
                'is_active' => true,
            ],

            // ========== CHANCES FANTÁSTICA ==========
            [
                'name' => 'Fantástica Día',
                'code' => 'fantastica_dia',
                'draw_schedule' => 'Lunes a Sábado 13:00',
                'is_active' => true,
            ],
            [
                'name' => 'Fantástica Noche',
                'code' => 'fantastica_noche',
                'draw_schedule' => 'Lunes a Sábado 20:30',
                'is_active' => true,
            ],

            // ========== CHANCES PAISITA ==========
            [
                'name' => 'Paisita Día',
                'code' => 'paisita_dia',
                'draw_schedule' => 'Lunes a Domingo 14:00',
                'is_active' => true,
            ],
            [
                'name' => 'Paisita Noche',
                'code' => 'paisita_noche',
                'draw_schedule' => 'Lunes a Domingo 20:00',
                'is_active' => true,
            ],

            // ========== CHANCES CHONTICO ==========
            [
                'name' => 'Chontico Día',
                'code' => 'chontico_dia',
                'draw_schedule' => 'Lunes a Domingo 13:00',
                'is_active' => true,
            ],
            [
                'name' => 'Chontico Noche',
                'code' => 'chontico_noche',
                'draw_schedule' => 'Lunes a Domingo 19:30',
                'is_active' => true,
            ],

            // ========== CHANCES PIJAO DE ORO ==========
            [
                'name' => 'Pijao de Oro',
                'code' => 'pijao_oro',
                'draw_schedule' => 'Lunes a Viernes 14:00, Sábado 21:00, Domingo 22:00',
                'is_active' => true,
            ],

            // ========== SUPER ASTRO ==========
            [
                'name' => 'Super Astro Sol',
                'code' => 'super_astro_sol',
                'draw_schedule' => 'Lunes a Sábado 14:30',
                'is_active' => true,
            ],
            [
                'name' => 'Super Astro Luna',
                'code' => 'super_astro_luna',
                'draw_schedule' => 'Lunes a Sábado 22:30, Domingo 20:30',
                'is_active' => true,
            ],

            // ========== CHANCE NACIONAL ==========
            [
                'name' => 'Chance Nacional',
                'code' => 'chance_nacional',
                'draw_schedule' => 'Lunes a Domingo 22:30',
                'is_active' => true,
            ],

            // ========== LOTERÍAS ADICIONALES ==========
            [
                'name' => 'Lotería del Caribe',
                'code' => 'caribe',
                'draw_schedule' => 'Miércoles y Sábado 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de la Sabana',
                'code' => 'sabana',
                'draw_schedule' => 'Viernes 22:30',
                'is_active' => true,
            ],
            [
                'name' => 'Lotería de Cali',
                'code' => 'cali',
                'draw_schedule' => 'Martes 22:30',
                'is_active' => true,
            ],
        ];

        foreach ($lotteries as $lottery) {
            Lottery::firstOrCreate(
                ['code' => $lottery['code']],
                $lottery
            );
        }

        $this->command->info('✅ ' . count($lotteries) . ' loterías creadas exitosamente');
    }
}