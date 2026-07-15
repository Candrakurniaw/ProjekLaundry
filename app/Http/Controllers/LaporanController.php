<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->get('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', now()->toDateString());

        $totalPendapatan = Transaksi::whereBetween('tanggal_masuk', [$dari, $sampai])
            ->whereIn('status', ['selesai', 'diambil'])
            ->sum('total_harga');

        $transaksis = Transaksi::with('pelanggan')
            ->whereBetween('tanggal_masuk', [$dari, $sampai])
            ->latest()
            ->get();

        $totalTransaksi = $transaksis->count();
        $totalBulanLalu = Transaksi::whereBetween('tanggal_masuk', [
            now()->subMonth()->startOfMonth()->toDateString(),
            now()->subMonth()->endOfMonth()->toDateString()
        ])->whereIn('status', ['selesai', 'diambil'])->sum('total_harga');

        $persenKenaikan = $totalBulanLalu > 0
            ? round((($totalPendapatan - $totalBulanLalu) / $totalBulanLalu) * 100, 1)
            : 0;

        return view('laporan', compact(
            'totalPendapatan',
            'totalTransaksi',
            'persenKenaikan',
            'transaksis',
            'dari',
            'sampai'
        ));
    }
}
