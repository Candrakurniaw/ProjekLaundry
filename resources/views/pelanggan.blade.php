@extends('layouts.app')

@section('title', 'Manajemen Pelanggan - PoS Laundry')
@section('activeNav', 'pelanggan')

@section('content')
<section>
  <div class="flex gap-4 overflow-x-auto no-scrollbar pb-2">
    <div class="min-w-[160px] bg-white border border-outline-variant p-4 rounded-xl">
      <div class="flex items-center gap-2 mb-2">
        <span class="material-symbols-outlined text-primary text-sm">group</span>
        <span class="font-label-bold text-label-bold text-on-surface-variant">Total</span>
      </div>
      <div class="font-headline-md text-headline-md text-on-surface">{{ number_format($totalPelanggan) }}</div>
    </div>
    <div class="min-w-[160px] bg-white border border-outline-variant p-4 rounded-xl">
      <div class="flex items-center gap-2 mb-2">
        <span class="material-symbols-outlined text-secondary text-sm">person_add</span>
        <span class="font-label-bold text-label-bold text-on-surface-variant">Bulan Ini</span>
      </div>
      <div class="font-headline-md text-headline-md text-on-surface">{{ $pelangganBulanIni }}</div>
    </div>
  </div>
</section>

<section class="flex gap-2">
  <div class="relative flex-1">
    <input class="w-full h-10 px-4 pl-10 bg-white border border-outline-variant rounded-lg font-body-base text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" placeholder="Cari pelanggan..." type="text" id="searchPelanggan" onkeyup="filterPelanggan()"/>
    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
  </div>
</section>

<section class="space-y-4">
  <div class="flex items-center justify-between mb-2">
    <h2 class="font-title-sm text-title-sm text-on-surface">Daftar Pelanggan</h2>
    <span class="font-body-sm text-body-sm text-on-surface-variant">{{ $pelanggans->total() }} Pelanggan</span>
  </div>

  @if ($pelanggans->isEmpty())
  <div class="bg-white p-8 rounded-xl border border-outline-variant text-center">
    <span class="material-symbols-outlined text-outline text-4xl mb-2">person</span>
    <p class="text-on-surface-variant font-body-base">Belum ada pelanggan. Tambah pelanggan baru dengan tombol +</p>
  </div>
  @else
  @foreach ($pelanggans as $p)
  <div class="bg-white border border-outline-variant rounded-xl p-4 flex flex-col gap-3 card-pelanggan" data-nama="{{ strtolower($p->nama) }}">
    <div class="flex justify-between items-start">
      <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-full border border-outline-variant bg-surface-container flex items-center justify-center">
          <span class="material-symbols-outlined text-outline">person</span>
        </div>
        <div>
          <h3 class="font-title-sm text-title-sm text-on-surface nama-pelanggan">{{ $p->nama }}</h3>
          <p class="font-label-bold text-label-bold text-primary">{{ $p->kode_pelanggan }}</p>
        </div>
      </div>
      <div class="flex gap-2">
        <button class="w-8 h-8 rounded-lg border border-outline-variant flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-all" onclick="openEdit({{ $p->id }}, '{{ addslashes($p->nama) }}', '{{ addslashes($p->no_telepon ?? '') }}', '{{ addslashes($p->alamat ?? '') }}')">
          <span class="material-symbols-outlined text-[18px]">edit</span>
        </button>
        <form method="POST" action="{{ route('pelanggan.destroy', $p) }}" onsubmit="return confirm('Hapus pelanggan ini?')" class="inline">
          @csrf
          @method('DELETE')
          <button class="w-8 h-8 rounded-lg border border-error/20 bg-error-container/20 flex items-center justify-center text-error hover:bg-error-container/40 transition-all">
            <span class="material-symbols-outlined text-[18px]">delete</span>
          </button>
        </form>
      </div>
    </div>
    <div class="space-y-1 border-t border-outline-variant pt-3">
      @if ($p->no_telepon)
      <div class="flex items-center gap-2 text-on-surface-variant">
        <span class="material-symbols-outlined text-[16px]">call</span>
        <span class="font-body-base text-body-base">{{ $p->no_telepon }}</span>
      </div>
      @endif
      @if ($p->alamat)
      <div class="flex items-start gap-2 text-on-surface-variant">
        <span class="material-symbols-outlined text-[16px] mt-0.5">location_on</span>
        <span class="font-body-base text-body-base">{{ $p->alamat }}</span>
      </div>
      @endif
    </div>
  </div>
  @endforeach
  @endif
</section>

