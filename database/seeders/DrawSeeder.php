<?php

namespace Database\Seeders;

use App\Models\Draw;
use App\Models\Lottery;
use Illuminate\Database\Seeder;

class DrawSeeder extends Seeder
{
    public function run(): void
    {
        $lotteries = Lottery::all();
        
        foreach ($lotteries as $lottery) {
            for ($i = 0; $i < 20; $i++) {
                $numbers = [];
                while (count($numbers) < 4) {
                    $num = rand(0, 99);
                    if (!in_array($num, $numbers)) {
                        $numbers[] = $num;
                    }
                }
                sort($numbers);
                
                Draw::create([
                    'lottery_id' => $lottery->id,
                    'draw_date' => now()->subDays(20 - $i),
                    'draw_number' => str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'results' => $numbers,
                ]);
            }
        }
    }
}