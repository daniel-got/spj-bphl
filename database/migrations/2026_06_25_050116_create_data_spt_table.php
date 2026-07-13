<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_spt', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spt')->unique();
            $table->date('tgl_spt');
            
            // Kolom Surat Dasar untuk menampung acuan Poin 3 (Opsional)
            $table->text('surat_dasar')->nullable();
            
            // Menyimpan data array pegawai (ID, Nama, NIP, Pangkat, Jabatan, Peran) dalam bentuk JSON
            $table->json('pegawai_ditugaskan');
            
            $table->text('tujuan_kegiatan');
            $table->string('tempat_tujuan');
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->integer('lama_kegiatan');
            $table->string('kode_mak');

            // Workflow & Tracking Columns
            $table->enum('status', ['draft', 'diajukan', 'direvisi', 'disetujui', 'ditolak'])->default('draft');
            $table->foreignId('pembuat_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('verifikator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('catatan_verifikator')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_spt');
    }
};
