<!DOCTYPE html>
<html lang="it" class="bg-mao-bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mau House 44 — Appartamento di lusso nel centro storico di Palermo. Prenota direttamente su WhatsApp.">
    <meta name="theme-color" content="#16A34A">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mau House 44 — Palermo')</title>

    <!-- Favicon & PWA -->
    <link rel="icon" type="image/png" href="/images/icon-192.png">
    <link rel="apple-touch-icon" href="/images/icon-192.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Mau House 44">

    <!-- Preconnect fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
    @stack('styles')

    <!-- iubenda Privacy Controls & Cookie Solution -->
    <script type="text/javascript" src="https://embeds.iubenda.com/widgets/595bd553-c1d2-4a46-9df7-3791621feeb3.js" async></script>
</head>
<body class="bg-mao-bg text-mao-cream overflow-x-hidden" style="background:#08060A;color:#F5EFE6;">

{{-- ════════════════════════════════════════
     LOADER
════════════════════════════════════════ --}}
<div id="loader">
    <div class="loader-cat">
        <div class="loader-ring"></div>
        <div class="loader-ring-2"></div>
        <img src="/images/logo.png" alt="Mau House Logo" style="width:80px;height:80px;object-fit:contain;">
    </div>
    <div class="text-center">
        <div class="loader-title">MAU <span>HOUSE</span></div>
        <div class="loader-sub" style="margin-top:0.35rem;">Palermo &nbsp;·&nbsp; Appartamento 44</div>
    </div>
    <div class="loader-dots">
        <span></span><span></span><span></span>
    </div>
</div>

{{-- ════════════════════════════════════════
     NAVBAR COMPONENT
════════════════════════════════════════ --}}
@include('components.navbar')

{{-- ════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ --}}
<main>
    @yield('content')
</main>

{{-- ════════════════════════════════════════
     FOOTER COMPONENT
════════════════════════════════════════ --}}
@include('components.footer')

</body>
</html>
