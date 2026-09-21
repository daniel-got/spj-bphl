# 🏗️ Developing Clean — Panduan Arsitektur & Alur Kerja Laravel (SPJ BPHL)

> Panduan ini adalah dokumen **wajib** bagi *developer* dalam mengembangkan fitur baru di proyek **SPJ BPHL** (Sistem Perjalanan Dinas BPHL).
> Proyek ini meninggalkan MVC Tradisional (Fat Controller) dan beralih menggunakan pola **Service Layer + Form Request**
> agar kode lebih *scalable*, *reusable*, dan mudah di-*maintenance*.

---

## 1. Arsitektur Utama: MVC + Service Pattern

Sistem ini tidak hanya menggunakan MVC murni, tapi menambahkan **Service Layer** di antara Controller dan Model,
serta **Form Request** sebagai lapisan validasi terpisah.

```
Browser → Route → Form Request → Middleware → Controller → Service → Model/DB
                                                   ↓
                                                View (Blade)
```

**Alur data bergerak secara berurutan:**

1. **Route (`routes/web.php`):** Menerima permintaan URL dan mengarahkannya ke Controller.
2. **Form Request (`app/Http/Requests/`):** Menyaring input pengguna. Jika validasi gagal, kembalikan error. Jika lolos, teruskan ke Controller.
3. **Middleware (`CheckRole`):** Berjalan **sebelum** request sampai ke Controller. Digunakan untuk cek autentikasi dan otorisasi role.
4. **Controller (`app/Http/Controllers/`):** Bertugas sebagai "Pengarah Lalu Lintas" (*Thin Controller*). Hanya menerima data valid, memanggil Service, dan mengembalikan View atau Redirect. **Dilarang keras** menaruh logika bisnis di sini.
5. **Service (`app/Services/`):** Bertugas sebagai "Otak Aplikasi" (*Business Logic*). Semua logika kompleks, transaksi database, kalkulasi, dan transformasi data dilakukan di sini.
6. **Model (`app/Models/`):** Representasi database murni. Berisi relasi, *fillable*, *casts*, dan *query scopes*.
7. **View (`resources/views/`):** Merender HTML menggunakan Blade Components yang sudah tersedia.

### Mengapa Service Layer?

| Tanpa Service Layer | Dengan Service Layer |
|---|---|
| Logic bisnis menumpuk di Controller | Controller hanya mengatur alur (tipis) |
| Controller sulit di-*test* | Service mudah di-*unit test* secara terpisah |
| Kode duplikasi antar Controller | Logic bisa di-*reuse* dari Controller mana saja |

---

## 2. Alur Pengembangan Fitur Baru (6 Langkah Wajib)

Ikuti urutan **6 langkah** ini setiap kali membuat modul/fitur baru. Contoh studi kasus: **Fitur Pegawai**.

---

### Langkah 1: Database Layer (Migration & Model)

*Siapkan pondasi data terlebih dahulu.*

1. **Jalankan command:** `php artisan make:model Pegawai -m`
2. **Edit Migration** (`database/migrations/..._create_data_pegawai_table.php`):
   *(Nama tabel menggunakan prefix `data_` sesuai konvensi proyek ini)*
   ```php
   public function up() {
       Schema::create('data_pegawai', function (Blueprint $table) {
           $table->id();
           $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
           $table->string('nip')->unique();
           $table->string('nama_pegawai');
           $table->string('pangkat_golongan')->nullable();
           $table->string('jabatan')->nullable();
           $table->string('sub_seksi')->nullable();
           $table->timestamps();
       });
   }
   ```
3. **Migrate:** `php artisan migrate`
4. **Edit Model** (`app/Models/Pegawai.php`):
   ```php
   class Pegawai extends Model {
       protected $table = 'data_pegawai'; // konvensi prefix data_

       protected $fillable = [
           'user_id', 'nip', 'nama_pegawai',
           'pangkat_golongan', 'jabatan', 'sub_seksi',
       ];

       // -------------------------------------------------------------------------
       // Relationships
       // -------------------------------------------------------------------------

       /**
        * Setiap Pegawai memiliki satu akun User untuk login.
        * Akses: $pegawai->user->email
        */
       public function user(): BelongsTo {
           return $this->belongsTo(User::class, 'user_id');
       }

       // -------------------------------------------------------------------------
       // Query Scopes
       // -------------------------------------------------------------------------

       /**
        * Filter berdasarkan kata kunci (search by nama, nip, atau sub_seksi).
        * Dipanggil: Pegawai::search($keyword)->paginate(10)
        */
       public function scopeSearch($query, ?string $keyword) {
           if (!$keyword) return $query;

           return $query->where(function ($q) use ($keyword) {
               $q->where('nama_pegawai', 'like', "%{$keyword}%")
                 ->orWhere('nip', 'like', "%{$keyword}%")
                 ->orWhere('sub_seksi', 'like', "%{$keyword}%");
           });
       }
   }
   ```

