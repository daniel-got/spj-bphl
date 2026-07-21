<x-layout.app title="Edit SPT - SPJ BPHL 4">

    {{-- CDN Tom Select untuk Dropdown Search --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    {{-- CSS sama persis dengan create.blade.php agar tampilan konsisten --}}
    <style>
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

        .ts-wrapper.has-items:not(.dropdown-active) .ts-control > input::placeholder {
            color: transparent !important;
            opacity: 0 !important;
        }

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

        .ts-wrapper .ts-control > input {
            font-size: 14px !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            max-width: 100% !important;
        }

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
                    Edit SPT
                </h1>
            </div>

            @php
                // Decode data pegawai yang sudah tersimpan supaya bisa dipakai untuk
                // mengisi baris-baris awal form edit (bisa lebih dari 1 pegawai).
                $existingPegawai = $spt->pegawai_ditugaskan;
                if (is_string($existingPegawai)) {
                    $existingPegawai = json_decode($existingPegawai, true);
                }
                $existingPegawai = is_array($existingPegawai) && count($existingPegawai) > 0
                    ? $existingPegawai
                    : [[]]; // minimal 1 baris kosong kalau data lama tidak ada
            @endphp

            {{-- Form --}}
            <form action="{{ route('user.spt.update', $spt->id) }}" method="POST" id="spt-form">
                @csrf
                @method('PUT')

                <div class="bg-surface border border-border-custom rounded-xl shadow-sm p-6 space-y-6">

                    {{-- Nomor & Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nomor_spt" label="Nomor SPT" placeholder="Contoh: 094/01/SPT/2026"
                            :value="old('nomor_spt', $spt->nomor_spt)" :required="true" :error="$errors->first('nomor_spt')" />
                        <x-form.date-picker name="tgl_spt" label="Tanggal SPT"
                            :value="old('tgl_spt', optional($spt->tgl_spt)->format('m/d/Y'))" :required="true"
                            :error="$errors->first('tgl_spt')" />
                    </div>

                    {{-- Baris Baru: Jenis Kategori SPT & Surat Dasar --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        {{-- Jenis Tugas menggunakan x-form.select --}}
                        <x-form.select
                            name="jenis_tugas"
                            label="Jenis Kategori SPT"
                            :required="true"
                            :selected="old('jenis_tugas', $spt->jenis_tugas)"
                            :error="$errors->first('jenis_tugas')"
                            :options="['pelatihan' => 'Pelatihan', 'keuangan' => 'Keuangan', 'administrasi' => 'Administrasi']"
                            placeholder="-- Pilih Kategori Tugas --"
                        />

                        {{-- Surat Dasar: Dynamic Repeater --}}
                        <div class="md:col-span-2 flex flex-col">
                            <label class="text-sm font-medium text-text-main mb-2 block">
                                Surat Dasar / Acuan Poin <span class="text-muted text-xs">(Opsional)</span>
                            </label>

                            <style>
                                #surat-dasar-list .ts-wrapper,
                                #surat-dasar-list .ts-wrapper.single,
                                #surat-dasar-list .ts-wrapper.multi {
                                    height: auto !important;
                                    max-height: none !important;
                                    overflow: visible !important;
                                }
                                #surat-dasar-list .ts-control,
                                #surat-dasar-list .ts-wrapper.single .ts-control,
                                #surat-dasar-list .ts-wrapper.multi .ts-control {
                                    height: auto !important;
                                    max-height: none !important;
                                    min-height: 38px !important;
                                    overflow: visible !important;
                                    flex-wrap: wrap !important;
                                    padding: 6px 12px !important;
                                }
                                #surat-dasar-list .ts-control > div,
                                #surat-dasar-list .ts-control > .item,
                                #surat-dasar-list .ts-control > div.item {
                                    white-space: normal !important;
                                    overflow: visible !important;
                                    text-overflow: unset !important;
                                    word-break: break-word !important;
                                    max-width: 100% !important;
                                    line-height: 1.5 !important;
                                    display: block !important;
                                }
                                #surat-dasar-list .ts-control > input {
                                    width: 100% !important;
                                }
                                #surat-dasar-list .ts-dropdown .option {
                                    white-space: normal !important;
                                    word-break: break-word !important;
                                    line-height: 1.5 !important;
                                    padding: 8px 12px !important;
                                }
                            </style>
                            <div id="surat-dasar-list" class="space-y-3">
                                <!-- Dynamic rows added by JS -->
                            </div>
                            
                            <div class="mt-3">
                                <x-action.button type="button" id="btn-add-surat-dasar"
                                    class="border-primary text-primary text-sm hover:bg-primary hover:text-white px-3 py-1.5 gap-1.5">
                                    <x-utility.icon name="plus" class="w-4 h-4" />
                                    Tambah Poin Acuan
                                </x-action.button>
                            </div>

                            <small class="text-xs text-muted mt-1">
                                Teks ini dapat dipilih dari daftar master atau diketik langsung sesuai kebutuhan.
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
                            @foreach ($existingPegawai as $index => $pegawaiTersimpan)
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
                                                            data-jabatan="{{ $pegawai->jabatan }}"
                                                            @selected(($pegawaiTersimpan['pegawai_id'] ?? null) == $pegawai->id)>
                                                            {{ $pegawai->nama_pegawai }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="text-xs font-medium text-text-main mb-1">Peran SPT</label>
                                                <select required class="pegawai-peran w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background border-border-custom focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                                    <option value="Penanggung Jawab" @selected(($pegawaiTersimpan['peran'] ?? '') === 'Penanggung Jawab')>Penanggung Jawab</option>
                                                    <option value="Anggota" @selected(($pegawaiTersimpan['peran'] ?? 'Anggota') === 'Anggota')>Anggota</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="text-xs font-medium text-text-main mb-1">NIP</label>
                                                <input type="text" readonly tabindex="-1"
                                                    value="{{ $pegawaiTersimpan['nip'] ?? '' }}"
                                                    class="pegawai-nip w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="text-xs font-medium text-text-main mb-1">Pangkat/Golongan</label>
                                                <input type="text" readonly tabindex="-1"
                                                    value="{{ $pegawaiTersimpan['pangkat'] ?? '' }}"
                                                    class="pegawai-pangkat w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="text-xs font-medium text-text-main mb-1">Jabatan</label>
                                                <input type="text" readonly tabindex="-1"
                                                    value="{{ $pegawaiTersimpan['jabatan'] ?? '' }}"
                                                    class="pegawai-jabatan w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background text-muted border-border-custom cursor-not-allowed" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                            :value="old('tujuan_kegiatan', $spt->tujuan_kegiatan)" :required="true" :error="$errors->first('tujuan_kegiatan')" />

                        {{-- Tempat Tujuan --}}
                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-text-main mb-2 block">
                                Tempat Tujuan <span class="text-danger">*</span>
                            </label>

                            <div id="tempat-tujuan-list" class="space-y-2">
                                @php
                                    $oldTempat = old('tempat_tujuan', $spt->tempat_tujuan ?? []);
                                    if (is_string($oldTempat)) {
                                        $parsedTempat = array_filter(array_map('trim', explode(',', $oldTempat)));
                                    } elseif (is_array($oldTempat)) {
                                        $parsedTempat = array_filter(array_map('trim', $oldTempat));
                                    } else {
                                        $parsedTempat = [];
                                    }
                                    if (empty($parsedTempat)) {
                                        $parsedTempat = [''];
                                    }
                                @endphp

                                @foreach($parsedTempat as $index => $val)
                                    <div class="tempat-tujuan-item flex gap-2 items-center">
                                        <div class="grow relative">
                                            <input type="text" name="tempat_tujuan[]" value="{{ $val }}" required
                                                placeholder="Contoh: Jakarta"
                                                class="w-full px-3 py-2 text-sm border border-border-custom rounded-md bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
                                        </div>
                                        <button type="button" class="btn-remove-tempat-tujuan text-danger p-2 hover:bg-danger/10 rounded-md transition-colors" style="{{ count($parsedTempat) > 1 ? '' : 'display: none;' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <x-action.button type="button" id="btn-add-tempat-tujuan"
                                    class="border-primary text-primary text-sm hover:bg-primary hover:text-white px-3 py-1.5 gap-1.5">
                                    <x-utility.icon name="plus" class="w-4 h-4" />
                                    Tambah Tempat Tujuan
                                </x-action.button>
                            </div>

                            @if ($errors->has('tempat_tujuan'))
                                <p class="text-xs text-danger mt-1">{{ $errors->first('tempat_tujuan') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Tanggal Berangkat, Kembali, Durasi Penugasan --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.date-picker name="tgl_berangkat" label="Tanggal Berangkat"
                            :value="old('tgl_berangkat', optional($spt->tgl_berangkat)->format('m/d/Y'))"
                            :required="true" :error="$errors->first('tgl_berangkat')" />
                        <x-form.date-picker name="tgl_kembali" label="Tanggal Kembali"
                            :value="old('tgl_kembali', optional($spt->tgl_kembali)->format('m/d/Y'))"
                            :required="true" :error="$errors->first('tgl_kembali')" />
                        <x-form.input name="lama_kegiatan" label="Durasi Penugasan (hari)" type="number"
                            placeholder="Otomatis dihitung" :value="old('lama_kegiatan', $spt->lama_kegiatan)" :required="true"
                            :error="$errors->first('lama_kegiatan')" :readonly="true" />
                    </div>

                    {{-- Kode MAK --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.input name="kode_mak" label="Kode MAK" placeholder="Kode MAK" :value="old('kode_mak', $spt->kode_mak)"
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
                        Simpan Perubahan
                    </x-action.button-primary>
                </div>

            </form>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function escapeHtml(str) {
                if (!str) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

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

            // Menyimpan daftar option mentah dari database (diambil dari select baris pertama)
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

            const cacheOptions = {};
            masterOptions.forEach(opt => {
                cacheOptions[opt.id] = opt;
            });

            function getSelectedPegawaiIds() {
                const ids = [];
                container.querySelectorAll('.pegawai-select').forEach(select => {
                    if (select.value) {
                        ids.push(select.value);
                    }
                });
                return ids;
            }

            function syncAllDropdowns() {
                const selectedIds = getSelectedPegawaiIds();

                container.querySelectorAll('.pegawai-item').forEach(item => {
                    const select = item.querySelector('.pegawai-select');
                    if (!select || !select.tomselect) return;

                    const ts = select.tomselect;
                    const currentValue = ts.getValue();

                    ts.off('change');
                    ts.clearOptions();

                    masterOptions.forEach(opt => {
                        if (!selectedIds.includes(opt.id) || opt.id === currentValue) {
                            ts.addOption({ value: opt.id, text: opt.text });
                        }
                    });

                    ts.refreshOptions(false);
                    ts.setValue(currentValue, true);

                    ts.on('change', function(value) {
                        handleDropdownChange(item, value);
                    });
                });
            }

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

            // Fungsi Inisialisasi Tom Select. Untuk halaman Edit, select bisa sudah punya
            // <option selected> dari data lama -> Tom Select otomatis membaca itu sebagai nilai awal.
            function initPegawaiRow(item) {
                const select = item.querySelector('.pegawai-select');

                if (select.tomselect) {
                    select.tomselect.destroy();
                }

                const ts = new TomSelect(select, {
                    create: false,
                    maxOptions: 100,
                    placeholder: "Cari & Pilih Pegawai...",
                    searchField: ['text'],
                    openOnFocus: true,
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

             addBtn.addEventListener('click', function() {
                 const newItem = document.createElement('div');
                 newItem.className = 'pegawai-item border border-border-custom rounded-lg p-4 bg-background/50';

                 let selectOptionsHTML = '<option value="">Pilih Pegawai</option>';
                 masterOptions.forEach(opt => {
                     selectOptionsHTML += `<option value="${opt.id}">${opt.text}</option>`;
                 });

                 newItem.innerHTML = `
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

             // Inisialisasi semua baris yang sudah ada (termasuk baris hasil data lama dari server)
             container.querySelectorAll('.pegawai-item').forEach(initPegawaiRow);
             updateRemoveButtons();
             syncAllDropdowns();

             // Interseptor form submit untuk membundel data pegawai ke input JSON hidden
             // Auto-fill Surat Dasar
            const suratDasarGrouped = @json($suratDasarGrouped);
            const jenisTugasSelect = document.querySelector('[name="jenis_tugas"]');
            const suratDasarTextarea = document.getElementById('surat_dasar_textarea');
            
            if (jenisTugasSelect && suratDasarTextarea) {
                // Check if it's not old input before overwriting
                let hasOldSuratDasar = !!suratDasarTextarea.value.trim();

                jenisTugasSelect.addEventListener('change', function() {
                    const selectedJenis = this.value;
                    
                    let targetSuratDasar = [];
                    if (selectedJenis && suratDasarGrouped[selectedJenis]) {
                        targetSuratDasar = suratDasarGrouped[selectedJenis];
                    } else if (suratDasarGrouped['']) {
                        targetSuratDasar = suratDasarGrouped[''];
                    }

                    if (targetSuratDasar && targetSuratDasar.length > 0) {
                        const listTeks = targetSuratDasar.map((item, index) => `${index + 1}. ${item.teks}`);
                        suratDasarTextarea.value = listTeks.join('\n');
                    } else {
                        suratDasarTextarea.value = '';
                    }
                });

                // Trigger auto-fill on page load if a type is pre-selected and textarea is empty
                if (jenisTugasSelect.value && !hasOldSuratDasar) {
                    jenisTugasSelect.dispatchEvent(new Event('change'));
                }
            }

            // Interseptor form submit untuk membundel data pegawai ke input JSON hidden
            form.addEventListener('submit', function(e) {
                if (typeof hitungHari === 'function') {
                    hitungHari();
                }

                const items = container.querySelectorAll('.pegawai-item');
                const pegawaiData = [];

                items.forEach((item) => {
                    const select = item.querySelector('.pegawai-select');
                    const peranSelect = item.querySelector('.pegawai-peran');
                    const nipInput = item.querySelector('.pegawai-nip');
                    const pangkatInput = item.querySelector('.pegawai-pangkat');
                    const jabatanInput = item.querySelector('.pegawai-jabatan');

                    const selectedId = select && select.tomselect
                        ? select.tomselect.getValue()
                        : (select ? select.value : null);

                    if (selectedId) {
                        let dataPegawai = (typeof cacheOptions !== 'undefined' && cacheOptions)
                            ? (cacheOptions[selectedId] || cacheOptions[String(selectedId)])
                            : null;

                        if (!dataPegawai && select) {
                            const opt = select.querySelector(`option[value="${selectedId}"]`);
                            if (opt) {
                                dataPegawai = {
                                    text: opt.textContent.trim(),
                                    nip: opt.getAttribute('data-nip') || '',
                                    pangkat: opt.getAttribute('data-pangkat') || '',
                                    jabatan: opt.getAttribute('data-jabatan') || ''
                                };
                            }
                        }

                        let namaPegawai = dataPegawai ? dataPegawai.text : '';
                        if (!namaPegawai && select && select.tomselect && select.tomselect.options[selectedId]) {
                            namaPegawai = select.tomselect.options[selectedId].text;
                        }

                        if (selectedId && (namaPegawai || (nipInput && nipInput.value))) {
                            pegawaiData.push({
                                pegawai_id: selectedId,
                                nama_pegawai: namaPegawai || 'Pegawai',
                                nip: nipInput && nipInput.value ? nipInput.value : (dataPegawai ? dataPegawai.nip : ''),
                                pangkat: pangkatInput && pangkatInput.value ? pangkatInput.value : (dataPegawai ? dataPegawai.pangkat : ''),
                                jabatan: jabatanInput && jabatanInput.value ? jabatanInput.value : (dataPegawai ? dataPegawai.jabatan : ''),
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

            function getSuratDasarOptions() {
                const selectedJenis = jenisTugasSelect ? jenisTugasSelect.value : '';
                let targetSuratDasar = [];
                if (selectedJenis && suratDasarGrouped[selectedJenis]) {
                    targetSuratDasar = suratDasarGrouped[selectedJenis];
                } else if (suratDasarGrouped['']) {
                    targetSuratDasar = suratDasarGrouped[''];
                }
                return targetSuratDasar.map(item => ({ value: item.teks, text: item.teks }));
            }

            function syncSuratDasarDropdowns() {
                const selects = suratDasarContainer.querySelectorAll('select.surat-dasar-select');
                const selectedValues = Array.from(selects)
                    .map(s => s.tomselect ? s.tomselect.getValue() : null)
                    .filter(v => v);

                const allOptions = getSuratDasarOptions();

                selects.forEach((select, index) => {
                    const row = select.closest('.surat-dasar-item');
                    const numSpan = row.querySelector('.surat-dasar-number');
                    if (numSpan) numSpan.textContent = (index + 1) + '.';

                    if (select.tomselect) {
                        const ts = select.tomselect;
                        const currentValue = ts.getValue();
                        
                        ts.clearOptions();
                        
                        const availableOptions = allOptions.filter(opt => 
                            opt.value === currentValue || !selectedValues.includes(opt.value)
                        );
                        
                        ts.addOption(availableOptions);
                        
                        if (currentValue && !availableOptions.find(o => o.value === currentValue)) {
                            ts.addOption({value: currentValue, text: currentValue});
                        }

                        if (currentValue) {
                            ts.setValue(currentValue, true);
                        }
                    }
                });
            }

            function addSuratDasarRow(value = '') {
                const div = document.createElement('div');
                div.className = 'surat-dasar-item flex gap-2 items-start mb-2';
                div.innerHTML = `
                    <div class="grow flex rounded-md shadow-sm">
                        <span class="surat-dasar-number inline-flex items-center px-3 rounded-l-md border border-r-0 border-border-custom bg-background/50 text-muted text-sm font-medium"></span>
                        <div class="grow" style="min-width: 0;">
                            <select name="surat_dasar[]" class="surat-dasar-select w-full" placeholder="Pilih atau ketik acuan poin..."></select>
                        </div>
                    </div>
                    <button type="button" class="btn-remove-surat-dasar text-danger p-2 hover:bg-danger/10 rounded-md transition-colors mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                `;
                suratDasarContainer.appendChild(div);

                const select = div.querySelector('.surat-dasar-select');
                const ts = new TomSelect(select, {
                    create: true,
                    createOnBlur: true,
                    maxItems: 1,
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    placeholder: 'Pilih atau ketik acuan poin...',
                    render: {
                        item: function(data, escape) {
                            return '<div style="white-space: normal; overflow: visible; word-break: break-word; line-height: 1.5; padding: 2px 0;">' + escape(data.text) + '</div>';
                        },
                        option: function(data, escape) {
                            return '<div style="white-space: normal; word-break: break-word; padding: 6px 10px; line-height: 1.5;">' + escape(data.text) + '</div>';
                        }
                    }
                });

                ts.addOption(getSuratDasarOptions());

                if (value) {
                    ts.addOption({value: value, text: value});
                    ts.setValue(value);
                }

                const tsControl = select.parentElement.querySelector('.ts-control');
                if (tsControl) {
                    tsControl.style.borderTopLeftRadius = '0';
                    tsControl.style.borderBottomLeftRadius = '0';
                }

                ts.on('change', () => syncSuratDasarDropdowns());

                div.querySelector('.btn-remove-surat-dasar').addEventListener('click', function() {
                    ts.destroy();
                    div.remove();
                    syncSuratDasarDropdowns();
                });

                syncSuratDasarDropdowns();
            }

            // Commit any uncommitted typed text in TomSelect inputs on form submit
            const sptForm = suratDasarContainer ? suratDasarContainer.closest('form') : null;
            if (sptForm) {
                sptForm.addEventListener('submit', function() {
                    suratDasarContainer.querySelectorAll('select.surat-dasar-select').forEach(select => {
                        if (select.tomselect) {
                            const ts = select.tomselect;
                            const typedInput = ts.control_input ? ts.control_input.value.trim() : '';
                            if (!ts.getValue() && typedInput) {
                                ts.createItem(typedInput);
                                ts.setValue(typedInput);
                            }
                        }
                    });
                });
            }

            if (btnAddSuratDasar) {
                btnAddSuratDasar.addEventListener('click', () => addSuratDasarRow());
            }

            if (jenisTugasSelect) {
                jenisTugasSelect.addEventListener('change', function(e) {
                    if (isInitialLoadSurat && suratDasarContainer.querySelectorAll('.surat-dasar-item').length > 0) {
                        isInitialLoadSurat = false;
                        syncSuratDasarDropdowns();
                        return;
                    }

                    suratDasarContainer.querySelectorAll('.surat-dasar-select').forEach(s => {
                        if (s.tomselect) s.tomselect.destroy();
                    });
                    suratDasarContainer.innerHTML = '';
                    
                    addSuratDasarRow();
                    isInitialLoadSurat = false;
                });
            }

            const oldSuratDasar = @json(old('surat_dasar', $spt->surat_dasar ?? []));
            let parsedOld = [];
            if (typeof oldSuratDasar === 'string') {
                parsedOld = oldSuratDasar.split('\n').filter(s => s.trim() !== '');
            } else if (Array.isArray(oldSuratDasar)) {
                parsedOld = oldSuratDasar.filter(s => s && s.trim() !== '');
            }

            if (parsedOld.length > 0) {
                parsedOld.forEach(val => addSuratDasarRow(val));
                isInitialLoadSurat = false;
            } else if (jenisTugasSelect && jenisTugasSelect.value) {
                jenisTugasSelect.dispatchEvent(new Event('change'));
            // Dynamic Repeater untuk Tempat Tujuan
            const tempatTujuanContainer = document.getElementById('tempat-tujuan-list');
            const btnAddTempatTujuan = document.getElementById('btn-add-tempat-tujuan');

            function addTempatTujuanRow(val = '') {
                if (!tempatTujuanContainer) return;
                const div = document.createElement('div');
                div.className = 'tempat-tujuan-item flex gap-2 items-center';
                div.innerHTML = `
                    <div class="grow relative">
                        <input type="text" name="tempat_tujuan[]" value="${escapeHtml(val)}" required
                            placeholder="Contoh: Jakarta"
                            class="w-full px-3 py-2 text-sm border border-border-custom rounded-md bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" />
                    </div>
                    <button type="button" class="btn-remove-tempat-tujuan text-danger p-2 hover:bg-danger/10 rounded-md transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                `;
                tempatTujuanContainer.appendChild(div);
                bindTempatTujuanRow(div);
                updateTempatTujuanButtons();
            }

            function bindTempatTujuanRow(row) {
                const btn = row.querySelector('.btn-remove-tempat-tujuan');
                if (btn) {
                    btn.addEventListener('click', function() {
                        if (tempatTujuanContainer.querySelectorAll('.tempat-tujuan-item').length > 1) {
                            row.remove();
                            updateTempatTujuanButtons();
                        }
                    });
                }
            }

            function updateTempatTujuanButtons() {
                if (!tempatTujuanContainer) return;
                const items = tempatTujuanContainer.querySelectorAll('.tempat-tujuan-item');
                items.forEach(item => {
                    const btn = item.querySelector('.btn-remove-tempat-tujuan');
                    if (btn) {
                        btn.style.display = items.length > 1 ? 'block' : 'none';
                    }
                });
            }

            if (tempatTujuanContainer) {
                tempatTujuanContainer.querySelectorAll('.tempat-tujuan-item').forEach(bindTempatTujuanRow);
                updateTempatTujuanButtons();
            }

            if (btnAddTempatTujuan) {
                btnAddTempatTujuan.addEventListener('click', function(e) {
                    e.preventDefault();
                    addTempatTujuanRow();
                });
            }

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
