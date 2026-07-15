<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('pengaturan', compact('layanans'));
    }

    public function storeLayanan(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_jam' => 'required|integer|min:1',
        ]);

        Layanan::create($validated);

        return redirect()->route('pengaturan')->with('success', 'Layanan berhasil ditambahkan');
    }

    public function updateLayanan(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_jam' => 'required|integer|min:1',
        ]);

        $layanan->update($validated);

        return redirect()->route('pengaturan')->with('success', 'Layanan berhasil diupdate');
    }

    public function destroyLayanan(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('pengaturan')->with('success', 'Layanan berhasil dihapus');
    }
}
