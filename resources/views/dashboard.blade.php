@extends('layouts.app')

@section('title', 'Dashboard PoS Laundry')
@section('activeNav', 'dashboard')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600&display=swap">
@vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])

<div class="pos-dashboard min-h-screen relative">
  <div class="pd-bubbles" aria-hidden="true"><span></span><span></span><span></span><span></span><span></span></div>

  <div class="relative z-10">
    <div class="mb-1">
      <h2 class="pd-display font-headline-md text-headline-md text-on-surface">Dashboard</h2>
      <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $todayName }}</p>
    </div>

    <a href="{{ route('transaksi') }}"
       class="pd-ticket w-full flex items-center justify-center gap-3 px-6 h-14 text-white rounded-2xl font-label-bold text-label-bold transition-all mt-4 mb-6">
      <span class="pd-ticket-badge">
        <span class="pd-drum-spin" style="position:relative;width:16px;height:16px;display:block;">
          <i style="position:absolute;width:4px;height:4px;border-radius:9999px;background:#fff;top:0;left:6px;"></i>
          <i style="position:absolute;width:4px;height:4px;border-radius:9999px;background:#fff;top:6px;left:0;"></i>
          <i style="position:absolute;width:4px;height:4px;border-radius:9999px;background:#fff;bottom:0;right:3px;"></i>
        </span>
      </span>
      <span class="pd-display text-[15px]">Transaksi Baru</span>
      <span class="material-symbols-outlined text-[20px] ml-1">arrow_forward</span>
      <span class="pd-ticket-bubbles" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
    </a>

    <div class="flex overflow-x-auto no-scrollbar gap-card-gap pb-1 snap-x">
      <div class="pd-tag flex-shrink-0 w-64 snap-start bg-white p-4 rounded-xl border border-outline-variant soft-lift">
        <div class="flex items-center justify-between mb-3">
          <p class="text-on-surface-variant font-label-bold text-[11px] uppercase tracking-wide">Pendapatan Hari Ini</p>
          <div class="w-8 h-8 bg-secondary-container/30 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-secondary text-[18px]">payments</span>
          </div>
        </div>
        <h3 class="pd-display font-display-lg text-display-lg text-on-surface pd-count" data-format="rupiah" data-value="{{ (int) $pendapatanHariIni }}">Rp 0</h3>
      </div>
      <div class="pd-tag flex-shrink-0 w-64 snap-start bg-white p-4 rounded-xl border border-outline-variant soft-lift">
        <div class="flex items-center justify-between mb-3">
          <p class="text-on-surface-variant font-label-bold text-[11px] uppercase tracking-wide">Jumlah Transaksi</p>
          <div class="w-8 h-8 bg-tertiary-fixed/30 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-tertiary text-[18px]">receipt_long</span>
          </div>
        </div>
        <h3 class="pd-display font-display-lg text-display-lg text-on-surface pd-count" data-format="number" data-value="{{ (int) $transaksiHariIni }}">0</h3>
      </div>
      <div class="pd-tag flex-shrink-0 w-64 snap-start bg-white p-4 rounded-xl border border-outline-variant soft-lift">
        <div class="flex items-center justify-between mb-3">
          <p class="text-on-surface-variant font-label-bold text-[11px] uppercase tracking-wide">Total Pelanggan</p>
          <div class="w-8 h-8 bg-secondary-fixed/30 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-on-secondary-container text-[18px]">group</span>
          </div>
        </div>
        <h3 class="pd-display font-display-lg text-display-lg text-on-surface pd-count" data-format="number" data-value="{{ (int) $totalPelanggan }}">0</h3>
      </div>
    </div>

    <div class="space-y-3 mt-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-primary text-[20px]">history</span>
          <h4 class="pd-display font-title-sm text-title-sm text-on-surface">Transaksi Terakhir</h4>
        </div>
        <a href="{{ route('laporan') }}" class="text-primary font-label-bold text-body-sm">Lihat Semua</a>
      </div>
      <div class="space-y-card-gap">
        @forelse ($transaksiTerakhir as $t)
        @php $isDone = in_array($t->status, ['selesai', 'diambil']); @endphp
        <div class="pd-item bg-white p-4 rounded-xl border border-outline-variant flex items-center gap-3 active:bg-surface-container transition-colors">
          <span class="pd-stripe" style="background: {{ $isDone ? '#3FB68B' : '#F5A623' }};"></span>
          <div class="flex items-center gap-3 flex-1 min-w-0">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 {{ $isDone ? 'bg-secondary-container/20 text-secondary' : 'bg-tertiary-fixed/20 text-tertiary' }}">
              <span class="material-symbols-outlined">person</span>
            </div>
            <div class="min-w-0">
              <p class="font-label-bold text-on-surface truncate">{{ $t->pelanggan?->nama ?? 'Walk-in' }}</p>
              <p class="pd-mono text-[11px] text-primary font-semibold">{{ $t->kode_transaksi }} <span class="font-sans text-on-surface-variant font-normal ml-1">• {{ $t->created_at->format('H:i') }}</span></p>
            </div>
          </div>
          <div class="flex flex-col items-end gap-1 flex-shrink-0">
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase flex items-center {{ $isDone ? 'bg-secondary-container/40 text-on-secondary-container' : 'bg-tertiary-fixed/40 text-on-tertiary-fixed-variant' }}">
              <span class="pd-dot-pulse {{ $isDone ? '' : 'on' }}" style="background: {{ $isDone ? '#3FB68B' : '#F5A623' }};"></span>
              {{ $t->status }}
            </span>
            <p class="font-label-bold text-on-surface">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</p>
          </div>
        </div>
        @empty
        <div class="bg-white p-8 rounded-xl border border-outline-variant text-center">
          <span class="material-symbols-outlined text-outline text-4xl mb-2">receipt_long</span>
          <p class="text-on-surface-variant font-body-base">Belum ada transaksi hari ini</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@section('header')
<header class="flex items-center justify-between h-16 px-container-padding bg-surface-container-lowest border-b border-outline-variant">
  <div class="flex items-center gap-3">
    <div class="pd-drum">
      <span class="pd-drum-spin">
        <i></i><i></i><i></i>
      </span>
    </div>
    <div>
      <p class="font-label-bold text-on-surface-variant leading-none mb-0.5">Halo, Kasir</p>
      <div class="flex items-center gap-1">
        <span class="w-1.5 h-1.5 rounded-full bg-primary pd-dot-pulse on"></span>
        <p class="text-[10px] font-bold text-primary uppercase">Online</p>
      </div>
    </div>
  </div>
  <div class="flex items-center gap-2">
    <button class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:bg-surface-container rounded-full transition-all">
      <span class="material-symbols-outlined">notifications</span>
    </button>
    <button class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:bg-surface-container rounded-full transition-all">
      <span class="material-symbols-outlined">search</span>
    </button>
  </div>
</header>
@endsection

@section('extra')

@endsection