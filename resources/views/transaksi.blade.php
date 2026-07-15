@extends('layouts.app')

@section('title', 'Transaksi Baru - PoS Laundry')
@section('activeNav', 'transaksi')

@section('content')
<form method="POST" action="{{ route('transaksi.store') }}">
  @csrf

  <section class="flex flex-col gap-4">
    <div class="flex items-center gap-2">
      <span class="material-symbols-outlined text-primary text-[20px]">person</span>
      <h2 class="font-title-sm text-title-sm text-on-surface">Data Pelanggan</h2>
    </div>
    <div class="bg-white p-5 rounded-xl border border-outline-variant flex flex-col gap-4">
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant px-1">Nama Pelanggan</label>
        <input class="h-input-height w-full px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base" placeholder="Contoh: Budi Santoso" type="text" name="pelanggan_nama" required/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant px-1">Nomor Telepon/WA</label>
        <input class="h-input-height w-full px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base" placeholder="0812-3456-7890" type="text" name="pelanggan_telepon"/>
      </div>
    </div>
  </section>

  <section class="flex flex-col gap-4">
    <div class="flex items-center gap-2">
      <span class="material-symbols-outlined text-primary text-[20px]">laundry</span>
      <h2 class="font-title-sm text-title-sm text-on-surface">Detail Layanan</h2>
    </div>
    <div class="bg-white p-5 rounded-xl border border-outline-variant flex flex-col gap-5">
      @if ($layanans->isEmpty())
      <div class="text-center py-4">
        <p class="text-on-surface-variant font-body-base">Belum ada layanan. Tambah layanan dulu di menu Pengaturan.</p>
        <a href="{{ route('pengaturan') }}" class="text-primary font-label-bold mt-2 inline-block">Ke Pengaturan</a>
      </div>
      @else
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant px-1">Jenis Layanan</label>
        <div class="flex flex-col gap-2">
          @foreach ($layanans as $l)
          <label class="flex items-center gap-3 p-3 rounded-lg border border-outline-variant bg-surface-bright cursor-pointer hover:border-primary/50 transition-all">
            <input type="radio" name="jenis_layanan" value="{{ $l->id }}" class="accent-primary" required/>
            <div>
              <span class="font-label-bold text-on-surface">{{ $l->nama }}</span>
              <span class="text-primary font-bold ml-2">Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }}/kg</span>
            </div>
          </label>
          @endforeach
        </div>
      </div>
      @endif
      <div class="grid grid-cols-2 gap-4">
        <div class="flex flex-col gap-1.5">
          <label class="font-label-bold text-label-bold text-on-surface-variant px-1">Berat (kg)</label>
          <input class="h-input-height w-full px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base" placeholder="0.0" step="0.1" type="number" name="berat" required min="0.1"/>
        </div>
        <div class="flex flex-col gap-1.5">
          <label class="font-label-bold text-label-bold text-on-surface-variant px-1">Estimasi Selesai</label>
          <input class="h-input-height w-full px-3 rounded-lg border border-outline-variant bg-surface-bright text-body-base" type="date" name="tanggal_selesai_estimasi" value="{{ date('Y-m-d', strtotime('+1 day')) }}"/>
        </div>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant px-1">Catatan Tambahan</label>
        <textarea class="w-full p-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base resize-none" placeholder="Contoh: Pisahkan baju luntur" rows="2" name="catatan"></textarea>
      </div>
    </div>
  </section>

  <button class="w-full h-12 bg-[#0B4F55] text-white rounded-xl font-label-bold text-label-bold flex items-center justify-center gap-2 active:scale-[0.98] transition-all mt-4" type="submit">
    <span class="material-symbols-outlined text-[20px]">save</span>
    Simpan Transaksi
  </button>

  <div class="h-8"></div>
</form>
@endsection

@section('header')
<header class="bg-surface-container-lowest flex items-center justify-between h-16 px-container-padding border-b border-outline-variant">
  <div class="flex items-center gap-3">
    <a href="javascript:history.back()" class="p-2 -ml-2 rounded-full hover:bg-surface-container transition-colors">
      <span class="material-symbols-outlined text-primary">arrow_back</span>
    </a>
    <h1 class="font-headline-md-mobile text-headline-md-mobile text-primary">Transaksi Baru</h1>
  </div>
</header>
@endsection
