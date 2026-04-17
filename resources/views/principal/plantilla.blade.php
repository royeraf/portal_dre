<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="Cristian Figueroa Ferrer" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $mititulo ?? 'DIRECCION REGIONAL DE EDUCACION HUANUCO' }}">
    <meta name="keywords" content="todo respecto a DRE Huanuco">

    <title>@yield('title', 'DIRECCION REGIONAL DE EDUCACION - HUANUCO')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/log33.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..700;1,300..700&display=swap">


    {{-- Icons: Lucide (loaded via npm/Vite in app.js) --}}

    {{-- Tailwind CSS + Alpine.js via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script>if(!/jsid=/.test(document.cookie)){document.cookie='jsid=1;path=/;SameSite=Lax';}</script>
</head>
<body class="min-h-screen flex flex-col overflow-x-hidden">

{{-- Social sidebar --}}
<div class="fixed left-0 top-60 z-50 hidden sm:flex flex-col rounded-r-lg overflow-hidden shadow-lg" id="social-sidebar">
    <a href="https://www.facebook.com/direccionregionaldeeducacion/?locale=es_LA" target="_blank"
       class="flex items-center justify-center w-10 h-10 bg-[#3b5998] text-white hover:w-14 transition-all duration-300" title="Facebook">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
    </a>
    <a href="https://www.tiktok.com/@drehuanuco" target="_blank"
       class="flex items-center justify-center w-10 h-10 bg-black text-white hover:w-14 transition-all duration-300" title="TikTok">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1 0-5.78c.29 0 .57.04.84.12v-3.5a6.37 6.37 0 0 0-.84-.05A6.34 6.34 0 0 0 3.15 15.3 6.34 6.34 0 0 0 9.49 21.65a6.34 6.34 0 0 0 6.34-6.34V9.06a8.16 8.16 0 0 0 4.77 1.52V7.13a4.82 4.82 0 0 1-1.01-.44z"/></svg>
    </a>
    <a href="mailto:rcoronel@drehuanuco.gob.pe"
       class="flex items-center justify-center w-10 h-10 bg-gray-600 text-white hover:w-14 transition-all duration-300" title="Correo">
        <i data-lucide="mail" class="w-4 h-4"></i>
    </a>
</div>

@include('principal.header')

<main class="flex-1">
    @yield('content')
</main>

@include('principal.footer')

@stack('scripts')
</body>
</html>
