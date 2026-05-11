<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 font-sans text-slate-900 antialiased">
    <div class="min-h-screen overflow-hidden bg-[radial-gradient(circle_at_top_left,_rgba(20,184,166,0.22),_transparent_34%),radial-gradient(circle_at_85%_15%,_rgba(249,115,22,0.18),_transparent_28%),linear-gradient(135deg,_#020617_0%,_#0f172a_52%,_#111827_100%)]">
        <header class="relative z-10 border-b border-white/10 bg-white/5 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4 sm:px-6 lg:px-8">
                <a href="#" class="flex items-center gap-3 text-white">
                    <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-teal-400 text-lg font-black text-slate-950 shadow-lg shadow-teal-500/20">
                        EF
                    </span>
                    <span>
                        <span class="block text-sm font-semibold uppercase tracking-[0.2em] text-teal-100">Event Federal</span>
                        <span class="block text-xs text-slate-300">Participant Registration</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-2 text-sm font-medium text-slate-200 sm:flex">
                    <a href="{{ route('participants.create') }}" class="rounded-lg px-4 py-2 transition hover:bg-white/10 hover:text-white">
                        Registrasi
                    </a>
                </nav>
            </div>
        </header>

        <main class="relative z-10 mx-auto grid min-h-[calc(100vh-80px)] w-full max-w-6xl items-center gap-8 px-5 py-10 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <section class="text-white">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-teal-300/30 bg-teal-300/10 px-4 py-2 text-sm font-semibold text-teal-100">
                    <span class="h-2 w-2 rounded-full bg-teal-300"></span>
                    @yield('eyebrow', 'Pendaftaran Peserta')
                </div>

                <h1 class="max-w-xl text-4xl font-black leading-tight sm:text-5xl">
                    @yield('page_title', 'Daftar Lebih Cepat, Data Lebih Rapi.')
                </h1>

                <p class="mt-5 max-w-lg text-base leading-7 text-slate-300">
                    @yield('page_description', 'Lengkapi data peserta untuk mendapatkan nomor BIB dan token registrasi resmi event.')
                </p>

                <div class="mt-8 grid max-w-lg grid-cols-3 gap-3">
                    <div class="rounded-lg border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <div class="text-2xl font-black text-teal-200">01</div>
                        <div class="mt-1 text-xs font-medium text-slate-300">Isi Data</div>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <div class="text-2xl font-black text-orange-200">02</div>
                        <div class="mt-1 text-xs font-medium text-slate-300">Verifikasi</div>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/10 p-4 backdrop-blur">
                        <div class="text-2xl font-black text-sky-200">03</div>
                        <div class="mt-1 text-xs font-medium text-slate-300">Dapat BIB</div>
                    </div>
                </div>
            </section>

            <section class="w-full">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
