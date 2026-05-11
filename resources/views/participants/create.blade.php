@extends('layouts.master')

@section('title', 'Registrasi Peserta - ' . config('app.name'))
@section('eyebrow', 'Formulir Registrasi')
@section('page_title', 'Amankan Nomor Peserta Event Federal.')
@section('page_description', 'Isi data dengan benar agar tim panitia bisa memvalidasi peserta, kontak darurat, dan nomor BIB tanpa hambatan.')

@section('content')
<div class="rounded-lg border border-white/20 bg-white p-6 shadow-2xl shadow-slate-950/30 sm:p-8">
    <div class="mb-7">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-teal-600">
            Registrasi Peserta
        </p>
        <h2 class="mt-2 text-2xl font-black text-slate-950">
            Data Peserta
        </h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">
            Kolom bertanda wajib perlu diisi sebelum pendaftaran dikirim.
        </p>
    </div>

    <form action="{{ route('participants.store') }}" method="POST" class="space-y-5">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Nama Lengkap <span class="text-orange-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10"
                    placeholder="Masukkan nama sesuai identitas"
                    required
                >

                @error('name')
                    <div class="mt-2 text-sm font-medium text-red-600">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Komunitas
                </label>

                <input
                    type="text"
                    name="community"
                    value="{{ old('community') }}"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10"
                    placeholder="Nama komunitas"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Tanggal Lahir
                </label>

                <input
                    type="date"
                    name="birth_date"
                    value="{{ old('birth_date') }}"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Nomor HP <span class="text-orange-500">*</span>
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10"
                    placeholder="08xxxxxxxxxx"
                    required
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Kontak Darurat
                </label>

                <input
                    type="text"
                    name="emergency_contact"
                    value="{{ old('emergency_contact') }}"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10"
                    placeholder="Nama atau nomor keluarga"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Golongan Darah
                </label>

                <select
                    name="blood_type"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10"
                >
                    <option value="">Pilih golongan darah</option>

                    @foreach ([
                        'A','B','AB','O',
                        'A+','B+','AB+','O+',
                        'A-','B-','AB-','O-'
                    ] as $blood)
                        <option
                            value="{{ $blood }}"
                            @selected(old('blood_type') == $blood)
                        >
                            {{ $blood }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Alamat
                </label>

                <textarea
                    name="address"
                    rows="4"
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10"
                    placeholder="Alamat domisili peserta"
                >{{ old('address') }}</textarea>
            </div>
        </div>

        <button
            type="submit"
            class="flex w-full items-center justify-center rounded-lg bg-teal-600 px-5 py-3.5 text-base font-bold text-white shadow-lg shadow-teal-600/25 transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/25"
        >
            Daftar Sekarang
        </button>
    </form>
</div>
@endsection
