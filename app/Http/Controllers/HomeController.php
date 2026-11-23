<?php

namespace App\Http\Controllers;

use App\Models\FishSeed;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil maksimal 6 bibit ikan terbaru untuk ditampilkan di Landing Page
        $fishSeeds = FishSeed::with(['sizes.stock'])
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();
            
        return view('welcome', compact('fishSeeds'));
    }
}
