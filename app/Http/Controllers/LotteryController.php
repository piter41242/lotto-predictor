<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function index()
    {
        $lotteries = Lottery::where('is_active', true)->orderBy('name')->get();
        return response()->json($lotteries);
    }

    // app/Http/Controllers/LotteryController.php

    public function getDraws(Lottery $lottery)
    {
        $draws = $lottery->draws()
            ->orderBy('draw_date', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($draw) {
                return [
                    'id' => $draw->id,
                    'draw_date' => $draw->draw_date->format('Y-m-d'),
                    'draw_number' => $draw->draw_number,
                    'results' => $draw->results, // Ahora es string "1234"
                ];
            })
            ->reverse()
            ->values();

        return response()->json($draws);
    }
}