<!-- Modal Tambah Pelanggan -->
<div class="fixed inset-0 bg-black/40 z-50 hidden flex items-end justify-center" id="modalTambah">
  <div class="bg-white w-full max-w-lg rounded-t-3xl p-6 max-h-[90vh] overflow-y-auto animate-slide-up">
    <div class="flex items-center justify-between mb-6">
      <h2 class="font-title-sm text-title-sm text-on-surface">Tambah Pelanggan</h2>
      <button class="p-2 hover:bg-surface-container rounded-full" onclick="closeModal('modalTambah')">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    <form method="POST" action="{{ route('pelanggan.store') }}" class="flex flex-col gap-4">
      @csrf
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Nama Lengkap</label>
        <input class="h-input-height px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="text" name="nama" required/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Nomor Telepon</label>
        <input class="h-input-height px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="text" name="no_telepon" placeholder="0812-3456-7890"/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Alamat</label>
        <textarea class="p-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none resize-none" name="alamat" rows="2"></textarea>
      </div>
      <button class="h-input-height bg-primary text-white font-label-bold text-label-bold rounded-lg active:scale-[0.98] transition-all mt-2" type="submit">Simpan</button>
    </form>
  </div>
</div>

<!-- Modal Edit Pelanggan -->
<div class="fixed inset-0 bg-black/40 z-50 hidden flex items-end justify-center" id="modalEdit">
  <div class="bg-white w-full max-w-lg rounded-t-3xl p-6 max-h-[90vh] overflow-y-auto animate-slide-up">
    <div class="flex items-center justify-between mb-6">
      <h2 class="font-title-sm text-title-sm text-on-surface">Edit Pelanggan</h2>
      <button class="p-2 hover:bg-surface-container rounded-full" onclick="closeModal('modalEdit')">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    <form method="POST" action="" class="flex flex-col gap-4" id="formEdit">
      @csrf
      @method('PUT')
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Nama Lengkap</label>
        <input class="h-input-height px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="text" name="nama" id="editNama" required/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Nomor Telepon</label>
        <input class="h-input-height px-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none" type="text" name="no_telepon" id="editTelepon"/>
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="font-label-bold text-label-bold text-on-surface-variant">Alamat</label>
        <textarea class="p-4 rounded-lg border border-outline-variant bg-surface-bright text-body-base focus:ring-2 focus:ring-primary focus:border-primary outline-none resize-none" name="alamat" id="editAlamat" rows="2"></textarea>
      </div>
      <button class="h-input-height bg-primary text-white font-label-bold text-label-bold rounded-lg active:scale-[0.98] transition-all mt-2" type="submit">Simpan Perubahan</button>
    </form>
  </div>
</div>

<style>
.animate-slide-up { animation: slideUp 0.3s ease-out; }
@keyframes slideUp { from { transform: translateY(100%); } to { transform: translateY(0); } }
</style>

<script>
function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

function openEdit(id, nama, telepon, alamat) {
  document.getElementById('editNama').value = nama;
  document.getElementById('editTelepon').value = telepon;
  document.getElementById('editAlamat').value = alamat;
  document.getElementById('formEdit').action = '{{ url('/pelanggan') }}/' + id;
  openModal('modalEdit');
}

function filterPelanggan() {
  const q = document.getElementById('searchPelanggan').value.toLowerCase();
  document.querySelectorAll('.card-pelanggan').forEach(card => {
    card.style.display = card.dataset.nama.includes(q) ? '' : 'none';
  });
}

document.getElementById('modalTambah').addEventListener('click', function(e) {
  if (e.target === this) closeModal('modalTambah');
});
document.getElementById('modalEdit').addEventListener('click', function(e) {
  if (e.target === this) closeModal('modalEdit');
});
</script>
@endsection

@section('header')
<header class="bg-surface-container-lowest px-container-padding h-16 flex items-center justify-between border-b border-outline-variant">
  <div class="flex items-center gap-3">
    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white">
      <span class="material-symbols-outlined">person</span>
    </div>
    <div>
      <h1 class="font-headline-md-mobile text-headline-md-mobile text-primary">Pelanggan</h1>
      <p class="font-body-sm text-body-sm text-on-surface-variant">PoS Laundry Management</p>
    </div>
  </div>
</header>
@endsection

@section('extra')
<button class="fixed bottom-24 right-6 w-14 h-14 bg-primary text-white rounded-full shadow-lg flex items-center justify-center active:scale-95 transition-transform z-40" onclick="openModal('modalTambah')">
  <span class="material-symbols-outlined text-[32px]">add</span>
</button>
@endsection
