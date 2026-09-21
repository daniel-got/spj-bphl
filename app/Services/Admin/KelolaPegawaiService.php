<?php

namespace App\Services\Admin;

use App\Enums\Golongan;
use App\Enums\Pangkat;
use App\Enums\UserRole;
use App\Models\Pegawai;
use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KelolaPegawaiService
{
    /**
     * Mendapatkan data pegawai untuk ditampilkan di halaman kelola pegawai.
     */
    public function getPegawaiData(?string $search = null): array
    {
        $query = Pegawai::with('user')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pegawai', 'ilike', "%{$search}%")
                  ->orWhere('nip', 'ilike', "%{$search}%")
                  ->orWhere('jabatan', 'ilike', "%{$search}%")
                  ->orWhere('sub_seksi', 'ilike', "%{$search}%")
                  ->orWhere('pangkat', 'ilike', "%{$search}%")
                  ->orWhere('golongan', 'ilike', "%{$search}%")
                  ->orWhereHas('user', function ($qUser) use ($search) {
                      $qUser->whereRaw('CAST(roles AS TEXT) ILIKE ?', ["%{$search}%"])
                            ->orWhere('email', 'ilike', "%{$search}%");
                  });
            });
        }

        $pegawais = $query->paginate(10)->withQueryString();

        return [
            'pegawais' => $pegawais,
        ];
    }

    /**
     * Membuat Pegawai dan akun User.
     */
    public function createPegawai(array $data): Pegawai
    {
        return DB::transaction(function () use ($data) {
            // 1. Buat User
            $user = User::create([
                'name' => $data['nama_pegawai'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'roles' => $data['roles'] ?? ['user'],
            ]);

            // 2. Buat profil Pegawai terkait
            return Pegawai::create([
                'user_id' => $user->id,
                'nama_pegawai' => $data['nama_pegawai'],
                'nip' => $data['nip'],
                'pangkat' => $data['pangkat'] ?? null,
                'golongan' => $data['golongan'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'sub_seksi' => $data['sub_seksi'] ?? null,
            ]);
        });
    }

    /**
     * Memperbarui Pegawai dan akun User.
     */
    public function updatePegawai(Pegawai $pegawai, array $data): Pegawai
    {
        return DB::transaction(function () use ($pegawai, $data) {
            // 1. Update profil Pegawai
            $pegawai->update([
                'nama_pegawai' => $data['nama_pegawai'],
                'nip' => $data['nip'],
                'pangkat' => $data['pangkat'] ?? null,
                'golongan' => $data['golongan'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'sub_seksi' => $data['sub_seksi'] ?? null,
            ]);

            // 2. Update User
            $user = $pegawai->user;
            $user->name = $data['nama_pegawai'];
            $user->email = $data['email'];

            if (isset($data['roles'])) {
                abort_if(! auth()->user()->isAdmin(), 403, 'Unauthorized to update roles.');
                $user->roles = $data['roles'];
            }

            if (! empty($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            return $pegawai;
        });
    }

    /**
     * Menghapus Pegawai (dan User terkait).
     */
    public function deletePegawai(Pegawai $pegawai): void
    {
        DB::transaction(function () use ($pegawai) {
            $user = $pegawai->user;
            $pegawai->delete();
            if ($user) {
                $user->delete();
            }
        });
    }

    /**
     * Memproses import CSV.
     */
    public function importCsv(UploadedFile $file): array
    {
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\RawDataImport, $file);
        if (empty($sheets) || empty($sheets[0])) {
            throw new Exception('File kosong atau format tidak didukung.');
        }

        $data = $sheets[0];
        $header = array_shift($data); // Ambil baris pertama sebagai header

        // Pastikan format kolom sesuai dengan template

        // Pastikan format kolom sesuai dengan template
        $expectedHeader = ['nama_pegawai', 'nip', 'pangkat', 'golongan', 'jabatan', 'sub_seksi', 'email', 'password', 'roles'];

        // Membersihkan BOM jika ada pada karakter pertama (biasa terjadi pada file CSV dari Excel)
        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);

        if ($header !== $expectedHeader) {
            throw new Exception('Format kolom CSV/Excel tidak sesuai. Gunakan template yang disediakan.');
        }

        $berhasil = 0;
        $gagal = 0;
        $errors = [];
        $rowNum = 2; // Baris data dimulai dari baris ke-2

        DB::beginTransaction();

        try {
            foreach ($data as $row) {
                // Lewati baris kosong
                if (empty(array_filter($row, fn($val) => $val !== null && trim($val) !== ''))) {
                    continue;
                }

                // Normalisasi jumlah elemen baris agar sesuai dengan header (isi null jika kosong)
                $row = array_pad($row, count($header), null);
                if (count($row) > count($header)) {
                    $row = array_slice($row, 0, count($header));
                }

                $rowData = array_combine($header, $row);

                // Sanitize CSV Injection
                foreach ($row as &$cell) {
                    if (preg_match('/^[\=\+\-\@]/', $cell)) {
                        $cell = "'".$cell;
                    }
                }
                unset($cell);

                $rowData = array_combine($header, $row);
                
                // AUTO-CLEANUP NIP (hapus spasi dll)
                $rowData['nip'] = preg_replace('/\D/', '', (string)$rowData['nip']);
                // AUTO-CLEANUP Pangkat (ambil nilai IV/b dari string seperti "Pembina / IV.b")
                if (!empty($rowData['pangkat']) && preg_match('/([I|V|X]+)[.\/]([a-e])/i', $rowData['pangkat'], $matches)) {
                    $rowData['pangkat'] = strtoupper($matches[1]) . '/' . strtolower($matches[2]);
                }

                $nip = $rowData['nip'];
                $email = strtolower(trim($rowData['email']));

                // Cek NIP atau Email apakah sudah ada
                $existingNip = Pegawai::where('nip', $nip)->exists();
                $existingEmail = User::where('email', $email)->exists();

                if ($existingNip || $existingEmail) {
                    $errors[] = "Baris $rowNum: NIP ({$nip}) atau Email ({$email}) sudah terdaftar.";
                    $gagal++;
                    $rowNum++;

                    continue;
                }

                // Parsing roles (comma separated or single)
                $rawRoles = array_map('trim', explode(',', $rowData['roles']));
                $parsedRoles = [];
                $validRoles = UserRole::values();
                $hasInvalidRole = false;

                foreach ($rawRoles as $r) {
                    if (empty($r)) {
                        continue;
                    }
                    if (! in_array($r, $validRoles)) {
                        $hasInvalidRole = true;
                        break;
                    }
                    $parsedRoles[] = $r;
                }

                if (empty($parsedRoles)) {
                    $parsedRoles = ['user'];
                }

                // Cek role valid
                if ($hasInvalidRole) {
                    $errors[] = "Baris $rowNum: Salah satu Role dalam '{$rowData['roles']}' tidak valid.";
                    $gagal++;
                    $rowNum++;

                    continue;
                }

                // Cek pangkat dan golongan valid
                $validPangkat = Pangkat::values();
                if (! empty($rowData['pangkat']) && ! in_array($rowData['pangkat'], $validPangkat)) {
                    $rowData['pangkat'] = null;
                }

                $validGolongan = Golongan::values();
                if (! empty($nip) && strlen($nip) !== 18) {
                    $errors[] = "Baris $rowNum: NIP harus 18 digit.";
                    $gagal++;
                    $rowNum++;
                    continue;
                }
                if (! empty($rowData['golongan']) && ! in_array($rowData['golongan'], $validGolongan)) {
                    $rowData['golongan'] = null;
                }

                // Insert User
                $user = User::create([
                    'name' => trim($rowData['nama_pegawai']),
                    'email' => $email,
                    'password' => Hash::make($rowData['password'] ?: $nip),
                    'roles' => $parsedRoles,
                ]);

                // Insert Pegawai
                Pegawai::create([
                    'user_id' => $user->id,
                    'nama_pegawai' => $rowData['nama_pegawai'],
                    'nip' => $nip,
                    'pangkat' => $rowData['pangkat'] ?: null,
                    'golongan' => $rowData['golongan'] ?: null,
                    'jabatan' => $rowData['jabatan'] ?: null,
                    'sub_seksi' => $rowData['sub_seksi'] ?: null,
                ]);

                $berhasil++;
                $rowNum++;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Gagal memproses baris $rowNum: ".$e->getMessage());
        }

        return [
            'berhasil' => $berhasil,
            'gagal' => $gagal,
            'errors' => $errors,
        ];
    }

    /**
     * Dry-run: Validasi CSV tanpa menyimpan ke database.
     * Menyimpan file sementara di storage dan mengembalikan token.
     */
    public function validateCsvOnly(UploadedFile $file): array
    {
        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\RawDataImport, $file);
        if (empty($sheets) || empty($sheets[0])) {
            return [
                'valid' => false,
                'berhasil' => 0,
                'gagal' => 0,
                'errors' => ['File kosong atau format tidak didukung.'],
                'token' => null,
                'preview' => [],
            ];
        }

        $dataInput = $sheets[0];
        $header = array_shift($dataInput);

        $expectedHeader = ['nama_pegawai', 'nip', 'pangkat', 'golongan', 'jabatan', 'sub_seksi', 'email', 'password', 'roles'];
        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);

        if ($header !== $expectedHeader) {
            return [
                'valid' => false,
                'berhasil' => 0,
                'gagal' => 0,
                'errors' => ['Format kolom tidak sesuai. Pastikan header sesuai template.'],
                'token' => null,
                'preview' => [],
            ];
        }

        $berhasil = 0;
        $gagal = 0;
        $errors = [];
        $preview = [];
        $rowNum = 2;
        $validRoles = UserRole::values();

        $seenNips = [];
        $seenEmails = [];

        foreach ($dataInput as $row) {
            if (empty(array_filter($row, fn($val) => $val !== null && trim($val) !== ''))) {
                continue;
            }

            // Normalisasi jumlah elemen baris agar sesuai dengan header (isi null jika kosong)
            $row = array_pad($row, count($header), null);
            if (count($row) > count($header)) {
                $row = array_slice($row, 0, count($header));
            }

            $data = array_combine($header, $row);
            
            // AUTO-CLEANUP NIP (hapus spasi dll)
            $data['nip'] = preg_replace('/\D/', '', (string)$data['nip']);
            // AUTO-CLEANUP Pangkat (ambil nilai IV/b dari string seperti "Pembina / IV.b")
            if (!empty($data['pangkat']) && preg_match('/([I|V|X]+)[.\/]([a-e])/i', $data['pangkat'], $matches)) {
                $data['pangkat'] = strtoupper($matches[1]) . '/' . strtolower($matches[2]);
            }
            
            $rowErrors = [];

            if (Pegawai::where('nip', $data['nip'])->exists() || in_array($data['nip'], $seenNips)) {
                $rowErrors[] = 'NIP sudah terdaftar.';
            }
            if (User::where('email', $data['email'])->exists() || in_array($data['email'], $seenEmails)) {
                $rowErrors[] = 'Email sudah digunakan.';
            }

            // Validasi roles
            $rawRoles = array_map('trim', explode(',', $data['roles']));
            $hasInvalidRole = false;
            foreach ($rawRoles as $r) {
                if (empty($r)) {
                    continue;
                }
                if (! in_array($r, $validRoles)) {
                    $hasInvalidRole = true;
                    break;
                }
            }

            if ($hasInvalidRole) {
                $rowErrors[] = 'Role tidak valid.';
            }

            if (! empty($data['pangkat']) && ! in_array($data['pangkat'], Pangkat::values())) {
                $data['pangkat'] = null;
            }
            if (! empty($data['golongan']) && ! in_array($data['golongan'], Golongan::values())) {
                $data['golongan'] = null;
            }

            if (empty($data['nama_pegawai'])) {
                $rowErrors[] = 'Nama kosong.';
            }

            if (! empty($rowErrors)) {
                $errors[] = "Baris $rowNum diabaikan: ".implode(' ', $rowErrors);
                $gagal++;
            } else {
                $seenNips[] = $data['nip'];
                $seenEmails[] = $data['email'];
                $berhasil++;

                // Preview hanya 5 baris pertama yang valid
                if (count($preview) < 5) {
                    $preview[] = [
                        'nama' => $data['nama_pegawai'],
                        'nip' => $data['nip'],
                        'roles' => $data['roles'],
                    ];
                }
            }

            $rowNum++;
        }

        // Jika ada data valid, simpan file sementara dengan token unik
        $token = null;
        if ($berhasil > 0) {
            $token = Str::random(40);
            $userId = auth()->id();
            $extension = $file->getClientOriginalExtension() ?: 'csv';
            $file->storeAs('tmp/excel-import', $userId.'_'.$token.'.'.$extension, 'local');
        }

        return [
            // Selama ada yang berhasil, kita anggap file valid untuk diimport (mengabaikan yang gagal)
            'valid' => $berhasil > 0,
            'berhasil' => $berhasil,
            'gagal' => $gagal,
            'errors' => $errors,
            'token' => $token,
            'preview' => $preview,
        ];
    }

    /**
     * Import dari file sementara menggunakan token.
     */
    public function importFromToken(string $token): array
    {
        $userId = auth()->id();
        
        // Cari ekstensi yang ada (bisa .csv, .xlsx, .xls)
        $dirPath = storage_path('app/private/tmp/excel-import/');
        $files = glob($dirPath . $userId.'_'.$token.'.*');

        if (empty($files)) {
            throw new Exception('Token tidak valid atau sudah kadaluarsa. Silakan upload ulang.');
        }

        $path = $files[0];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $mimeType = match($extension) {
            'csv' => 'text/csv',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls' => 'application/vnd.ms-excel',
            default => 'application/octet-stream',
        };

        $uploadedFile = new UploadedFile($path, basename($path), $mimeType, null, true);
        $result = $this->importCsv($uploadedFile);

        // Hapus file sementara setelah berhasil diimport
        @unlink($path);

        return $result;
    }
}
