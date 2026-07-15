<!DOCTYPE html>
<html class="light" lang="id">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
  <title>@yield('title', 'PoS Laundry')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-on-surface @yield('bodyClass')">
  @yield('header')
  @include('partials.flash-messages')
  <main class="@yield('mainClass', 'min-h-screen safe-bottom')">
    @if (!isset($noWrapper) || !$noWrapper)
    <div class="p-container-padding space-y-gutter">
    @endif
      @yield('content')
    @if (!isset($noWrapper) || !$noWrapper)
    </div>
    @endif
  </main>
  @if (!isset($showBottomNav) || $showBottomNav)
  @include('partials.bottom-nav')
  @endif
  @yield('extra')
</body>
</html>
