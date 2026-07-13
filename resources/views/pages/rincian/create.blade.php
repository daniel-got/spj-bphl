<x-layout.app title="Tambah Rincian - SPJ BPHL 4">

    <!-- jQuery & Select2 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <x-style.select2 />

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
                    Tambah Rincian Baru
                </h1>
            </div>

            <form action="{{ route('user.rincian.store') }}" method="POST">
                @csrf

                <div class="bg-surface border border-border-custom rounded-xl shadow-sm p-6 space-y-6">

                    {{-- Pencarian SPD --}}
                    <div class="pb-6 flex flex-col gap-1 border-b border-border-custom">
                        <label for="spd_id" class="text-sm font-semibold text-text-main">
                            Pilih Nomor SPD
                        </label>
                        <select name="spd_id" id="spd_id" class="w-full">
                            <option value="">Cari dan pilih Nomor SPD...</option>
                        </select>
                        @if ($errors->has('spd_id'))
                            <p class="text-xs text-danger mt-1">{{ $errors->first('spd_id') }}</p>
                        @endif
                    </div>

                    {{-- Data SPD (Readonly) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nomor_spd" label="Nomor SPD" disabled="true" />
                        <x-form.input name="tgl_spd" label="Tanggal SPD" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="pegawai_ditugaskan" label="Pegawai Ditugaskan" disabled="true" />
                        <x-form.input name="nip_pegawai" label="NIP Pegawai" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <x-form.textarea name="tujuan_kegiatan" label="Tujuan Kegiatan" rows="2" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="berangkat_dari" label="Berangkat Dari" disabled="true" />
                        <x-form.input name="tempat_tujuan" label="Tempat Tujuan" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.input name="lama_kegiatan" label="Lama Kegiatan (Hari)" disabled="true" />
                        <x-form.input name="jenis_perjalanan" label="Jenis Perjalanan" disabled="true" />
                        <x-form.input name="alat_angkut" label="Alat Angkut" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <x-form.input name="kode_mak" label="Kode MAK" disabled="true" />
                        <x-form.input name="ppk" label="PPK" disabled="true" />
                        <x-form.input name="nama_ppk" label="Nama PPK" disabled="true" />
                        <x-form.input name="nip_ppk" label="NIP PPK" disabled="true" />
                    </div>

                    {{-- Field Khusus Rincian (Editable + Dinamis) --}}
                    <div class="border-t border-border-custom pt-6 space-y-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base font-bold text-text-main">Biaya Rincian</h3>
                            <button type="button" id="btn-tambah-biaya"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md border border-primary text-primary text-sm font-medium hover:bg-primary hover:text-white transition duration-150">
                                <x-utility.icon name="plus" class="w-4 h-4" />
                                Tambah Rincian
                            </button>
                        </div>

                        <div id="rincian-biaya-container" class="space-y-4">
                            {{-- Baris pertama selalu ada --}}
                            <div class="rincian-row bg-background border border-border-custom rounded-lg p-4 relative">
                                <button type="button"
                                    class="btn-hapus-baris absolute top-3 right-3 text-muted hover:text-danger transition hidden"
                                    title="Hapus baris ini">
                                    <x-utility.icon name="trash" class="w-4 h-4" />
                                </button>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm font-semibold text-text-main">Biaya Transport (Rp)</label>
                                        <input type="number" name="rincian_biaya[0][biaya_transport]" min="0"
                                            placeholder="Contoh: 150000"
                                            class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm font-semibold text-text-main">Penginapan (%)</label>
                                        <select name="rincian_biaya[0][penginapan]"
                                            class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm text-text-main focus:outline-none focus:ring-2 focus:ring-primary">
                                            <option value="">-- Pilih --</option>
                                            <option value="100">100%</option>
                                            <option value="30">30%</option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm font-semibold text-text-main">Biaya Hotel / Penginapan (Rp)</label>
                                        <input type="number" name="rincian_biaya[0][hotel_ril]" min="0"
                                            placeholder="Otomatis dihitung..." readonly
                                            class="block w-full rounded-md border border-border-custom bg-surface-muted px-3 py-2 text-sm text-text-main focus:outline-none" />
                                    </div>
                                </div>
                            </div>
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
                        Simpan Rincian
                    </x-action.button-primary>
                </div>
            </form>
        </div>
    </main>
    <x-layout.footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select2 untuk SPD
            $('#spd_id').select2({
                placeholder: 'Cari dan pilih Nomor SPD...',
                allowClear: true,
                ajax: {
                    url: '{{ route("user.rincian.spd.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });

            // Handle ketika SPD dipilih
            $('#spd_id').on('select2:select', function (e) {
                const spdId = e.params.data.id;
                if (spdId) {
                    let url = '{{ route("user.rincian.spd.ajax", ["id" => ":id"]) }}';
                    url = url.replace(':id', spdId);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            // Autofill semua input disabled
                            $('#nomor_spd').val(data.nomor_spd || '');
                            $('#tgl_spd').val(data.tgl_spd || '');
                            $('#pegawai_ditugaskan').val(data.pegawai_ditugaskan || '');
                            $('#nip_pegawai').val(data.nip_pegawai || '');
                            $('#tujuan_kegiatan').val(data.tujuan_kegiatan || '');
                            $('#berangkat_dari').val(data.berangkat_dari || '');
                            $('#tempat_tujuan').val(data.tempat_tujuan || '');
                            $('#lama_kegiatan').val(data.lama_kegiatan || '');
                            $('#jenis_perjalanan').val(data.jenis_perjalanan || '');
                            $('#alat_angkut').val(data.alat_angkut || '');
                            $('#kode_mak').val(data.kode_mak || '');
                            $('#ppk').val(data.ppk || '');
                            $('#nama_ppk').val(data.nama_ppk || '');
                            $('#nip_ppk').val(data.nip_ppk || '');
                            
                            // Simpan rate penginapan ke data attribute form atau window
                            window.currentPenginapanRate = data.penginapan_rate || 0;
                            
                            // Trigger kalkulasi ulang jika sudah ada baris rincian
                            calculateAllPenginapan();
                        },
                        error: function() {
                            alert('Gagal mengambil data SPD.');
                        }
                    });
                }
            });
            
            // Handle ketika select dibersihkan (clear)
            $('#spd_id').on('select2:unselect', function (e) {
                // Reset semua field
                $('#nomor_spd, #tgl_spd, #pegawai_ditugaskan, #nip_pegawai, #tujuan_kegiatan, #berangkat_dari, #tempat_tujuan, #lama_kegiatan, #jenis_perjalanan, #alat_angkut, #kode_mak, #ppk, #nama_ppk, #nip_ppk').val('');
                window.currentPenginapanRate = 0;
                calculateAllPenginapan();
            });
        });
    </script>

    <script>
        // -----------------------------------------------------------------------
        // Dynamic Rincian Biaya Rows
        // -----------------------------------------------------------------------
        (function () {
            const container = document.getElementById('rincian-biaya-container');
            const btnTambah = document.getElementById('btn-tambah-biaya');

            /** Build a single rincian row HTML with a given index */
            function buildRow(index) {
                return `
                    <div class="rincian-row bg-background border border-border-custom rounded-lg p-4 relative">
                        <button type="button"
                            class="btn-hapus-baris absolute top-3 right-3 text-muted hover:text-danger transition"
                            title="Hapus baris ini">
                            <x-utility.icon name="trash" class="w-4 h-4" />
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
                                    placeholder="Otomatis dihitung..." readonly
                                    class="block w-full rounded-md border border-border-custom bg-surface-muted px-3 py-2 text-sm text-text-main focus:outline-none" />
                            </div>
                        </div>
                    </div>`;
            }

            /** Re-index all rows sequentially after add/remove */
            function reindex() {
                container.querySelectorAll('.rincian-row').forEach(function (row, i) {
                    row.querySelectorAll('input, select').forEach(function (el) {
                        if (el.name) {
                            el.name = el.name.replace(/\[\d+\]/, '[' + i + ']');
                        }
                    });
                });

                // Show/hide delete button: hide when only 1 row
                const rows = container.querySelectorAll('.rincian-row');
                rows.forEach(function (row) {
                    const btn = row.querySelector('.btn-hapus-baris');
                    if (btn) btn.classList.toggle('hidden', rows.length === 1);
                });
            }

            // Tambah baris baru
            btnTambah.addEventListener('click', function () {
                const index = container.querySelectorAll('.rincian-row').length;
                container.insertAdjacentHTML('beforeend', buildRow(index));
                reindex();
            });

            // Hapus baris (delegasi event ke container)
            container.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-hapus-baris');
                if (!btn) return;
                const row = btn.closest('.rincian-row');
                if (container.querySelectorAll('.rincian-row').length > 1) {
                    row.remove();
                    reindex();
                }
            });

            // Kalkulasi penginapan saat persentase berubah
            container.addEventListener('change', function(e) {
                if (e.target.matches('select[name*="[penginapan]"]')) {
                    const row = e.target.closest('.rincian-row');
                    calculateRowPenginapan(row);
                }
            });
            
            window.calculateRowPenginapan = function(row) {
                const select = row.querySelector('select[name*="[penginapan]"]');
                const inputHotel = row.querySelector('input[name*="[hotel_ril]"]');
                const persentase = parseInt(select.value) || 0;
                const rate = window.currentPenginapanRate || 0;
                const lamaKegiatan = parseInt(document.getElementById('lama_kegiatan').value) || 0;
                
                // Menghitung total: rate * persentase% * (lama_kegiatan - 1)
                // Menginap biasanya lama kegiatan - 1 hari. 
                // Wait, default calculation might be just rate * percentage * days? 
                // Usually hotel calculation requires user to input quantity, but for now we just do rate * percentage% * (lama_kegiatan-1) if applicable, 
                // Let's just do rate * percentage% for 1 day first, or should we multiply by days?
                // Let's multiply by (lamaKegiatan > 1 ? lamaKegiatan - 1 : 1) as a default, or just rate * percentage%
                let hariMenginap = lamaKegiatan > 1 ? lamaKegiatan - 1 : 1;
                if (lamaKegiatan === 0) hariMenginap = 1; // fallback
                
                const total = Math.round((rate * (persentase / 100)) * hariMenginap);
                inputHotel.value = total > 0 ? total : '';
            }
            
            window.calculateAllPenginapan = function() {
                container.querySelectorAll('.rincian-row').forEach(row => {
                    calculateRowPenginapan(row);
                });
            }

            // Inisialisasi: tampilkan tombol hapus hanya jika lebih dari 1
            reindex();
        })();
    </script>
</x-layout.app>
