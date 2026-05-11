@extends('layouts.master')

@section('title', 'Pendaftaran Berhasil - ' . config('app.name'))
@section('eyebrow', 'Registrasi Selesai')
@section('page_title', 'Peserta Berhasil Terdaftar.')
@section('page_description', 'Simpan nomor BIB dan token registrasi ini sebagai bukti pendaftaran resmi Event Federal.')

@section('content')
<div class="rounded-lg border border-white/20 bg-white p-6 text-center shadow-2xl shadow-slate-950/30 sm:p-8">
    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 text-3xl font-black text-emerald-600">
        ✓
    </div>

    <h2 class="mt-5 text-3xl font-black text-slate-950">
        Pendaftaran Berhasil
    </h2>

    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
        Data peserta sudah masuk ke sistem. Berikut detail pendaftaran yang bisa digunakan saat verifikasi.
    </p>

    <div class="mt-7 grid gap-3 text-left">
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
            <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                Nama
            </div>
            <div class="mt-1 text-lg font-bold text-slate-950">
                {{ $participant->name }}
            </div>
        </div>

        <div class="rounded-lg border border-teal-200 bg-teal-50 p-5 text-center">
            <div class="text-xs font-semibold uppercase tracking-[0.16em] text-teal-700">
                Nomor BIB
            </div>
            <div class="mt-2 text-5xl font-black text-teal-700">
                {{ $participant->bib_number }}
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
            <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                Komunitas
            </div>
            <div class="mt-1 text-lg font-bold text-slate-950">
                {{ $participant->community ?: '-' }}
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-slate-950 p-4 text-left">
            <div class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">
                QR Token
            </div>

            <div class="mt-4 flex justify-center">
                <div class="rounded-lg bg-white p-4 shadow-lg shadow-slate-950/20">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(220)->margin(1)->generate($participant->qr_token) !!}
                </div>
            </div>

            <div class="mt-2 break-all font-mono text-sm leading-6 text-teal-200">
                {{ $participant->qr_token }}
            </div>
        </div>
    </div>

    <a
        href="{{ route('participants.create') }}"
        class="mt-7 inline-flex w-full items-center justify-center rounded-lg bg-teal-600 px-5 py-3.5 text-base font-bold text-white shadow-lg shadow-teal-600/25 transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/25 sm:w-auto"
    >
        Daftarkan Peserta Lain
    </a>
</div>
@endsection
