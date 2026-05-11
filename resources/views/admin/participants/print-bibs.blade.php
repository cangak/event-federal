<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print BIB Massal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #ffffff !important;
            }

            .print-page {
                page-break-after: always;
                box-shadow: none !important;
            }

            .print-page:last-child {
                page-break-after: auto;
            }

            .bib-card {
                break-inside: avoid;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-950">
    <div class="no-print mx-auto flex max-w-4xl items-center justify-between gap-3 px-5 py-4">
        <a
            href="{{ route('admin.participants.index', $search ? ['search' => $search] : []) }}"
            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
            Back
        </a>

        <div class="flex items-center gap-3">
            <span class="text-sm font-semibold text-slate-600">
                {{ $participants->count() }} peserta
            </span>
            <button
                type="button"
                onclick="window.print()"
                class="rounded-lg bg-teal-600 px-5 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-teal-700"
            >
                Print Semua
            </button>
        </div>
    </div>

    <main class="mx-auto max-w-[210mm] px-4 pb-8 print:px-0 print:pb-0">
        @forelse ($participants->chunk(2) as $participantPage)
            <section class="print-page mb-6 grid min-h-[281mm] grid-rows-2 gap-4 rounded-lg bg-white p-4 shadow-xl print:mb-0 print:min-h-0 print:rounded-none print:p-0">
                @foreach ($participantPage as $participant)
                    <article class="bib-card overflow-hidden rounded-lg border-4 border-slate-950 bg-white">
                        <div class="flex h-full min-h-[132mm] flex-col p-5">
                            <div class="flex items-start justify-between gap-4 border-b-4 border-slate-950 pb-4">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.24em] text-teal-700">
                                        {{ config('app.name') }}
                                    </p>
                                    <div class="mt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                                        Participant BIB
                                    </div>
                                </div>

                                <div class="rounded-lg bg-slate-950 px-4 py-3 text-right text-white">
                                    <div class="text-[10px] font-bold uppercase tracking-[0.18em] text-teal-200">
                                        Blood Type
                                    </div>
                                    <div class="mt-1 text-2xl font-black">
                                        {{ $participant->blood_type ?: '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid flex-1 grid-cols-[1fr_170px] items-center gap-5 py-5">
                                <div>
                                    <div class="text-[10px] font-black uppercase tracking-[0.24em] text-slate-500">
                                        NO BIB
                                    </div>
                                    <h2 class="mt-2 text-6xl font-black leading-none tracking-normal text-slate-950">
                                        {{ $participant->bib_number }}
                                    </h2>

                                    <div class="mt-4">
                                        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                                            Participant
                                        </div>
                                        <div class="mt-1 text-2xl font-black leading-tight text-slate-950">
                                            {{ $participant->name }}
                                        </div>
                                        <div class="mt-1 text-base font-semibold text-slate-600">
                                            {{ $participant->community ?: 'Independent Participant' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col items-center">
                                    <div class="rounded-lg border-2 border-slate-950 bg-white p-3">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(140)->margin(1)->generate($participant->qr_token) !!}
                                    </div>
                                    <div class="mt-2 text-center text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">
                                        Scan Checkpoint
                                    </div>
                                </div>
                            </div>

                            <div class="border-t-2 border-slate-200 pt-4">
                                <div class="mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                                    Sponsor
                                </div>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach ($sponsors as $sponsor)
                                        <div class="flex min-h-12 items-center justify-center rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 px-2 text-center text-[10px] font-black uppercase tracking-wide text-slate-500">
                                            {{ $sponsor }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

                @if ($participantPage->count() === 1)
                    <div class="hidden print:block"></div>
                @endif
            </section>
        @empty
            <section class="rounded-lg bg-white p-8 text-center text-sm font-semibold text-slate-500 shadow">
                Tidak ada peserta untuk dicetak.
            </section>
        @endforelse
    </main>
</body>
</html>
