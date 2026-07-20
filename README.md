# Dokumentasi Deployment & Development SPJ BPHL

Dokumen ini berisi panduan teknis lengkap mengenai siklus pengembangan (development) hingga peluncuran (production) untuk aplikasi SPJ BPHL. Aplikasi ini menggunakan arsitektur container (Podman/Docker) dengan strategi Multi-Stage Build dan terintegrasi dengan GitHub Actions CI/CD.

## Arsitektur Infrastruktur

- **Aplikasi Utama:** Laravel 11 (PHP 8.3 FPM)
- **Database:** PostgreSQL (Host-based, diakses via Gateway Podman)
- **Web Server Internal:** Nginx (Alpine) di dalam container untuk melayani file statis dan proxy ke PHP-FPM.
- **Web Server Eksternal (Reverse Proxy):** Nginx (Host-based VPS) untuk terminasi SSL (HTTPS) dan traffic forwarding.
- **Orkestrasi:** Podman Compose (kompatibel penuh dengan Docker Compose).

---

## 1. Lingkungan Development (Lokal)

Pada lingkungan lokal (Windows, Mac, Linux), pengembangan dilakukan menggunakan `docker-compose.yml`. Konfigurasi ini akan melakukan *volume mount* direktori aktif ke dalam container sehingga setiap perubahan kode akan langsung terlihat (hot-reload) tanpa perlu melakukan *build* ulang.

### Prasyarat Lokal
- Docker Desktop atau Podman Desktop terinstal.
- Node.js (opsional, jika ingin mem-build aset secara lokal di luar container).
- Composer (opsional).

### Langkah Menjalankan di Lokal

1. Duplikasi file konfigurasi environment:
   ```bash
   cp .env.example .env
   ```
2. Sesuaikan konfigurasi `.env` untuk lokal (misal: koneksi database mengarah ke container database lokal jika ada).
3. Jalankan container di latar belakang:
   ```bash
   docker-compose up -d
   ```
4. Masuk ke dalam container `app` untuk menginstal dependensi:
   ```bash
   docker-compose exec app bash
   composer install
   npm install
   npm run dev
   php artisan key:generate
   php artisan migrate
   ```

Aplikasi dapat diakses melalui `http://localhost:8000`.

---

## 2. Lingkungan Production (VPS)

Pada lingkungan Production, kita menggunakan `docker-compose.prod.yml` yang dikombinasikan dengan arsitektur **Multi-Stage Build** di `Dockerfile`. Pada tahap ini, seluruh *source code* akan dikunci (baked-in) ke dalam *image*, dependensi development dihapus, dan aset frontend dikompilasi secara otomatis.

### Konfigurasi VPS (Satu Kali Setup)

1. **Persiapan Database (PostgreSQL Host)**
   Pastikan PostgreSQL di VPS mengizinkan koneksi dari jaringan Podman (biasanya `10.89.0.0/16` atau `172.22.0.0/16`).
   - Edit `/etc/postgresql/*/main/postgresql.conf`:
     ```ini
     listen_addresses = '*'
     ```
   - Edit `/etc/postgresql/*/main/pg_hba.conf`:
     ```text
     host    all             all             172.22.0.0/16           md5
     ```
   - Izinkan port di UFW:
     ```bash
     sudo ufw allow from 172.22.0.0/16 to any port 5432
     ```
   - Restart layanan: `sudo systemctl restart postgresql`.

2. **Penyesuaian File .env**
   Pastikan file `.env` di VPS memiliki konfigurasi yang mutlak diperlukan untuk lingkungan Reverse Proxy:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://spj-bphl4.dniel.my.id
   
   # Gunakan host.containers.internal agar container dapat menghubungi database di Host VPS
   DB_HOST=host.containers.internal
   ```

3. **Konfigurasi Reverse Proxy Nginx Utama**
   Edit blok server Nginx pada VPS (`/etc/nginx/sites-available/spj-bphl4.dniel.my.id`) untuk melempar traffic ke port `8000`:
   ```nginx
   location / {
       proxy_pass http://127.0.0.1:8000;
       proxy_set_header Host $host;
       proxy_set_header X-Real-IP $remote_addr;
       proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
       proxy_set_header X-Forwarded-Proto $scheme;
   }
   ```
   Restart Nginx: `sudo systemctl restart nginx`.

---

## 3. Deployment Otomatis (CI/CD GitHub Actions)

Sistem telah dilengkapi dengan alur otomatisasi deployment. Setiap kali ada perubahan kode yang di-push atau di-merge ke branch `main`, GitHub Actions akan mengambil alih.

### Cara Kerja CI/CD
1. GitHub Actions terhubung ke VPS secara aman menggunakan protokol SSH.
2. Melakukan `git pull origin main` di direktori proyek VPS.
3. Menjalankan perintah `podman-compose -f docker-compose.prod.yml up -d --build`.
4. Berkat teknik *Multi-Stage Build*, Podman akan mendeteksi perubahan pada file sumber, menjalankan `composer install --no-dev`, mengeksekusi `npm run build`, dan membangun ulang *image* Nginx yang berisi file statis terbaru.

### Konfigurasi GitHub Secrets
Agar otomatisasi ini berjalan, repositori GitHub harus memiliki variabel *Secrets* berikut:
- `VPS_HOST`: Alamat IP Publik VPS.
- `VPS_USERNAME`: Username login VPS (misalnya `root` atau `ubuntu`).
- `VPS_SSH_KEY`: Isi lengkap dari Private Key SSH (`id_ed25519` atau `id_rsa`) yang sudah memiliki otorisasi masuk ke VPS.

### Keamanan Khusus (Mixed Content & Proxy)
Untuk memastikan keamanan HTTPS terjaga secara utuh (mencegah error *Mixed Content* saat berada di balik Reverse Proxy), sistem menggunakan dua tingkat pengamanan di dalam source code:
1. `bootstrap/app.php` mengaktifkan `trustProxies(at: '*')` untuk membaca header `X-Forwarded-Proto` dari Nginx.
2. `AppServiceProvider.php` memiliki kondisi wajib `URL::forceScheme('https')` setiap kali environment berada di status `production`.
