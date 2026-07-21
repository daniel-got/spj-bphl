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

            <form action="{{ route('user.rincian.store') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="border-t border-border-custom pt-6 space-y-6">
                        
                        {{-- Bagian Transportasi --}}
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-bold text-text-main">Biaya Transportasi</h3>
                            </div>
                            <p class="text-sm text-muted mb-4">Kategori transportasi disesuaikan dengan Alat Angkut pada SPD.</p>
                            
                            <div id="transport-container" class="space-y-6">
                                <p class="text-sm italic text-muted">Pilih SPD terlebih dahulu untuk menampilkan kategori transportasi.</p>
                            </div>
                        </div>

                        {{-- Bagian Penginapan --}}
                        <div class="border-t border-border-custom pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-bold text-text-main">Biaya Hotel / Penginapan</h3>
                                <x-action.button id="btn-tambah-penginapan"
                                    class="border-primary text-primary text-sm hover:bg-primary hover:text-white px-3 py-1.5 gap-1.5" type="button">
                                    <x-utility.icon name="plus" class="w-4 h-4" />
                                    Tambah Penginapan
                                </x-action.button>
                            </div>
                            
                            <div id="penginapan-container" class="space-y-4">
                                {{-- Row penginapan akan diisi lewat JS --}}
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
                            
                            // Generate Transport Categories
                            generateTransportCategories(data.alat_angkut || '');
                            
                            // Kosongkan penginapan
                            document.getElementById('penginapan-container').innerHTML = '';
                            addPenginapanRow();
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
                document.getElementById('transport-container').innerHTML = '<p class="text-sm italic text-muted">Pilih SPD terlebih dahulu untuk menampilkan kategori transportasi.</p>';
                document.getElementById('penginapan-container').innerHTML = '';
            });
        });
    </script>

    <script>
        // -----------------------------------------------------------------------
        // Dynamic Rincian Biaya Rows
        // -----------------------------------------------------------------------
        
        function generateTransportCategories(alatAngkutString) {
            const container = document.getElementById('transport-container');
            container.innerHTML = '';
            if (!alatAngkutString) return;

            const categories = alatAngkutString.split(',').map(s => s.trim()).filter(s => s);
            
            categories.forEach(category => {
                const safeCategory = category.replace(/[^a-zA-Z0-9]/g, '_');
                
                const html = `
                    <div class="transport-category border border-border-custom rounded-lg p-4 bg-surface" data-kategori="${category}">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-border-custom">
                            <h4 class="font-semibold text-text-main">${category}</h4>
                            <button class="btn-tambah-transport inline-flex items-center justify-center px-3 py-1 text-sm font-medium border border-primary text-primary hover:bg-primary hover:text-white rounded-md transition" type="button" data-kategori="${category}" data-safe-kategori="${safeCategory}">
                                Tambah Rute
                            </button>
                        </div>
                        <div class="transport-rows space-y-4" id="transport-rows-${safeCategory}">
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
                
                // Add default row
                addTransportRow(category, document.getElementById(`transport-rows-${safeCategory}`));
            });
        }

        function addTransportRow(category, rowsContainer) {
            const index = rowsContainer.querySelectorAll('.transport-row').length;
            const html = `
                <div class="transport-row relative grid grid-cols-1 md:grid-cols-4 gap-4 p-3 bg-background border border-border-custom rounded-md mt-3">
                    <button type="button" class="btn-hapus-transport absolute -top-2 -right-2 bg-danger text-white rounded-full p-1 shadow-sm hover:bg-red-600 z-10 hidden">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-text-main">Lokasi Awal</label>
                        <input type="text" name="rincian_biaya[transport][${category}][${index}][lokasi_awal]" required placeholder="Cth: Jakarta"
                            class="block w-full rounded-md border border-border-custom bg-surface px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-text-main">Lokasi Tujuan</label>
                        <input type="text" name="rincian_biaya[transport][${category}][${index}][lokasi_tujuan]" required placeholder="Cth: Bandung"
                            class="block w-full rounded-md border border-border-custom bg-surface px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-text-main">Biaya (Rp)</label>
                        <input type="number" name="rincian_biaya[transport][${category}][${index}][biaya]" min="0" required placeholder="Cth: 150000"
                            class="block w-full rounded-md border border-border-custom bg-surface px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-text-main">Lampiran (Opsional)</label>
                        <input type="file" name="rincian_biaya[transport][${category}][${index}][lampiran]" accept=".pdf,.png,.jpg,.jpeg"
                            class="block w-full text-xs text-text-main file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:bg-primary file:text-white hover:file:bg-primary-dark" />
                    </div>
                </div>
            `;
            rowsContainer.insertAdjacentHTML('beforeend', html);
            reindexTransportRows(rowsContainer, category);
        }

        function reindexTransportRows(rowsContainer, category) {
            const rows = rowsContainer.querySelectorAll('.transport-row');
            rows.forEach((row, i) => {
                row.querySelectorAll('input').forEach(el => {
                    if (el.name) {
                        el.name = el.name.replace(/\[\d+\]/, '[' + i + ']');
                    }
                });
                
                const btn = row.querySelector('.btn-hapus-transport');
                if (btn) btn.classList.toggle('hidden', rows.length === 1);
            });
        }

        function addPenginapanRow() {
            const container = document.getElementById('penginapan-container');
            const index = container.querySelectorAll('.penginapan-row').length;
            const html = `
                <div class="penginapan-row relative grid grid-cols-1 md:grid-cols-4 gap-4 p-4 bg-background border border-border-custom rounded-lg mt-3">
                    <button type="button" class="btn-hapus-penginapan absolute -top-2 -right-2 bg-danger text-white rounded-full p-1.5 shadow-sm hover:bg-red-600 z-10 hidden">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-semibold text-text-main">Keterangan</label>
                        <input type="text" name="rincian_biaya[penginapan][${index}][keterangan]" required placeholder="Cth: Hotel ABC"
                            class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-semibold text-text-main">Penginapan (%)</label>
                        <select name="rincian_biaya[penginapan][${index}][penginapan_persen]" required
                            class="block w-full rounded-md border border-border-custom bg-surface px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="">-- Pilih --</option>
                            <option value="100">100%</option>
                            <option value="30">30%</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-semibold text-text-main">Biaya Hotel (Rp)</label>
                        <input type="number" name="rincian_biaya[penginapan][${index}][hotel_ril]" min="0" readonly placeholder="Otomatis"
                            class="block w-full rounded-md border border-border-custom bg-surface-muted px-3 py-2 text-sm focus:outline-none" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-semibold text-text-main">Lampiran (Opsional)</label>
                        <input type="file" name="rincian_biaya[penginapan][${index}][lampiran]" accept=".pdf,.png,.jpg,.jpeg"
                            class="block w-full text-sm text-text-main file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-medium file:bg-primary file:text-white hover:file:bg-primary-dark" />
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            reindexPenginapanRows();
        }

        function reindexPenginapanRows() {
            const container = document.getElementById('penginapan-container');
            const rows = container.querySelectorAll('.penginapan-row');
            rows.forEach((row, i) => {
                row.querySelectorAll('input, select').forEach(el => {
                    if (el.name) {
                        el.name = el.name.replace(/\[\d+\]/, '[' + i + ']');
                    }
                });
                const btn = row.querySelector('.btn-hapus-penginapan');
                if (btn) btn.classList.toggle('hidden', rows.length === 1);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const transportContainer = document.getElementById('transport-container');
            const penginapanContainer = document.getElementById('penginapan-container');
            const btnTambahPenginapan = document.getElementById('btn-tambah-penginapan');

            // Tambah Row Transport
            transportContainer.addEventListener('click', function (e) {
                const btnTambah = e.target.closest('.btn-tambah-transport');
                if (btnTambah) {
                    const category = btnTambah.getAttribute('data-kategori');
                    const safeCategory = btnTambah.getAttribute('data-safe-kategori');
                    const rowsContainer = document.getElementById(`transport-rows-${safeCategory}`);
                    addTransportRow(category, rowsContainer);
                }

                const btnHapus = e.target.closest('.btn-hapus-transport');
                if (btnHapus) {
                    const row = btnHapus.closest('.transport-row');
                    const categoryContainer = row.closest('.transport-rows');
                    const category = categoryContainer.closest('.transport-category').getAttribute('data-kategori');
                    
                    if (categoryContainer.querySelectorAll('.transport-row').length > 1) {
                        row.remove();
                        reindexTransportRows(categoryContainer, category);
                    }
                }
            });

            // Tambah Row Penginapan
            btnTambahPenginapan.addEventListener('click', function () {
                addPenginapanRow();
            });

            // Hapus Row Penginapan
            penginapanContainer.addEventListener('click', function (e) {
                const btnHapus = e.target.closest('.btn-hapus-penginapan');
                if (btnHapus) {
                    const row = btnHapus.closest('.penginapan-row');
                    if (penginapanContainer.querySelectorAll('.penginapan-row').length > 1) {
                        row.remove();
                        reindexPenginapanRows();
                    }
                }
            });

            // Kalkulasi Penginapan
            penginapanContainer.addEventListener('change', function(e) {
                if (e.target.matches('select[name*="[penginapan_persen]"]')) {
                    calculateRowPenginapan(e.target.closest('.penginapan-row'));
                }
            });
            
            window.calculateRowPenginapan = function(row) {
                const select = row.querySelector('select[name*="[penginapan_persen]"]');
                const inputHotel = row.querySelector('input[name*="[hotel_ril]"]');
                const persentase = parseInt(select.value) || 0;
                const rate = window.currentPenginapanRate || 0;
                const lamaKegiatan = parseInt(document.getElementById('lama_kegiatan').value) || 0;
                
                let hariMenginap = lamaKegiatan > 1 ? lamaKegiatan - 1 : 1;
                if (lamaKegiatan === 0) hariMenginap = 1; // fallback
                
                const total = Math.round((rate * (persentase / 100)) * hariMenginap);
                inputHotel.value = total > 0 ? total : '';
            }
        });
    </script>
</x-layout.app>
