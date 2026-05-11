<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print BIB {{ $participant->bib_number }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #ffffff !important;
            }

            .bib-card {
                box-shadow: none !important;
                break-inside: avoid;
            }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-950">
    <div class="no-print mx-auto flex max-w-5xl items-center justify-between gap-3 px-5 py-4">
        <a
            href="{{ route('admin.participants.index') }}"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
            Back
        </a>

        <button
            type="button"
            onclick="window.print()"
            class="rounded-lg bg-teal-600 px-5 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-teal-700"
        >
            Print BIB
        </button>
    </div>

    <main class="mx-auto max-w-5xl px-5 pb-8 print:px-0 print:pb-0">
        <section class="bib-card overflow-hidden rounded-lg border-4 border-slate-950 bg-white shadow-2xl">
            <div class="min-h-[420px] p-8">
                <div class="flex items-start justify-between gap-6 border-b-4 border-slate-950 pb-6">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.24em] text-teal-700">
                            {{ config('app.name') }}
                        </p>
                       
                    </div>

                    <div class="rounded-lg bg-slate-950 px-5 py-4 text-right text-white">
                        <div class="text-xs font-bold uppercase tracking-[0.18em] text-teal-200">
                            Blood Type
                        </div>
                        <div class="mt-1 text-3xl font-black">
                            {{ $participant->blood_type ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-[1fr_230px] items-center gap-8 py-8">
                    <div>
                        <div class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">
                            NO BIB
                        </div>
                        <h1 class="mt-3 text-8xl font-black leading-none tracking-normal text-slate-950">
                            {{ $participant->bib_number }}
                        </h1>

                        <div class="mt-6">
                            <div class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">
                                Participant
                            </div>
                            <div class="mt-2 text-3xl font-black text-slate-950">
                                {{ $participant->name }}
                            </div>
                            <div class="mt-1 text-lg font-semibold text-slate-600">
                                {{ $participant->community ?: 'Independent Participant' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="rounded-lg border-2 border-slate-950 bg-white p-4">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(190)->margin(1)->generate($participant->qr_token) !!}
                        </div>
                        <div class="mt-3 text-center text-xs font-bold uppercase tracking-[0.18em] text-slate-500">
                            Scan Checkpoint
                        </div>
                    </div>
                </div>

                <div class="border-t-2 border-slate-200 pt-5">
                    <div class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">
                        Sponsor
                    </div>
                    <div class="grid grid-cols-4 gap-3">
                        @foreach ($sponsors as $sponsor)
                            <div class="flex min-h-16 items-center justify-center rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 px-3 text-center text-xs font-black uppercase tracking-wide text-slate-500">
                                {{ $sponsor }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
