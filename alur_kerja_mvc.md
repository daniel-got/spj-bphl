# Panduan Arsitektur Modern: Service Layer & MVC (SPJ BPHL)

Dokumen ini adalah panduan wajib bagi *developer* dalam mengembangkan fitur baru di proyek SPJ BPHL. Proyek ini meninggalkan MVC Tradisional (Fat Controller) dan beralih menggunakan pola **Service Layer + Form Request** agar kode lebih *scalable*, *reusable*, dan mudah di-*maintenance*.

---

## 1. Konsep Dasar & Alur Data (Data Flow)

Dalam arsitektur ini, setiap kelas hanya memiliki satu tanggung jawab utama (*Single Responsibility Principle*). Alur data bergerak secara berurutan:

**`Route` → `Form Request` → `Controller` → `Service` → `Model` → `Controller` → `View`**

1. **Route (`routes/web.php`):** Menerima permintaan URL dan mengarahkannya ke Controller.
2. **Form Request (`app/Http/Requests/`):** Menyaring input pengguna. Jika validasi gagal, kembalikan error. Jika lolos, teruskan ke Controller.
3. **Controller (`app/Http/Controllers/`):** Bertugas sebagai "Pengarah Lalu Lintas" (Thin Controller). Hanya menerima data valid, memanggil Service, dan mengembalikan tampilan (View) atau Redirect. **Dilarang keras** menaruh logika bisnis (perhitungan, DB transaction) di sini.
4. **Service (`app/Services/`):** Bertugas sebagai "Otak Aplikasi" (Business Logic). Semua logika kompleks, transaksi database multi-tabel, *generate* nomor surat, dan *upload* file dilakukan di sini.
5. **Model (`app/Models/`):** Representasi database murni. Berisi relasi (`hasOne`, `belongsTo`), *fillable*, dan *query scopes*.
6. **View (`resources/views/`):** Merender HTML menggunakan antarmuka konsisten (Blade Components).

---

## 2. Alur Langkah Pengembangan (Studi Kasus: Fitur Pegawai)

Ikuti urutan 6 langkah ini setiap kali membuat modul/fitur baru.

### Langkah 1: Database Layer (Migration & Model)
*Siapkan pondasi data terlebih dahulu.*

1. **Jalankan command:** `php artisan make:model Pegawai -m`
2. **Edit Migration (`database/migrations/..._create_data_pegawai_table.php`):**
   *(Pastikan nama tabel konsisten, misal `data_pegawai`)*
   ```php
   public function up() {
       Schema::create('data_pegawai', function (Blueprint $table) {
           $table->id();
           $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
           $table->string('nip')->unique();
           $table->string('nama_pegawai');
           $table->timestamps();
       });
   }
   ```
3. **Migrate:** `php artisan migrate`
4. **Edit Model (`app/Models/Pegawai.php`):**
   ```php
   class Pegawai extends Model {
       protected $table = 'data_pegawai';
       protected $fillable = ['user_id', 'nip', 'nama_pegawai'];

       public function user() {
           return $this->belongsTo(User::class);
       }
   }
   ```

### Langkah 2: Validation Layer (Form Request)
*Buat filter keamanan untuk input dari form.*

1. **Jalankan command:** `php artisan make:request StorePegawaiRequest`
2. **Edit file (`app/Http/Requests/StorePegawaiRequest.php`):**
   ```php
   public function authorize(): bool {
       // Bisa diatur ke true jika middleware sudah menghandle autorisasi (misal di route)
       return auth()->user()->role === 'admin'; 
   }

   public function rules(): array {
       return [
           'nip'          => 'required|string|unique:data_pegawai,nip',
           'nama_pegawai' => 'required|string|max:255',
           'email'        => 'required|email|unique:users,email',
           'role'         => 'required|string|in:admin,verifikator,kepala_balai,kepala_tu,kepala_seksi_pephphl,kepala_seksi_ppphphl,user'
       ];
   }
   ```

### Langkah 3: Business Logic Layer (Service)
*Buat "Otak" yang memproses data.*

1. Buat folder manual jika belum ada: `app/Services/`
2. Buat file baru: `app/Services/PegawaiService.php`
   ```php
   <?php

   namespace App\Services;

   use App\Models\User;
   use App\Models\Pegawai;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Hash;

   class PegawaiService
   {
       /**
        * Menyimpan data user baru beserta relasi pegawainya.
        */
       public function createPegawai(array $data)
       {
           // Gunakan DB Transaction agar jika satu gagal, semua di-rollback
           return DB::transaction(function () use ($data) {
               
               // 1. Buat Akun User
               $user = User::create([
                   'name'     => $data['nama_pegawai'],
                   'email'    => $data['email'],
                   // Set password default menggunakan NIP
                   'password' => Hash::make($data['nip']),
                   'role'     => $data['role']
               ]);

               // 2. Buat Data Pegawai terhubung ke User
               $pegawai = Pegawai::create([
                   'user_id'      => $user->id,
                   'nip'          => $data['nip'],
                   'nama_pegawai' => $data['nama_pegawai']
               ]);

               return $pegawai;
           });
       }
       
       /**
        * Mengambil semua daftar pegawai untuk tabel (Reusable)
        */
       public function getAllPaginated($perPage = 10)
       {
           return Pegawai::with('user')->latest()->paginate($perPage);
       }
   }
   ```

