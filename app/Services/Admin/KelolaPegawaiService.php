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
    public function getPegawaiData(): array
    {
        $pegawais = Pegawai::with('user')->latest()->paginate(10);

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
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ',');

        // Pastikan format kolom sesuai dengan template
        $expectedHeader = ['nama_pegawai', 'nip', 'pangkat', 'golongan', 'jabatan', 'sub_seksi', 'email', 'password', 'roles'];

        // Membersihkan BOM jika ada pada karakter pertama (biasa terjadi pada file CSV dari Excel)
        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);

        if ($header !== $expectedHeader) {
            fclose($handle);
            throw new Exception('Format kolom CSV tidak sesuai. Gunakan template yang disediakan.');
        }

        $berhasil = 0;
        $gagal = 0;
        $errors = [];
        $rowNum = 2; // Baris data dimulai dari baris ke-2

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Lewati baris kosong
                if (empty(array_filter($row))) {
                    continue;
                }

                if (count($row) !== count($header)) {
                    $errors[] = "Baris $rowNum: Jumlah kolom tidak sesuai.";
                    $gagal++;
                    $rowNum++;

                    continue;
                }

                // Sanitize CSV Injection
                foreach ($row as &$cell) {
                    if (preg_match('/^[\=\+\-\@]/', $cell)) {
                        $cell = "'".$cell;
                    }
                }
                unset($cell);

                $data = array_combine($header, $row);

                // Cek NIP atau Email apakah sudah ada
                $existingNip = Pegawai::where('nip', $data['nip'])->exists();
                $existingEmail = User::where('email', $data['email'])->exists();

                if ($existingNip || $existingEmail) {
                    $errors[] = "Baris $rowNum: NIP ({$data['nip']}) atau Email ({$data['email']}) sudah terdaftar.";
                    $gagal++;
                    $rowNum++;

                    continue;
                }

                // Parsing roles (comma separated or single)
                $rawRoles = array_map('trim', explode(',', $data['roles']));
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
                    $errors[] = "Baris $rowNum: Salah satu Role dalam '{$data['roles']}' tidak valid.";
                    $gagal++;
                    $rowNum++;

                    continue;
                }

                // Cek pangkat dan golongan valid
                $validPangkat = Pangkat::values();
                if (! empty($data['pangkat']) && ! in_array($data['pangkat'], $validPangkat)) {
                    $errors[] = "Baris $rowNum: Pangkat '{$data['pangkat']}' tidak valid.";
                    $gagal++;
                    $rowNum++;

                    continue;
                }

                $validGolongan = Golongan::values();
                if (! empty($data['golongan']) && ! in_array($data['golongan'], $validGolongan)) {
                    $errors[] = "Baris $rowNum: Golongan '{$data['golongan']}' tidak valid.";
                    $gagal++;
                    $rowNum++;

                    continue;
                }

                // Insert User
                $user = User::create([
                    'name' => $data['nama_pegawai'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'roles' => $parsedRoles,
                ]);

                // Insert Pegawai
                Pegawai::create([
                    'user_id' => $user->id,
                    'nama_pegawai' => $data['nama_pegawai'],
                    'nip' => $data['nip'],
                    'pangkat' => $data['pangkat'] ?: null,
                    'golongan' => $data['golongan'] ?: null,
                    'jabatan' => $data['jabatan'] ?: null,
                    'sub_seksi' => $data['sub_seksi'] ?: null,
                ]);

                $berhasil++;
                $rowNum++;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            fclose($handle);
            throw new Exception("Gagal memproses baris $rowNum: ".$e->getMessage());
        }

        fclose($handle);

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
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ',');

        $expectedHeader = ['nama_pegawai', 'nip', 'pangkat', 'golongan', 'jabatan', 'sub_seksi', 'email', 'password', 'roles'];
        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);

        if ($header !== $expectedHeader) {
            fclose($handle);

            return [
                'valid' => false,
                'berhasil' => 0,
                'gagal' => 0,
                'errors' => ['Format kolom CSV tidak sesuai. Pastikan header CSV sesuai template.'],
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

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (empty(array_filter($row))) {
                continue;
            }

            if (count($row) !== count($header)) {
                $errors[] = "Baris $rowNum: Jumlah kolom tidak sesuai.";
                $gagal++;
                $rowNum++;

                continue;
            }

            $data = array_combine($header, $row);
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
                $rowErrors[] = 'Pangkat tidak valid.';
            }
            if (! empty($data['golongan']) && ! in_array($data['golongan'], Golongan::values())) {
                $rowErrors[] = 'Golongan tidak valid.';
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

        fclose($handle);

        // Jika ada data valid, simpan file sementara dengan token unik
        $token = null;
        if ($berhasil > 0) {
            $token = Str::random(40);
            $userId = auth()->id();
            $file->storeAs('tmp/csv-import', $userId.'_'.$token.'.csv', 'local');
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
        // Pada Laravel versi terbaru, disk 'local' default menunjuk ke storage/app/private
        $path = storage_path('app/private/tmp/csv-import/'.$userId.'_'.$token.'.csv');

        if (! file_exists($path)) {
            throw new Exception('Token tidak valid atau sudah kadaluarsa. Silakan upload ulang.');
        }

        $uploadedFile = new UploadedFile($path, basename($path), 'text/csv', null, true);
        $result = $this->importCsv($uploadedFile);

        // Hapus file sementara setelah berhasil diimport
        @unlink($path);

        return $result;
    }
}
