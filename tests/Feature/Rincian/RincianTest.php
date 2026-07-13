<?php

namespace Tests\Feature\Rincian;

use App\Models\Pegawai;
use App\Models\Rincian;
use App\Models\Spd;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RincianTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // INDEX - Melihat Daftar Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_halaman_daftar_rincian(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);

        $response = $this->actingAs($user)->get(route('user.rincian.index'));

        $response->assertStatus(200);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $response = $this->get(route('user.rincian.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_ajax_spd_mengembalikan_nama_pegawai_dan_tanggal_terformat(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $pegawai = Pegawai::factory()->create(['user_id' => $user->id]);
        $spd = Spd::factory()->create([
            'pembuat_id' => $user->id,
            'nip_pegawai' => $pegawai->nip,
            'tgl_spd' => '2026-07-13',
        ]);

        $response = $this->actingAs($user)->getJson(route('user.rincian.spd.ajax', $spd->id));

        $response->assertStatus(200);
        // Bukan array objek ([object Object]) — harus nama pegawai tunggal.
        $response->assertJsonPath('pegawai_ditugaskan', $pegawai->nama_pegawai);
        // Tanggal harus terformat Y-m-d, bukan ISO string.
        $response->assertJsonPath('tgl_spd', '2026-07-13');
    }

    // -------------------------------------------------------------------------
    // CREATE - Form Tambah Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuka_halaman_tambah_rincian(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);

        $response = $this->actingAs($user)->get(route('user.rincian.create'));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // AJAX - Pencarian SPD (Select2)
    // -------------------------------------------------------------------------

    public function test_ajax_pencarian_spd_mengembalikan_json(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        Spd::factory()->create(['nomor_spd' => 'SPD/TEST/BPHL/2026', 'pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('user.rincian.spd.search', ['q' => 'SPD/TEST']));

        $response->assertStatus(200)
            ->assertJsonStructure(['results' => [['id', 'text']]]);
    }

    public function test_ajax_detail_spd_mengembalikan_data_lengkap(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('user.rincian.spd.ajax', $spd->id));

        $response->assertStatus(200)
            ->assertJsonStructure(['nomor_spd', 'tgl_spd', 'pegawai_ditugaskan', 'nip_pegawai', 'tujuan_kegiatan']);
    }

    public function test_ajax_detail_spd_mengembalikan_array_kosong_jika_id_tidak_valid(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);

        $response = $this->actingAs($user)->getJson(route('user.rincian.spd.ajax', 99999));

        $response->assertStatus(200)->assertJson([]);
    }

    // -------------------------------------------------------------------------
    // STORE - Simpan Rincian Baru (otomatis copy data dari SPD)
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuat_rincian_dari_spd_dengan_data_dinamis_ganda(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);

        // Buat SPD
        $spd = Spd::factory()->create([
            'pembuat_id' => $user->id,
            'alat_angkut' => ['Pesawat', 'Kereta Api', 'Taksi'],
        ]);

        $response = $this->actingAs($user)->post(route('user.rincian.store'), [
            'spd_id' => $spd->id,
            'rincian_biaya' => [
                [
                    'biaya_transport' => 150000,
                    'penginapan' => 100,
                    'hotel_ril' => 500000,
                ],
                [
                    'biaya_transport' => 200000,
                    'penginapan' => 30,
                    'hotel_ril' => 700000,
                ],
            ],
        ]);

        $response->assertRedirect(route('user.rincian.index'));
        $this->assertDatabaseHas('data_rincian', [
            'spd_id' => $spd->id,
        ]);

        $rincian = Rincian::where('spd_id', $spd->id)->first();
        $this->assertCount(2, $rincian->rincian_biaya);
        $this->assertEquals(150000, $rincian->rincian_biaya[0]['biaya_transport']);
        $this->assertEquals(200000, $rincian->rincian_biaya[1]['biaya_transport']);
    }

    public function test_gagal_membuat_rincian_tanpa_spd_id(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);

        $response = $this->actingAs($user)->post(route('user.rincian.store'), [
            'rincian_biaya' => [
                [
                    'biaya_transport' => 150000,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('spd_id');
    }

    public function test_gagal_membuat_rincian_jika_spd_id_tidak_valid(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);

        $response = $this->actingAs($user)->post(route('user.rincian.store'), [
            'spd_id' => 99999,
        ]);

        $response->assertSessionHasErrors('spd_id');
    }

    // -------------------------------------------------------------------------
    // SHOW - Lihat Detail Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_detail_rincian(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $rincian = Rincian::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.rincian.show', $rincian));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // UPDATE - Edit Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_mengedit_biaya_rincian_menjadi_ganda(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $rincian = Rincian::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('user.rincian.update', $rincian), [
            'rincian_biaya' => [
                [
                    'biaya_transport' => 250000,
                    'penginapan' => 100,
                    'hotel_ril' => 750000,
                ],
                [
                    'biaya_transport' => 50000,
                    'penginapan' => 30,
                    'hotel_ril' => 0,
                ],
            ],
        ]);

        $response->assertRedirect(route('user.rincian.index'));

        $rincian->refresh();
        $this->assertCount(2, $rincian->rincian_biaya);
        $this->assertEquals(250000, $rincian->rincian_biaya[0]['biaya_transport']);
        $this->assertEquals(50000, $rincian->rincian_biaya[1]['biaya_transport']);
    }

    // -------------------------------------------------------------------------
    // DESTROY - Hapus Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_menghapus_rincian(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $rincian = Rincian::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('user.rincian.destroy', $rincian));

        $response->assertRedirect(route('user.rincian.index'));
        $this->assertDatabaseMissing('data_rincian', ['id' => $rincian->id]);
    }

    // -------------------------------------------------------------------------
    // ROLE FILTER - Keamanan Akses Data
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_rincian_yang_ditugaskan_kepadanya_melalui_nip(): void
    {
        $user = User::factory()->create(['roles' => ['user']]);
        $pegawai = Pegawai::factory()->create(['user_id' => $user->id]);

        // Rincian dibuat oleh orang lain (admin), tapi ditugaskan ke user ini (NIP sama di SPD)
        $admin = User::factory()->create(['roles' => ['admin']]);
        $spd = Spd::factory()->create([
            'nip_pegawai' => $pegawai->nip,
            'pembuat_id' => $admin->id,
        ]);
        $rincian = Rincian::factory()->create([
            'spd_id' => $spd->id,
            'pembuat_id' => $admin->id,
        ]);

        $response = $this->actingAs($user)->get(route('user.rincian.index'));

        $response->assertStatus(200);
        $response->assertSee($spd->nomor_spd);
    }
}
