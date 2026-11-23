<?php

namespace App\Http\Controllers;

use App\Models\FishSeedSize;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Recalculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'fish_seed_size_id' => 'required|exists:fish_seed_sizes,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $size = FishSeedSize::with(['fishSeed', 'stock'])->findOrFail($request->fish_seed_size_id);
        $stock = $size->stock ? $size->stock->quantity : 0;
        $reqQty = (int)$request->quantity;

        if ($stock < $reqQty) {
            return back()->with('error', 'Stok tidak mencukupi. Sisa stok: ' . $stock);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$size->id])) {
            $newQty = $cart[$size->id]['quantity'] + $reqQty;
            if ($newQty > $stock) {
                return back()->with('error', 'Stok tidak mencukupi untuk penambahan ini. Sisa stok: ' . $stock);
            }
            $cart[$size->id]['quantity'] = $newQty;
        } else {
            $cart[$size->id] = [
                'id' => $size->id,
                'name' => $size->fishSeed->name,
                'size_label' => $size->size_label,
                'price' => $size->price,
                'quantity' => $reqQty,
                'image' => $size->fishSeed->image,
                'max_stock' => $stock
            ];
        }

        session()->put('cart', $cart);
        
        if ($request->input('action') === 'buy_now') {
            return redirect()->route('checkout.index');
        }
        
        return redirect()->back()->with('success', 'Bibit ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $reqQty = (int)$request->quantity;
            if ($reqQty > $cart[$id]['max_stock']) {
                return back()->with('error', 'Stok tidak mencukupi. Maksimal: ' . $cart[$id]['max_stock']);
            }
            $cart[$id]['quantity'] = $reqQty;
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang.');
    }
}
