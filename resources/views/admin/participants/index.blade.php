<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Participants
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    List registered participant dan status checkpoint event.
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row">
                <a
                    href="{{ route('admin.participants.print-bibs', request()->only('search')) }}"
                    target="_blank"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                >
                    Print BIB Massal
                </a>

                <a
                    href="{{ route('admin.participants.scan') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500/20"
                >
                    Scan Barcode
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-5 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <form action="{{ route('admin.participants.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama, BIB, komunitas, atau nomor HP"
                        class="min-h-11 flex-1 rounded-lg border-gray-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    >

                    <button
                        type="submit"
                        class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                    >
                        Search
                    </button>
                </form>
            </div>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                        <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:bg-gray-900 dark:text-gray-400">
                            <tr>
                                <th class="px-5 py-3">BIB</th>
                                <th class="px-5 py-3">Participant</th>
                                <th class="px-5 py-3">Phone</th>
                                @foreach ($checkpoints as $checkpoint)
                                    <th class="px-5 py-3">{{ $checkpoint }}</th>
                                @endforeach
                                <th class="px-5 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($participants as $participant)
                                <tr class="text-gray-700 dark:text-gray-200">
                                    <td class="whitespace-nowrap px-5 py-4 font-bold text-teal-700 dark:text-teal-300">
                                        {{ $participant->bib_number }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-gray-950 dark:text-white">
                                            {{ $participant->name }}
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $participant->community ?: '-' }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        {{ $participant->phone }}
                                    </td>
                                    @foreach (array_keys($checkpoints) as $field)
                                        <td class="whitespace-nowrap px-5 py-4">
                                            @if ($participant->{$field})
                                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300">
                                                    {{ $participant->{$field}->format('d M H:i') }}
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500 dark:bg-gray-700 dark:text-gray-300">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="whitespace-nowrap px-5 py-4 text-right">
                                        <a
                                            href="{{ route('admin.participants.print-bib', $participant) }}"
                                            target="_blank"
                                            class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-3 py-2 text-xs font-bold text-white transition hover:bg-gray-700 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-white"
                                        >
                                            Print BIB
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Belum ada participant terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-700">
                    {{ $participants->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
