# 🏗️ Developing Clean — Panduan Arsitektur & Alur Data Laravel

> Panduan ini dirangkum dari pola pengembangan nyata pada **Sistem Tugas Akhir** (Laravel).
> Tujuannya agar konsep ini bisa diterapkan langsung ke proyek Laravel lainnya.

---

## 1. Arsitektur Utama: MVC + Service Pattern

Sistem ini tidak hanya menggunakan MVC murni, tapi menambahkan **Service Layer** di antara Controller dan Model. Ini adalah pola yang sangat direkomendasikan untuk proyek menengah ke atas.

```
Browser → Routes → Middleware → Controller → Service → Model/DB
                                    ↓
                                  View (Blade)
```

### Mengapa Service Layer?

| Tanpa Service Layer | Dengan Service Layer |
|---|---|
| Logic bisnis menumpuk di Controller | Controller hanya mengatur alur (tipis) |
| Controller sulit di-*test* | Service mudah di-*unit test* secara terpisah |
| Kode duplikasi antar Controller | Logic bisa di-*reuse* dari Controller mana saja |

---

## 2. Alur Data Detail (Contoh: Lihat Data Mahasiswa)

### Step 1 — Route
Definisikan URL dan arahkan ke Controller. Kelompokkan berdasarkan peran (role) user.

```php
// routes/web/admin.php
Route::prefix('super-admin')->name('super_admin.')->middleware(['super_admin'])->group(function () {
    Route::get('/mahasiswa', [SuperAdminController::class, 'mahasiswa'])->name('mahasiswa');
});
```

**Prinsip:**
- Pisahkan file route per peran: `admin.php`, `dosen.php`, `mahasiswa.php`, `koor.php`
- Selalu gunakan named routes (`.name('...')`) agar bisa dipanggil via `route('...')` di seluruh kode
- Lindungi dengan middleware yang sesuai

---

### Step 2 — Middleware (Gatekeeper)
Middleware berjalan **sebelum** request sampai ke Controller. Gunakan untuk:
- Cek autentikasi & otorisasi role
- Men-*set* data konteks ke session / view

```php
// app/Http/Middleware/DosenContext.php
public function handle(Request $request, Closure $next): Response
{
    if (auth()->check() && auth()->user()->isDosen()) {
        // Set default context jika belum ada di session
        if (!session()->has('dosen_context')) {
            session(['dosen_context' => 'pembimbing']);
        }

        // Share variabel global ke SEMUA view
        view()->share('dosenContext', session('dosen_context'));
    }

    return $next($request);
}
```

**Prinsip:**
- Middleware bukan untuk logika bisnis, hanya untuk *gating* dan *konteks*
- Gunakan `view()->share()` untuk variabel yang dibutuhkan banyak view sekaligus

---

### Step 3 — Controller (Tipis / Thin Controller)
Controller harus **setipis mungkin**. Tugasnya hanya:
1. Terima request
2. Delegasikan ke Service
3. Kembalikan View atau Redirect

```php
// app/Http/Controllers/SuperAdminController.php
public function mahasiswa()
{
    // Hanya delegasi ke Service, tidak ada logika di sini
    $data = $this->superAdminService->getMahasiswaManagementData();

    return view('dashboard.super_admin.view_mahasiswa', $data);
}
```

**Injeksi Service via Constructor (Dependency Injection):**
```php
class SuperAdminController extends Controller
{
    public function __construct(
        private SuperAdminService $superAdminService  // Laravel auto-inject
    ) {}
}
```

**Prinsip:**
- Controller tidak boleh berisi query Eloquent secara langsung
- Gunakan Constructor Injection untuk Service
- Satu method = satu tanggung jawab

---

### Step 4 — Service Layer (Pusat Logika Bisnis)
Di sinilah semua query database, kalkulasi, dan transformasi data dilakukan.

