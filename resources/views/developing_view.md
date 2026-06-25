# SPJ BPHL — Developing View Guide

Panduan ini mencakup cara membuat dan mengembangkan Laravel View menggunakan Blade component yang tersedia serta color palette yang telah dikonfigurasi secara global dalam proyek ini.

---

## Daftar Isi

1. [Arsitektur View](#1-arsitektur-view)
2. [Color Palette Global](#2-color-palette-global)
3. [Menjalankan Dev Server](#3-menjalankan-dev-server)
4. [Membuat Halaman Baru](#4-membuat-halaman-baru)
5. [Layout Components](#5-layout-components)
6. [Navigation Components](#6-navigation-components)
7. [Dashboard Components](#7-dashboard-components)
8. [Data Components](#8-data-components)
9. [Form Components](#9-form-components)
10. [Action Components](#10-action-components)
11. [Feedback Components](#11-feedback-components)
12. [Utility Components](#12-utility-components)

---

## 1. Arsitektur View

```
resources/views/
├── partials/               # Potongan template, dipanggil dengan @include
│   ├── head.blade.php      # <head> tag, meta, Vite assets
│   └── scripts.blade.php   # JS scripts sebelum </body>
│
├── components/             # Komponen reusable, dipanggil dengan <x-...>
│   ├── layout/             # Struktur halaman
│   ├── navigation/         # Navigasi
│   ├── dashboard/          # Widget dashboard
│   ├── data/               # Tampilan data
│   ├── form/               # Elemen form
│   ├── action/             # Tombol & aksi
│   ├── feedback/           # Notifikasi & dialog
│   └── utility/            # Helper kecil
│
└── pages/                  # Halaman utama yang dipanggil oleh Controller
    └── home.blade.php
```

**Aturan:**
- `partials/` → tidak memiliki props, pakai `@include('partials.nama')`
- `components/` → memiliki `@props`, pakai `<x-group.nama />`
- Setiap halaman baru dibuat di `pages/`

---

## 2. Color Palette Global

Color palette dikonfigurasi di `resources/css/app.css` menggunakan Tailwind CSS v4 `@theme`.

### Referensi Warna

| Token | Kelas Tailwind | Hex | Penggunaan |
|---|---|---|---|
| Primary | `bg-primary` / `text-primary` | `#537D44` | Tombol utama, elemen aktif |
| Primary Hover | `hover:bg-primary-hover` | `#456B39` | State hover tombol utama |
| Primary Light | `bg-primary-light` | `#EAF4E6` | Background badge/highlight hijau |
| Secondary | `bg-secondary` / `text-secondary` | `#936843` | Aksen coklat, elemen sekunder |
| Secondary Light | `bg-secondary-light` | `#F3E8DB` | Background badge/highlight coklat |
| Background | `bg-background` | `#F8FAF7` | Background body/halaman |
| Surface | `bg-surface` | `#FFFFFF` | Background card, panel, modal |
| Text | `text-text-main` | `#1E293B` | Teks utama |
| Muted | `text-muted` | `#64748B` | Teks sekunder, placeholder, label |
| Border | `border-border-custom` | `#D7E2D3` | Garis border elemen |
| Success | `bg-success` / `text-success` | `#16A34A` | Status berhasil / disetujui |
| Warning | `bg-warning` / `text-warning` | `#F59E0B` | Status menunggu / peringatan |
| Danger | `bg-danger` / `text-danger` | `#DC2626` | Status gagal / hapus / error |
| Info | `bg-info` / `text-info` | `#0EA5E9` | Status informasi / berlangsung |

### Contoh Penggunaan

```html
{{-- Tombol Utama --}}
<button class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md">
    Simpan
</button>

{{-- Badge Status --}}
<span class="bg-primary-light text-primary text-xs font-medium px-2.5 py-0.5 rounded-full">
    Aktif
</span>

{{-- Card dengan border palette --}}
<div class="bg-surface border border-border-custom rounded-xl p-6">
    <p class="text-text-main">Konten card</p>
    <p class="text-muted text-sm">Deskripsi pendek</p>
</div>

{{-- Halaman background --}}
<body class="bg-background">
```

---

## 3. Menjalankan Dev Server

Jalankan perintah ini di terminal setiap kali akan mengembangkan view:

```bash
# Terminal 1 — Vite (compile CSS & JS)
npm run dev

# Terminal 2 — Laravel
php artisan serve
```

> **Penting:** Tailwind tidak akan mengenali kelas baru jika Vite tidak berjalan.
> Jangan gunakan Tailwind CDN — proyek ini sudah pakai Vite build.

---

## 4. Membuat Halaman Baru

### Langkah 1 — Buat file view di `pages/`

```bash
# Contoh: halaman daftar SPT
touch resources/views/pages/spt/index.blade.php
```

### Langkah 2 — Gunakan layout utama

```blade
{{-- resources/views/pages/spt/index.blade.php --}}
<x-layout.app title="Daftar SPT">

    <x-layout.navbar />

    <div class="flex">
        <x-layout.sidebar :items="$menuItems" />

        <main class="flex-1 p-6 bg-background min-h-screen">
            <x-layout.page-header
                title="Daftar Surat Perintah Tugas"
                description="Kelola semua SPT yang ada di sistem."
            />

            {{-- Konten halaman --}}

        </main>
    </div>

</x-layout.app>
```

### Langkah 3 — Daftarkan route dan controller

```php
// routes/web.php
Route::get('/spt', [SptController::class, 'index'])->name('spt.index');
```

```php
// app/Http/Controllers/SptController.php
public function index()
{
    return view('pages.spt.index', [
        'menuItems' => [...],
    ]);
}
```

---

## 5. Layout Components

### `<x-layout.app>`
Layout dasar HTML. Membungkus seluruh halaman.

```blade
<x-layout.app title="Judul Halaman" description="Meta description">
    {{-- konten --}}
</x-layout.app>
```

| Prop | Default | Keterangan |
|---|---|---|
| `title` | `'SPJ BPHL 4 Jambi'` | Judul tab browser |
| `description` | _(meta desc default)_ | Meta description SEO |

---

### `<x-layout.navbar>`
Navbar publik (landing page). Tidak memiliki props khusus — hardcoded untuk SPJ BPHL.

```blade
<x-layout.navbar />
```

---

### `<x-layout.sidebar>`
Sidebar navigasi dashboard.

```blade
@php
$menu = [
    ['label' => 'Dashboard',  'url' => '/dashboard', 'icon' => 'home',         'active' => true],
    ['label' => 'Daftar SPT', 'url' => '/spt',       'icon' => 'document-text','active' => false],
    ['label' => 'Laporan',    'url' => '/laporan',    'icon' => 'chart-bar',    'active' => false],
];
@endphp

<x-layout.sidebar :items="$menu" />
```

| Prop | Default | Keterangan |
|---|---|---|
| `items` | `[]` | Array menu dengan key: `label`, `url`, `icon`, `active` |
| `collapsed` | `false` | Jika `true`, sidebar menjadi icon-only |

**Named Slot — Footer Sidebar:**
```blade
<x-layout.sidebar :items="$menu">
    <x-slot:footer>
        <p class="text-xs text-muted">v1.0.0</p>
    </x-slot:footer>
</x-layout.sidebar>
```

---

### `<x-layout.page-header>`
Header halaman dengan judul dan deskripsi.

```blade
<x-layout.page-header
    title="Daftar SPT"
    description="Kelola surat perintah tugas"
>
    <x-slot:actions>
        <x-action.button-primary>+ Tambah SPT</x-action.button-primary>
    </x-slot:actions>
</x-layout.page-header>
```

---

### `<x-layout.breadcrumb>`
Breadcrumb navigasi halaman.

```blade
@php
$crumbs = [
    ['label' => 'Dashboard', 'url' => '/dashboard'],
    ['label' => 'SPT',       'url' => '/spt'],
    ['label' => 'Detail'],   // tidak ada url = halaman aktif
];
@endphp

<x-layout.breadcrumb :items="$crumbs" />
```

---

### `<x-layout.footer>`
Footer halaman.

```blade
<x-layout.footer />
```

---

## 6. Navigation Components

### `<x-navigation.tabs>`
Tab navigasi berbasis URL query param.

```blade
@php
$tabs = [
    ['label' => 'Semua',     'value' => 'all',      'count' => 42],
    ['label' => 'Menunggu',  'value' => 'pending',   'count' => 5],
    ['label' => 'Disetujui', 'value' => 'approved'],
    ['label' => 'Ditolak',   'value' => 'rejected'],
];
@endphp

<x-navigation.tabs :tabs="$tabs" :active="request('tab', 'all')" name="tab" />
```

| Prop | Default | Keterangan |
|---|---|---|
| `tabs` | `[]` | Array tab: `label`, `value`, `count` (opsional), `url` (opsional) |
| `active` | `null` | Value tab yang aktif |
| `name` | `'tab'` | Nama query param di URL |

---

### `<x-navigation.pagination>`
Wrapper pagination Laravel.

```blade
{{-- $data adalah hasil paginate() dari controller --}}
<x-navigation.pagination :paginator="$data" />
```

---

## 7. Dashboard Components

### `<x-dashboard.stat-card>`
Kartu statistik untuk dashboard.

```blade
{{-- Minimal --}}
<x-dashboard.stat-card title="Total SPT" value="128" />

{{-- Lengkap --}}
<x-dashboard.stat-card
    title="Total SPT"
    value="128"
    description="Dibanding bulan lalu"
    icon="document-text"
    trend="+12%"
    :trendUp="true"
    color="green"
/>
```

| Prop | Default | Keterangan |
|---|---|---|
| `title` | _(wajib)_ | Label kartu |
| `value` | _(wajib)_ | Nilai utama yang ditampilkan besar |
| `description` | `null` | Teks kecil di bawah nilai |
| `icon` | `null` | Nama icon Heroicon |
| `trend` | `null` | Teks trend, misal `'+12%'` |
| `trendUp` | `null` | `true` = hijau, `false` = merah, `null` = abu |
| `color` | `'gray'` | `gray \| blue \| green \| red \| yellow` — warna background icon |

---

### `<x-dashboard.chart-card>`
Wrapper card untuk grafik/chart.

```blade
<x-dashboard.chart-card title="Tren SPT per Bulan">
    {{-- Letakkan library chart di sini, misal Chart.js canvas --}}
    <canvas id="sptChart"></canvas>
</x-dashboard.chart-card>
```

---

### `<x-dashboard.recent-activity>`
Daftar aktivitas terkini.

```blade
@php
$activities = [
    ['title' => 'SPT #001 disetujui', 'time' => '10 menit lalu', 'user' => 'Admin'],
    ['title' => 'SPD #023 dibuat',    'time' => '1 jam lalu',    'user' => 'Budi'],
];
@endphp

<x-dashboard.recent-activity :activities="$activities" />
```

---

## 8. Data Components

### `<x-data.table>`
Tabel data dengan support array.

```blade
@php
$headers = ['No', 'Nama', 'Jabatan', 'Status', 'Aksi'];

$rows = $pegawai->map(fn($p, $i) => [
    $i + 1,
    $p->nama,
    $p->jabatan,
    '<x-data.status-badge status="' . $p->status . '" />',
    '<x-action.dropdown-action :items="[...]" />',
]);
@endphp

<x-data.table :headers="$headers" :rows="$rows" :striped="true" />
```

| Prop | Default | Keterangan |
|---|---|---|
| `headers` | `[]` | Array string atau array `['label','key','sortable']` |
| `rows` | `[]` | Array of arrays. Cell boleh berisi HTML |
| `striped` | `false` | Baris genap akan diberi warna berbeda |

> **Catatan:** Cell mendukung raw HTML (`{!! $cell !!}`). Pastikan data yang dirender aman dari XSS.

---

### `<x-data.badge>`
Badge label generik dengan warna kustom.

```blade
<x-data.badge label="Aktif"    color="green"  />
<x-data.badge label="Menunggu" color="yellow" />
<x-data.badge label="Ditolak"  color="red"    />
<x-data.badge label="Draft"    color="gray"   />
<x-data.badge label="Premium"  color="purple" />
```

| Nilai `color` | Tampilan |
|---|---|
| `gray` | Abu-abu (default) |
| `blue` | Biru |
| `green` | Hijau |
| `red` | Merah |
| `yellow` | Kuning |
| `purple` | Ungu |
| `orange` | Oranye |

---

### `<x-data.status-badge>`
Badge khusus status SPT/SPD — otomatis mapping label dan warna.

```blade
<x-data.status-badge status="draft"     />  {{-- Abu → "Draft" --}}
<x-data.status-badge status="pending"   />  {{-- Kuning → "Menunggu" --}}
<x-data.status-badge status="approved"  />  {{-- Hijau → "Disetujui" --}}
<x-data.status-badge status="rejected"  />  {{-- Merah → "Ditolak" --}}
<x-data.status-badge status="completed" />  {{-- Hijau → "Selesai" --}}
<x-data.status-badge status="cancelled" />  {{-- Merah → "Dibatalkan" --}}
<x-data.status-badge status="ongoing"   />  {{-- Biru → "Berlangsung" --}}
<x-data.status-badge status="active"    />  {{-- Biru → "Aktif" --}}
<x-data.status-badge status="inactive"  />  {{-- Abu → "Nonaktif" --}}
```

---

### `<x-data.empty-state>`
Tampilan kosong ketika tidak ada data.

```blade
<x-data.empty-state
    title="Tidak ada SPT"
    description="Belum ada surat perintah tugas yang dibuat."
>
    <x-slot:action>
        <x-action.button-primary>+ Tambah SPT</x-action.button-primary>
    </x-slot:action>
</x-data.empty-state>
```

---

### `<x-data.timeline>`
Timeline aktivitas atau riwayat perubahan.

```blade
@php
$events = [
    [
        'title'       => 'SPT dibuat',
        'description' => 'Oleh Admin Pusat',
        'time'        => '25 Jun 2025, 08:00',
        'icon'        => 'document-add',
    ],
    [
        'title' => 'Menunggu persetujuan',
        'time'  => '25 Jun 2025, 08:05',
        'icon'  => 'clock',
    ],
    [
        'title'       => 'Disetujui Kepala Balai',
        'description' => 'Disetujui oleh Dr. Hendra',
        'time'        => '25 Jun 2025, 10:30',
        'icon'        => 'check-circle',
    ],
];
@endphp

<x-data.timeline :events="$events" />
```

| Key dalam `events` | Keterangan |
|---|---|
| `title` | _(wajib)_ Judul event |
| `time` | _(wajib)_ Waktu event |
| `description` | _(opsional)_ Keterangan tambahan |
| `icon` | _(opsional)_ Nama icon Heroicon |

---

### `<x-data.stepper>`
Indikator langkah proses multi-step (wizard).

```blade
@php
$steps = [
    ['label' => 'Data Pegawai',   'description' => 'Isi biodata'],
    ['label' => 'Detail Tugas',   'description' => 'Tujuan & tanggal'],
    ['label' => 'Upload Berkas',  'description' => 'Dokumen pendukung'],
    ['label' => 'Konfirmasi',     'description' => 'Review & kirim'],
];
@endphp

<x-data.stepper :steps="$steps" :current="2" />
```

| Prop | Default | Keterangan |
|---|---|---|
| `steps` | `[]` | Array langkah dengan key `label` dan `description` (opsional) |
| `current` | `1` | Nomor langkah yang sedang aktif (1-based) |

---

## 9. Form Components

### `<x-form.input>`

```blade
{{-- Minimal --}}
<x-form.input name="nama" label="Nama Lengkap" />

{{-- Dengan semua opsi --}}
<x-form.input
    name="email"
    label="Email"
    type="email"
    placeholder="contoh@email.com"
    :value="old('email', $user->email ?? null)"
    :required="true"
    :error="$errors->first('email')"
    hint="Gunakan email kantor"
/>
```

| Prop | Default | Keterangan |
|---|---|---|
| `name` | _(wajib)_ | Atribut `name` & `id` |
| `label` | `null` | Label di atas input |
| `type` | `'text'` | Tipe input HTML |
| `placeholder` | `null` | Placeholder |
| `value` | `null` | Nilai awal (support `old()`) |
| `required` | `false` | Tandai wajib diisi |
| `disabled` | `false` | Nonaktifkan input |
| `error` | `null` | Pesan error validasi |
| `hint` | `null` | Teks bantuan (muncul jika tidak ada error) |

---

### `<x-form.select>`

```blade
{{-- Dengan array asosiatif --}}
<x-form.select
    name="jabatan"
    label="Jabatan"
    :options="['pns' => 'PNS', 'pppk' => 'PPPK', 'honorer' => 'Honorer']"
    :selected="old('jabatan')"
    :required="true"
    :error="$errors->first('jabatan')"
/>

{{-- Dengan array dari database --}}
<x-form.select
    name="pegawai_id"
    label="Pilih Pegawai"
    :options="$pegawai->pluck('nama', 'id')"
/>
```

---

### `<x-form.textarea>`

```blade
<x-form.textarea
    name="keterangan"
    label="Keterangan"
    placeholder="Tuliskan keterangan perjalanan dinas..."
    :rows="4"
    :error="$errors->first('keterangan')"
/>
```

---

### `<x-form.date-picker>`

```blade
<x-form.date-picker
    name="tanggal_berangkat"
    label="Tanggal Berangkat"
    :value="old('tanggal_berangkat')"
    :required="true"
/>
```

---

### `<x-form.file-upload>`

```blade
<x-form.file-upload
    name="dokumen_spt"
    label="Upload Dokumen SPT"
    accept=".pdf,.docx"
    hint="Format: PDF atau DOCX, maks. 5MB"
/>
```

---

### `<x-form.search>`

```blade
<x-form.search
    name="q"
    placeholder="Cari nama pegawai..."
    :value="request('q')"
/>
```

---

## 10. Action Components

### `<x-action.button>`
Base button yang bisa dikustomisasi penuh via kelas Tailwind.

```blade
{{-- Tombol dengan warna palette kustom --}}
<x-action.button class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md">
    Simpan
</x-action.button>

{{-- Tombol outline --}}
<x-action.button class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md">
    Batal
</x-action.button>

{{-- Tombol danger --}}
<x-action.button class="bg-danger hover:bg-red-700 text-white px-4 py-2 text-sm rounded-md">
    Hapus
</x-action.button>

{{-- Submit form --}}
<x-action.button type="submit" class="bg-primary hover:bg-primary-hover text-white px-5 py-2.5 rounded-md">
    Kirim Formulir
</x-action.button>
```

---

### `<x-action.button-primary>`
Shortcut tombol utama (sudah preset style hitam). Untuk menggunakan warna palette, gunakan `<x-action.button>` dengan kelas manual.

```blade
<x-action.button-primary>Masuk</x-action.button-primary>
```

---

### `<x-action.dropdown-action>`
Dropdown menu aksi (Edit, Hapus, dll). Membutuhkan Alpine.js.

```blade
@php
$aksi = [
    ['label' => 'Detail',  'url' => route('spt.show', $spt), 'icon' => 'eye'],
    ['label' => 'Edit',    'url' => route('spt.edit', $spt), 'icon' => 'pencil'],
    ['divider' => true],
    ['label' => 'Hapus',   'url' => route('spt.destroy', $spt), 'icon' => 'trash', 'danger' => true],
];
@endphp

<x-action.dropdown-action :items="$aksi" label="Aksi" align="right" />
```

| Prop | Default | Keterangan |
|---|---|---|
| `items` | `[]` | Array item: `label`, `url`, `icon` (opsional), `danger` (opsional), `divider` (opsional) |
| `label` | `'Aksi'` | Teks tombol trigger |
| `align` | `'right'` | Posisi dropdown: `right \| left` |

---

### `<x-action.action-menu>`
Versi icon-only dari dropdown action (titik tiga / kebab menu).

```blade
<x-action.action-menu :items="$aksi" />
```

---

## 11. Feedback Components

### `<x-feedback.alert>`
Notifikasi inline di dalam halaman.

```blade
{{-- Dari session flash --}}
@if(session('success'))
    <x-feedback.alert type="success" title="Berhasil!">
        {{ session('success') }}
    </x-feedback.alert>
@endif

@if($errors->any())
    <x-feedback.alert type="error" title="Terjadi Kesalahan" :dismissible="true">
        <ul class="list-disc pl-4 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-feedback.alert>
@endif
```

| Prop | Default | Keterangan |
|---|---|---|
| `type` | `'info'` | `info \| success \| warning \| error` |
| `title` | `null` | Judul alert (bold) |
| `dismissible` | `false` | Tambahkan tombol tutup (butuh Alpine.js) |

---

### `<x-feedback.modal>`
Dialog modal. Dibuka dengan JS `openModal('id')`.

```blade
{{-- Trigger --}}
<x-action.button
    onclick="openModal('modal-tambah-spt')"
    class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md text-sm"
>
    + Tambah SPT
</x-action.button>

{{-- Modal --}}
<x-feedback.modal id="modal-tambah-spt" title="Tambah SPT Baru" size="lg">
    <form method="POST" action="{{ route('spt.store') }}">
        @csrf
        <x-form.input name="nomor_spt" label="Nomor SPT" :required="true" />
        <x-form.select name="pegawai_id" label="Pegawai" :options="$pegawai->pluck('nama','id')" />
    </form>

    <x-slot:footer>
        <x-action.button onclick="closeModal('modal-tambah-spt')"
            class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md">
            Batal
        </x-action.button>
        <x-action.button type="submit" form="form-spt"
            class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md">
            Simpan
        </x-action.button>
    </x-slot:footer>
</x-feedback.modal>
```

| Prop | Default | Keterangan |
|---|---|---|
| `id` | _(wajib)_ | ID unik modal |
| `title` | `null` | Judul header modal |
| `size` | `'md'` | `sm \| md \| lg \| xl` |
| `closeable` | `true` | Tampilkan tombol X dan klik backdrop untuk tutup |

**JS Helper (sudah otomatis include di dalam komponen):**
```js
openModal('id-modal')   // buka modal
closeModal('id-modal')  // tutup modal
```

---

### `<x-feedback.confirm-dialog>`
Dialog konfirmasi sebelum aksi destruktif.

```blade
<x-feedback.confirm-dialog
    id="confirm-hapus"
    title="Hapus SPT?"
    message="Data SPT yang dihapus tidak dapat dikembalikan."
    confirm-label="Ya, Hapus"
    cancel-label="Batal"
    action="{{ route('spt.destroy', $spt) }}"
    method="DELETE"
/>

<x-action.button
    onclick="openModal('confirm-hapus')"
    class="bg-danger hover:bg-red-700 text-white px-3 py-1.5 text-sm rounded-md"
>
    Hapus
</x-action.button>
```

---

### `<x-feedback.toast>`
Notifikasi pop-up sementara.

```blade
<x-feedback.toast />

{{-- Memicu toast dari script atau Alpine: --}}
<script>
    // Trigger toast dari PHP flash session
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', () => {
            showToast('{{ session('success') }}', 'success');
        });
    @endif
</script>
```

---

### `<x-feedback.skeleton>`
Placeholder loading saat data belum tersedia.

```blade
{{-- Loading state --}}
@if($loading)
    <x-feedback.skeleton lines="4" />
@else
    <x-data.table :headers="$headers" :rows="$rows" />
@endif
```

---

## 12. Utility Components

### `<x-utility.icon>`
Icon dari set Heroicon. Digunakan di seluruh komponen.

```blade
{{-- Ukuran default: w-5 h-5 --}}
<x-utility.icon name="home" />
<x-utility.icon name="document-text" class="w-6 h-6 text-primary" />
<x-utility.icon name="check-circle"  class="w-4 h-4 text-success" />
<x-utility.icon name="x-circle"      class="w-4 h-4 text-danger" />
```

---

### `<x-utility.avatar>`
Avatar foto atau inisial nama.

```blade
{{-- Dengan foto --}}
<x-utility.avatar name="Budi Santoso" src="{{ $user->foto_url }}" size="md" />

{{-- Tanpa foto (otomatis inisial + warna) --}}
<x-utility.avatar name="Budi Santoso" size="lg" />
<x-utility.avatar name="Ani Wulandari" size="sm" shape="square" />
```

| Prop | Default | Keterangan |
|---|---|---|
| `name` | _(wajib)_ | Nama lengkap (untuk inisial dan alt text) |
| `src` | `null` | URL foto. Jika null, tampilkan inisial |
| `size` | `'md'` | `xs \| sm \| md \| lg \| xl` |
| `shape` | `'circle'` | `circle \| square` |

---

### `<x-utility.tooltip>`
Tooltip teks saat hover.

```blade
<x-utility.tooltip text="Klik untuk menyalin nomor dokumen">
    <x-utility.copy-button :value="$spt->nomor" />
</x-utility.tooltip>
```

---

### `<x-utility.copy-button>`
Tombol salin teks ke clipboard.

```blade
<x-utility.copy-button :value="$spt->nomor_spt" />
<x-utility.copy-button value="SPT/BPHL4/2025/001" label="Salin Nomor" />
```

---

## Contoh Halaman Lengkap

```blade
{{-- resources/views/pages/spt/index.blade.php --}}
<x-layout.app title="Daftar SPT — SPJ BPHL">

    <x-layout.navbar />

    <div class="flex min-h-screen">
        <x-layout.sidebar :items="$menuItems" />

        <main class="flex-1 bg-background p-6 space-y-6">

            <x-layout.breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'SPT'],
            ]" />

            <x-layout.page-header title="Daftar SPT" description="Kelola semua surat perintah tugas">
                <x-slot:actions>
                    <x-action.button
                        onclick="openModal('modal-tambah')"
                        class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md inline-flex items-center gap-2"
                    >
                        <x-utility.icon name="plus" class="w-4 h-4" />
                        Tambah SPT
                    </x-action.button>
                </x-slot:actions>
            </x-layout.page-header>

            @if(session('success'))
                <x-feedback.alert type="success">{{ session('success') }}</x-feedback.alert>
            @endif

            <x-navigation.tabs :tabs="[
                ['label' => 'Semua',     'value' => 'all'],
                ['label' => 'Menunggu',  'value' => 'pending'],
                ['label' => 'Disetujui', 'value' => 'approved'],
            ]" :active="request('tab', 'all')" />

            <x-data.table
                :headers="['No', 'Nomor SPT', 'Pegawai', 'Tujuan', 'Status', 'Aksi']"
                :rows="$rows"
                :striped="true"
            />

            <x-navigation.pagination :paginator="$spt" />

        </main>
    </div>

    {{-- Modal Tambah --}}
    <x-feedback.modal id="modal-tambah" title="Tambah SPT" size="lg">
        <form id="form-tambah-spt" method="POST" action="{{ route('spt.store') }}">
            @csrf
            <div class="space-y-4">
                <x-form.input name="nomor_spt"   label="Nomor SPT"   :required="true" />
                <x-form.input name="tujuan"       label="Tujuan"      :required="true" />
                <x-form.date-picker name="tanggal" label="Tanggal"    :required="true" />
                <x-form.select
                    name="pegawai_id"
                    label="Pegawai"
                    :options="$pegawai->pluck('nama', 'id')"
                    :required="true"
                />
            </div>
        </form>

        <x-slot:footer>
            <x-action.button
                onclick="closeModal('modal-tambah')"
                class="border border-border-custom text-text-main hover:bg-background px-4 py-2 text-sm rounded-md"
            >
                Batal
            </x-action.button>
            <x-action.button
                type="submit" form="form-tambah-spt"
                class="bg-primary hover:bg-primary-hover text-white px-4 py-2 text-sm rounded-md"
            >
                Simpan
            </x-action.button>
        </x-slot:footer>
    </x-feedback.modal>

</x-layout.app>
```

---

## Tips & Best Practices

1. **Props Opsional** — Jika prop tidak ditulis, komponen akan menggunakan nilai default-nya. Tidak perlu menuliskan semua prop.
2. **Atribut HTML** — Semua komponen meneruskan atribut ekstra (misal `id`, `data-*`, `wire:model`) langsung ke elemen HTML melalui `$attributes->merge()`.
3. **Error Validasi Form** — Selalu teruskan `$errors->first('nama_field')` ke prop `:error` pada form component.
4. **Color Palette** — Selalu gunakan warna dari palette di atas untuk konsistensi. Hindari hardcode warna arbitrary seperti `bg-[#537D44]` — gunakan kelas `bg-primary`.
5. **Alpine.js** — Komponen `dropdown-action`, `alert` (dismissible), dan `feedback/modal` membutuhkan Alpine.js aktif. Pastikan CDN Alpine sudah ada di `partials/scripts.blade.php`.
