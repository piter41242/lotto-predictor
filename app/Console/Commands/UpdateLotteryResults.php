<?php
// app/Console/Commands/UpdateLotteryResults.php

namespace App\Console\Commands;

use App\Models\Lottery;
use App\Models\Draw;
use Illuminate\Console\Command;

class UpdateLotteryResults extends Command
{
    protected $signature = 'lottery:update-results
                            {--lottery= : Actualizar solo una lotería}
                            {--days=30 : Días hacia atrás}';
    
    protected $description = 'Actualiza resultados de loterías con datos de prueba';

    public function handle()
    {
        $query = Lottery::where('is_active', true);
        
        if ($this->option('lottery')) {
            $query->where('code', $this->option('lottery'));
        }
        
        $lotteries = $query->get();
        $days = (int) $this->option('days');
        
        $bar = $this->output->createProgressBar($lotteries->count());
        
        foreach ($lotteries as $lottery) {
            $this->newLine();
            $this->line("📊 {$lottery->name}");
            
            $count = 0;
            for ($i = 0; $i < $days; $i++) {
                $date = now()->subDays($i);
                $number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                
                $draw = Draw::updateOrCreate(
                    [
                        'lottery_id' => $lottery->id,
                        'draw_date' => $date->format('Y-m-d'),
                    ],
                    [
                        'draw_number' => $date->format('Ymd'),
                        'results' => $number,
                    ]
                );
                $count++;
            }
            
            $this->line("   ✅ {$count} sorteos actualizados");
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        $this->info('✅ Actualización completada');
        
        return 0;
    }
}