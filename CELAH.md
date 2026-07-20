# Celah Keamanan dan Potensi Bug

Dokumen ini berisi temuan terkait bug, kelemahan implementasi, dan potensi masalah logika yang dapat menyebabkan perilaku aplikasi tidak sesuai dengan aturan bisnis.

---

## 1. Informasi Pembuat SPT Tidak Akurat

**File**

```
resources/views/pages/spt/show.blade.php
```

### Temuan

Variabel `$isPembuat` juga bernilai `true` untuk pengguna dengan role **Admin**, sehingga Admin akan melihat teks:

> "Anda adalah pembuat SPT ini"

padahal Admin bukan pembuat sebenarnya.

### Dampak

- Informasi yang ditampilkan kepada pengguna menjadi tidak akurat.
- Membingungkan karena konsep **creator** dan **admin override** tercampur.
- Dapat menimbulkan kesalahpahaman mengenai kepemilikan dokumen.

### Rekomendasi

Pisahkan konsep:

- **Pembuat SPT (creator)** → hanya untuk menampilkan informasi bahwa pengguna adalah pembuat.
- **Admin** → hanya untuk memberikan hak akses operasional tanpa mengubah informasi kepemilikan.

---

## 2. Query `whereJsonContains` Salah pada Statistik Print SPT

**File**

```
resources/views/pages/spt/print.blade.php
```

### Temuan

`whereJsonContains()` digunakan dengan bentuk:

```php
[[ 'pegawai_id' => ... ]]
```

Padahal apabila `pegawai_ditugaskan` merupakan **array of objects**, kandidat yang benar adalah:

```php
['pegawai_id' => ...]
```

sesuai struktur validasi:

```php
pegawai_ditugaskan.*.pegawai_id
```

### Dampak

Statistik **Ditugaskan** dapat selalu bernilai `0` meskipun pengguna sebenarnya termasuk dalam daftar pegawai yang ditugaskan.

### Rekomendasi

Gunakan kandidat object tunggal pada `whereJsonContains()`.

---

## 3. Recent SPT Tidak Menampilkan SPT yang Ditugaskan

**File**

```
app/Services/User/DashboardService.php
```

### Temuan

Query Recent SPT menggunakan:

```php
whereJsonContains([[ ... ]])
```

yang umumnya tidak cocok dengan struktur JSON array of objects.

### Dampak

Dashboard hanya akan menampilkan:

- SPT yang dibuat sendiri

dan tidak pernah menampilkan:

- SPT yang hanya menugaskan pengguna.

### Rekomendasi

Gunakan kandidat object yang sesuai dengan struktur JSON.

---

## 4. Ringkasan Dokumen Tidak Menghitung SPT yang Ditugaskan

**File**

```
app/Services/User/DashboardService.php
```

### Temuan

Ringkasan dokumen juga menggunakan bentuk:

```php
whereJsonContains([[ ... ]])
```

### Dampak

Status seperti:

- Approved
- Selesai

untuk SPT yang hanya menugaskan pengguna tidak ikut dihitung pada dashboard.

### Rekomendasi

Gunakan bentuk object yang sesuai pada `whereJsonContains()`.

---

## 5. Filter "SPT Saya" Tidak Menemukan Penugasan

**File**

```
app/Services/Spt/SptService.php
```

### Temuan

Filter **SPT Saya** menggunakan:

```php
whereJsonContains([[ ... ]])
```

### Dampak

Apabila `pegawai_ditugaskan` berupa array of objects, query tidak akan pernah cocok sehingga pengguna dapat melihat:

- 0 SPT

meskipun sebenarnya ditugaskan pada beberapa SPT.

### Rekomendasi

Gunakan object kandidat yang sesuai dengan struktur JSON.

---

## 6. Filter Non-Strict Tidak Mengembalikan SPT Penugasan

**File**

```
app/Services/Spt/SptService.php
```

### Temuan

Filter non-strict juga menggunakan bentuk:

```php
whereJsonContains([[ ... ]])
```

### Dampak

Kondisi:

- pengguna sebagai pegawai yang ditugaskan

tidak pernah terpenuhi sehingga daftar SPT hanya berdasarkan:

- `pembuat_id`

### Rekomendasi

Perbaiki penggunaan `whereJsonContains()` agar sesuai dengan struktur JSON.

---

## 7. Perubahan Aturan Status pada Pembuatan SPD

**File**

```
app/Services/Spd/SpdService.php
```

### Temuan

Pembatasan status membuat SPD hanya dapat dibuat dari SPT dengan status:

- Approved
- Selesai

### Dampak

Perubahan ini mengubah alur bisnis yang sebelumnya memperbolehkan SPD dibuat dari status lain.

Selain itu beberapa test dapat gagal, misalnya:

```
tests/Feature/Spd/SpdTest::test_user_dapat_membuat_spd_baru
```

karena factory masih membuat SPD dari SPT berstatus Draft.

### Rekomendasi

Pastikan:

- seluruh test diperbarui,
- factory mengikuti aturan status baru,
- data seed konsisten dengan business rule terbaru.

---

## 8. Validasi Duplikat SPD Menghasilkan HTTP 500

**File**

```
app/Services/Spd/SpdService.php
```

### Temuan

Kasus duplikat masih menggunakan:

```php
throw new \Exception(...)
```

### Dampak

- menghasilkan HTTP 500,
- pengguna tidak mendapatkan pesan validasi pada form,
- error tidak terikat pada field input.

### Rekomendasi

Gunakan:

```php
ValidationException::withMessages()
```

agar:

- error muncul pada field yang sesuai,
- aplikasi tetap aman terhadap race condition,
- pengalaman pengguna menjadi lebih baik.

---

## 9. Validasi Duplikat Rincian Menghasilkan HTTP 500

**File**

```
app/Services/Rincian/RincianService.php
```

### Temuan

Kasus duplikat rincian masih melempar:

```php
throw new \Exception(...)
```

### Dampak

- menghasilkan HTTP 500,
- pengguna tidak memperoleh pesan validasi pada form.

Karena aturan bisnis hanya memperbolehkan:

> satu rincian untuk setiap SPD,

kasus ini merupakan validasi input, bukan kesalahan sistem.

### Rekomendasi

Gunakan:

```php
ValidationException::withMessages([
    'spd_id' => '...'
]);
```

agar pengguna kembali ke form dengan pesan kesalahan yang sesuai.

---

# Ringkasan

| No  | File                                        | Permasalahan                                               |
| --- | ------------------------------------------- | ---------------------------------------------------------- |
| 1   | `resources/views/pages/spt/show.blade.php`  | Status creator dan admin tercampur                         |
| 2   | `resources/views/pages/spt/print.blade.php` | `whereJsonContains()` menggunakan kandidat JSON yang salah |
| 3   | `app/Services/User/DashboardService.php`    | Recent SPT tidak memuat penugasan                          |
| 4   | `app/Services/User/DashboardService.php`    | Ringkasan dashboard tidak menghitung penugasan             |
| 5   | `app/Services/Spt/SptService.php`           | Filter "SPT Saya" gagal menemukan penugasan                |
| 6   | `app/Services/Spt/SptService.php`           | Filter non-strict tidak memuat penugasan                   |
| 7   | `app/Services/Spd/SpdService.php`           | Perubahan aturan status memengaruhi alur bisnis dan test   |
| 8   | `app/Services/Spd/SpdService.php`           | Validasi duplikat menghasilkan HTTP 500                    |
| 9   | `app/Services/Rincian/RincianService.php`   | Validasi duplikat menghasilkan HTTP 500                    |
