<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Menampilkan halaman scanner untuk panitia
    public function index()
    {
        return view('scanner');
    }

    // Endpoint pemrosesan hasil scan tiket
    public function checkIn(Request $request)
    {
        $ticketCode = $request->input('ticket_code');

        // Cari peserta berdasarkan kode tiket
        $participant = Participant::where('ticket_code', $ticketCode)->first();

        // 1. Validasi jika tiket tidak ada di database
        if (!$participant) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tiket tidak ditemukan atau tidak valid!',
            ], 404);
        }

        // 2. Validasi jika tiket sudah pernah dipakai
        if ($participant->is_attended) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tiket sudah pernah digunakan pada ' . $participant->attended_at->format('H:i') . ' WIB',
            ], 400);
        }

        // 3. Update status kehadiran jika tiket valid
        $participant->update([
            'is_attended' => true,
            'attended_at' => now(),
        ]);

        return response()->json([
            'status'      => 'success',
            'message'     => 'Check-in berhasil! Selamat datang, ' . $participant->name,
            'participant' => $participant,
        ]);
    }

    // Menampilkan rekapitulasi data dan statistik kehadiran
    public function dashboard()
    {
        $participants = Participant::latest()->get();
        $total = $participants->count();
        $attended = $participants->where('is_attended', true)->count();
        $notAttended = $total - $attended;

        return view('dashboard', compact('participants', 'total', 'attended', 'notAttended'));
    }

    // Export rekap data peserta ke file CSV/Excel
    public function export()
    {
        $fileName = 'rekap-kehadiran-' . date('Y-m-d') . '.csv';
        $participants = Participant::all();

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = ['Nama', 'Email', 'No HP', 'Kode Tiket', 'Status', 'Waktu Check-in'];

        $callback = function () use ($participants, $columns) {
            $file = fopen('php://output', 'w');
            // Menambahkan BOM agar file terbaca rapi di Microsoft Excel
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);

            foreach ($participants as $item) {
                fputcsv($file, [
                    $item->name,
                    $item->email,
                    $item->phone,
                    $item->ticket_code,
                    $item->is_attended ? 'Hadir' : 'Belum',
                    $item->attended_at ? $item->attended_at->format('d/m/Y H:i') . ' WIB' : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}