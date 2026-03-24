<?php
// app/Services/Scrapers/BaseScraper.php

namespace App\Services\Scrapers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

abstract class BaseScraper
{
    protected $lotteryCode;
    protected $baseUrl;
    protected $cacheTime = 3600; // 1 hora
    
    public function __construct(string $lotteryCode)
    {
        $this->lotteryCode = $lotteryCode;
        $this->initializeUrls();
    }
    
    abstract protected function initializeUrls(): void;
    abstract public function supports(string $lotteryCode): bool;
    abstract public function getRecentResults(int $limit = 20): array;
    abstract public function getResultByDate(string $date): ?array;
    
    protected function fetchHtml(string $url): ?string
    {
        $cacheKey = "scraper_{$this->lotteryCode}_" . md5($url);
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($url) {
            try {
                $response = Http::timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9',
                        'Accept-Language' => 'es-CO,es;q=0.9',
                        'Referer' => 'https://www.google.com/',
                    ])
                    ->get($url);
                    
                if ($response->successful()) {
                    return $response->body();
                }
            } catch (\Exception $e) {
                Log::error("Error scraping {$this->lotteryCode}: " . $e->getMessage());
            }
            return null;
        });
    }
    
    protected function fetchJson(string $url): ?array
    {
        $html = $this->fetchHtml($url);
        if ($html && preg_match('/<script[^>]*>([^<]*)<\/script>/', $html, $matches)) {
            // Intentar encontrar JSON en scripts
            if (preg_match('/\{.*\}/s', $matches[1], $jsonMatch)) {
                return json_decode($jsonMatch[0], true);
            }
        }
        return null;
    }
    
    protected function getMockData(int $limit): array
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