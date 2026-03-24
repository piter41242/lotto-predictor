<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\Prediction;
use App\Services\PredictionAlgorithm;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    protected $algorithm;

    public function __construct(PredictionAlgorithm $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'lottery_id' => 'required|exists:lotteries,id',
        ]);

        $lottery = Lottery::findOrFail($request->lottery_id);
        
        $draws = $lottery->draws()
            ->orderBy('draw_date', 'desc')
            ->limit(20)
            ->get()
            ->map(function($draw) {
                return $draw->results;
            })
            ->toArray();

        if (count($draws) < 20) {
            return response()->json([
                'error' => 'No hay suficientes resultados'
            ], 400);
        }

        $predictedNumbers = $this->algorithm->predict($draws, 20);

        $prediction = Prediction::create([
            'user_id' => auth()->id(),
            'lottery_id' => $lottery->id,
            'predicted_numbers' => $predictedNumbers,
            'algorithm_metadata' => [
                'draws_analyzed' => count($draws),
                'generated_at' => now(),
            ]
        ]);

        return response()->json([
            'success' => true,
            'prediction' => $prediction,
            'numbers' => $predictedNumbers
        ]);
    }

    public function history()
    {
        $predictions = Prediction::with('lottery')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($predictions);
    }
}