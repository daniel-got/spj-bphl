# Panduan Alur Kerja MVC (Model-View-Controller) SPJ BPHL

Dokumen ini menjelaskan alur kerja standar (best practice) dalam mengerjakan fitur baru di proyek SPJ BPHL menggunakan framework Laravel.

## Konsep Dasar
- **Model:** Representasi tabel database. Bertanggung jawab atas semua query, manipulasi data, dan relasi.
- **View:** Tampilan antarmuka pengguna (UI). Bertanggung jawab merender HTML menggunakan Blade Components.
- **Controller:** Logika bisnis (otak). Menerima *request* HTTP, memvalidasi input, memanggil Model, dan mengembalikan *response* (View atau Redirect).

---

## Alur Pembuatan Fitur (Studi Kasus: Fitur Pegawai)

Selalu ikuti urutan langkah-langkah di bawah ini saat membuat modul/fitur baru dari nol.

### 1. Database Layer (Migration & Model)
*Pikirkan datanya terlebih dahulu sebelum memikirkan tampilannya.*

1. **Jalankan command:** `php artisan make:model Pegawai -m`
2. **Edit Migration (`database/migrations/..._create_pegawais_table.php`):**
   ```php
   public function up() {
       Schema::create('pegawais', function (Blueprint $table) {
           $table->id();
           $table->string('nip')->unique();
           $table->string('nama');
           $table->timestamps();
       });
   }
   ```
3. **Migrate:** `php artisan migrate`
4. **Edit Model (`app/Models/Pegawai.php`):**
   ```php
   class Pegawai extends Model {
       protected $fillable = ['nip', 'nama']; // Wajib diisi agar bisa Mass Assignment
   }
   ```

### 2. Logic Layer (Controller)
*Buat pengendali alur datanya.*

1. **Jalankan command:** `php artisan make:controller PegawaiController --resource`
2. **Isi fungsi-fungsinya (`app/Http/Controllers/PegawaiController.php`):**
   ```php
   public function index() {
       $data = Pegawai::latest()->paginate(10);
       return view('pages.pegawai.index', compact('data'));
   }

   public function store(Request $request) {
       // 1. Validasi
       $validated = $request->validate([
           'nip'  => 'required|unique:pegawais,nip',
           'nama' => 'required'
       ]);
       
       // 2. Simpan Data (Model)
       Pegawai::create($validated);
       
       // 3. Redirect dengan pesan sukses
       return redirect()->route('pegawai.index')->with('success', 'Data berhasil disimpan!');
   }
   ```

### 3. Routing Layer (Jalur URL)
*Daftarkan URL agar Controller bisa diakses browser.*

1. **Edit file `routes/web.php`:**
   ```php
   use App\Http\Controllers\PegawaiController;

   Route::middleware(['auth'])->group(function () {
       Route::resource('pegawai', PegawaiController::class);
   });
   ```

### 4. Presentation Layer (View / Blade)
*Buat tampilannya menggunakan komponen UI BPHL.*

1. Buat direktori: `resources/views/pages/pegawai/`
2. **Buat file `index.blade.php` (Menampilkan tabel):**
   ```blade
   <x-layout.app title="Data Pegawai">
       <x-layout.page-header title="Data Pegawai" subtitle="Kelola data pegawai BPHL" />
       
       <x-layout.card>
           <x-data.table :headers="['NIP', 'Nama', 'Aksi']" :rows="..." />
       </x-layout.card>
   </x-layout.app>
   ```
3. **Buat file `create.blade.php` (Menampilkan form input):**
   ```blade
   <x-layout.app title="Tambah Pegawai">
       <x-layout.card title="Form Tambah Pegawai" class="max-w-2xl mx-auto">
           <form action="{{ route('pegawai.store') }}" method="POST" class="space-y-4">
               @csrf
               <x-form.input name="nip" label="NIP" required="true" :error="$errors->first('nip')" />
               <x-form.input name="nama" label="Nama Pegawai" required="true" />
               <x-action.button-primary type="submit">Simpan</x-action.button-primary>
           </form>
       </x-layout.card>
   </x-layout.app>
   ```

### 5. Integration Layer (Menu Global)
*Hubungkan halaman baru ke Sidebar/Navbar.*

1. **Edit file `config/navigation.php`:**
   ```php
   'sidebar' => [
       // ... menu lainnya
       ['label' => 'Pegawai', 'url' => '/pegawai', 'icon' => 'users'],
   ],
   ```

---

## Aturan Emas (Golden Rules)
1. **Thin Controller, Fat Model:** Usahakan Controller setipis mungkin. Jika ada perhitungan data kompleks, pindahkan fungsinya ke dalam Model.
2. **Gunakan Validasi Request:** Jangan pernah memasukkan `$request->all()` langsung ke database tanpa validasi. Gunakan `$request->validate(...)` atau *FormRequest*.
3. **Gunakan Blade Components:** Dilarang mendesain dari nol dengan tag HTML/Tailwind biasa berulang-ulang. Selalu gunakan `<x-layout...>`, `<x-form...>`, `<x-data...>` agar warna dan tema tetap konsisten.
