<?php

use App\Models\Participant;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('participants:generate {count=50 : Jumlah peserta yang akan dibuat} {--with-checkpoints : Isi timestamp checkpoint secara acak}', function () {
    $count = (int) $this->argument('count');

    if ($count < 1) {
        $this->error('Jumlah peserta minimal 1.');

        return Command::FAILURE;
    }

    $communities = [
        'Federal Runners',
        'Pontianak Run Crew',
        'Khatulistiwa Cycling',
        'Independent',
        'West Borneo Sport',
    ];

    $bloodTypes = [
        'A',
        'B',
        'AB',
        'O',
        'A+',
        'B+',
        'AB+',
        'O+',
        'A-',
        'B-',
        'AB-',
        'O-',
    ];

    $nextBibNumber = (Participant::max('id') ?? 0) + 1;
    $created = 0;

    $this->withProgressBar(range(1, $count), function () use (&$nextBibNumber, &$created, $communities, $bloodTypes) {
        do {
            $bibNumber = 'FED-' . str_pad($nextBibNumber, 5, '0', STR_PAD_LEFT);
            $nextBibNumber++;
        } while (Participant::where('bib_number', $bibNumber)->exists());

        do {
            $phone = '08' . fake()->numerify('##########');
        } while (Participant::where('phone', $phone)->exists());

        do {
            $qrToken = Str::random(16);
        } while (Participant::where('qr_token', $qrToken)->exists());

        $participant = Participant::create([
            'bib_number' => $bibNumber,
            'qr_token' => $qrToken,
            'name' => fake()->name(),
            'community' => fake()->randomElement($communities),
            'birth_date' => fake()->dateTimeBetween('-55 years', '-17 years')->format('Y-m-d'),
            'address' => fake()->address(),
            'phone' => $phone,
            'emergency_contact' => '08' . fake()->numerify('##########'),
            'blood_type' => fake()->randomElement($bloodTypes),
        ]);

        if ($this->option('with-checkpoints')) {
            $registeredAt = fake()->optional(0.85)->dateTimeBetween('-2 days', 'now');
            $cp1At = $registeredAt ? fake()->optional(0.65)->dateTimeBetween($registeredAt, 'now') : null;
            $cp2At = $cp1At ? fake()->optional(0.55)->dateTimeBetween($cp1At, 'now') : null;
            $finishedAt = $cp2At ? fake()->optional(0.45)->dateTimeBetween($cp2At, 'now') : null;

            $participant->forceFill([
                'registered_at' => $registeredAt,
                'cp1_at' => $cp1At,
                'cp2_at' => $cp2At,
                'finished_at' => $finishedAt,
            ])->save();
        }

        $created++;
    });

    $this->newLine(2);
    $this->info("Berhasil generate {$created} peserta event.");

    return Command::SUCCESS;
})->purpose('Generate dummy peserta event untuk testing');
