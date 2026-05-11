<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParticipantController extends Controller
{
    /**
     * Show registration form
     */
    public function create()
    {
        return view('participants.create');
    }

    /**
     * Store participant
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'community' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'address' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'emergency_contact' => 'required|string|max:20',
            'blood_type' => 'nullable|string|max:5',
        ]);

        $lastId = Participant::max('id') + 1;

        $bibNumber = 'FED-' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

        $participant = Participant::create([
            ...$validated,

            'bib_number' => $bibNumber,
            'qr_token' => Str::random(16),
        ]);
      
        return redirect()
            ->route('participants.success', $participant->qr_token);
    }

    /**
     * Success page
     */
    public function success($token)
    {
        $participant = Participant::where('qr_token',$token)->firstOrFail();

        return view('participants.success', compact('participant'));
    }
}