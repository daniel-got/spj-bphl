<x-layout.app title="Tambah SPT - SPJ BPHL 4">

    {{-- CDN Tom Select untuk Dropdown Search --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>


    {{-- Perbaikan CSS Mutakhir untuk Tampilan Search Tom Select --}}
    <style>
        /* 1. Atur kontainer utama Tom Select agar tingginya pas (38px) dan serasi dengan input lain */
        .ts-wrapper .ts-control {
            min-height: 38px !important;
            height: 38px !important;
            max-height: 38px !important;
            padding: 0 0.75rem !important;
            display: flex !important;
            align-items: center !important;
            gap: 4px !important;
            overflow: hidden !important;
            background-color: #ffffff !important;
            cursor: text !important;
        }

        /* 2. Saat dropdown TERTUTUP dan sudah ada pegawai terpilih: sembunyikan placeholder,
              cukup tampilkan nama pegawai yang sedang aktif */
        .ts-wrapper.has-items:not(.dropdown-active) .ts-control > input::placeholder {
            color: transparent !important;
            opacity: 0 !important;
        }

        /* 2b. Saat dropdown DIBUKA (mau ganti nama): sembunyikan teks nama yang sedang
               terpilih, lalu tampilkan kotak ketik pencarian secara penuh & jelas */
        .ts-wrapper.dropdown-active .ts-control > .item {
            display: none !important;
        }

        .ts-wrapper.dropdown-active .ts-control > input {
            width: 100% !important;
            flex: 1 1 auto !important;
        }

        .ts-wrapper.dropdown-active .ts-control > input::placeholder {
            color: #9ca3af !important;
            opacity: 1 !important;
        }

        /* 3. Atur kotak input pencarian agar menyatu rapi di dalam dropdown */
        .ts-wrapper .ts-control > input {
            font-size: 14px !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            max-width: 100% !important;
        }

        /* 4. Format teks nama pegawai terpilih agar memanjang rapi dan tidak patah/turun ke bawah */
        .ts-wrapper .ts-control > .item {
            display: inline-block !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: 180px !important;
            line-height: 38px !important;
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            color: #1f2937 !important;
            cursor: pointer !important;
        }

        /* 5. Tampilan list hasil pencarian dropdown agar melayang rapi di atas input bawahnya */
        .ts-dropdown {
            margin-top: 4px !important;
            border-radius: 0.375rem !important;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1) !important;
            z-index: 50 !important;
        }
    </style>

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
                <a href="{{ route('user.spt.index') }}" class="text-muted hover:text-text-main transition font-medium">
                    ← Kembali
                </a>
                <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                    Tambah SPT Baru
                </h1>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.spt.store') }}" method="POST" id="spt-form">
                @csrf

                <div class="bg-surface border border-border-custom rounded-xl shadow-sm p-6 space-y-6">

                    {{-- Nomor & Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nomor_spt" label="Nomor SPT" placeholder="Contoh: 094/01/SPT/2026"
                            :value="old('nomor_spt')" :required="true" :error="$errors->first('nomor_spt')" />
                        <x-form.date-picker name="tgl_spt" label="Tanggal SPT" :value="old('tgl_spt')" :required="true"
                            :error="$errors->first('tgl_spt')" />
                    </div>

                    {{-- Baris Baru: Jenis Kategori SPT & Surat Dasar --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        {{-- Jenis Tugas menggunakan x-form.select --}}
                        <x-form.select
                            name="jenis_tugas"
                            label="Jenis Kategori SPT"
                            :required="true"
                            :selected="old('jenis_tugas')"
                            :error="$errors->first('jenis_tugas')"
                            :options="['pelatihan' => 'Pelatihan', 'keuangan' => 'Keuangan', 'administrasi' => 'Administrasi']"
                            placeholder="-- Pilih Kategori Tugas --"
                        />

                        {{-- Surat Dasar: TomSelect creatable dropdown --}}
                        <div class="md:col-span-2 flex flex-col">
                            <label for="surat_dasar" class="text-sm font-medium text-text-main mb-2 block">
                                Surat Dasar / Acuan Poin 3 <span class="text-muted text-xs">(Opsional)</span>
                            </label>

                            {{-- Hidden input yang akan menjadi TomSelect --}}
                            <select id="surat_dasar_select" name="surat_dasar"
                                class="surat-dasar-tomselect w-full">
                                <option value="">-- Pilih atau ketik surat dasar --</option>
                                @foreach($riwayatSuratDasar as $riwayat)
                                    <option value="{{ $riwayat }}"
                                        {{ old('surat_dasar') === $riwayat ? 'selected' : '' }}>
                                        {{ $riwayat }}
                                    </option>
                                @endforeach
                                {{-- Jika nilai old() tidak ada di riwayat, tambahkan sebagai option terpilih --}}
                                @if(old('surat_dasar') && !in_array(old('surat_dasar'), $riwayatSuratDasar->toArray()))
                                    <option value="{{ old('surat_dasar') }}" selected>{{ old('surat_dasar') }}</option>
                                @endif
                            </select>

                            <small class="text-xs text-muted mt-1">
                                Pilih dari riwayat atau ketik surat baru &amp; tekan <kbd class="bg-surface border border-border-custom rounded px-1 py-0.5 text-xs">Enter</kbd> untuk menyimpan sebagai pilihan baru.
                            </small>
                            @if ($errors->has('surat_dasar'))
                                <p class="text-xs text-danger mt-1">{{ $errors->first('surat_dasar') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Pegawai yang Ditugaskan (Dinamis) --}}
                    <div class="border-t border-border-custom pt-6">
                        <label class="text-sm font-medium text-text-main mb-2 block">
                            Pegawai yang Ditugaskan <span class="text-danger">*</span>
                        </label>

                        <div id="pegawai-list" class="space-y-4">
                            <div class="pegawai-item border border-border-custom rounded-lg p-4 bg-background/50">
                                <div class="flex items-end gap-2">
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 grow">
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">Nama Pegawai</label>
                                            <select required class="pegawai-select w-full">
                                                <option value="">Pilih Pegawai</option>
                                                @foreach ($pegawaiList as $pegawai)
                                                    <option value="{{ $pegawai->id }}"
                                                        data-nama="{{ $pegawai->nama_pegawai }}"
                                                        data-nip="{{ $pegawai->nip }}"
                                                        data-pangkat="{{ $pegawai->pangkat }}{{ $pegawai->golongan ? ' / '.$pegawai->golongan : '' }}"
                                                        data-jabatan="{{ $pegawai->jabatan }}">
                                                        {{ $pegawai->nama_pegawai }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">Peran SPT</label>
                                            <select required class="pegawai-peran w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background border-border-custom focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                                <option value="Penanggung Jawab">Penanggung Jawab</option>
                                                <option value="Anggota">Anggota</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">NIP</label>
                                            <input type="text" readonly tabindex="-1"
                                                class="pegawai-nip w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">Pangkat/Golongan</label>
                                            <input type="text" readonly tabindex="-1"
                                                class="pegawai-pangkat w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="text-xs font-medium text-text-main mb-1">Jabatan</label>
                                            <input type="text" readonly tabindex="-1"
                                                class="pegawai-jabatan w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-action.button id="add-pegawai-btn"
                                class="border-primary text-primary text-sm hover:bg-primary hover:text-white px-3 py-1.5 gap-1.5">
                                <x-utility.icon name="plus" class="w-4 h-4" />
                                Tambah Pegawai
                            </x-action.button>
                        </div>

                        {{-- Hidden input berisi snapshot JSON lengkap --}}
                        <input type="hidden" name="pegawai_ditugaskan" id="pegawai_ditugaskan_json"
                            value="{{ old('pegawai_ditugaskan') }}">

                        @if ($errors->has('pegawai_ditugaskan'))
                            <p class="text-xs text-danger mt-1">{{ $errors->first('pegawai_ditugaskan') }}</p>
                        @endif
                    </div>

                    {{-- Tujuan & Tempat --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-border-custom pt-6">
                        <x-form.textarea name="tujuan_kegiatan" label="Tujuan Kegiatan"
                            placeholder="Tuliskan tujuan kegiatan perjalanan dinas..." :rows="3"
                            :value="old('tujuan_kegiatan')" :required="true" :error="$errors->first('tujuan_kegiatan')" />

                        <x-form.input name="tempat_tujuan" label="Tempat Tujuan" placeholder="Contoh: Jakarta"
                            :value="old('tempat_tujuan')" :required="true" :error="$errors->first('tempat_tujuan')" />
                    </div>

                    {{-- Tanggal Berangkat, Kembali, Durasi Penugasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.date-picker name="tgl_berangkat" label="Tanggal Berangkat" :value="old('tgl_berangkat')"
                            :required="true" :error="$errors->first('tgl_berangkat')" />
                        <x-form.date-picker name="tgl_kembali" label="Tanggal Kembali" :value="old('tgl_kembali')"
                            :required="true" :error="$errors->first('tgl_kembali')" />
                        <x-form.input name="lama_kegiatan" label="Durasi Penugasan (hari)" type="number"
                            placeholder="Otomatis dihitung" :value="old('lama_kegiatan')" :required="true"
                            :error="$errors->first('lama_kegiatan')" :readonly="true" />
                    </div>

                    {{-- Kode MAK --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.input name="kode_mak" label="Kode MAK" placeholder="Kode MAK" :value="old('kode_mak')"
                            :required="true" :error="$errors->first('kode_mak')" />
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('user.spt.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md border border-border-custom text-sm font-medium text-text-main hover:bg-background transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <x-action.button-primary type="submit">
                        Simpan & Buat SPT
                    </x-action.button-primary>
                </div>

            </form>

        </div>

    </main>

    <x-layout.footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('pegawai-list');
            const addBtn = document.getElementById('add-pegawai-btn');
            const form = document.getElementById('spt-form');
            const hiddenInput = document.getElementById('pegawai_ditugaskan_json');
            const tglBerangkat = document.getElementById('tgl_berangkat');
            const tglKembali = document.getElementById('tgl_kembali');
            const lamaKegiatan = document.getElementById('lama_kegiatan');

            // TomSelect creatable dropdown untuk Surat Dasar
            const suratDasarSelect = document.getElementById('surat_dasar_select');
            if (suratDasarSelect) {
                new TomSelect(suratDasarSelect, {
                    create: true,
                    maxItems: 1,
                    placeholder: '-- Pilih atau ketik surat dasar baru --',
                    createOnBlur: false,
                    persist: false,
                    render: {
                        option_create: function(data, escape) {
                            return `<div class="create">
                                        Simpan: <strong>${escape(data.input)}</strong>&hellip;
                                    </div>`;
                        },
                        no_results: function(data, escape) {
                            return `<div class="no-results">Tidak ditemukan. Ketik lalu tekan Enter untuk menyimpan baru.</div>`;
                        },
                    }
                });
            }

            // Menyimpan daftar option mentah dari database
            const firstSelect = container.querySelector('.pegawai-select');
            const masterOptions = [];
            if (firstSelect) {
                firstSelect.querySelectorAll('option').forEach(opt => {
                    if (opt.value) {
                        masterOptions.push({
                            id: opt.value,
                            text: opt.textContent.trim(),
                            nip: opt.getAttribute('data-nip') || '',
                            pangkat: opt.getAttribute('data-pangkat') || '',
                            jabatan: opt.getAttribute('data-jabatan') || ''
                        });
                    }
                });
            }

            // Cache data pegawai untuk kebutuhan auto-fill
            const cacheOptions = {};
            masterOptions.forEach(opt => {
                cacheOptions[opt.id] = opt;
            });

            // Mendapatkan daftar ID pegawai yang sedang aktif dipilih
            function getSelectedPegawaiIds() {
                const ids = [];
                container.querySelectorAll('.pegawai-select').forEach(select => {
                    if (select.value) {
                        ids.push(select.value);
                    }
                });
                return ids;
            }

            // Sinkronisasi pilihan dropdown agar tidak bisa memilih nama yang sama di baris berbeda
            // PENTING: option milik baris itu sendiri (currentValue) selalu ikut didaftarkan ulang,
            // sehingga baris yang SUDAH punya nama tetap bisa dicari & diganti ke nama lain yang masih tersedia.
            function syncAllDropdowns() {
                const selectedIds = getSelectedPegawaiIds();

                container.querySelectorAll('.pegawai-item').forEach(item => {
                    const select = item.querySelector('.pegawai-select');
                    if (!select || !select.tomselect) return;

                    const ts = select.tomselect;
                    const currentValue = ts.getValue();

                    ts.off('change'); // Matikan sementara listener agar tidak looping infinity
                    ts.clearOptions();

                    // Daftarkan ulang opsi yang belum dipilih di baris lain
                    // + opsi milik baris ini sendiri, supaya bisa dicari ulang untuk diganti
                    masterOptions.forEach(opt => {
                        if (!selectedIds.includes(opt.id) || opt.id === currentValue) {
                            ts.addOption({ value: opt.id, text: opt.text });
                        }
                    });

                    ts.refreshOptions(false);
                    ts.setValue(currentValue, true); // pastikan nilai terpilih tidak hilang setelah re-render opsi

                    ts.on('change', function(value) {
                        handleDropdownChange(item, value);
                    });
                });
            }

            // Aksi ketika pilihan dropdown berubah (Auto-fill data pendukung)
            function handleDropdownChange(item, value) {
                const nipInput = item.querySelector('.pegawai-nip');
                const pangkatInput = item.querySelector('.pegawai-pangkat');
                const jabatanInput = item.querySelector('.pegawai-jabatan');

                const dataPegawai = cacheOptions[value];
                if (dataPegawai) {
                    nipInput.value = dataPegawai.nip;
                    pangkatInput.value = dataPegawai.pangkat;
                    jabatanInput.value = dataPegawai.jabatan;
                } else {
                    nipInput.value = '';
                    pangkatInput.value = '';
                    jabatanInput.value = '';
                }

                syncAllDropdowns();
            }

            // Fungsi Inisialisasi Tom Select Baru (Mendukung Search Aktual)
            function initPegawaiRow(item) {
                const select = item.querySelector('.pegawai-select');

                if (select.tomselect) {
                    select.tomselect.destroy();
                }

                const ts = new TomSelect(select, {
                    create: false,
                    maxOptions: 100,
                    placeholder: "Cari & Pilih Pegawai...",
                    // FIX: hapus custom controlInput string HTML (tidak valid untuk Tom Select
                    // dan menyebabkan kotak pencarian tidak berfungsi saat mau mengganti nama
                    // yang sudah terpilih). Biarkan Tom Select membuat input pencarian bawaannya.
                    searchField: ['text'],
                    openOnFocus: true, // klik pada item yang sudah terisi langsung membuka dropdown + siap diketik
                    score: function(search) {
                        search = search.toLowerCase().trim();
                        if (!search.length) return function() { return 1; };
                        return function(item) {
                            return item.text.toLowerCase().includes(search) ? 1 : 0;
                        };
                    },
                    render: {
                        item: function(data, escape) {
                            return '<div class="text-sm font-normal">' + escape(data.text) + '</div>';
                        },
                        option: function(data, escape) {
                            return '<div class="px-3 py-2 text-sm hover:bg-primary/10 text-text-main cursor-pointer">' + escape(data.text) + '</div>';
                        }
                    }
                });

                // Terapkan class Tailwind tanpa menimpa arsitektur default Tom Select
                const tsWrapper = item.querySelector('.ts-wrapper');
                if (tsWrapper) {
                    tsWrapper.style.border = 'none';
                    tsWrapper.style.padding = '0';
                    tsWrapper.style.background = 'transparent';

                    const tsControl = tsWrapper.querySelector('.ts-control');
                    if (tsControl) {
                        tsControl.classList.add(
                            'w-full', 'text-sm', 'border', 'rounded-md', 'shadow-sm',
                            'focus:outline-none', 'focus:ring-2', 'focus:ring-primary',
                            'focus:border-primary', 'border-border-custom'
                        );
                    }
                }

                ts.on('change', function(value) {
                    handleDropdownChange(item, value);
                });
            }

            // Manajemen tombol hapus baris dinamis
            function updateRemoveButtons() {
                const items = container.querySelectorAll('.pegawai-item');
                items.forEach((item) => {
                    let removeBtn = item.querySelector('.remove-pegawai-btn');
                    const select = item.querySelector('.pegawai-select');
                    if (items.length > 1) {
                        if (!removeBtn) {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = `
                                <x-action.icon-button color="danger" class="remove-pegawai-btn">
                                    <x-utility.icon name="trash" class="w-5 h-5" />
                                </x-action.icon-button>
                            `.trim();
                            removeBtn = tempDiv.firstChild;
                            removeBtn.addEventListener('click', function() {
                                if (select && select.tomselect) {
                                    select.tomselect.destroy();
                                }
                                item.remove();
                                updateRemoveButtons();
                                syncAllDropdowns();
                            });
                            item.querySelector('.flex.items-end').appendChild(removeBtn);
                        }
                    } else {
                        if (removeBtn) removeBtn.remove();
                    }
                });
            }

            // Tambah baris baru pegawai
            addBtn.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'pegawai-item border border-border-custom rounded-lg p-4 bg-background/50';

                let selectOptionsHTML = '<option value="">Pilih Pegawai</option>';
                masterOptions.forEach(opt => {
                    selectOptionsHTML += `<option value="${opt.id}">${opt.text}</option>`;
                });                newItem.innerHTML = `
                    <div class="flex items-end gap-2">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 grow">
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">Nama Pegawai</label>
                                <select required class="pegawai-select w-full">
                                    ${selectOptionsHTML}
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">Peran SPT</label>
                                <select required class="pegawai-peran w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background border-border-custom focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                    <option value="Penanggung Jawab">Penanggung Jawab</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">NIP</label>
                                <input type="text" readonly tabindex="-1"
                                    class="pegawai-nip w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">Pangkat/Golongan</label>
                                <input type="text" readonly tabindex="-1"
                                    class="pegawai-pangkat w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-medium text-text-main mb-1">Jabatan</label>
                                <input type="text" readonly tabindex="-1"
                                    class="pegawai-jabatan w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newItem);
                initPegawaiRow(newItem);
                updateRemoveButtons();
                syncAllDropdowns();
            });

            // Menjalankan inisialisasi awal saat halaman dibuka
            container.querySelectorAll('.pegawai-item').forEach(initPegawaiRow);
            updateRemoveButtons();
            syncAllDropdowns();

            // Interseptor form submit untuk membundel data pegawai ke input JSON hidden
            form.addEventListener('submit', function(e) {
                const items = container.querySelectorAll('.pegawai-item');
                const pegawaiData = [];

                items.forEach((item) => {
                    const select = item.querySelector('.pegawai-select');
                    const peranSelect = item.querySelector('.pegawai-peran');
                    const nipInput = item.querySelector('.pegawai-nip');
                    const pangkatInput = item.querySelector('.pegawai-pangkat');
                    const jabatanInput = item.querySelector('.pegawai-jabatan');

                    if (select && select.value) {
                        const dataPegawai = cacheOptions[select.value];
                        if (dataPegawai) {
                            pegawaiData.push({
                                pegawai_id: select.value,
                                nama_pegawai: dataPegawai.text,
                                nip: nipInput ? nipInput.value : dataPegawai.nip,
                                pangkat: pangkatInput ? pangkatInput.value : dataPegawai.pangkat,
                                jabatan: jabatanInput ? jabatanInput.value : dataPegawai.jabatan,
                                peran: peranSelect ? peranSelect.value : 'Anggota',
                            });
                        }
                    }
                });

                if (pegawaiData.length === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu pegawai yang ditugaskan.');
                    return;
                }

                hiddenInput.value = JSON.stringify(pegawaiData);
            });

            // Logika penghitung otomatis selisih durasi hari kegiatan
            function hitungHari() {
                const tgl1 = tglBerangkat ? new Date(tglBerangkat.value) : null;
                const tgl2 = tglKembali ? new Date(tglKembali.value) : null;

                if (tgl1 && tgl2 && tglBerangkat.value && tglKembali.value) {
                    const selisih = tgl2.getTime() - tgl1.getTime();
                    lamaKegiatan.value = selisih >= 0
                        ? Math.ceil(selisih / (1000 * 3600 * 24)) + 1
                        : '';
                }
            }

            if (tglBerangkat) tglBerangkat.addEventListener('change', hitungHari);
            if (tglKembali) tglKembali.addEventListener('change', hitungHari);
        });
    </script>

</x-layout.app>
