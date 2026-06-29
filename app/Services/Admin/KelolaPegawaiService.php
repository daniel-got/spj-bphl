<?php

namespace App\Services\Admin;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Exception;

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
                'role' => $data['role'],
            ]);

            // 2. Buat profil Pegawai terkait
            return Pegawai::create([
                'user_id' => $user->id,
                'nama_pegawai' => $data['nama_pegawai'],
                'nip' => $data['nip'],
                'pangkat_golongan' => $data['pangkat_golongan'] ?? null,
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
                'pangkat_golongan' => $data['pangkat_golongan'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'sub_seksi' => $data['sub_seksi'] ?? null,
            ]);

            // 2. Update User
            $user = $pegawai->user;
            $user->name = $data['nama_pegawai'];
            $user->email = $data['email'];
            $user->role = $data['role'];

            if (!empty($data['password'])) {
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
        $expectedHeader = ['nama_pegawai', 'nip', 'pangkat_golongan', 'jabatan', 'sub_seksi', 'email', 'password', 'role'];

        // Membersihkan BOM jika ada pada karakter pertama (biasa terjadi pada file CSV dari Excel)
        $header[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $header[0]);

        if ($header !== $expectedHeader) {
            fclose($handle);
            throw new Exception("Format kolom CSV tidak sesuai. Gunakan template yang disediakan.");
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

                // Pastikan jumlah kolom sama
                if (count($row) !== count($header)) {
                    $errors[] = "Baris $rowNum: Jumlah kolom tidak sesuai.";
                    $gagal++;
                    $rowNum++;
                    continue;
                }

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

                // Cek role valid
                $validRoles = \App\Enums\UserRole::values();
                if (!in_array($data['role'], $validRoles)) {
                    $errors[] = "Baris $rowNum: Role '{$data['role']}' tidak valid.";
                    $gagal++;
                    $rowNum++;
                    continue;
                }

                // Insert User
                $user = User::create([
                    'name' => $data['nama_pegawai'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => $data['role'],
                ]);

                // Insert Pegawai
                Pegawai::create([
                    'user_id' => $user->id,
                    'nama_pegawai' => $data['nama_pegawai'],
                    'nip' => $data['nip'],
                    'pangkat_golongan' => $data['pangkat_golongan'] ?: null,
                    'jabatan' => $data['jabatan'] ?: null,
                    'sub_seksi' => $data['sub_seksi'] ?: null,
                ]);

                $berhasil++;
                $rowNum++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            throw new Exception("Gagal memproses baris $rowNum: " . $e->getMessage());
        }

        fclose($handle);

        return [
            'berhasil' => $berhasil,
            'gagal' => $gagal,
            'errors' => $errors,
        ];
    }
}
