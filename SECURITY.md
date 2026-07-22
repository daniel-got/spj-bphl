# Panduan Keamanan (Security Guidelines) SPJ BPHL

Dokumen ini berisi standar keamanan dan praktik terbaik yang wajib diterapkan selama pengembangan dan operasional sistem SPJ BPHL. Semua kontributor dan developer wajib mematuhi panduan ini untuk mencegah kebocoran data, eskalasi hak akses (*privilege escalation*), dan celah keamanan lainnya.

## 1. Otorisasi dan Kepemilikan Data (Data Ownership)

Keamanan akses dokumen tidak hanya bergantung pada *role* pengguna, tetapi juga pada kepemilikan data (Siapa yang membuat dan siapa yang ditugaskan).

- **Strict Creation Rule:** Hak akses *monitoring* (Kepala Balai, TU, Seksi) atau *Administrator* memberikan keistimewaan **HANYA UNTUK MEMBACA (Read-Only)** data secara global. Role-role ini **TIDAK BOLEH** diizinkan melewati (*bypass*) aturan kepemilikan saat melakukan **PEMBUATAN (Create)** atau **PENGUBAHAN (Update)** data.
  - *Contoh Kasus:* Seseorang dengan role Kepala TU tidak diizinkan membuat dokumen SPD dari SPT orang lain, meskipun ia memiliki hak untuk melihat SPT tersebut. SPD hanya boleh dibuat oleh pegawai yang namanya secara sah tercantum dalam daftar `pegawai_ditugaskan` di dalam SPT.
- **Validasi Lapis Service:** Validasi kepemilikan (seperti pengecekan ID pengguna terhadap pembuat atau penugasan) wajib dilakukan di lapisan `Service`, bukan di Controller, untuk memastikan logika keamanan tidak bisa dilewati jika endpoint dipanggil dari tempat lain.

## 2. Pencegahan Mixed Content (HTTPS Enforcing)

Karena aplikasi berjalan di belakang *Reverse Proxy* (Nginx/Cloudflare) dalam lingkungan VPS production, Laravel secara default mungkin kebingungan mengenali protokol asal dan mengenerate URL HTTP, yang menyebabkan error *Mixed Content* di browser.

- **Trust Proxies:** Aplikasi wajib menerima header proxy. Di `bootstrap/app.php`, pastikan proxy diizinkan: `->withMiddleware(function (Middleware $middleware) { $middleware->trustProxies(at: '*'); })`.
- **Force HTTPS:** Pada `app/Providers/AppServiceProvider.php`, pastikan scheme dipaksa menjadi HTTPS jika environment adalah production:
  ```php
  if (config('app.env') === 'production') {
      \Illuminate\Support\Facades\URL::forceScheme('https');
  }
  ```

## 3. Keamanan File dan Object Storage (S3 / Cloudflare R2)

Semua file sensitif seperti dokumen bukti, kwitansi, atau tanda tangan tidak boleh terekspos secara publik.

- **Private Buckets:** Jangan pernah mengaktifkan *Public Access / Public Development URL* pada bucket R2/S3.
- **Signed URLs / Application Proxy:** File hanya boleh diakses melalui aplikasi. Aplikasi harus mengautentikasi pengguna (memastikan mereka sudah login dan berhak melihat dokumen tersebut), lalu menyajikan file tersebut melalui fitur *Temporary Signed URL* (berlaku beberapa menit saja) atau dengan mengalirkan file (streaming) langsung dari controller privat.

## 4. Perlindungan Endpoint (Routing & Middleware)

- Seluruh route sistem inti wajib dilindungi oleh middleware `auth`.
- Route yang sensitif seperti persetujuan (approval) atau verifikasi keuangan wajib diberikan middleware tambahan atau pengecekan otorisasi ketat (Gates/Policies) yang memverifikasi bahwa pengguna memiliki *Role* yang sesuai (misal: PPK atau Verifikator).

## 5. Input Validation & Form Requests

- Tidak ada input dari sisi klien (browser) yang boleh dipercaya (*Never trust user input*).
- Validasi wajib ditangani di dalam kelas `FormRequest` terpisah.
- Gunakan `$request->validated()` saat menyimpan ke database, BUKAN `$request->all()`, untuk menghindari serangan *Mass Assignment*.

## 6. Prinsip Least Privilege pada Database & Server

- Koneksi database ke VPS harus menggunakan kredensial yang seminimal mungkin hak aksesnya.
- Jangan gunakan user `root` untuk koneksi MariaDB/MySQL dari dalam aplikasi Laravel. 
- Private SSH keys dan rahasia VPS di GitHub Actions disimpan secara ketat di GitHub Secrets dan tidak boleh di-echo atau di-log selama proses deployment.
