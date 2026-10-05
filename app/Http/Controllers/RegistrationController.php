<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    // Menampilkan halaman formulir pendaftaran
    public function create()
    {
        return view('register');
    }

    // Menyimpan data pendaftar & generate kode unik
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Buat kode tiket unik (contoh: EVT-9AB4C1D2)
        $ticketCode = 'EVT-' . strtoupper(Str::random(8));

        $participant = Participant::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'ticket_code' => $ticketCode,
        ]);

        return redirect()->route('ticket.show', $participant->ticket_code);
    }

    // Menampilkan halaman e-tiket beserta QR code
    public function show($ticket_code)
    {
        $participant = Participant::where('ticket_code', $ticket_code)->firstOrFail();

        return view('ticket', compact('participant'));
    }
}