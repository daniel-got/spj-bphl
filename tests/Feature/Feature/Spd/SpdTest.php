<?php

namespace Tests\Feature\Feature\Spd;

use App\Models\Spd;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpdTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // INDEX - Melihat Daftar SPD
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_halaman_daftar_spd(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('user.spd.index'));

        $response->assertStatus(200);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $response = $this->get(route('user.spd.index'));

        $response->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // CREATE - Form Tambah SPD
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuka_halaman_tambah_spd(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('user.spd.create'));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // STORE - Simpan SPD Baru
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuat_spd_baru(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $payload = [
            'nomor_spd'          => 'SPD/001/BPHL/' . now()->year,
            'tgl_spd'            => now()->format('Y-m-d'),
            'pegawai_ditugaskan' => 'Budi Santoso',
            'nip_pegawai'        => '198501012010011001',
            'pangkat_pegawai'    => 'Penata',
            'jabatan_pegawai'    => 'Staf Pelaksana',
            'tujuan_kegiatan'    => 'Menghadiri Rapat Koordinasi',
            'tempat_tujuan'      => ['Jakarta'],
            'tgl_berangkat'      => now()->addDays(5)->format('Y-m-d'),
            'tgl_kembali'        => now()->addDays(7)->format('Y-m-d'),
            'lama_kegiatan'      => 3,
            'kode_mak'           => '5311.001.001',
            'jenis_perjalanan'   => 'Luar Kota',
            'berangkat_dari'     => 'Samarinda',
            'alat_angkut'        => ['Kendaraan Dinas'],
            'ppk'                => 'Pejabat Pembuat Komitmen 1',
            'nama_ppk'           => 'Kepala Balai',
            'nip_ppk'            => '197001012000011001',
        ];

        $response = $this->actingAs($user)->post(route('user.spd.store'), $payload);

        $response->assertRedirect(route('user.spd.index'));
        $this->assertDatabaseHas('data_spd', ['nomor_spd' => 'SPD/001/BPHL/'.now()->year]);
    }

    public function test_gagal_membuat_spd_jika_nomor_spd_duplikat(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        Spd::factory()->create(['nomor_spd' => 'SPD/001/BPHL/'.now()->year, 'pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('user.spd.store'), [
            'nomor_spd' => 'SPD/001/BPHL/'.now()->year,
            'tgl_spd' => now()->format('Y-m-d'),
            'tujuan_kegiatan' => 'Rapat',
            'jenis_perjalanan' => 'Dalam Kota',
            'berangkat_dari' => 'Samarinda',
        ]);

        $response->assertSessionHasErrors('nomor_spd');
    }

    public function test_gagal_membuat_spd_jika_field_wajib_kosong(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post(route('user.spd.store'), []);

        $response->assertSessionHasErrors(['nomor_spd', 'tgl_spd', 'tujuan_kegiatan', 'jenis_perjalanan', 'berangkat_dari']);
    }

    // -------------------------------------------------------------------------
    // SHOW - Lihat Detail SPD
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_detail_spd(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.spd.show', $spd));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // UPDATE - Edit SPD
    // -------------------------------------------------------------------------

    public function test_user_dapat_mengedit_spd(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $spd  = Spd::factory()->create([
            'pembuat_id'    => $user->id,
            'jenis_perjalanan' => 'Luar Kota',
            'alat_angkut'   => 'Kendaraan Dinas',
            'ppk'           => 'Pejabat Pembuat Komitmen 1',
        ]);

        $response = $this->actingAs($user)->put(route('user.spd.update', $spd), [
            'nomor_spd'          => $spd->nomor_spd,
            'tgl_spd'            => $spd->tgl_spd->format('Y-m-d'),
            'pegawai_ditugaskan' => $spd->pegawai_ditugaskan,
            'nip_pegawai'        => $spd->nip_pegawai,
            'tujuan_kegiatan'    => 'Tujuan Diperbarui',
            'tempat_tujuan'      => $spd->tempat_tujuan,
            'tgl_berangkat'      => $spd->tgl_berangkat->format('Y-m-d'),
            'tgl_kembali'        => $spd->tgl_kembali->format('Y-m-d'),
            'lama_kegiatan'      => $spd->lama_kegiatan,
            'kode_mak'           => $spd->kode_mak,
            'jenis_perjalanan'   => 'Luar Kota',
            'berangkat_dari'     => $spd->berangkat_dari,
            'alat_angkut'        => ['Kendaraan Dinas'],
            'ppk'                => 'Pejabat Pembuat Komitmen 1',
            'nama_ppk'           => $spd->nama_ppk,
            'nip_ppk'            => $spd->nip_ppk,
        ]);

        $response->assertRedirect(route('user.spd.index'));
        $this->assertDatabaseHas('data_spd', ['id' => $spd->id, 'tujuan_kegiatan' => 'Tujuan Diperbarui']);
    }

    // -------------------------------------------------------------------------
    // DESTROY - Hapus SPD
    // -------------------------------------------------------------------------

    public function test_user_dapat_menghapus_spd(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('user.spd.destroy', $spd));

        $response->assertRedirect(route('user.spd.index'));
        $this->assertDatabaseMissing('data_spd', ['id' => $spd->id]);
    }
}
