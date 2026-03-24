<?php
// app/Services/Scrapers/Chances/DoradoScraper.php

namespace App\Services\Scrapers\Chances;

use App\Services\Scrapers\BaseScraper;

class DoradoScraper extends BaseScraper
{
    protected $horarios = [
        'dorado_dia' => ['url' => 'https://www.eldorado.com.co/resultados-dia', 'hora' => '14:30'],
        'dorado_tarde' => ['url' => 'https://www.eldorado.com.co/resultados-tarde', 'hora' => '18:00'],
        'dorado_noche' => ['url' => 'https://www.eldorado.com.co/resultados-noche', 'hora' => '22:30'],
    ];
    
    protected function initializeUrls(): void
    {
        // URLs ya definidas en $horarios
    }
    
    public function supports(string $lotteryCode): bool
    {
        return array_key_exists($lotteryCode, $this->horarios);
    }
    
    public function getRecentResults(int $limit = 20): array
    {
        $config = $this->horarios[$this->lotteryCode] ?? null;
        if (!$config) {
            return $this->getMockData($limit);
        }
        
        $html = $this->fetchHtml($config['url']);
        if (!$html) {
            return $this->getMockData($limit);
        }
        
        $results = [];
        
        // Patrón para El Dorado
        preg_match_all('/<div[^>]*class="[^"]*resultado[^"]*"[^>]*>.*?<span[^>]*class="[^"]*fecha[^"]*"[^>]*>(.*?)<\/span>.*?<span[^>]*class="[^"]*numero[^"]*"[^>]*>(\d{4})<\/span>/s', $html, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $index => $match) {
            if ($index >= $limit) break;
            
            $date = trim(strip_tags($match[1]));
            $number = trim(strip_tags($match[2]));
            
            $dateFormatted = $this->parseDate($date);
            
            if ($dateFormatted && preg_match('/\d{4}/', $number)) {
                $results[] = [
                    'draw_date' => $dateFormatted,
                    'draw_number' => $this->lotteryCode . '_' . str_replace('-', '', $dateFormatted),
                    'results' => $number,
                ];
            }
        }
        
        return $results ?: $this->getMockData($limit);
    }
    
    public function getResultByDate(string $date): ?array
    {
        $config = $this->horarios[$this->lotteryCode] ?? null;
        if (!$config) {
            return null;
        }
        
        $html = $this->fetchHtml($config['url']);
        if (!$html) {
            return null;
        }
        
        $dateFormatted = date('d/m/Y', strtotime($date));
        
        preg_match('/<div[^>]*>.*?' . preg_quote($dateFormatted) . '.*?(\d{4})<\/span>/s', $html, $match);
        
        if (isset($match[1])) {
            return [
                'draw_date' => $date,
                'draw_number' => $this->lotteryCode . '_' . str_replace('-', '', $date),
                'results' => $match[1],
            ];
        }
        
        return null;
    }
    
    private function parseDate(string $dateString): ?string
    {
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'd M Y'];
        
        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, trim($dateString));
            if ($date) {
                return $date->format('Y-m-d');
            }
        }
        
        $timestamp = strtotime($dateString);
        if ($timestamp) {
            return date('Y-m-d', $timestamp);
        }
        
        return null;
    }
}