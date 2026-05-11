<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\ScanLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminParticipantController extends Controller
{
    private const CHECKPOINTS = [
        'registered_at' => 'Registration',
        'cp1_at' => 'Checkpoint 1',
        'cp2_at' => 'Checkpoint 2',
        'finished_at' => 'Finish',
    ];

    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $participants = Participant::query()
            ->when($search, function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('bib_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('community', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.participants.index', [
            'participants' => $participants,
            'checkpoints' => self::CHECKPOINTS,
            'search' => $search,
        ]);
    }

    public function scan()
    {
        return view('admin.participants.scan', [
            'checkpoints' => self::CHECKPOINTS,
        ]);
    }

    public function printBib(Participant $participant)
    {
        return view('admin.participants.print-bib', [
            'participant' => $participant,
            'sponsors' => $this->sponsors(),
        ]);
    }

    public function printBibs(Request $request)
    {
        $search = $request->string('search')->toString();

        $participants = Participant::query()
            ->when($search, function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('bib_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('community', 'like', "%{$search}%");
            })
            ->orderBy('bib_number')
            ->get();

        return view('admin.participants.print-bibs', [
            'participants' => $participants,
            'sponsors' => $this->sponsors(),
            'search' => $search,
        ]);
    }

    public function checkIn(Request $request)
    {
        $wantsJson = $request->expectsJson() || $request->is('api/*');

        $validated = $request->validate([
            'token' => ['required', 'string', 'max:255'],
            'checkpoint' => ['required', Rule::in(array_keys(self::CHECKPOINTS))],
        ]);

        $token = $this->extractToken($validated['token']);
        $checkpoint = $validated['checkpoint'];

        $participant = Participant::where('qr_token', $token)->first();

        if (! $participant) {
            $message = 'Participant tidak ditemukan untuk QR token tersebut.';

            if ($wantsJson) {
                return response()->json(['message' => $message], 404);
            }

            return back()->withErrors(['token' => $message])->withInput();
        }

        $alreadyScanned = filled($participant->{$checkpoint});

        if (! $alreadyScanned) {
            $participant->forceFill([
                $checkpoint => now(),
            ])->save();

            $participant->refresh();
        }

        ScanLog::create([
            'participant_id' => $participant->id,
            'action' => $checkpoint,
            'scanned_by' => $request->user()->id,
            'created_at' => now(),
        ]);

        $payload = [
            'message' => $alreadyScanned
                ? self::CHECKPOINTS[$checkpoint] . ' peserta ini sudah tercatat.'
                : self::CHECKPOINTS[$checkpoint] . ' berhasil dicatat.',
            'already_scanned' => $alreadyScanned,
            'checkpoint' => $checkpoint,
            'checkpoint_label' => self::CHECKPOINTS[$checkpoint],
            'participant' => [
                'name' => $participant->name,
                'bib_number' => $participant->bib_number,
                'community' => $participant->community,
                'registered_at' => optional($participant->registered_at)->format('d M Y H:i:s'),
                'cp1_at' => optional($participant->cp1_at)->format('d M Y H:i:s'),
                'cp2_at' => optional($participant->cp2_at)->format('d M Y H:i:s'),
                'finished_at' => optional($participant->finished_at)->format('d M Y H:i:s'),
            ],
        ];

        if ($wantsJson) {
            return response()->json($payload);
        }

        return back()->with('scan_result', $payload);
    }

    private function extractToken(string $value): string
    {
        $value = trim($value);

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $path = parse_url($value, PHP_URL_PATH);

            if ($path) {
                return basename($path);
            }
        }

        return $value;
    }

    private function sponsors(): array
    {
        return [
            'Main Sponsor',
            'Official Partner',
            'Medical Partner',
            'Community Partner',
        ];
    }
}
