<?php

namespace Tests\Feature\Feature\Rincian;

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
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('user.rincian.index'));

        $response->assertStatus(200);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $response = $this->get(route('user.rincian.index'));

        $response->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // CREATE - Form Tambah Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuka_halaman_tambah_rincian(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('user.rincian.create'));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // AJAX - Pencarian SPD (Select2)
    // -------------------------------------------------------------------------

    public function test_ajax_pencarian_spd_mengembalikan_json(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        Spd::factory()->create(['nomor_spd' => 'SPD/TEST/BPHL/2026', 'pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('user.rincian.spd.search', ['q' => 'SPD/TEST']));

        $response->assertStatus(200)
            ->assertJsonStructure(['results' => [['id', 'text']]]);
    }

    public function test_ajax_detail_spd_mengembalikan_data_lengkap(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('user.rincian.spd.ajax', $spd->id));

        $response->assertStatus(200)
            ->assertJsonStructure(['nomor_spd', 'tgl_spd', 'pegawai_ditugaskan', 'nip_pegawai', 'tujuan_kegiatan']);
    }

    public function test_ajax_detail_spd_mengembalikan_array_kosong_jika_id_tidak_valid(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->getJson(route('user.rincian.spd.ajax', 99999));

        $response->assertStatus(200)->assertJson([]);
    }

    // -------------------------------------------------------------------------
    // STORE - Simpan Rincian Baru (otomatis copy data dari SPD)
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuat_rincian_dari_spd(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $spd = Spd::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('user.rincian.store'), [
            'spd_id' => $spd->id,
            'biaya_transport' => 150000,
            'penginapan' => 2,
            'hotel_ril' => 500000,
        ]);

        $response->assertRedirect(route('user.rincian.index'));
        $this->assertDatabaseHas('data_rincian', [
            'nomor_spd' => $spd->nomor_spd,
            'biaya_transport' => 150000,
        ]);
    }

    public function test_gagal_membuat_rincian_tanpa_spd_id(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post(route('user.rincian.store'), [
            'biaya_transport' => 150000,
        ]);

        $response->assertSessionHasErrors('spd_id');
    }

    public function test_gagal_membuat_rincian_jika_spd_id_tidak_valid(): void
    {
        $user = User::factory()->create(['role' => 'user']);

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
        $user = User::factory()->create(['role' => 'user']);
        $rincian = Rincian::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.rincian.show', $rincian));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // UPDATE - Edit Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_mengedit_biaya_rincian(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $rincian = Rincian::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('user.rincian.update', $rincian), [
            'biaya_transport' => 250000,
            'penginapan' => 3,
            'hotel_ril' => 750000,
        ]);

        $response->assertRedirect(route('user.rincian.index'));
        $this->assertDatabaseHas('data_rincian', [
            'id' => $rincian->id,
            'biaya_transport' => 250000,
        ]);
    }

    // -------------------------------------------------------------------------
    // DESTROY - Hapus Rincian
    // -------------------------------------------------------------------------

    public function test_user_dapat_menghapus_rincian(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $rincian = Rincian::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('user.rincian.destroy', $rincian));

        $response->assertRedirect(route('user.rincian.index'));
        $this->assertDatabaseMissing('data_rincian', ['id' => $rincian->id]);
    }
}