**Prinsip Model:**
- Nama tabel menggunakan prefix `data_` (contoh: `data_pegawai`, `data_spt`, `data_spd`)
- Pisahkan section dengan komentar: `Relationships`, `Query Scopes`, `Helpers`
- **Query Scope** untuk filter yang berulang di kueri
- Gunakan **Casts** untuk kolom JSON (seperti `pegawai_ditugaskan` di model Spt) agar otomatis ter-*cast* ke array PHP

---

### Langkah 2: Validation Layer (Form Request)

*Buat filter keamanan untuk input dari form — jangan pakai `$request->validate()` di Controller.*

1. **Jalankan command:** `php artisan make:request Admin/StorePegawaiRequest`
   *(Sub-folder sesuai role agar terorganisir: `app/Http/Requests/Admin/`)*
2. **Edit file** (`app/Http/Requests/Admin/StorePegawaiRequest.php`):
   ```php
   public function authorize(): bool {
       // Middleware CheckRole sudah menjaga pintu, tapi kita verifikasi ulang di sini
       return auth()->check() && auth()->user()->role === 'admin';
   }

   public function rules(): array {
       return [
           'nip'              => 'required|string|unique:data_pegawai,nip',
           'nama_pegawai'     => 'required|string|max:255',
           'pangkat_golongan' => 'nullable|string|max:100',
           'jabatan'          => 'nullable|string|max:255',
           'sub_seksi'        => 'nullable|string|max:255',
           'email'            => 'required|email|unique:users,email',
           'role'             => 'required|string|in:' . implode(',', UserRole::values()),
       ];
   }
   ```

---

### Langkah 3: Business Logic Layer (Service)

*Buat "Otak" yang memproses data — semua query dan logika ada di sini.*

1. Buat sub-folder sesuai domain jika belum ada: `app/Services/Admin/`
2. Buat file baru: `app/Services/Admin/PegawaiService.php`
   ```php
   <?php

   namespace App\Services\Admin;

   use App\Models\User;
   use App\Models\Pegawai;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Hash;

   class PegawaiService
   {
       /**
        * Menyimpan data user baru beserta profil pegawainya dalam satu transaksi.
        * Jika salah satu gagal, keduanya di-rollback.
        */
       public function createPegawai(array $data): Pegawai
       {
           return DB::transaction(function () use ($data) {

               // 1. Buat Akun User untuk login
               $user = User::create([
                   'name'     => $data['nama_pegawai'],
                   'email'    => $data['email'],
                   'password' => Hash::make($data['nip']), // password default = NIP
                   'role'     => $data['role'],
               ]);

               // 2. Buat profil Pegawai yang terhubung ke User
               return Pegawai::create([
                   'user_id'          => $user->id,
                   'nip'              => $data['nip'],
                   'nama_pegawai'     => $data['nama_pegawai'],
                   'pangkat_golongan' => $data['pangkat_golongan'] ?? null,
                   'jabatan'          => $data['jabatan'] ?? null,
                   'sub_seksi'        => $data['sub_seksi'] ?? null,
               ]);
           });
       }

       /**
        * Mengambil daftar pegawai dengan eager loading user (hindari N+1).
        * Mendukung pencarian via scope.
        */
       public function getAllPaginated(?string $keyword = null, int $perPage = 10)
       {
           return Pegawai::with('user')
                         ->search($keyword)
                         ->latest()
                         ->paginate($perPage);
       }
   }
   ```

**Prinsip Service:**
- Letakkan di sub-folder sesuai domain: `app/Services/Admin/`, `app/Services/Verifikator/`, dll.
- Gunakan `DB::transaction()` untuk operasi multi-tabel (buat User + Pegawai sekaligus)
- Gunakan `with([...])` untuk eager loading agar tidak terjadi N+1 Query
- Transformasi data di Service, bukan di Blade

---

### Langkah 4: Routing Controller Layer (Controller)

*Buat controller yang sangat tipis — hanya menerima, mendelegasikan, dan membalas.*

