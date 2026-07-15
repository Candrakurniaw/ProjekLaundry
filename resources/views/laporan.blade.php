@extends('layouts.app')

@section('title', 'Laporan Transaksi - PoS Laundry')
@section('activeNav', 'laporan')

@section('content')
<section class="relative overflow-hidden rounded-xl bg-[#0B4F55] p-6 text-white">
  <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
  <div class="relative z-10">
    <p class="font-label-bold text-label-bold opacity-80 uppercase tracking-wider">Total Pendapatan</p>
    <h2 class="font-display-lg text-display-lg mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
    @if ($persenKenaikan != 0)
    <div class="mt-4 flex items-center gap-2 text-primary-fixed font-label-bold text-label-bold bg-white/10 w-fit px-3 py-1 rounded-full">
      <span class="material-symbols-outlined text-[16px]">{{ $persenKenaikan >= 0 ? 'trending_up' : 'trending_down' }}</span>
      <span>{{ $persenKenaikan >= 0 ? '+' : '' }}{{ $persenKenaikan }}% dari bulan lalu</span>
    </div>
    @endif
  </div>
</section>

<section class="space-y-4">
  <h3 class="font-title-sm text-title-sm text-on-surface">Filter Laporan</h3>
  <form method="GET" action="{{ route('laporan') }}" class="grid grid-cols-2 gap-3">
    <div class="space-y-1.5">
      <label class="font-label-bold text-label-bold text-on-surface-variant ml-1">Dari Tanggal</label>
      <input class="w-full h-input-height px-3 rounded-lg border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary transition-all font-body-base text-body-base" type="date" name="dari" value="{{ $dari }}"/>
    </div>
    <div class="space-y-1.5">
      <label class="font-label-bold text-label-bold text-on-surface-variant ml-1">Sampai Tanggal</label>
      <input class="w-full h-input-height px-3 rounded-lg border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary transition-all font-body-base text-body-base" type="date" name="sampai" value="{{ $sampai }}"/>
    </div>
    <div class="col-span-2">
      <button class="w-full h-input-height bg-[#0B4F55] text-white font-label-bold text-label-bold rounded-lg active:scale-[0.98] transition-all" type="submit">Terapkan Filter</button>
    </div>
  </form>
</section>

<section class="space-y-4">
  <div class="flex items-center justify-between">
    <h3 class="font-title-sm text-title-sm text-on-surface">Riwayat Transaksi</h3>
    <span class="font-label-bold text-label-bold text-primary">{{ $totalTransaksi }} Transaksi</span>
  </div>
  <div class="space-y-3 pb-24">
    @forelse ($transaksis as $t)
    <div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant flex items-center justify-between active:scale-[0.98] transition-transform">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center {{ $t->status === 'selesai' || $t->status === 'diambil' ? 'text-primary' : 'text-tertiary' }}">
          <span class="material-symbols-outlined">receipt_long</span>
        </div>
        <div>
          <p class="font-label-bold text-label-bold text-on-surface-variant">#{{ $t->kode_transaksi }}</p>
          <p class="font-title-sm text-title-sm text-on-surface">{{ $t->pelanggan?->nama ?? 'Walk-in' }}</p>
          <div class="flex items-center gap-2 mt-1">
            <span class="px-2 py-0.5 rounded-full font-label-bold text-[10px] uppercase {{ $t->status === 'selesai' || $t->status === 'diambil' ? 'bg-secondary-container text-on-secondary-container' : 'bg-tertiary-fixed text-on-tertiary-fixed-variant' }}">{{ $t->status }}</span>
          </div>
        </div>
      </div>
      <div class="text-right">
        <p class="font-title-sm text-title-sm text-primary">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</p>
        <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $t->created_at->format('H:i') }} WIB</p>
      </div>
    </div>
    @empty
    <div class="bg-surface-container-lowest p-8 rounded-xl border border-outline-variant text-center">
      <span class="material-symbols-outlined text-outline text-4xl mb-2">receipt_long</span>
      <p class="text-on-surface-variant font-body-base">Tidak ada transaksi pada periode ini</p>
    </div>
    @endforelse
  </div>
</section>
@endsection

@section('header')
<header class="bg-surface-container-lowest flex items-center justify-between h-16 px-container-padding border-b border-outline-variant">
  <h1 class="font-headline-md-mobile text-headline-md-mobile text-primary">Laporan</h1>
  <div class="flex items-center gap-4">
    <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-high transition-colors">
      <span class="material-symbols-outlined text-on-surface-variant">calendar_today</span>
    </button>
    <div class="w-10 h-10 rounded-full bg-primary/10 border border-outline-variant flex items-center justify-center">
      <span class="material-symbols-outlined text-primary">person</span>
    </div>
  </div>
</header>
@endsection

@section('extra')
<button class="fixed bottom-20 right-6 w-14 h-14 bg-primary text-white rounded-full shadow-lg flex items-center justify-center active:scale-95 transition-transform">
  <span class="material-symbols-outlined">file_download</span>
</button>
<script>
window.addEventListener('scroll', () => {
  const header = document.querySelector('header');
  header.classList.toggle('shadow-md', window.scrollY > 10);
});
</script>
@endsection
