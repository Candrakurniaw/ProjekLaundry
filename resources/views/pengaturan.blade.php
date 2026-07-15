@extends('layouts.app')

@section('title', 'PoS Laundry - Pengaturan')
@section('activeNav', 'pengaturan')

@section('content')
<div class="flex bg-surface-container-low p-1 rounded-xl gap-1">
  <button class="flex-1 py-2 text-center rounded-lg font-label-bold text-label-bold transition-all bg-[#0B4F55] text-white" id="tab-profile" onclick="switchTab('profile')">Profil</button>
  <button class="flex-1 py-2 text-center rounded-lg font-label-bold text-label-bold transition-all text-black" id="tab-price" onclick="switchTab('price')">Layanan</button>
  <button class="flex-1 py-2 text-center rounded-lg font-label-bold text-label-bold transition-all text-black" id="tab-cashier" onclick="switchTab('cashier')">Kasir</button>
</div>

<section class="space-y-4" id="section-profile">
  <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant">
    <h2 class="font-title-sm text-title-sm text-primary mb-4">Profil Toko</h2>
    <div class="flex flex-col items-center mb-6">
      <div class="w-24 h-24 rounded-full bg-primary-fixed flex items-center justify-center border-4 border-surface-container-lowest overflow-hidden">
        <span class="material-symbols-outlined text-4xl text-on-primary-fixed">store</span>
      </div>
    </div>
    <form method="POST" action="" class="space-y-4">
      @csrf
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Nama Toko</label>
        <input class="h-input-height px-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all font-body-base text-body-base" type="text" value="PoS Laundry Kebon Jeruk" name="nama_toko" disabled/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Nomor Telepon</label>
        <input class="h-input-height px-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all font-body-base text-body-base" type="tel" value="0812-3456-7890" name="telepon" disabled/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Alamat Lengkap</label>
        <textarea class="p-3 rounded-lg border border-outline-variant focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all font-body-base text-body-base h-24" name="alamat" disabled>Jl. Panjang No. 88, Kebon Jeruk, Jakarta Barat, 11530</textarea>
      </div>
    </form>
  </div>
</section>

<section class="hidden space-y-4" id="section-price">
  <div class="flex items-center justify-between">
    <h2 class="font-title-sm text-title-sm text-primary">Daftar Layanan</h2>
    <button class="flex items-center gap-1 text-primary font-label-bold text-label-bold" onclick="openTambahLayanan()">
      <span class="material-symbols-outlined text-sm">add_circle</span> Tambah
    </button>
  </div>
  <div class="space-y-3">
    @if ($layanans->isEmpty())
    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant text-center">
      <p class="text-on-surface-variant font-body-base">Belum ada layanan. Tambah layanan baru.</p>
    </div>
    @else
    @foreach ($layanans as $l)
    <div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant flex items-center justify-between">
      <div>
        <p class="font-label-bold text-label-bold text-on-surface">{{ $l->nama }}</p>
        <p class="text-primary font-bold">Rp {{ number_format($l->harga_per_kg, 0, ',', '.') }} /kg</p>
        <p class="text-[10px] text-on-surface-variant">Estimasi {{ $l->estimasi_jam }} jam</p>
      </div>
      <div class="flex gap-2">
        <button class="p-2 text-on-surface-variant hover:text-primary transition-colors" onclick="openEditLayanan({{ $l->id }}, '{{ addslashes($l->nama) }}', {{ $l->harga_per_kg }}, {{ $l->estimasi_jam }})">
          <span class="material-symbols-outlined text-xl">edit</span>
        </button>
        <form method="POST" action="{{ route('pengaturan.layanan.destroy', $l) }}" onsubmit="return confirm('Hapus layanan ini?')" class="inline">
          @csrf
          @method('DELETE')
          <button class="p-2 text-on-surface-variant hover:text-error transition-colors">
            <span class="material-symbols-outlined text-xl">delete</span>
          </button>
        </form>
      </div>
    </div>
    @endforeach
    @endif
  </div>
</section>