1. **Jalankan command:** `php artisan make:controller Admin/PegawaiController`
2. **Edit file** (`app/Http/Controllers/Admin/PegawaiController.php`):
   ```php
   <?php

   namespace App\Http\Controllers\Admin;

   use App\Http\Controllers\Controller;
   use App\Http\Requests\Admin\StorePegawaiRequest;
   use App\Services\Admin\PegawaiService;

   class PegawaiController extends Controller
   {
       // Dependency Injection: inject Service via constructor (bukan new PegawaiService())
       public function __construct(
           private PegawaiService $pegawaiService
       ) {}

       public function index()
       {
           // Logika pengambilan data sepenuhnya di-handle oleh Service
           $pegawais = $this->pegawaiService->getAllPaginated(
               request('search')
           );
           return view('pages.admin.pegawai.index', compact('pegawais'));
       }

       public function create()
       {
           return view('pages.admin.pegawai.create');
       }

       public function store(StorePegawaiRequest $request)
       {
           // Jika masuk ke sini, validasi sudah 100% lulus via Form Request.
           // $request->validated() mengambil data yang sudah bersih & aman.
           $this->pegawaiService->createPegawai($request->validated());

           return redirect()
               ->route('admin.pegawai.index')
               ->with('success', 'Data Pegawai & Akun berhasil dibuat.');
       }
   }
   ```

**Prinsip Controller:**
- Tidak boleh ada query Eloquent langsung di Controller
- Gunakan Constructor Injection (bukan `new ServiceClass()`)
- Satu method = satu tanggung jawab

---

### Langkah 5: Routing & Navigation

*Hubungkan fitur ke sistem agar bisa diakses.*

1. **Daftarkan di `routes/web/admin.php`** (pisah per role, seperti pola yang sudah ada):
   ```php
   use App\Http\Controllers\Admin\DashboardController;
   use App\Http\Controllers\Admin\PegawaiController;

   Route::middleware(['auth', 'role:admin'])
       ->prefix('admin')
       ->name('admin.')
       ->group(function () {

           // Dashboard (sudah ada)
           Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

           // Manajemen Pegawai (baru ditambahkan)
           // Menghasilkan: admin.pegawai.index, admin.pegawai.create, dst.
           Route::resource('pegawai', PegawaiController::class);
       });
   ```

2. **Pastikan `routes/web.php`** meng-*include* file route yang baru:
   ```php
   require __DIR__ . '/web/auth.php';
   require __DIR__ . '/web/admin.php';
   // require __DIR__ . '/web/verifikator.php'; // tambahkan saat fitur verifikator dibuat
   ```

**Prinsip Routing:**
- Pisahkan file route per role: `admin.php`, `verifikator.php`, dll. (jangan semua di `web.php`)
- Selalu gunakan **named routes** (`.name('...')`) agar bisa dipanggil via `route('admin.pegawai.index')`
- Lindungi selalu dengan dua middleware: `auth` (sudah login) + `role:admin` (CheckRole)
- Gunakan `Route::resource()` untuk CRUD agar konsisten dan tidak perlu tulis 7 route manual

---

### Langkah 6: Presentation Layer (View / Blade Components)

*Wajib menggunakan komponen yang sudah ada di `developing_view.md`.*

1. Buat folder: `resources/views/pages/admin/pegawai/`

2. **File `index.blade.php`** (Tampilan Tabel):
   ```blade
   <x-layout.app title="Kelola Pegawai">
       <x-layout.page-header
           title="Data Pegawai"
           subtitle="Manajemen akun dan data profil pegawai BPHL"
       />

       <x-layout.card>
           <x-slot:header>
               <div class="flex justify-between items-center px-6 py-4 border-b border-border-custom">
                   <h3 class="text-lg font-semibold text-text-main">Daftar Pegawai</h3>
                   <x-action.button-primary href="{{ route('admin.pegawai.create') }}">
                       Tambah Pegawai
                   </x-action.button-primary>
               </div>
           </x-slot:header>

           <div class="p-0">
               <table class="w-full text-sm text-left">
                   <thead>
                       <tr class="border-b border-border-custom">
                           <th class="px-6 py-3">NIP</th>
                           <th class="px-6 py-3">Nama Pegawai</th>
                           <th class="px-6 py-3">Jabatan</th>
                           <th class="px-6 py-3">Sub Seksi</th>
                           <th class="px-6 py-3">Role</th>
                       </tr>
                   </thead>
                   <tbody>
                       @foreach ($pegawais as $pegawai)
                       <tr class="border-b border-border-custom">
                           <td class="px-6 py-4">{{ $pegawai->nip }}</td>
                           <td class="px-6 py-4">{{ $pegawai->nama_pegawai }}</td>
                           <td class="px-6 py-4">{{ $pegawai->jabatan ?? '-' }}</td>
                           <td class="px-6 py-4">{{ $pegawai->sub_seksi ?? '-' }}</td>
                           <td class="px-6 py-4">{{ $pegawai->user?->roleLabel() }}</td>
                       </tr>
                       @endforeach
                   </tbody>
               </table>
           </div>

           <x-slot:footer>
               {{ $pegawais->links('components.navigation.pagination') }}
           </x-slot:footer>
       </x-layout.card>
   </x-layout.app>
   ```

