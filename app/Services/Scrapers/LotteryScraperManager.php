<?php
// app/Services/Scrapers/LotteryScraperManager.php

namespace App\Services\Scrapers;

use App\Services\Scrapers\Lotteries\TraditionalLotteryScraper;
use App\Services\Scrapers\Chances\DoradoScraper;
use App\Services\Scrapers\Chances\AntioquenitaScraper;
use App\Services\Scrapers\Chances\FantasticaScraper;
use App\Services\Scrapers\Chances\PaisitaScraper;
use App\Services\Scrapers\Chances\ChonticoScraper;
use App\Services\Scrapers\Chances\PijaoOroScraper;
use App\Services\Scrapers\Chances\SuperAstroScraper;
use App\Services\Scrapers\Chances\ChanceNacionalScraper;

class LotteryScraperManager
{
    protected $scrapers = [];
    
    public function __construct()
    {
        $this->registerScrapers();
    }
    
    protected function registerScrapers(): void
    {
        // Loterías tradicionales (23 loterías)
        $this->scrapers[] = new TraditionalLotteryScraper('');
        
        // Chances
        $this->scrapers[] = new DoradoScraper('');
        $this->scrapers[] = new AntioquenitaScraper('');
        $this->scrapers[] = new FantasticaScraper('');
        $this->scrapers[] = new PaisitaScraper('');
        $this->scrapers[] = new ChonticoScraper('');
        $this->scrapers[] = new PijaoOroScraper('');
        $this->scrapers[] = new SuperAstroScraper('');
        $this->scrapers[] = new ChanceNacionalScraper('');
    }
    
    public function getResults(string $lotteryCode, int $limit = 20): array
    {
        $scraper = $this->getScraper($lotteryCode);
        
        if ($scraper) {
            $scraperClone = clone $scraper;
            $reflection = new \ReflectionClass($scraperClone);
            $property = $reflection->getProperty('lotteryCode');
            $property->setAccessible(true);
            $property->setValue($scraperClone, $lotteryCode);
            
            return $scraperClone->getRecentResults($limit);
        }
        
        return [];
    }
    
    protected function getScraper(string $lotteryCode): ?BaseScraper
    {
        foreach ($this->scrapers as $scraper) {
            if ($scraper->supports($lotteryCode)) {
                return $scraper;
            }
        }
        return null;
    }
}