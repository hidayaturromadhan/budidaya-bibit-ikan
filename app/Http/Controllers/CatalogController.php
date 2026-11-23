<?php

namespace App\Http\Controllers;

use App\Models\FishSeed;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = FishSeed::with(['sizes.stock'])->where('is_active', true);
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $fishSeeds = $query->paginate(12)->withQueryString();
        $categories = FishSeed::where('is_active', true)->whereNotNull('category')->distinct()->pluck('category');

        return view('catalog.index', compact('fishSeeds', 'categories'));
    }

    public function show(FishSeed $fishSeed)
    {
        if (!$fishSeed->is_active) {
            abort(404);
        }
        
        $fishSeed->load('sizes.stock');
        return view('catalog.show', compact('fishSeed'));
    }
}