3. **File `create.blade.php`** (Tampilan Form):
   ```blade
   <x-layout.app title="Tambah Pegawai">
       <x-layout.card title="Form Tambah Pegawai" class="max-w-3xl mx-auto mt-6">

           <form action="{{ route('admin.pegawai.store') }}" method="POST" class="space-y-6">
               @csrf

               <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                   <x-form.input name="nip" label="NIP" :required="true" :error="$errors->first('nip')" />
                   <x-form.input name="nama_pegawai" label="Nama Lengkap" :required="true" :error="$errors->first('nama_pegawai')" />
                   <x-form.input name="pangkat_golongan" label="Pangkat / Golongan" :error="$errors->first('pangkat_golongan')" />
                   <x-form.input name="jabatan" label="Jabatan" :error="$errors->first('jabatan')" />
                   <x-form.input name="sub_seksi" label="Sub Seksi" :error="$errors->first('sub_seksi')" />
                   <x-form.input name="email" label="Email Login" type="email" :required="true" :error="$errors->first('email')" />

                   <x-form.select name="role" label="Role Sistem" :required="true" :error="$errors->first('role')">
                       <option value="">-- Pilih Role --</option>
                       <option value="admin">Administrator</option>
                       <option value="verifikator">Verifikator</option>
                       <option value="kepala_balai">Kepala Balai</option>
                       <option value="kepala_tu">Kepala Sub Bagian TU</option>
                       <option value="kepala_seksi_pephphl">Kepala Seksi PEPHPHL</option>
                       <option value="kepala_seksi_ppphphl">Kepala Seksi PPPHPHL</option>
                       <option value="user">Pegawai</option>
                   </x-form.select>
               </div>

               <x-slot:footer>
                   <div class="flex justify-end gap-2">
                       <x-action.button-secondary href="{{ route('admin.pegawai.index') }}">Batal</x-action.button-secondary>
                       <x-action.button-primary type="submit">Simpan Pegawai</x-action.button-primary>
                   </div>
               </x-slot:footer>
           </form>

       </x-layout.card>
   </x-layout.app>
   ```

---

## 3. Konsep Penting Tambahan

### Middleware — CheckRole (Gatekeeper)

Middleware `CheckRole` berjalan **sebelum** request sampai ke Controller. Tugasnya murni sebagai "penjaga pintu" — cek apakah user berhak mengakses halaman tersebut.

```php
// app/Http/Middleware/CheckRole.php
public function handle(Request $request, Closure $next, string $role): Response
{
    // Pastikan user sudah login
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // Pastikan role user sesuai dengan yang diminta route
    if (auth()->user()->role !== $role) {
        abort(403, 'Akses Ditolak. Halaman ini hanya untuk role: ' . $role);
    }

    return $next($request);
}
```

**Cara daftarkan di route (sudah berjalan di proyek ini):**
```php
Route::middleware(['auth', 'role:admin'])->group(...)      // hanya admin
Route::middleware(['auth', 'role:verifikator'])->group(...) // hanya verifikator
```

**Prinsip:**
- Middleware bukan untuk logika bisnis, hanya untuk *gating*
- Tidak ada query database kompleks di Middleware

---

### Enums — UserRole (Menghindari "Magic String")

Daripada menyebar string seperti `'admin'`, `'verifikator'`, `'kepala_balai'` di mana-mana, proyek ini menggunakan **PHP Backed Enum**.

