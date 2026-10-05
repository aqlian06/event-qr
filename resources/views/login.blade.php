<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Panitia - Event QR</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-sm w-full bg-white p-6 rounded-2xl shadow-md border border-gray-200">
        <h1 class="text-xl font-bold text-gray-800 text-center mb-1">Akses Panitia</h1>
        <p class="text-xs text-gray-500 text-center mb-6">Masukkan kata sandi untuk mengelola kehadiran</p>

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-xs rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase tracking-wider">Kata Sandi</label>
                <input 
                    type="password" 
                    name="password" 
                    required 
                    placeholder="Masukkan sandi..." 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-800"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-slate-900 text-white font-medium py-2 rounded-lg text-sm hover:bg-black transition"
            >
                Masuk
            </button>
        </form>
    </div>

</body>
</html>