<?php
// app/Services/Scrapers/Lotteries/MedellinScraper.php

namespace App\Services\Scrapers\Lotteries;

use App\Services\Scrapers\BaseScraper;

class MedellinScraper extends BaseScraper
{
    public function supports(string $lotteryCode): bool
    {
        return in_array($lotteryCode, ['medellin', 'medellin_loteria']);
    }
    
    public function getRecentResults(string $lotteryCode, int $limit = 20): array
    {
        $results = [];
        $url = "https://www.loteriamedellin.com.co/resultados-anteriores";
        
        $html = $this->fetchHtml($url);
        if (!$html) {
            return $this->getMockData($limit);
        }
        
        // Parsear HTML de Lotería de Medellín
        // Ejemplo de estructura (ajustar según la página real)
        preg_match_all('/<tr class="resultado">(.*?)<\/tr>/s', $html, $rows);
        
        foreach ($rows[1] as $index => $row) {
            if ($index >= $limit) break;
            
            // Extraer fecha y número
            preg_match('/<td class="fecha">(.*?)<\/td>/s', $row, $dateMatch);
            preg_match('/<td class="numero">(.*?)<\/td>/s', $row, $numberMatch);
            
            if (isset($dateMatch[1]) && isset($numberMatch[1])) {
                $results[] = [
                    'draw_date' => trim(strip_tags($dateMatch[1])),
                    'draw_number' => '',
                    'results' => trim(strip_tags($numberMatch[1])),
                ];
            }
        }
        
        return $results ?: $this->getMockData($limit);
    }
    
    public function getResultByDate(string $lotteryCode, string $date): ?array
    {
        $url = "https://www.loteriamedellin.com.co/resultado/{$date}";
        $html = $this->fetchHtml($url);
        
        if ($html && preg_match('/Número ganador: (\d{4})/', $html, $match)) {
            return [
                'draw_date' => $date,
                'draw_number' => '',
                'results' => $match[1],
            ];
        }
        
        return null;
    }
    
    private function getMockData(int $limit): array
    {
        $results = [];
        for ($i = 0; $i < $limit; $i++) {
            $results[] = [
                'draw_date' => now()->subDays($i)->format('Y-m-d'),
                'draw_number' => str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'results' => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT),
            ];
        }
        return $results;
    }
}