```php
// app/Enums/UserRole.php
enum UserRole: string
{
    case ADMIN                = 'admin';
    case VERIFIKATOR          = 'verifikator';
    case KEPALA_BALAI         = 'kepala_balai';
    case KEPALA_TU            = 'kepala_tu';
    case KEPALA_SEKSI_PEPHPHL = 'kepala_seksi_pephphl';
    case KEPALA_SEKSI_PPPHPHL = 'kepala_seksi_ppphphl';
    case USER                 = 'user';

    // Label readable untuk ditampilkan di UI
    public function label(): string
    {
        return match($this) {
            self::ADMIN                => 'Administrator',
            self::VERIFIKATOR          => 'Verifikator',
            self::KEPALA_BALAI         => 'Kepala Balai',
            self::KEPALA_TU            => 'Kepala Sub Bagian TU',
            self::KEPALA_SEKSI_PEPHPHL => 'Kepala Seksi PEPHPHL',
            self::KEPALA_SEKSI_PPPHPHL => 'Kepala Seksi PPPHPHL',
            self::USER                 => 'Pegawai',
        };
    }
}
```

**Pemakaian di Model User (Query Scope berbasis Enum):**
```php
// app/Models/User.php

public function scopeAdmin(Builder $query): Builder
{
    return $query->where('role', UserRole::ADMIN->value);
    // Dipanggil: User::admin()->count()
}

public function scopeVerifikator(Builder $query): Builder
{
    return $query->where('role', UserRole::VERIFIKATOR->value);
    // Dipanggil: User::verifikator()->count()
}

// Helper method untuk pengecekan role pada instance
public function isAdmin(): bool
{
    return $this->role === UserRole::ADMIN->value;
}
```

**Keuntungan:**
- Tidak ada typo pada string role (IDE bisa auto-complete)
- Perubahan nilai cukup di satu tempat (`UserRole.php`)
- `UserRole::values()` bisa langsung dipakai di validasi Form Request

---

### Query Scopes pada Model (Reusable Filters)

Scope memungkinkan filter kueri kompleks ditulis sekali dan dipanggil berkali-kali.

```php
// app/Models/Pegawai.php

// Scope dengan parameter (pencarian keyword)
public function scopeSearch($query, ?string $keyword)
{
    if (!$keyword) return $query;

    return $query->where(function ($q) use ($keyword) {
        $q->where('nama_pegawai', 'like', "%{$keyword}%")
          ->orWhere('nip', 'like', "%{$keyword}%")
          ->orWhere('sub_seksi', 'like', "%{$keyword}%");
    });
}
```

```php
// app/Models/User.php

// Scope tanpa parameter
public function scopeMonitoring(Builder $query): Builder
{
    return $query->whereIn('role', UserRole::monitoringRoles());
    // Dipanggil: User::monitoring()->get()
}
```

**Cara panggil di Service:**
```php
// Scope tanpa parameter
User::admin()->count();
User::verifikator()->count();
User::monitoring()->get();

// Scope dengan parameter + chain
Pegawai::search($keyword)->with('user')->latest()->paginate(10);
```

---

### Eager Loading — Hindari N+1 Query Problem

Selalu gunakan `with([...])` saat akan mengakses relasi di dalam loop.

```php
// ❌ BURUK — N+1 Query (1 query untuk User + N query untuk setiap pegawai)
$users = User::all();
foreach ($users as $user) {
    echo $user->pegawai->nip; // query baru setiap iterasi!
}

// ✅ BAIK — Eager Loading (hanya 2 query total)
$users = User::with('pegawai')->latest()->limit(5)->get();
foreach ($users as $user) {
    echo $user->pegawai->nip; // sudah ada di memori, tidak ada query baru
}
```

Contoh nyata dari `DashboardService.php`:
```php
// app/Services/Admin/DashboardService.php
private function getRecentUsers()
{
    return User::with('pegawai')  // eager load relasi pegawai sekaligus
               ->latest()
               ->limit(5)
               ->get();
}
```

---

### Role-Based Routing & Controller Separation

Setiap peran user memiliki file route dan controller sendiri.

```
routes/
├── web.php              → entry point, require semua file route per role
└── web/
    ├── auth.php         → route login, logout
    └── admin.php        → route khusus role 'admin' (sudah ada)
    {{-- tambahkan saat fitur per role berkembang: --}}
    {{-- verifikator.php, pegawai.php, monitoring.php --}}

app/Http/Controllers/
├── LoginController.php       → authenticate & logout
├── LandingPageController.php → halaman publik
└── Admin/
    └── DashboardController.php → thin controller, delegate ke DashboardService
```

