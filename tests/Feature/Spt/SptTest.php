<?php

namespace Tests\Feature\Spt;

use App\Http\Middleware\EnsurePembuatSpt;
use App\Models\Pegawai;
use App\Models\Spt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SptTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // INDEX - Melihat Daftar SPT
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_halaman_daftar_spt(): void
    {
        // Biarkan menggunakan role bawaan dari factory tim kalian
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.spt.index'));

        $response->assertStatus(200);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $response = $this->get(route('user.spt.index'));

        $response->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // CREATE - Form Tambah SPT
    // -------------------------------------------------------------------------

    public function test_user_dapat_membuka_halaman_tambah_spt(): void
    {
        $user = User::factory()->create();

        // Kita hanya mematikan middleware kustom pengunci rute saja,
        // sehingga middleware session web (termasuk variabel $errors) tetap hidup aman!
        $response = $this->withoutMiddleware([EnsurePembuatSpt::class])
            ->actingAs($user)
            ->get(route('user.spt.create'));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // STORE - Simpan SPT Baru
    // -------------------------------------------------------------------------

    public function test_user_dapat_mengajukan_spt_baru(): void
    {
        $user = User::factory()->create();

        $payload = [
            'nomor_spt' => 'SPT/001/BPHL/'.now()->year,
            'tgl_spt' => now()->format('Y-m-d'),
            'tujuan_kegiatan' => 'Menghadiri Rapat Koordinasi Nasional',
            'tempat_tujuan' => 'Jakarta',
            'tgl_berangkat' => now()->addDays(5)->format('Y-m-d'),
            'tgl_kembali' => now()->addDays(7)->format('Y-m-d'),
            'lama_kegiatan' => 3,
            'kode_mak' => '5311.001.001',
            'pegawai_ditugaskan' => [
                ['pegawai_id' => 1, 'nama_pegawai' => 'Budi Santoso', 'nip' => '198501012010011001', 'pangkat' => 'Penata / IIIc', 'jabatan' => 'Analis Data', 'peran' => 'Penanggung Jawab'],
            ],
        ];

        // Seed data pegawai agar exists validation lolos
        Pegawai::factory()->create(['id' => 1]);

        $response = $this->withoutMiddleware([EnsurePembuatSpt::class])
            ->actingAs($user)
            ->post(route('user.spt.store'), $payload);

        $response->assertRedirect(route('user.spt.index'));
        $this->assertDatabaseHas('data_spt', ['nomor_spt' => 'SPT/001/BPHL/'.now()->year]);
    }

    public function test_gagal_membuat_spt_jika_nomor_spt_sudah_ada(): void
    {
        $user = User::factory()->create();
        Spt::factory()->create(['nomor_spt' => 'SPT/001/BPHL/'.now()->year, 'pembuat_id' => $user->id]);

        $payload = [
            'nomor_spt' => 'SPT/001/BPHL/'.now()->year,
            'tgl_spt' => now()->format('Y-m-d'),
            'tujuan_kegiatan' => 'Rapat',
            'tempat_tujuan' => 'Bandung',
            'tgl_berangkat' => now()->addDays(1)->format('Y-m-d'),
            'tgl_kembali' => now()->addDays(2)->format('Y-m-d'),
            'lama_kegiatan' => 2,
            'kode_mak' => '5311.001.001',
        ];

        $response = $this->withoutMiddleware([EnsurePembuatSpt::class])
            ->actingAs($user)
            ->from(route('user.spt.create'))
            ->post(route('user.spt.store'), $payload);

        $response->assertSessionHasErrors('nomor_spt');
    }

    public function test_gagal_membuat_spt_jika_field_wajib_kosong(): void
    {
        $user = User::factory()->create();

        $response = $this->withoutMiddleware([EnsurePembuatSpt::class])
            ->actingAs($user)
            ->from(route('user.spt.create'))
            ->post(route('user.spt.store'), []);

        $response->assertSessionHasErrors(['nomor_spt', 'tgl_spt', 'tujuan_kegiatan']);
    }

    // -------------------------------------------------------------------------
    // SHOW - Lihat Detail SPT
    // -------------------------------------------------------------------------

    public function test_user_dapat_melihat_detail_spt(): void
    {
        $user = User::factory()->create();
        $spt = Spt::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('user.spt.show', $spt));

        $response->assertStatus(200);
    }

    // -------------------------------------------------------------------------
    // DESTROY - Hapus SPT
    // -------------------------------------------------------------------------

    public function test_user_dapat_menghapus_spt_miliknya(): void
    {
        $user = User::factory()->create();
        $spt = Spt::factory()->create(['pembuat_id' => $user->id]);

        $response = $this->withoutMiddleware([EnsurePembuatSpt::class])
            ->actingAs($user)
            ->delete(route('user.spt.destroy', $spt));

        $response->assertRedirect(route('user.spt.index'));
        $this->assertDatabaseMissing('data_spt', ['id' => $spt->id]);
    }
    public function test_user_dapat_mengajukan_spt_baru_dengan_banyak_pegawai(): void
    {
        $user = User::factory()->create();

        Pegawai::factory()->create(['id' => 1, 'nama_pegawai' => 'Budi Santoso', 'nip' => '198501012010011001', 'pangkat' => 'Penata', 'jabatan' => 'Analis']);
        Pegawai::factory()->create(['id' => 2, 'nama_pegawai' => 'Ani Wijaya', 'nip' => '199002022015012002', 'pangkat' => 'Pengatur', 'jabatan' => 'Administrasi']);

        $payload = [
            'nomor_spt' => 'SPT/MULTI/001/'.now()->year,
            'tgl_spt' => now()->format('Y-m-d'),
            'tujuan_kegiatan' => 'Tujuan Multi Pegawai',
            'tempat_tujuan' => 'Jakarta',
            'tgl_berangkat' => now()->addDays(1)->format('Y-m-d'),
            'tgl_kembali' => now()->addDays(3)->format('Y-m-d'),
            'lama_kegiatan' => 3,
            'kode_mak' => 'MAK-001',
            'pegawai_ditugaskan' => [
                [
                    'pegawai_id' => 1,
                    'nama_pegawai' => 'Budi Santoso',
                    'nip' => '198501012010011001',
                    'pangkat' => 'Penata',
                    'jabatan' => 'Analis',
                    'peran' => 'Penanggung Jawab',
                ],
                [
                    'pegawai_id' => 2,
                    'nama_pegawai' => 'Ani Wijaya',
                    'nip' => '199002022015012002',
                    'pangkat' => 'Pengatur',
                    'jabatan' => 'Administrasi',
                    'peran' => 'Anggota',
                ],
            ],
        ];

        $response = $this->withoutMiddleware([EnsurePembuatSpt::class])
            ->actingAs($user)
            ->post(route('user.spt.store'), $payload);

        $response->assertRedirect(route('user.spt.index'));

        $spt = Spt::where('nomor_spt', 'SPT/MULTI/001/'.now()->year)->first();
        $this->assertNotNull($spt);
        $this->assertCount(2, $spt->pegawai_ditugaskan);
        $this->assertEquals('Budi Santoso', $spt->penanggung_jawab);
        $this->assertEquals('Ani Wijaya', $spt->anggota);
    }
}
