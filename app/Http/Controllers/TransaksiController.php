<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('transaksi', compact('layanans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_layanan' => 'required|exists:layanans,id',
            'berat' => 'required|numeric|min:0.1',
            'pelanggan_nama' => 'required|string|max:255',
            'pelanggan_telepon' => 'nullable|string|max:20',
            'catatan' => 'nullable|string',
            'tanggal_selesai_estimasi' => 'nullable|date',
        ]);

        $pelanggan = Pelanggan::firstOrCreate(
            ['no_telepon' => $validated['pelanggan_telepon']],
            [
                'kode_pelanggan' => 'CUST-' . str_pad((Pelanggan::max('id') ?? 0) + 1, 3, '0', STR_PAD_LEFT),
                'nama' => $validated['pelanggan_nama'],
            ]
        );

        $layanan = Layanan::findOrFail($validated['jenis_layanan']);
        $subtotal = $layanan->harga_per_kg * $validated['berat'];

        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TRX-' . str_pad((Transaksi::max('id') ?? 0) + 1, 3, '0', STR_PAD_LEFT),
            'pelanggan_id' => $pelanggan->id,
            'total_harga' => $subtotal,
            'status' => 'proses',
            'catatan' => $validated['catatan'] ?? null,
            'tanggal_masuk' => now()->toDateString(),
            'tanggal_selesai_estimasi' => $validated['tanggal_selesai_estimasi'] ?? now()->addDay()->toDateString(),
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'layanan_id' => $layanan->id,
            'berat' => $validated['berat'],
            'harga_per_kg' => $layanan->harga_per_kg,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil disimpan');
    }
}
