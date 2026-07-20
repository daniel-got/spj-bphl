<?php

namespace Tests\Feature\Spd;

use App\Models\Pegawai;
use App\Models\Spd;
use App\Models\Spt;
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
        $user = User::factory()->create(['roles' => ['user']]);

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
        $user = User::factory()->create(['roles' => ['user']]);

        $response = $this->actingAs($user)->get(route('user.spd.create'));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // STORE - Simpan SPD Baru
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuat_spd_baru(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $spt = Spt::factory()->create(['pembuat_id' => $user->id, 'status' => Spt::STATUS_APPROVED]);

        $payload = [
            'nomor_spd' => 'SPD/001/BPHL/'.now()->year,
            'tgl_spd' => now()->format('Y-m-d'),
            'nip_pegawai' => '198501012010011001',
            'jenis_perjalanan' => 'Luar Kota',
            'berangkat_dari' => 'Samarinda',
            'alat_angkut' => ['Kendaraan Dinas'],
            'ppk' => 'Pejabat Pembuat Komitmen 1',
            'nama_ppk' => 'Kepala Balai',
            'nip_ppk' => '197001012000011001',
            'spt_id' => $spt->id,
        ];

        $response = $this->actingAs($user)->post(route('user.spd.store'), $payload);

        $response->assertRedirect(route('user.spd.index'));
        $this->assertDatabaseHas('data_spd', ['nomor_spd' => 'SPD/001/BPHL/'.now()->year]);
    }

    public function test_nip_pegawai_dipaksa_dari_akun_yang_login(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $pegawai = Pegawai::factory()->create(['user_id' => $user->id]);
        $spt = Spt::factory()->create(['pembuat_id' => $user->id, 'status' => Spt::STATUS_APPROVED]);

        $payload = [
            'nomor_spd' => 'SPD/010/BPHL/'.now()->year,
            'tgl_spd' => now()->format('Y-m-d'),
            // Sengaja mengirim NIP orang lain — harus diabaikan & ditimpa NIP akun.
            'nip_pegawai' => '000000000000000000',
            'jenis_perjalanan' => 'Luar Kota',
            'berangkat_dari' => 'Samarinda',
            'alat_angkut' => ['Kendaraan Dinas'],
            'ppk' => 'Pejabat Pembuat Komitmen 1',
            'nama_ppk' => 'Kepala Balai',
            'nip_ppk' => '197001012000011001',
            'spt_id' => $spt->id,
        ];

        $this->actingAs($user)->post(route('user.spd.store'), $payload);

        $this->assertDatabaseHas('data_spd', [
            'nomor_spd' => 'SPD/010/BPHL/'.now()->year,
            'nip_pegawai' => $pegawai->nip,
        ]);
    }

    public function test_riwayat_spd_menampilkan_identitas_pegawai(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $pegawai = Pegawai::factory()->create(['user_id' => $user->id]);
        $spd = Spd::factory()->create([
            'pembuat_id' => $user->id,
            'nip_pegawai' => $pegawai->nip,
        ]);

        // Accessor membaca identitas dari data_pegawai berdasarkan nip_pegawai.
        $this->assertSame($pegawai->nama_pegawai, $spd->pegawai_ditugaskan);
        $this->assertSame($pegawai->jabatan, $spd->jabatan_pegawai);
        $this->assertNotNull($spd->pangkat_pegawai);

        $this->actingAs($user)
            ->get(route('user.spd.show', $spd))
            ->assertStatus(200)
            ->assertSee($pegawai->nama_pegawai);
    }

    public function test_user_gagal_membuat_spd_untuk_spt_orang_lain(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $otherUser = User::factory()->create(['roles' => ['user']]);
        $spt = Spt::factory()->create(['pembuat_id' => $otherUser->id, 'status' => Spt::STATUS_APPROVED]);

        $payload = [
            'nomor_spd' => 'SPD/001/BPHL/'.now()->year,
            'tgl_spd' => now()->format('Y-m-d'),
            'nip_pegawai' => '198501012010011001',
            'jenis_perjalanan' => 'Luar Kota',
            'berangkat_dari' => 'Samarinda',
            'alat_angkut' => ['Kendaraan Dinas'],
            'ppk' => 'Pejabat Pembuat Komitmen 1',
            'nama_ppk' => 'Kepala Balai',
            'nip_ppk' => '197001012000011001',
            'spt_id' => $spt->id,
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Anda tidak memiliki akses untuk membuat SPD dari SPT ini.');

        $this->actingAs($user)->withoutExceptionHandling()->post(route('user.spd.store'), $payload);
    }

    public function test_gagal_membuat_spd_jika_nomor_spd_duplikat(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $spt = Spt::factory()->create(['pembuat_id' => $user->id, 'status' => Spt::STATUS_APPROVED]);
        Spd::factory()->create(['nomor_spd' => 'SPD/001/BPHL/'.now()->year, 'pembuat_id' => $user->id, 'spt_id' => $spt->id]);

        $response = $this->actingAs($user)->post(route('user.spd.store'), [
            'nomor_spd' => 'SPD/001/BPHL/'.now()->year,
            'tgl_spd' => now()->format('Y-m-d'),
            'berangkat_dari' => 'Samarinda',
            'spt_id' => $spt->id,
        ]);

        $response->assertSessionHasErrors('nomor_spd');
    }

    public function test_gagal_membuat_spd_jika_field_wajib_kosong(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);

        $response = $this->actingAs($user)->post(route('user.spd.store'), []);

        $response->assertSessionHasErrors(['nomor_spd', 'tgl_spd', 'berangkat_dari', 'spt_id']);
    }

    // -------------------------------------------------------------------------
    // SHOW - Lihat Detail SPD
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_detail_spd(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.spd.show', $spd));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // UPDATE - Edit SPD
    // -------------------------------------------------------------------------

    public function test_halaman_edit_spd_menampilkan_tanggal_dari_spt(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $spt = Spt::factory()->create([
            'pembuat_id' => $user->id,
            'status' => Spt::STATUS_APPROVED,
            'tgl_berangkat' => '2026-08-10',
            'tgl_kembali' => '2026-08-15',
        ]);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id, 'spt_id' => $spt->id]);

        $response = $this->actingAs($user)->get(route('user.spd.edit', $spd));

        $response->assertStatus(200);
        // Tanggal (turunan dari SPT) harus tampil dalam format Y-m-d agar terbaca input type=date.
        $response->assertSee('value="2026-08-10"', false);
        $response->assertSee('value="2026-08-15"', false);
        // spt_id harus ikut dikirim agar update tidak gagal validasi (required).
        $response->assertSee('name="spt_id" value="'.$spt->id.'"', false);
    }

    public function test_user_dapat_mengedit_spd(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $spt = Spt::factory()->create(['status' => Spt::STATUS_APPROVED]);
        $spd = Spd::factory()->create([
            'pembuat_id' => $user->id,
            'spt_id' => $spt->id,
            'ppk' => 'Pejabat Pembuat Komitmen 1',
        ]);

        $response = $this->actingAs($user)->put(route('user.spd.update', $spd), [
            'nomor_spd' => $spd->nomor_spd,
            'tgl_spd' => $spd->tgl_spd->format('Y-m-d'),
            'nip_pegawai' => $spd->nip_pegawai,
            'jenis_perjalanan' => 'Dalam Kota',
            'berangkat_dari' => 'Berangkat Diperbarui',
            'alat_angkut' => ['Kendaraan Dinas'],
            'ppk' => 'Pejabat Pembuat Komitmen 1',
            'nama_ppk' => $spd->nama_ppk,
            'nip_ppk' => $spd->nip_ppk,
            'spt_id' => $spt->id,
        ]);

        $response->assertRedirect(route('user.spd.index'));
        $this->assertDatabaseHas('data_spd', ['id' => $spd->id, 'berangkat_dari' => 'Berangkat Diperbarui']);
    }

    // -------------------------------------------------------------------------
    // DESTROY - Hapus SPD
    // -------------------------------------------------------------------------

    public function test_user_dapat_menghapus_spd(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('user.spd.destroy', $spd));

        $response->assertRedirect(route('user.spd.index'));
        $this->assertDatabaseMissing('data_spd', ['id' => $spd->id]);
    }
}
