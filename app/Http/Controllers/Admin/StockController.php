<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FishSeedSize;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $sizes = FishSeedSize::with(['fishSeed', 'stock'])->get();
        return view('admin.stocks.index', compact('sizes'));
    }

    public function create()
    {
        // Not used conventionally, but we can use it for a generic 'Add Stock' page
        $sizes = FishSeedSize::with('fishSeed')->get();
        return view('admin.stocks.create', compact('sizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fish_seed_size_id' => 'required|exists:fish_seed_sizes,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            // Create movement
            StockMovement::create($validated);

            // Update stock
            $stock = Stock::firstOrCreate(
                ['fish_seed_size_id' => $validated['fish_seed_size_id']],
                ['quantity' => 0]
            );

            if ($validated['type'] === 'in') {
                $stock->increment('quantity', $validated['quantity']);
            } else {
                $stock->decrement('quantity', $validated['quantity']);
            }
        });

        return redirect()->route('admin.stocks.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function edit($id)
    {
        // For specific size stock update
        $size = FishSeedSize::with('fishSeed')->findOrFail($id);
        return view('admin.stocks.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        // We handle stock update via store method conceptually, 
        // but if they use the edit form, it submits here.
        $validated = $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);
        
        $validated['fish_seed_size_id'] = $id;

        DB::transaction(function () use ($validated) {
            StockMovement::create($validated);

            $stock = Stock::firstOrCreate(
                ['fish_seed_size_id' => $validated['fish_seed_size_id']],
                ['quantity' => 0]
            );

            if ($validated['type'] === 'in') {
                $stock->increment('quantity', $validated['quantity']);
            } else {
                $stock->decrement('quantity', $validated['quantity']);
            }
        });

        return redirect()->route('admin.stocks.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Generally you don't delete stock, but you can view movements
    }
    
    public function show($id)
    {
        $size = FishSeedSize::with('fishSeed')->findOrFail($id);
        $movements = StockMovement::where('fish_seed_size_id', $id)->orderBy('created_at', 'desc')->get();
        return view('admin.stocks.show', compact('size', 'movements'));
    }
}
