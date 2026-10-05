<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kehadiran Acara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Rekapitulasi Kehadiran</h1>
                <p class="text-sm text-gray-500">Monitoring kehadiran peserta secara langsung</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('attendance.export') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                    Unduh Laporan (.csv)
                </a>
                <a href="{{ route('attendance.index') }}" target="_blank" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-900 transition">
                    Buka Pemindai QR
                </a>
                <a href="{{ route('register.create') }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                    Form Pendaftaran
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <p class="text-sm font-medium text-gray-500">Total Pendaftar</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $total }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <p class="text-sm font-medium text-gray-500">Sudah Hadir</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $attended }}</p>
            </div>
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <p class="text-sm font-medium text-gray-500">Belum Hadir</p>
                <p class="text-3xl font-bold text-amber-500 mt-1">{{ $notAttended }}</p>
            </div>
        </div>

        <!-- Tabel Peserta -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-semibold text-gray-800">Daftar Peserta</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600">
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Kontak</th>
                            <th class="py-3 px-4">Kode Tiket</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4">Waktu Check-in</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($participants as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $item->name }}</td>
                                <td class="py-3 px-4 text-gray-500 text-xs">
                                    {{ $item->email }}<br>{{ $item->phone }}
                                </td>
                                <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $item->ticket_code }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if ($item->is_attended)
                                        <span class="inline-block bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-semibold">
                                            Hadir
                                        </span>
                                    @else
                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full font-semibold">
                                            Belum
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-xs text-gray-500">
                                    {{ $item->attended_at ? $item->attended_at->format('H:i') . ' WIB' : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">Belum ada data pendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>