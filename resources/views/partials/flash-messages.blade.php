@if (session('success'))
<div class="fixed top-4 left-4 right-4 z-50 bg-primary text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-label-bold" id="flashMessage">
  <span class="material-symbols-outlined text-[18px]">check_circle</span>
  {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="fixed top-4 left-4 right-4 z-50 bg-error text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm font-label-bold" id="flashError">
  <span class="material-symbols-outlined text-[18px]">error</span>
  {{ session('error') }}
</div>
@endif

@if ($errors->any())
<div class="fixed top-4 left-4 right-4 z-50 bg-error text-white px-4 py-3 rounded-xl shadow-lg text-sm font-label-bold" id="errorsList">
  <div class="flex items-start gap-2">
    <span class="material-symbols-outlined text-[18px] mt-0.5">error</span>
    <ul class="list-disc list-inside">
      @foreach ($errors->all() as $err)
      <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
</div>
@endif
