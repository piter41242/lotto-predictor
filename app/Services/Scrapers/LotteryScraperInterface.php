<?php
// app/Services/Scrapers/LotteryScraperInterface.php

namespace App\Services\Scrapers;

interface LotteryScraperInterface
{
    public function getRecentResults(string $lotteryCode, int $limit = 20): array;
    public function getResultByDate(string $lotteryCode, string $date): ?array;
    public function supports(string $lotteryCode): bool;
}