```php
// app/Services/SuperAdminService.php
public function getMahasiswaManagementData(): array
{
    // Query via Model (menggunakan scope)
    $totalMahasiswa = User::mahasiswa()->count();
    $lulus = TugasAkhir::where('status', 'completed')->count();
    $passRate = $totalMahasiswa > 0 ? round(($lulus / $totalMahasiswa) * 100) : 0;

    // Transformasi data untuk View
    $mahasiswaPage = TugasAkhir::with([
        'mahasiswa', 'pembimbing1', 'latestProposal', 'latestSeminar', 'latestSidang',
    ])->whereHas('mahasiswa')->latest()->paginate(10);

    $mahasiswaPage->getCollection()->transform(function (TugasAkhir $ta) {
        // Transformasi setiap record menjadi array siap pakai di View
        return [
            'nama'     => $ta->mahasiswa?->name ?? '-',
            'nim'      => $ta->mahasiswa?->nim ?? '-',
            'tahap'    => $this->determineTahap($ta),
            'progress' => $this->determineProgress($ta),
        ];
    });

    // Kembalikan array terstruktur ke Controller
    return [
        'mahasiswa'       => $mahasiswaPage,
        'kelulusan_stats' => ['lulus' => $lulus, 'pass_rate' => $passRate],
    ];
}
```

**Prinsip:**
- Return type selalu `array` agar mudah di-*pass* ke View
- Transformasi data di Service, bukan di Blade
- Gunakan `with([...])` untuk eager loading dan hindari N+1 Query

---

### Step 5 — Model (Representasi Database)
Model bertugas mendefinisikan struktur tabel, relasi antar tabel, dan scope query yang dapat digunakan kembali.

```php
// app/Models/User.php

// --- Relationships ---
public function tugasAkhir()
{
    return $this->hasOne(TugasAkhir::class)->latestOfMany();
}

// --- Query Scopes (filter yang reusable) ---
public function scopeMahasiswa($query)
{
    return $query->where('role', 'mahasiswa');
    // Dipanggil dengan: User::mahasiswa()->get()
}

public function scopeDosen($query)
{
    return $query->whereIn('role', ['dosen', 'koor_ta', 'kaprodi']);
    // Dipanggil dengan: User::dosen()->count()
}

// --- Helper Methods (logika pada instance) ---
public function isMahasiswa(): bool
{
    return $this->role === 'mahasiswa';
}

public function isDosen(): bool
{
    return in_array($this->role, ['dosen', 'koor_ta', 'kaprodi']);
}
```

**Prinsip:**
- Pisahkan section dengan komentar: `Relationships`, `Query Scopes`, `Helpers`
- **Query Scope** untuk filter yang berulang di kueri
- **Helper Method** untuk logika pada satu object (instance)
- Gunakan **Casts** untuk kolom Enum agar otomatis ter-*cast* ke PHP Enum

---

## 3. Enums — Menghindari "Magic String"

Daripada menyebar string seperti `'disetujui'`, `'pending'`, `'ditolak'` di mana-mana, gunakan PHP Backed Enum.

```php
// app/Enums/ApprovalDosenStatus.php
enum ApprovalDosenStatus: string
{
    case PENDING   = 'pending';
    case DISETUJUI = 'disetujui';
    case DITOLAK   = 'ditolak';
}
```

**Pemakaian di Model (auto-cast):**
```php
// app/Models/TugasAkhir.php
protected function casts(): array
{
    return [
        'approval_pembimbing_status' => ApprovalDosenStatus::class, // otomatis cast
    ];
}

// Sekarang bisa dibandingkan dengan aman:
public function isApprovalSelesai(): bool
{
    return $this->approval_pembimbing_status === ApprovalDosenStatus::DISETUJUI;
}
```

**Keuntungan:**
- Tidak ada typo pada string status
- IDE bisa auto-complete
- Perubahan nilai cukup di satu tempat

---

## 4. Role-Based Routing & Controller Separation

Setiap peran user memiliki file route dan controller sendiri.

```
routes/
├── web.php          → entry point, import semua file route
├── web/
│   ├── admin.php    → route super_admin
│   ├── dosen.php    → route dosen (pembimbing & penguji)
│   ├── koor.php     → route koordinator TA & Prodi
│   └── mahasiswa.php→ route mahasiswa

app/Http/Controllers/
├── SuperAdminController.php
├── DosenPembimbingController.php
├── DosenPengujiController.php
├── KoorTAController.php
├── KoorProdiController.php
└── UserController.php  → dashboard & routing berdasarkan role
```

