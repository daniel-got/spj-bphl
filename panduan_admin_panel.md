# Panduan Detail: Membangun Fitur Admin (Service Layer)

Gunakan panduan ini untuk mencoba memprogram (coding) sendiri fitur Admin. Kita mematuhi arsitektur **Service Layer + Form Request** sesuai standar BPHL.

---

## Fase 1: Fondasi Keamanan & Routing (Sudah Sama dengan Sebelumnya)

Lakukan **Langkah 1 sampai 4** seperti pada rancangan sebelumnya (Membuat `PegawaiSeeder`, Middleware `CheckRole`, Edit `LoginController` untuk redirect admin, dan Setup Web Route Admin).

---

## Fase 2: Manajemen Pengguna (Kelola Pegawai via Service Layer)

Di fase ini, kita akan membuat fitur Tambah Pegawai dengan arsitektur yang sangat rapi.

### Langkah 1: Siapkan Form Request (Validasi)
**1. Jalankan command:**
```bash
php artisan make:request Admin/StorePegawaiRequest
```

**2. Edit `app/Http/Requests/Admin/StorePegawaiRequest.php`:**
```php
<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StorePegawaiRequest extends FormRequest
{
    public function authorize(): bool {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array {
        return [
            'nama_pegawai'     => 'required|string|max:255',
            'nip'              => 'required|string|unique:data_pegawai,nip',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:6', // Admin mengetikkan manual
            'role'             => 'required|string|in:admin,verifikator,kepala_balai,kepala_tu,kepala_seksi_pephphl,kepala_seksi_ppphphl,user',
            'pangkat_golongan' => 'nullable|string',
            'jabatan'          => 'nullable|string',
            'sub_seksi'        => 'nullable|string',
        ];
    }
}
```

### Langkah 2: Siapkan Service Layer (Logika Bisnis)
**1. Buat folder dan file manual:** `app/Services/Admin/PegawaiService.php`

**2. Edit kodenya (Semua kerumitan ada di sini):**
```php
<?php
namespace App\Services\Admin;

use App\Models\User;
use App\Models\Pegawai; // Pastikan model Pegawai mengambil tabel 'data_pegawai'
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PegawaiService
{
    public function createPegawai(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Buat User (Akun Login)
            $user = User::create([
                'name'     => $data['nama_pegawai'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => $data['role'],
            ]);

            // 2. Buat Profil Pegawai
            $pegawai = Pegawai::create([
                'user_id'          => $user->id,
                'nama_pegawai'     => $data['nama_pegawai'],
                'nip'              => $data['nip'],
                'pangkat_golongan' => $data['pangkat_golongan'] ?? null,
                'jabatan'          => $data['jabatan'] ?? null,
                'sub_seksi'        => $data['sub_seksi'] ?? null,
            ]);

            return $pegawai;
        });
    }

    public function getAllPaginated($search = null, $perPage = 10)
    {
        $query = Pegawai::with('user')->latest();

        if ($search) {
            $query->where('nama_pegawai', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('sub_seksi', 'like', "%{$search}%");
        }

        return $query->paginate($perPage);
    }
}
```

### Langkah 3: Siapkan Controller (Pengarah Lalu Lintas)
**1. Jalankan command:**
```bash
php artisan make:controller Admin/PegawaiController
```

**2. Edit `app/Http/Controllers/Admin/PegawaiController.php` (Sangat Tipis):**
```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StorePegawaiRequest;
use App\Services\Admin\PegawaiService;

class PegawaiController extends Controller
{
    protected $pegawaiService;

    // Suntikkan Service (Dependency Injection)
    public function __construct(PegawaiService $pegawaiService) {
        $this->pegawaiService = $pegawaiService;
    }

    public function index(Request $request) {
        $search = $request->query('search');
        $pegawais = $this->pegawaiService->getAllPaginated($search);
        
        return view('pages.admin.pegawai.index', compact('pegawais', 'search'));
    }

    public function create() {
        return view('pages.admin.pegawai.create');
    }

    public function store(StorePegawaiRequest $request) {
        // Validasi otomatis berjalan sebelum masuk fungsi ini
        $this->pegawaiService->createPegawai($request->validated());

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai berhasil ditambahkan!');
    }
}
```

### Langkah 4: Tampilan Blade (Menggunakan Komponen BPHL)
*(Catatan: Anda bisa melihat referensi pemanggilan `<x-layout.app>` dan `<x-form.input>` di dokumen `alur_kerja_serviceLayer.md` pada Langkah 6).*

Dengan memisahkan ketiga hal ini (Request, Service, Controller), kode Anda akan sangat bersih dan dapat di-test per bagian dengan mudah!
