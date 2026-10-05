# EventQR - Event Registration & Real-Time QR Attendance System

Sistem manajemen pendaftaran acara dan pencatatan absensi kehadiran berbasis *web scanner* QR code secara *real-time*. Dibangun menggunakan **Laravel**, **Tailwind CSS**, dan pustaka **HTML5 QR Code Scanner**.

---

## 📌 Ringkasan Proyek

Sistem ini dirancang untuk mengatasi antrean panjang dan pencatatan manual pada meja registrasi acara (*event check-in*). Peserta cukup mendaftar secara mandiri untuk mendapatkan e-tiket dengan QR code unik. Panitia di lokasi cukup membuka kamera peramban (baik laptop maupun *smartphone*) untuk memindai tiket, memvalidasi keaslian, dan mencatat waktu kehadiran secara otomatis ke basis data.

---

## ✨ Fitur Utama

- **Pendaftaran Mandiri Peserta:** Formulir registrasi publik dengan validasi data masukan (nama, email, nomor kontak).
- **Penerbitan E-Tiket & QR Code Otomatis:** Menghasilkan kode tiket acak unik (misal: `EVT-XXXXXXXX`) dan merender QR Code berbasis SVG menggunakan `simplesoftwareio/simple-qrcode`.
- **Pemindai QR Berbasis Kamera (*Browser-Based*):** Validasi kehadiran instan melalui kamera tanpa perlu memasang aplikasi *mobile* terpisah (menggunakan `html5-qrcode`).
- **Pencegahan Tiket Ganda (*Anti-Double Check-in*):** Sistem menolak tiket yang sudah pernah digunakan dan menampilkan waktu pemindaian pertama.
- **Dashboard Rekapitulasi *Real-Time*:** Metrik ringkas berupa total pendaftar, jumlah peserta hadir, dan yang belum hadir beserta tabel detail log waktu *check-in*.
- **Ekspor Data ke CSV/Excel:** Mengunduh seluruh rekapitulasi kehadiran dengan satu klik menggunakan format *comma-separated values* berstandar UTF-8 BOM.
- **Proteksi Akses Panitia:** Halaman operasional panitia (`/scan` dan `/dashboard`) dilindungi oleh *custom middleware* dan kata sandi sesi.

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

| Bagian | Teknologi |
| --- | --- |
| **Backend Framework** | Laravel 12 (PHP 8.2+) |
| **Database** | MySQL |
| **Frontend Styling** | Blade Engine & Tailwind CSS |
| **QR Code Generator** | `simplesoftwareio/simple-qrcode` |
| **QR Code Scanner** | `html5-qrcode` (JavaScript) |

---

## 🔄 Diagram Alur Sistem (Workflow)

```text
[ Peserta ]
     │
     ▼
[ Isi Form Registrasi ] ──► [ Simpan ke Database ]
                                    │
                                    ▼
                          [ Generate Unique QR ]
                                    │
                                    ▼
                           [ Halaman E-Tiket ]
                                    │
[ Panitia di Pintu Masuk ]          │
     │                              ▼
     ├──► [ Buka /scan ] ──► [ Arahkan Kamera ke QR ]
                                    │
                                    ├─── Tiket Valid & Belum Hadir ──► [ Tandai Hadir + Catat Jam ]
                                    │
                                    └─── Tiket Sudah Digunakan ──────► [ Tampilkan Notifikasi Merah ]