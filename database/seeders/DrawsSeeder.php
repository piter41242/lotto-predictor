<?php

namespace Database\Seeders;

use App\Models\Draw;
use App\Models\Lottery;
use Illuminate\Database\Seeder;

class DrawsSeeder extends Seeder
{
    public function run(): void
    {
        $lotteries = Lottery::all();
        
        foreach ($lotteries as $lottery) {
            for ($i = 0; $i < 20; $i++) {
                // Generar número de 4 dígitos (0000-9999)
                $number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                
                Draw::create([
                    'lottery_id' => $lottery->id,
                    'draw_date' => now()->subDays(20 - $i),
                    'draw_number' => str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'results' => $number,
                ]);
            }
        }
        
        $this->command->info('✅ Sorteos generados para ' . $lotteries->count() . ' loterías');
    }
}