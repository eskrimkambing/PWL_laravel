<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    private function aturan(): array
    {
        return [
            'nama'  => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
        ];
    }

    public function index()
    {
        $toppings = Topping::orderBy('nama')->get();

        return view('toppings.index', compact('toppings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->aturan());

        Topping::create($data);

        return redirect()->route('toppings.index')
            ->with('success', 'Topping berhasil ditambahkan!');
    }

    public function edit(Topping $topping)
    {
        return view('toppings.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping)
    {
        $data = $request->validate($this->aturan());
        $data['sold_out'] = $request->boolean('sold_out');

        $topping->update($data);

        return redirect()->route('toppings.index')
            ->with('success', 'Topping berhasil diperbarui!');
    }

    // Tandai / buka kembali topping: "Sold Out" <-> tersedia.
    public function toggleSoldOut(Topping $topping)
    {
        $topping->update(['sold_out' => !$topping->sold_out]);

        return redirect()->route('toppings.index')
            ->with('success', $topping->nama . ($topping->sold_out
                ? ' ditandai Sold Out.'
                : ' tersedia kembali.'));
    }

    public function destroy(Topping $topping)
    {
        $topping->delete();

        return redirect()->route('toppings.index')
            ->with('success', 'Topping berhasil dihapus!');
    }
}
