<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Tiket Acara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Library HTML5 QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col items-center p-4">

    <div class="max-w-md w-full text-center mt-6">
        <h1 class="text-xl font-bold mb-1">Pemindai QR Panitia</h1>
        <p class="text-sm text-gray-400 mb-6">Arahkan kamera ke QR code tiket peserta</p>

        <!-- Kotak Kamera Scanner -->
        <div class="overflow-hidden rounded-2xl border-2 border-gray-700 bg-black shadow-lg">
            <div id="reader" class="w-full"></div>
        </div>

        <!-- Kotak Notifikasi Hasil Scan -->
        <div id="scan-result" class="mt-4 p-4 rounded-xl hidden font-medium text-sm transition-all duration-300"></div>
    </div>

    <script>
        let isProcessing = false;

        function onScanSuccess(decodedText) {
            // Cegah scan ganda saat request masih diproses
            if (isProcessing) return;
            isProcessing = true;

            fetch("{{ route('attendance.checkin') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ticket_code: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                const box = document.getElementById('scan-result');
                box.classList.remove('hidden', 'bg-green-600', 'bg-red-600');

                if (data.status === 'success') {
                    box.classList.add('bg-green-600');
                    box.innerText = data.message;
                } else {
                    box.classList.add('bg-red-600');
                    box.innerText = data.message;
                }

                // Beri jeda 3 detik sebelum scanner bisa membaca tiket berikutnya
                setTimeout(() => {
                    box.classList.add('hidden');
                    isProcessing = false;
                }, 3000);
            })
            .catch(err => {
                console.error(err);
                isProcessing = false;
            });
        }

        // Inisialisasi scanner kamera
        const html5QrcodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        });
        html5QrcodeScanner.render(onScanSuccess);
    </script>

</body>
</html>