**Pattern redirect by role setelah login (di `LoginController`):**
```php
// app/Http/Controllers/LoginController.php
if (Auth::attempt($credentials, $remember)) {
    $request->session()->regenerate();

    $user = Auth::user();

    // Dispatch ke dashboard yang sesuai berdasarkan role
    if ($user->isAdmin()) {
        return redirect()->intended(route('admin.dashboard'));
    }

    // Tambahkan kondisi lain saat fitur role lain berkembang:
    // if ($user->isVerifikator()) return redirect()->intended(route('verifikator.dashboard'));

    return redirect()->intended('/dashboard');
}
```

---

## 4. Golden Rules (Aturan Emas)

1. **JANGAN menaruh `DB::transaction`, `Mail::send`, `Storage::put` di dalam Controller.** Semuanya wajib di dalam *Service*.
2. **JANGAN memvalidasi form menggunakan `$request->validate()` di Controller.** Wajib menggunakan *Form Request* kelas terpisah di `app/Http/Requests/`.
3. **REUSABLE SERVICE:** Jika ada controller lain (misal API atau role Verifikator) butuh logika yang sama, jangan di-*copy-paste*. Cukup *inject* `PegawaiService` yang sama dan panggil fungsinya.
4. **BLADE COMPONENTS:** Jangan membuat `<button class="...">` secara manual. Selalu panggil `<x-action.button-primary>`. Konsistensi UI (merujuk ke `developing_view.md`) adalah prioritas utama.

---

## 5. Prinsip Umum Ringkasan

| Prinsip | Implementasi di SPJ BPHL |
|---|---|
| **Thin Controller** | `DashboardController` hanya memanggil `getDashboardData()` dan return view |
| **Fat Service** | Semua query, agregasi, transformasi ada di `DashboardService`, `PegawaiService`, dst. |
| **Form Request** | Validasi di `App\Http\Requests\Admin\StorePegawaiRequest`, bukan di Controller |
| **Reusable Scopes** | `User::admin()`, `User::verifikator()`, `Pegawai::search($keyword)` |
| **Type Safety via Enum** | `UserRole::ADMIN->value`, `UserRole::values()`, `$user->roleLabel()` |
| **Eager Loading** | `User::with('pegawai')->...` di `DashboardService::getRecentUsers()` |
| **Role Separation** | `routes/web/admin.php`, nantinya `verifikator.php`, dll. |
| **Middleware for Gating** | `CheckRole` middleware: `role:admin`, `role:verifikator` |
| **Named Routes** | `route('admin.dashboard')`, `route('admin.pegawai.index')` |
| **Dependency Injection** | `__construct(private DashboardService $dashboardService)` |
| **Sections in Model** | Komentar pemisah `Relationships`, `Query Scopes`, `Helper Methods` |
| **DB Transaction** | `DB::transaction()` saat buat User + Pegawai sekaligus di Service |

---

## 6. Struktur Direktori yang Direkomendasikan

```
app/
├── Enums/
│   └── UserRole.php            → Enum semua role di sistem SPJ BPHL
├── Http/
│   ├── Controllers/
│   │   ├── LoginController.php
│   │   ├── LandingPageController.php
│   │   └── Admin/              → Controller per fitur, sub-folder per role
│   │       ├── DashboardController.php
│   │       └── PegawaiController.php
│   ├── Middleware/
│   │   └── CheckRole.php       → Gating berdasarkan role
│   └── Requests/
│       └── Admin/              → Form Request sub-folder per role
│           └── StorePegawaiRequest.php
├── Models/
│   ├── User.php                → Auth model + scopes + helpers
│   ├── Pegawai.php             → Profil pegawai (tabel: data_pegawai)
│   ├── Spt.php                 → Surat Perintah Tugas (tabel: data_spt)
│   ├── Spd.php                 → Surat Perjalanan Dinas (tabel: data_spd)
│   └── Rincian.php             → Rincian biaya perjalanan
└── Services/
    └── Admin/                  → Service sub-folder per domain/role
        └── DashboardService.php

routes/
├── web.php                     → Entry point, require file route per role
└── web/
    ├── auth.php                → login, logout
    └── admin.php               → semua route role admin

resources/views/
└── pages/
    └── admin/
        ├── dashboard.blade.php
        └── pegawai/            → index, create, edit, show
```

---

> **Kesimpulan:** Pola ini membuat kode mudah dibaca, mudah di-*maintain*, dan mudah dikembangkan.
> Kunci utamanya adalah **pemisahan tanggung jawab** — setiap layer punya perannya sendiri dan tidak mencampuri urusan layer lain.
> Dokumen ini berlaku sebagai standar pengembangan di proyek **SPJ BPHL (Sistem Perjalanan Dinas BPHL)**.
