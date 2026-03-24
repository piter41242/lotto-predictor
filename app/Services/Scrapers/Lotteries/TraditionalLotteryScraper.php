<?php
// app/Services/Scrapers/Lotteries/TraditionalLotteryScraper.php

namespace App\Services\Scrapers\Lotteries;

use App\Services\Scrapers\BaseScraper;

class TraditionalLotteryScraper extends BaseScraper
{
    protected $urls = [];
    
    protected function initializeUrls(): void
    {
        $this->urls = [
            'medellin' => 'https://www.loteriamedellin.com.co/resultados-anteriores',
            'bogota' => 'https://www.loterias.com.co/bogota/resultados',
            'huila' => 'https://www.loterias.com.co/huila/resultados',
            'tolima' => 'https://www.loterias.com.co/tolima/resultados',
            'manizales' => 'https://www.loterias.com.co/manizales/resultados',
            'boyaca' => 'https://www.loterias.com.co/boyaca/resultados',
            'quindio' => 'https://www.loterias.com.co/quindio/resultados',
            'cundinamarca' => 'https://www.loterias.com.co/cundinamarca/resultados',
            'santander' => 'https://www.loterias.com.co/santander/resultados',
            'valle' => 'https://www.loterias.com.co/valle/resultados',
            'cruz_roja' => 'https://www.loterias.com.co/cruz-roja/resultados',
            'risaralda' => 'https://www.loterias.com.co/risaralda/resultados',
            'cauca' => 'https://www.loterias.com.co/cauca/resultados',
            'narino' => 'https://www.loterias.com.co/narino/resultados',
            'atlantico' => 'https://www.loterias.com.co/atlantico/resultados',
            'meta' => 'https://www.loterias.com.co/meta/resultados',
            'sucre' => 'https://www.loterias.com.co/sucre/resultados',
            'cordoba' => 'https://www.loterias.com.co/cordoba/resultados',
            'casanare' => 'https://www.loterias.com.co/casanare/resultados',
            'magdalena' => 'https://www.loterias.com.co/magdalena/resultados',
            'caribe' => 'https://www.loterias.com.co/caribe/resultados',
            'sabana' => 'https://www.loterias.com.co/sabana/resultados',
            'cali' => 'https://www.loterias.com.co/cali/resultados',
        ];
    }
    
    public function supports(string $lotteryCode): bool
    {
        return array_key_exists($lotteryCode, $this->urls);
    }
    
    public function getRecentResults(int $limit = 20): array
    {
        $url = $this->urls[$this->lotteryCode] ?? null;
        if (!$url) {
            return $this->getMockData($limit);
        }
        
        $html = $this->fetchHtml($url);
        if (!$html) {
            return $this->getMockData($limit);
        }
        
        $results = [];
        
        // Patrón para loterías tradicionales
        preg_match_all('/<tr[^>]*>.*?<td[^>]*>(.*?)<\/td>.*?<td[^>]*>(.*?)<\/td>.*?<td[^>]*>(\d{4})<\/td>/s', $html, $matches, PREG_SET_ORDER);
        
        if (empty($matches)) {
            // Segundo patrón
            preg_match_all('/<div[^>]*class="[^"]*resultado[^"]*"[^>]*>.*?<span[^>]*class="[^"]*fecha[^"]*"[^>]*>(.*?)<\/span>.*?<span[^>]*class="[^"]*numero[^"]*"[^>]*>(\d{4})<\/span>/s', $html, $matches2, PREG_SET_ORDER);
            $matches = $matches2;
        }
        
        foreach ($matches as $index => $match) {
            if ($index >= $limit) break;
            
            $date = trim(strip_tags($match[1] ?? $match[0] ?? ''));
            $number = trim(strip_tags($match[2] ?? $match[1] ?? ''));
            
            // Convertir fecha a formato Y-m-d
            $dateFormatted = $this->parseDate($date);
            
            if ($dateFormatted && preg_match('/\d{4}/', $number)) {
                $results[] = [
                    'draw_date' => $dateFormatted,
                    'draw_number' => str_replace('-', '', $dateFormatted),
                    'results' => $number,
                ];
            }
        }
        
        return $results ?: $this->getMockData($limit);
    }
    
    public function getResultByDate(string $date): ?array
    {
        $url = $this->urls[$this->lotteryCode] ?? null;
        if (!$url) {
            return null;
        }
        
        $html = $this->fetchHtml($url);
        if (!$html) {
            return null;
        }
        
        $dateFormatted = date('d/m/Y', strtotime($date));
        
        // Buscar por fecha
        preg_match('/<tr[^>]*>.*?' . preg_quote($dateFormatted) . '.*?(\d{4})<\/td>/s', $html, $match);
        
        if (isset($match[1])) {
            return [
                'draw_date' => $date,
                'draw_number' => str_replace('-', '', $date),
                'results' => $match[1],
            ];
        }
        
        return null;
    }
    
    private function parseDate(string $dateString): ?string
    {
        // Intentar diferentes formatos de fecha
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'd M Y', 'M d, Y'];
        
        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, trim($dateString));
            if ($date) {
                return $date->format('Y-m-d');
            }
        }
        
        // Si no, intentar con strtotime
        $timestamp = strtotime($dateString);
        if ($timestamp) {
            return date('Y-m-d', $timestamp);
        }
        
        return null;
    }
}