### Langkah 4: Routing Controller Layer (Controller)
*Buat controller yang sangat tipis.*

1. **Jalankan command:** `php artisan make:controller Admin/PegawaiController`
2. **Edit file (`app/Http/Controllers/Admin/PegawaiController.php`):**
   ```php
   <?php

   namespace App\Http\Controllers\Admin;

   use App\Http\Controllers\Controller;
   use App\Http\Requests\StorePegawaiRequest;
   use App\Services\PegawaiService;

   class PegawaiController extends Controller
   {
       // Dependency Injection Service ke dalam constructor atau method
       protected $pegawaiService;

       public function __construct(PegawaiService $pegawaiService)
       {
           $this->pegawaiService = $pegawaiService;
       }

       public function index()
       {
           // Logika pengambilan data di-handle oleh Service
           $pegawais = $this->pegawaiService->getAllPaginated();
           return view('pages.admin.pegawai.index', compact('pegawais'));
       }

       public function create()
       {
           return view('pages.admin.pegawai.create');
       }

       // Tangkap parameter Form Request (StorePegawaiRequest)
       public function store(StorePegawaiRequest $request)
       {
           // Jika masuk ke fungsi ini, berarti validasi sudah 100% lulus.
           // $request->validated() akan mengambil array data yang sudah bersih.
           
           $this->pegawaiService->createPegawai($request->validated());
           
           // Kembalikan Response
           return redirect()
                   ->route('admin.pegawai.index')
                   ->with('success', 'Data Pegawai & Akun berhasil dibuat.');
       }
   }
   ```

### Langkah 5: Routing & Navigation
*Hubungkan ke sistem agar bisa diakses.*

1. **Daftarkan di `routes/web.php`:**
   ```php
   use App\Http\Controllers\Admin\PegawaiController;

   Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
       // Menghasilkan admin.pegawai.index, admin.pegawai.create, dll.
       Route::resource('pegawai', PegawaiController::class);
   });
   ```
2. **Tambahkan ke Menu Global (`config/navigation.php`):**
   ```php
   'admin_sidebar' => [
       ['label' => 'Kelola Pegawai', 'url' => '/admin/pegawai', 'icon' => 'users'],
   ],
   ```

### Langkah 6: Presentation Layer (View/Blade Components)
*Wajib menggunakan komponen yang sudah ada di dokumentasi `developing_view.md`.*

1. Buat folder: `resources/views/pages/admin/pegawai/`
2. **File `index.blade.php` (Tampilan Tabel):**
   ```blade
   <x-layout.app title="Kelola Pegawai">
       <x-layout.page-header 
           title="Data Pegawai" 
           subtitle="Manajemen akun dan data profil pegawai" 
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

           {{-- Misal asumsi komponen table siap pakai --}}
           <div class="p-0">
               <table class="w-full text-sm text-left">
                   <!-- Header, Body loop $pegawais -->
               </table>
           </div>
           
           <x-slot:footer>
               {{ $pegawais->links('components.navigation.pagination') }}
           </x-slot:footer>
       </x-layout.card>
   </x-layout.app>
   ```

3. **File `create.blade.php` (Tampilan Form):**
   ```blade
   <x-layout.app title="Tambah Pegawai">
       <x-layout.card title="Form Tambah Pegawai" class="max-w-3xl mx-auto mt-6">
           
           <form action="{{ route('admin.pegawai.store') }}" method="POST" class="space-y-6">
               @csrf
               
               <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                   <x-form.input name="nip" label="NIP" :required="true" :error="$errors->first('nip')" />
                   <x-form.input name="nama_pegawai" label="Nama Lengkap" :required="true" :error="$errors->first('nama_pegawai')" />
                   <x-form.input name="email" label="Email Login" type="email" :required="true" :error="$errors->first('email')" />
                   
                   <x-form.select name="role" label="Role Sistem" :required="true" :error="$errors->first('role')">
                       <option value="">-- Pilih Role --</option>
                       <option value="admin">Admin</option>
                       <option value="user">Pegawai Biasa</option>
                       <option value="verifikator">Verifikator</option>
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

## 3. Golden Rules (Aturan Emas)

1. **JANGAN menaruh `DB::transaction`, `Mail::send`, `Storage::put` di dalam Controller.** Semuanya wajib di dalam *Service*.
2. **JANGAN memvalidasi form menggunakan `$request->validate()` di Controller.** Wajib menggunakan *Form Request* kelas terpisah.
3. **REUSABLE SERVICE:** Jika ada controller lain (misal API Controller) butuh membuat pegawai, jangan di-*copy-paste* logic-nya, cukup *inject* `PegawaiService` dan panggil fungsinya.
4. **BLADE COMPONENTS:** Jangan membuat `<button class="...">` secara manual. Selalu panggil `<x-action.button-primary>`. Konsistensi UI (merujuk ke `developing_view.md`) adalah prioritas utama.
