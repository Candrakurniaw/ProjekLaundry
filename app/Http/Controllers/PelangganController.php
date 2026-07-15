<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::latest()->paginate(20);
        $totalPelanggan = Pelanggan::count();
        $pelangganBulanIni = Pelanggan::whereMonth('created_at', now()->month)->count();

        return view('pelanggan', compact('pelanggans', 'totalPelanggan', 'pelangganBulanIni'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20|unique:pelanggans,no_telepon',
            'alamat' => 'nullable|string',
        ]);

        Pelanggan::create([
            'kode_pelanggan' => 'CUST-' . str_pad((Pelanggan::max('id') ?? 0) + 1, 3, '0', STR_PAD_LEFT),
            'nama' => $validated['nama'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ]);

        return redirect()->route('pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20|unique:pelanggans,no_telepon,' . $pelanggan->id,
            'alamat' => 'nullable|string',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan')->with('success', 'Pelanggan berhasil diupdate');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan')->with('success', 'Pelanggan berhasil dihapus');
    }
}
