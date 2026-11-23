<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FishSeed;
use App\Models\FishSeedSize;
use Illuminate\Http\Request;

class FishSeedSizeController extends Controller
{
    public function index()
    {
        $sizes = FishSeedSize::with('fishSeed')->get();
        return view('admin.fish_seed_sizes.index', compact('sizes'));
    }

    public function create()
    {
        $fishSeeds = FishSeed::all();
        return view('admin.fish_seed_sizes.create', compact('fishSeeds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fish_seed_id' => 'required|exists:fish_seeds,id',
            'size_label' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        FishSeedSize::create($validated);

        return redirect()->route('admin.fish-seed-sizes.index')->with('success', 'Ukuran Bibit berhasil ditambahkan.');
    }

    public function edit(FishSeedSize $fishSeedSize)
    {
        $fishSeeds = FishSeed::all();
        return view('admin.fish_seed_sizes.edit', compact('fishSeedSize', 'fishSeeds'));
    }

    public function update(Request $request, FishSeedSize $fishSeedSize)
    {
        $validated = $request->validate([
            'fish_seed_id' => 'required|exists:fish_seeds,id',
            'size_label' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $fishSeedSize->update($validated);

        return redirect()->route('admin.fish-seed-sizes.index')->with('success', 'Ukuran Bibit berhasil diperbarui.');
    }

    public function destroy(FishSeedSize $fishSeedSize)
    {
        $fishSeedSize->delete();

        return redirect()->route('admin.fish-seed-sizes.index')->with('success', 'Ukuran Bibit berhasil dihapus.');
    }
}
