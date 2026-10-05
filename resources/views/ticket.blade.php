<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $participant->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-sm w-full bg-white p-6 rounded-2xl shadow-lg border border-gray-200 text-center">
        <!-- Badge Status -->
        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wider">
            E-Ticket Resmi
        </span>

        <!-- Info Peserta -->
        <h2 class="text-xl font-bold text-gray-800 mt-4">{{ $participant->name }}</h2>
        <p class="text-xs text-gray-500">{{ $participant->email }}</p>
        
        <div class="mt-2 inline-block bg-gray-100 px-3 py-1 rounded text-xs font-mono text-gray-600">
            {{ $participant->ticket_code }}
        </div>

        <!-- Render QR Code SVG -->
        <div class="flex justify-center my-6 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            {!! QrCode::size(200)->generate($participant->ticket_code) !!}
        </div>

        <p class="text-xs text-gray-400">
            Tunjukkan kode QR ini ke panitia di meja registrasi saat hari H.
        </p>
    </div>

</body>
</html>