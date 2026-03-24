<?php
// app/Services/Scrapers/Chances/FantasticaScraper.php

namespace App\Services\Scrapers\Chances;

use App\Services\Scrapers\BaseScraper;

class FantasticaScraper extends BaseScraper
{
    protected $horarios = [
        'fantastica_dia' => ['url' => 'https://www.fantastica.com.co/resultados-dia', 'hora' => '13:00'],
        'fantastica_noche' => ['url' => 'https://www.fantastica.com.co/resultados-noche', 'hora' => '20:30'],
    ];
    
    protected function initializeUrls(): void {}
    
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
        preg_match_all('/<div[^>]*class="[^"]*resultado[^"]*"[^>]*>.*?<span[^>]*>(\d{2}\/\d{2}\/\d{4})<\/span>.*?<strong>(\d{4})<\/strong>/s', $html, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $index => $match) {
            if ($index >= $limit) break;
            
            $dateFormatted = $this->parseDate($match[1]);
            if ($dateFormatted) {
                $results[] = [
                    'draw_date' => $dateFormatted,
                    'draw_number' => $this->lotteryCode . '_' . str_replace('-', '', $dateFormatted),
                    'results' => $match[2],
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
        preg_match('/' . preg_quote($dateFormatted) . '.*?(\d{4})/s', $html, $match);
        
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
        $date = \DateTime::createFromFormat('d/m/Y', trim($dateString));
        if ($date) {
            return $date->format('Y-m-d');
        }
        return null;
    }
}