**Pattern redirect by role (di UserController):**
```php
public function index()
{
    $user = Auth::user();

    // Dispatch ke dashboard yang sesuai berdasarkan role
    if ($user->isSuperAdmin())  return redirect()->route('super_admin.dashboard');
    if ($user->isDosen())       return redirect()->route('dosen.pembimbing.dashboard');
    if ($user->isKoorTA())      return redirect()->route('portal');
    if ($user->isKoorProdi())   return redirect()->route('portal');

    // Default: mahasiswa
    return view('dashboard.mahasiswa.mahasiswa', [...]);
}
```

---

## 5. Query Scopes pada Model (Reusable Filters)

Scope memungkinkan filter kueri kompleks ditulis sekali dan dipanggil berkali-kali.

```php
// app/Models/TugasAkhir.php

// Scope dengan parameter
public function scopeForPembimbing($query, int $dosenId)
{
    return $query->where(function ($q) use ($dosenId) {
        $q->where('pembimbing_1_id', $dosenId)
          ->orWhere('pembimbing_2_id', $dosenId);
    });
}

// Scope tanpa parameter
public function scopeActive($query)
{
    return $query->where('status', TugasAkhirStatus::ACTIVE);
}
```

**Cara panggil:**
```php
// Scope tanpa parameter
TugasAkhir::active()->get();

// Scope dengan parameter
TugasAkhir::forPembimbing($dosenId)->with('mahasiswa')->get();

// Bisa di-chain
TugasAkhir::active()->forPembimbing($dosenId)->count();
```

---

## 6. Eager Loading — Hindari N+1 Query Problem

Selalu gunakan `with([...])` saat akan mengakses relasi di dalam loop.

```php
// ❌ BURUK — N+1 Query (1 query untuk TugasAkhir + N query untuk setiap mahasiswa)
$tas = TugasAkhir::all();
foreach ($tas as $ta) {
    echo $ta->mahasiswa->name; // query baru setiap iterasi!
}

// ✅ BAIK — Eager Loading (hanya 2 query total)
$tas = TugasAkhir::with(['mahasiswa', 'pembimbing1', 'latestSeminar'])->get();
foreach ($tas as $ta) {
    echo $ta->mahasiswa->name; // sudah ada di memori, tidak ada query baru
}
```

---

## 7. Prinsip Umum yang Bisa Diterapkan

| Prinsip | Implementasi |
|---|---|
| **Thin Controller** | Controller hanya delegasi ke Service, tidak ada query |
| **Fat Service** | Semua logika bisnis dan query ada di Service |
| **Reusable Scopes** | Filter query didefinisikan di Model sebagai scope |
| **Type Safety via Enum** | Hindari magic string untuk status/tipe |
| **Eager Loading** | Selalu `with([...])` saat akses relasi di loop |
| **Role Separation** | Pisahkan route dan controller per peran |
| **Middleware for Context** | Gunakan middleware untuk set data konteks session/view |
| **Named Routes** | Selalu beri nama route untuk kemudahan refactor |
| **Dependency Injection** | Inject Service via constructor, bukan `new ServiceClass()` |
| **Sections in Model** | Pisahkan `Relationships`, `Scopes`, `Helpers` dengan komentar |

---

## 8. Struktur Direktori yang Direkomendasikan

```
app/
├── Enums/                  → PHP Enums untuk status, tipe, dll
├── Http/
│   ├── Controllers/        → Thin controllers per fitur/role
│   └── Middleware/         → Gating, context setting
├── Models/                 → Eloquent models + scopes + helpers
└── Services/               → Business logic & data transformation

routes/
├── web.php                 → Entry point
└── web/
    ├── admin.php
    ├── dosen.php
    ├── mahasiswa.php
    └── koor.php

resources/views/
└── dashboard/
    ├── super_admin/
    ├── mahasiswa/
    ├── dosen/
    └── components/         → Blade components yang reusable
```

---

> **Kesimpulan:** Pola ini membuat kode mudah dibaca, mudah di-*maintain*, dan mudah dikembangkan.
> Kunci utamanya adalah **pemisahan tanggung jawab** — setiap layer punya perannya sendiri dan tidak mencampuri urusan layer lain.
