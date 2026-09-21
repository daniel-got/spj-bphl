# Ringkasan Log Wajib Laravel di Production

Saat aplikasi Laravel berjalan di environment *production*, logging harus difokuskan pada informasi yang **kritis, relevan, dan actionable**. Hindari log yang terlalu berisik (*noisy*).

## 1. Kategori Log Kritis

### A. Error & Exception (Sistem Kritis)
* **Uncaught Exceptions (HTTP 500):** *Syntax error*, fungsi tidak ditemukan, memori habis (*out-of-memory*).
* **Database Connectivity:** Gagal terhubung ke Database atau Redis (penyebab utama pemadaman/ *downtime*).
* **Query Deadlocks & Timeout:** Kegagalan *query* karena konflik antrean atau proses terlalu lama.

### B. Interaksi Pihak Ketiga (API Eksternal)
* **Payment Gateway Failures:** *Timeout* atau *error* dari penyedia layanan pembayaran (misal: Midtrans/Stripe).
* **Email & SMS Gateway Fails:** Gagal kirim OTP/Notifikasi (catat *payload error*, bukan data sensitif).
* **Webhook Failures:** Gagal memproses data masuk dari *webhook*.

### C. Keamanan & Akses (Audit Trail)
* **Failed Logins (Brute Force):** IP tertentu yang gagal *login* lebih dari 5 kali berturut-turut.
* **Unauthorized Access (HTTP 403):** Akses ke rute/sumber daya tanpa hak akses (misal: pengguna biasa mencoba mengakses rute admin).
* **Perubahan Data Kritis:** Penghapusan data secara massal atau perubahan konfigurasi sistem oleh pengguna.

### D. Business Logic (Transaksi)
* **Transaction Rollbacks:** Alasan mengapa sebuah `DB::transaction()` dibatalkan (*rollback*) di tengah jalan.
* **Failed Background Jobs:** Kegagalan proses antrean (Queue/Horizon) yang masuk ke tabel `failed_jobs`.

---

## 2. Aturan Emas Konfigurasi (`.env` & `config/logging.php`)

1. **Log Level yang Tepat:** 
   * Gunakan `LOG_LEVEL=error` (atau maksimal `warning`).
   * **DILARANG** menggunakan `debug` di *production* karena akan mencatat *query* dan variabel yang membebani kapasitas peladen.
2. **Gunakan Log Channel "Daily":** 
   * Gunakan `LOG_CHANNEL=daily` agar fail log dirotasi per hari (contoh: `laravel-2026-07-13.log`).
   * Atur durasi penyimpanan (misalnya menghapus log yang usianya lebih dari 14 hari) agar *disk* tidak penuh.
3. **Sensor Data Sensitif:** 
   * Jangan pernah mencatat Kata Sandi (*Password*), Token (JWT/Sanctum), Data Kartu Kredit, atau NIK ke dalam log.
