@php $activeNav = $activeNav ?? 'dashboard'; @endphp
@php
$navItems = [
  'dashboard' => ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'dashboard'],
  'transaksi' => ['label' => 'Transaksi', 'icon' => 'receipt_long', 'route' => 'transaksi'],
  'pelanggan' => ['label' => 'Pelanggan', 'icon' => 'person', 'route' => 'pelanggan'],
  'laporan'   => ['label' => 'Laporan', 'icon' => 'assessment', 'route' => 'laporan'],
  'pengaturan'=> ['label' => 'Pengaturan', 'icon' => 'settings', 'route' => 'pengaturan'],
];
@endphp
<nav class="fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-outline-variant flex items-center justify-around px-2 z-50 pb-[env(safe-area-inset-bottom)]">
  @foreach ($navItems as $key => $item)
  @php $isActive = $key === $activeNav; @endphp
  <a class="flex flex-col items-center justify-center w-full h-full {{ $isActive ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}" href="{{ route($item['route']) }}">
    <span class="material-symbols-outlined mb-0.5" @if($isActive) style="font-variation-settings: 'FILL' 1;" @endif>{{ $item['icon'] }}</span>
    <span class="text-[10px] font-label-bold">{{ $item['label'] }}</span>
  </a>
  @endforeach
</nav>
