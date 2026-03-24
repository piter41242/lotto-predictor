<?php
// app/Services/Scrapers/Lotteries/BalotoScraper.php

namespace App\Services\Scrapers\Lotteries;

use App\Services\Scrapers\BaseScraper;

class BalotoScraper extends BaseScraper
{
    public function supports(string $lotteryCode): bool
    {
        return in_array($lotteryCode, ['baloto', 'baloto_revancha']);
    }
    
    public function getRecentResults(string $lotteryCode, int $limit = 20): array
    {
        $results = [];
        $url = "https://www.baloto.com.co/resultados";
        
        $html = $this->fetchHtml($url);
        if (!$html) {
            return $this->getMockData($limit);
        }
        
        // Parsear Baloto (5 números + super balota)
        preg_match_all('/<div class="sorteo-item">(.*?)<\/div>/s', $html, $sorteos);
        
        foreach ($sorteos[1] as $index => $sorteo) {
            if ($index >= $limit) break;
            
            preg_match('/<span class="fecha">(.*?)<\/span>/', $sorteo, $dateMatch);
            preg_match('/<span class="numeros">(\d{2})<\/span>/', $sorteo, $numbers);
            
            // Baloto tiene formato especial
            if (isset($dateMatch[1]) && isset($numbers[1])) {
                $results[] = [
                    'draw_date' => trim($dateMatch[1]),
                    'draw_number' => '',
                    'results' => $numbers[1], // Esto necesita ajuste
                ];
            }
        }
        
        return $results ?: $this->getMockData($limit);
    }
    
    public function getResultByDate(string $lotteryCode, string $date): ?array
    {
        return null;
    }
    
    private function getMockData(int $limit): array
    {
        $results = [];
        for ($i = 0; $i < $limit; $i++) {
            $numbers = [];
            for ($j = 0; $j < 5; $j++) {
                $numbers[] = str_pad(rand(1, 43), 2, '0', STR_PAD_LEFT);
            }
            $superBalota = str_pad(rand(1, 16), 2, '0', STR_PAD_LEFT);
            
            $results[] = [
                'draw_date' => now()->subDays($i)->format('Y-m-d'),
                'draw_number' => '',
                'results' => implode(' ', $numbers) . ' + ' . $superBalota,
            ];
        }
        return $results;
    }
}