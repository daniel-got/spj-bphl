<x-layout.app title="Edit Rincian - SPJ BPHL 4">
    <main class="grow flex flex-col px-6 py-10">
        <div class="max-w-5xl mx-auto w-full">

            @if ($errors->any())
                <div class="mb-6">
                    <x-feedback.alert type="error" title="Terjadi Kesalahan" :dismissible="true">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-feedback.alert>
                </div>
            @endif

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('user.rincian.index') }}" class="text-muted hover:text-text-main transition font-medium">
                    ← Kembali
                </a>
                <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                    Edit Rincian Biaya
                </h1>
            </div>

            <form action="{{ route('user.rincian.update', $rincian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-surface border border-border-custom rounded-xl shadow-sm p-6 space-y-6">

                    {{-- Data SPD (Readonly) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nomor_spd" label="Nomor SPD" :value="$rincian->nomor_spd" disabled="true" />
                        <x-form.input name="tgl_spd" label="Tanggal SPD" :value="$rincian->tgl_spd" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="pegawai_ditugaskan" label="Pegawai Ditugaskan" :value="$rincian->pegawai_ditugaskan" disabled="true" />
                        <x-form.input name="nip_pegawai" label="NIP Pegawai" :value="$rincian->nip_pegawai" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <x-form.textarea name="tujuan_kegiatan" label="Tujuan Kegiatan" rows="2" :value="$rincian->tujuan_kegiatan" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="berangkat_dari" label="Berangkat Dari" :value="$rincian->berangkat_dari" disabled="true" />
                        <x-form.input name="tempat_tujuan" label="Tempat Tujuan" :value="$rincian->tempat_tujuan" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.input name="lama_kegiatan" label="Lama Kegiatan (Hari)" :value="$rincian->lama_kegiatan" disabled="true" />
                        <x-form.input name="jenis_perjalanan" label="Jenis Perjalanan" :value="$rincian->jenis_perjalanan" disabled="true" />
                        <x-form.input name="alat_angkut" label="Alat Angkut" :value="$rincian->alat_angkut" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <x-form.input name="kode_mak" label="Kode MAK" :value="$rincian->kode_mak" disabled="true" />
                        <x-form.input name="ppk" label="PPK" :value="$rincian->ppk" disabled="true" />
                        <x-form.input name="nama_ppk" label="Nama PPK" :value="$rincian->nama_ppk" disabled="true" />
                        <x-form.input name="nip_ppk" label="NIP PPK" :value="$rincian->nip_ppk" disabled="true" />
                    </div>

                    {{-- Field Khusus Rincian (Editable + Dinamis) --}}
                    <div class="border-t border-border-custom pt-6 space-y-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-bold text-text-main">Biaya Rincian</h3>
                            <button type="button" id="btn-tambah-biaya"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-primary text-primary text-sm font-medium hover:bg-primary hover:text-white transition duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Rincian
                            </button>
                        </div>

                        <div id="rincian-biaya-container" class="space-y-4">
                            @php
                                $existingBiaya = old('rincian_biaya', $rincian->rincian_biaya ?? []);
                                if (empty($existingBiaya)) {
                                    $existingBiaya = [['biaya_transport' => '', 'penginapan' => '', 'hotel_ril' => '']];
                                }
                            @endphp

                            @foreach ($existingBiaya as $i => $baris)
                                <div class="rincian-row bg-background border border-border-custom rounded-lg p-4 relative">
                                    <button type="button"
                                        class="btn-hapus-baris absolute top-3 right-3 text-muted hover:text-danger transition {{ count($existingBiaya) <= 1 ? 'hidden' : '' }}"
                                        title="Hapus baris ini">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-text-main">Biaya Transport (Rp)</label>
                                            <input type="number" name="rincian_biaya[{{ $i }}][biaya_transport]" min="0"
                                                value="{{ $baris['biaya_transport'] ?? '' }}"
                                                placeholder="Contoh: 150000"
                                                class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary" />
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-text-main">Penginapan (%)</label>
                                            <select name="rincian_biaya[{{ $i }}][penginapan]"
                                                class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary">
                                                <option value="">-- Pilih --</option>
                                                <option value="100" {{ ($baris['penginapan'] ?? '') == 100 ? 'selected' : '' }}>100%</option>
                                                <option value="30" {{ ($baris['penginapan'] ?? '') == 30 ? 'selected' : '' }}>30%</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-text-main">Biaya Hotel / Penginapan (Rp)</label>
                                            <input type="number" name="rincian_biaya[{{ $i }}][hotel_ril]" min="0"
                                                value="{{ $baris['hotel_ril'] ?? '' }}"
                                                placeholder="Contoh: 500000"
                                                class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('user.rincian.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md border border-border-custom text-sm font-medium text-text-main hover:bg-background transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <x-action.button-primary type="submit">
                        Simpan Perubahan
                    </x-action.button-primary>
                </div>
            </form>
        </div>
    </main>
    <x-layout.footer />

    <script>
        // -----------------------------------------------------------------------
        // Dynamic Rincian Biaya Rows (Edit)
        // -----------------------------------------------------------------------
        (function () {
            const container = document.getElementById('rincian-biaya-container');
            const btnTambah = document.getElementById('btn-tambah-biaya');

            function buildRow(index) {
                return `
                    <div class="rincian-row bg-background border border-border-custom rounded-lg p-4 relative">
                        <button type="button"
                            class="btn-hapus-baris absolute top-3 right-3 text-muted hover:text-danger transition"
                            title="Hapus baris ini">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex flex-col gap-1">
                                <label class="text-sm font-semibold text-text-main">Biaya Transport (Rp)</label>
                                <input type="number" name="rincian_biaya[${index}][biaya_transport]" min="0"
                                    placeholder="Contoh: 150000"
                                    class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary" />
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-sm font-semibold text-text-main">Penginapan (%)</label>
                                <select name="rincian_biaya[${index}][penginapan]"
                                    class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="">-- Pilih --</option>
                                    <option value="100">100%</option>
                                    <option value="30">30%</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-sm font-semibold text-text-main">Biaya Hotel / Penginapan (Rp)</label>
                                <input type="number" name="rincian_biaya[${index}][hotel_ril]" min="0"
                                    placeholder="Contoh: 500000"
                                    class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary" />
                            </div>
                        </div>
                    </div>`;
            }

            function reindex() {
                container.querySelectorAll('.rincian-row').forEach(function (row, i) {
                    row.querySelectorAll('input, select').forEach(function (el) {
                        if (el.name) {
                            el.name = el.name.replace(/\[\d+\]/, '[' + i + ']');
                        }
                    });
                });
                const rows = container.querySelectorAll('.rincian-row');
                rows.forEach(function (row) {
                    const btn = row.querySelector('.btn-hapus-baris');
                    if (btn) btn.classList.toggle('hidden', rows.length === 1);
                });
            }

            btnTambah.addEventListener('click', function () {
                const index = container.querySelectorAll('.rincian-row').length;
                container.insertAdjacentHTML('beforeend', buildRow(index));
                reindex();
            });

            container.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-hapus-baris');
                if (!btn) return;
                const row = btn.closest('.rincian-row');
                if (container.querySelectorAll('.rincian-row').length > 1) {
                    row.remove();
                    reindex();
                }
            });

            reindex();
        })();
    </script>
</x-layout.app>
