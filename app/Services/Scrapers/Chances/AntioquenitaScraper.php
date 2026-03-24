<?php
// app/Services/Scrapers/Chances/AntioquenitaScraper.php

namespace App\Services\Scrapers\Chances;

use App\Services\Scrapers\BaseScraper;

class AntioquenitaScraper extends BaseScraper
{
    protected $horarios = [
        'antioquenita_dia' => ['url' => 'https://www.antioquenita.com/resultados-dia', 'hora' => '12:00'],
        'antioquenita_tarde' => ['url' => 'https://www.antioquenita.com/resultados-tarde', 'hora' => '17:00'],
    ];
    
    protected function initializeUrls(): void
    {
        // URLs definidas en $horarios
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
        
        // Patrón para Antioqueñita
        preg_match_all('/<tr[^>]*>.*?<td[^>]*>(.*?)<\/td>.*?<td[^>]*>(\d{4})<\/td>/s', $html, $matches, PREG_SET_ORDER);
        
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
        
        preg_match('/<tr[^>]*>.*?' . preg_quote($dateFormatted) . '.*?(\d{4})<\/td>/s', $html, $match);
        
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
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d'];
        
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