<section class="hidden space-y-4" id="section-cashier">
  <div class="flex items-center justify-between">
    <h2 class="font-title-sm text-title-sm text-primary">Akun Kasir Aktif</h2>
    <button class="flex items-center gap-1 text-primary font-label-bold text-label-bold">
      <span class="material-symbols-outlined text-sm">person_add</span> Tambah Kasir
    </button>
  </div>
  <div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden">
    <div class="p-4 border-b border-outline-variant flex items-center gap-4">
      <div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed font-bold">RN</div>
      <div class="flex-1">
        <p class="font-label-bold text-label-bold text-on-surface">Rina Nurhayati</p>
        <div class="flex items-center gap-1">
          <span class="w-2 h-2 rounded-full bg-primary"></span>
          <span class="text-[10px] text-on-surface-variant uppercase tracking-wider font-bold">Aktif Sekarang</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Tambah/Edit Layanan -->
<div class="fixed inset-0 bg-black/40 z-50 hidden flex items-end justify-center" id="modalLayanan">
  <div class="bg-white w-full max-w-lg rounded-t-3xl p-6 max-h-[90vh] overflow-y-auto animate-slide-up">
    <div class="flex items-center justify-between mb-6">
      <h2 class="font-title-sm text-title-sm text-on-surface" id="modalLayananTitle">Tambah Layanan</h2>
      <button class="p-2 hover:bg-surface-container rounded-full" onclick="closeModal('modalLayanan')">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    <form method="POST" action="" class="flex flex-col gap-4" id="formLayanan">
      @csrf
      <input type="hidden" name="_method" id="layananMethod" value="POST">
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Nama Layanan</label>
        <input class="h-input-height px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="text" name="nama" id="layananNama" required placeholder="Contoh: Cuci Kering"/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Harga per Kg (Rp)</label>
        <input class="h-input-height px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="number" name="harga_per_kg" id="layananHarga" required min="0"/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Estimasi (jam)</label>
        <input class="h-input-height px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="number" name="estimasi_jam" id="layananEstimasi" required min="1" value="24"/>
      </div>
      <button class="h-input-height bg-primary text-white font-label-bold text-label-bold rounded-lg active:scale-[0.98] transition-all mt-2" type="submit" id="btnSimpanLayanan">Simpan</button>
    </form>
  </div>
</div>

<style>
.animate-slide-up { animation: slideUp 0.3s ease-out; }
@keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
</style>

<script>
function switchTab(tab) {
  ['profile','price','cashier'].forEach(t => {
    document.getElementById('section-' + t).classList.add('hidden');
    const btn = document.getElementById('tab-' + t);
    btn.classList.remove('bg-[#0B4F55]', 'text-white');
    btn.classList.add('text-black');
  });
  document.getElementById('section-' + tab).classList.remove('hidden');
  const activeBtn = document.getElementById('tab-' + tab);
  activeBtn.classList.remove('text-black');
  activeBtn.classList.add('bg-[#0B4F55]', 'text-white');
}

function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function openTambahLayanan() {
  document.getElementById('modalLayananTitle').textContent = 'Tambah Layanan';
  document.getElementById('layananNama').value = '';
  document.getElementById('layananHarga').value = '';
  document.getElementById('layananEstimasi').value = '24';
  document.getElementById('formLayanan').action = '{{ route('pengaturan.layanan.store') }}';
  document.getElementById('layananMethod').value = 'POST';
  document.getElementById('btnSimpanLayanan').textContent = 'Simpan';
  openModal('modalLayanan');
}

function openEditLayanan(id, nama, harga, estimasi) {
  document.getElementById('modalLayananTitle').textContent = 'Edit Layanan';
  document.getElementById('layananNama').value = nama;
  document.getElementById('layananHarga').value = harga;
  document.getElementById('layananEstimasi').value = estimasi;
  document.getElementById('formLayanan').action = '{{ url('/pengaturan/layanan') }}/' + id;
  document.getElementById('layananMethod').value = 'PUT';
  document.getElementById('btnSimpanLayanan').textContent = 'Simpan Perubahan';
  openModal('modalLayanan');
}

document.getElementById('modalLayanan').addEventListener('click', function(e) {
  if (e.target === this) closeModal('modalLayanan');
});
</script>
@endsection

@section('header')
<header class="bg-surface-container-lowest px-container-padding h-16 flex items-center justify-between border-b border-outline-variant">
  <h1 class="font-headline-md-mobile text-headline-md-mobile text-primary">Pengaturan</h1>
  <div class="flex items-center gap-3">
    <div class="w-8 h-8 rounded-full border border-outline-variant bg-primary/10 flex items-center justify-center">
      <span class="material-symbols-outlined text-primary text-sm">person</span>
    </div>
  </div>
</header>
@endsection
