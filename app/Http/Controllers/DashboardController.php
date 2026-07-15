<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $pendapatanHariIni = Transaksi::whereDate('tanggal_masuk', $today)->sum('total_harga');
        $transaksiHariIni = Transaksi::whereDate('tanggal_masuk', $today)->count();
        $selesaiHariIni = Transaksi::whereDate('tanggal_masuk', $today)->where('status', 'selesai')->count();
        $totalPelanggan = Pelanggan::count();

        $transaksiTerakhir = Transaksi::with('pelanggan')
            ->latest()
            ->take(5)
            ->get();

        $todayName = now()->locale('id')->isoFormat('dddd, D MMMM Y');

        return view('dashboard', compact(
            'pendapatanHariIni',
            'transaksiHariIni',
            'selesaiHariIni',
            'totalPelanggan',
            'transaksiTerakhir',
            'todayName'
        ));
    }
}
