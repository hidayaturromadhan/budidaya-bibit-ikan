<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FishSeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FishSeedController extends Controller
{
    public function index()
    {
        $fishSeeds = FishSeed::all();
        return view('admin.fish_seeds.index', compact('fishSeeds'));
    }

    public function create()
    {
        return view('admin.fish_seeds.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('fish_seeds', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        FishSeed::create($validated);

        return redirect()->route('admin.fish-seeds.index')->with('success', 'Bibit Ikan berhasil ditambahkan.');
    }

    public function edit(FishSeed $fishSeed)
    {
        return view('admin.fish_seeds.edit', compact('fishSeed'));
    }

    public function update(Request $request, FishSeed $fishSeed)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($fishSeed->image) {
                Storage::disk('public')->delete($fishSeed->image);
            }
            $validated['image'] = $request->file('image')->store('fish_seeds', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $fishSeed->update($validated);

        return redirect()->route('admin.fish-seeds.index')->with('success', 'Bibit Ikan berhasil diperbarui.');
    }

    public function destroy(FishSeed $fishSeed)
    {
        if ($fishSeed->image) {
            Storage::disk('public')->delete($fishSeed->image);
        }
        $fishSeed->delete();

        return redirect()->route('admin.fish-seeds.index')->with('success', 'Bibit Ikan berhasil dihapus.');
    }
}
