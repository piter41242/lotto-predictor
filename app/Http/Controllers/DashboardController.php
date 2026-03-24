<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lotteries = Lottery::where('is_active', true)->orderBy('name')->get();
        return view('dashboard', compact('lotteries'));
    }
}