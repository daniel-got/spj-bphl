<?php

namespace Tests\Feature\Admin;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelolaPegawaiTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // INDEX - Melihat Daftar Pegawai
    // -------------------------------------------------------------------------

    public function test_admin_dapat_melihat_halaman_kelola_pegawai(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.kelolaPegawai'));

        $response->assertStatus(200);
    }

    public function test_user_biasa_tidak_dapat_mengakses_halaman_kelola_pegawai(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('admin.kelolaPegawai'));

        $response->assertStatus(403);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $response = $this->get(route('admin.kelolaPegawai'));

        $response->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // STORE - Menambah Pegawai
    // -------------------------------------------------------------------------

    public function test_admin_dapat_menambahkan_pegawai_baru(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.kelolaPegawai.store'), [
            'nama_pegawai' => 'Budi Santoso',
            'nip' => '198501012010011001',
            'email' => 'budi@bphl.go.id',
            'password' => 'password123',
            'role' => 'user',
            'pangkat' => null,
            'golongan' => null,
            'jabatan' => 'Staf Pelaksana',
            'sub_seksi' => 'TU',
        ]);

        $response->assertRedirect(route('admin.kelolaPegawai'));
        $this->assertDatabaseHas('data_pegawai', ['nip' => '198501012010011001']);
        $this->assertDatabaseHas('users', ['email' => 'budi@bphl.go.id', 'role' => 'user']);
    }

    public function test_gagal_tambah_pegawai_jika_nip_sudah_ada(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Pegawai::factory()->create(['nip' => '198501012010011001']);

        $response = $this->actingAs($admin)->post(route('admin.kelolaPegawai.store'), [
            'nama_pegawai' => 'Orang Lain',
            'nip' => '198501012010011001', // NIP duplikat
            'email' => 'orang@bphl.go.id',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response->assertSessionHasErrors('nip');
    }

    public function test_gagal_tambah_pegawai_jika_field_wajib_kosong(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.kelolaPegawai.store'), []);

        $response->assertSessionHasErrors(['nama_pegawai', 'nip', 'email', 'password', 'role']);
    }

    // -------------------------------------------------------------------------
    // UPDATE - Memperbarui Pegawai
    // -------------------------------------------------------------------------

    public function test_admin_dapat_memperbarui_data_pegawai(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pegawai = Pegawai::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.kelolaPegawai.update', $pegawai), [
            'nama_pegawai' => 'Nama Diperbarui',
            'nip' => $pegawai->nip,
            'email' => $pegawai->user->email,
            'role' => 'verifikator',
            'pangkat' => null,
            'golongan' => null,
            'jabatan' => 'Verifikator Ahli',
            'sub_seksi' => null,
        ]);

        $response->assertRedirect(route('admin.kelolaPegawai'));
        $this->assertDatabaseHas('data_pegawai', ['id' => $pegawai->id, 'nama_pegawai' => 'Nama Diperbarui']);
        $this->assertDatabaseHas('users', ['id' => $pegawai->user_id, 'role' => 'verifikator']);
    }

    public function test_admin_dapat_mengganti_role_pegawai(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pegawai = Pegawai::factory()->create(['user_id' => User::factory()->create(['role' => 'user'])->id]);

        $this->actingAs($admin)->put(route('admin.kelolaPegawai.update', $pegawai), [
            'nama_pegawai' => $pegawai->nama_pegawai,
            'nip' => $pegawai->nip,
            'email' => $pegawai->user->email,
            'role' => 'verifikator',
            'pangkat' => null,
            'golongan' => null,
        ]);

        $this->assertDatabaseHas('users', ['id' => $pegawai->user_id, 'role' => 'verifikator']);
    }

    // -------------------------------------------------------------------------
    // DESTROY - Menghapus Pegawai
    // -------------------------------------------------------------------------

    public function test_admin_dapat_menghapus_pegawai(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pegawai = Pegawai::factory()->create();

        $userId = $pegawai->user_id;

        $response = $this->actingAs($admin)->delete(route('admin.kelolaPegawai.destroy', $pegawai));

        $response->assertRedirect(route('admin.kelolaPegawai'));
        $this->assertDatabaseMissing('data_pegawai', ['id' => $pegawai->id]);
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }
}
