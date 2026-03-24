<?php

namespace App\Services;

class PredictionAlgorithm
{
    public function predict(array $recentDraws, int $numberCount = 20): array
    {
        if (empty($recentDraws)) {
            return $this->generateRandomNumbers($numberCount);
        }
        
        // Analizar cada dígito por separado
        $digitPositions = [[], [], [], []];
        
        foreach ($recentDraws as $draw) {
            $digits = str_split((string)$draw);
            foreach ($digits as $pos => $digit) {
                $digitPositions[$pos][] = (int)$digit;
            }
        }
        
        // Predecir números
        $predictions = [];
        for ($i = 0; $i < $numberCount * 2; $i++) {
            $number = '';
            for ($pos = 0; $pos < 4; $pos++) {
                if (!empty($digitPositions[$pos])) {
                    $frequencies = array_count_values($digitPositions[$pos]);
                    arsort($frequencies);
                    $topDigits = array_keys($frequencies);
                    
                    // Añadir factor aleatorio para variabilidad
                    $useHot = rand(0, 100) < 70; // 70% probabilidad de usar números calientes
                    
                    if ($useHot && count($topDigits) > 0) {
                        $selected = $topDigits[array_rand($topDigits)];
                    } else {
                        $selected = rand(0, 9);
                    }
                } else {
                    $selected = rand(0, 9);
                }
                $number .= $selected;
            }
            $predictions[] = $number;
        }
        
        // Eliminar duplicados y limitar
        $predictions = array_unique($predictions);
        $predictions = array_slice($predictions, 0, $numberCount);
        
        // Si faltan números, completar con aleatorios
        if (count($predictions) < $numberCount) {
            $needed = $numberCount - count($predictions);
            $random = $this->generateRandomNumbers($needed);
            $predictions = array_merge($predictions, $random);
        }
        
        sort($predictions);
        return $predictions;
    }
    
    private function generateRandomNumbers(int $count): array
    {
        $numbers = [];
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        }
        return $numbers;
    }
}
