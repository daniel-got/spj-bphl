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

                    {{-- Kategori & Surat Dasar --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <div class="flex flex-col">
                            <label for="jenis_tugas" class="text-sm font-medium text-text-main mb-2 block">
                                Jenis Kategori SPT <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_tugas" id="jenis_tugas" required 
                                class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background border-border-custom focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="">-- Pilih Kategori Tugas --</option>
                                <option value="pelatihan" {{ old('jenis_tugas', $spt->jenis_tugas) == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                <option value="keuangan" {{ old('jenis_tugas', $spt->jenis_tugas) == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                                <option value="administrasi" {{ old('jenis_tugas', $spt->jenis_tugas) == 'administrasi' ? 'selected' : '' }}>Administrasi</option>
                            </select>
                            @if ($errors->has('jenis_tugas'))
                                <p class="text-xs text-danger mt-1">{{ $errors->first('jenis_tugas') }}</p>
                            @endif
                        </div>

                        <div class="md:col-span-2 flex flex-col">
                            <label for="surat_dasar" class="text-sm font-medium text-text-main mb-2 block">
                                Surat Dasar / Acuan Poin 3 <span class="text-muted text-xs">(Opsional)</span>
                            </label>
                            <textarea name="surat_dasar" id="surat_dasar" rows="2" 
                                placeholder="Contoh: Nota Dinas Kepala Pusat Diklat SDM Lingkungan Hidup dan Kehutanan Nomor: ND.385/XI-3/2026 tanggal 10 Juli 2026"
                                class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-background border-border-custom focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">{{ old('surat_dasar', $spt->surat_dasar) }}</textarea>
                            
                            {{-- PERBAIKAN NEW: KOTAK RIWAYAT KLIK CEPAT --}}
                            @if(isset($riwayatSuratDasar) && $riwayatSuratDasar->count() > 0)
                                <div class="mt-2 text-muted" style="font-size: 11px;">
                                    <span class="d-block mb-1"><strong>Klik Cepat Riwayat:</strong></span>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @foreach($riwayatSuratDasar as $riwayat)
                                            <button type="button" class="btn-riwayat border border-border-custom bg-background/80 hover:bg-background rounded px-2 py-0.5 text-left text-text-main transition duration-150 max-w-full truncate" title="{{ $riwayat }}">
                                                {{ $riwayat }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <small class="text-xs text-muted mt-1">Kosongkan jika surat jenis Administrasi atau tidak memerlukan dasar surat tambahan.</small>
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
                                                    <option value="Anggota" @selected(($pegawaiTersimpan['peran'] ?? 'Anggota') === 'Anggota')>Anggota</option>
                                                    <option value="Penanggung Jawab" @selected(($pegawaiTersimpan['peran'] ?? '') === 'Penanggung Jawab')>Penanggung Jawab</option>
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
                            <button type="button" id="add-pegawai-btn"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:text-primary-hover transition duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Pegawai
                            </button>
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

                        @php
                            // Antisipasi jika tempat_tujuan tersimpan sebagai JSON array (multi tujuan)
                            $tempatTujuanValue = $spt->tempat_tujuan;
                            if (is_array($tempatTujuanValue)) {
                                $tempatTujuanValue = implode(', ', $tempatTujuanValue);
                            } else {
                                $decodedTujuan = json_decode($tempatTujuanValue, true);
                                $tempatTujuanValue = is_array($decodedTujuan) ? implode(', ', $decodedTujuan) : $tempatTujuanValue;
                            }
                        @endphp
                        <x-form.input name="tempat_tujuan" label="Tempat Tujuan" placeholder="Contoh: Jakarta"
                            :value="old('tempat_tujuan', $tempatTujuanValue)" :required="true" :error="$errors->first('tempat_tujuan')" />
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
                    <button type="submit"
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold py-2.5 px-5 rounded-md transition duration-150 ease-in-out border border-transparent">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('pegawai-list');
            const addBtn = document.getElementById('add-pegawai-btn');
            const form = document.getElementById('spt-form');
            const hiddenInput = document.getElementById('pegawai_ditugaskan_json');
            const tglBerangkat = document.getElementById('tgl_berangkat');
            const tglKembali = document.getElementById('tgl_kembali');
            const lamaKegiatan = document.getElementById('lama_kegiatan');
            
            // PERBAIKAN NEW: Element handler untuk Klik Cepat Riwayat Surat Dasar
            const textareaSuratDasar = document.getElementById('surat_dasar');
            const tombolRiwayat = document.querySelectorAll('.btn-riwayat');

            if (tombolRiwayat.length > 0 && textareaSuratDasar) {
                tombolRiwayat.forEach(button => {
                    button.addEventListener('click', function() {
                        textareaSuratDasar.value = this.innerText.trim();
                        textareaSuratDasar.focus();
                    });
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

            // Fungsi Inisialisasi Tom Select.
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
                            removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className = 'remove-pegawai-btn text-danger hover:text-red-700 transition duration-150 p-2';
                            removeBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`;
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
                                    <option value="Anggota">Anggota</option>
                                    <option value="Penanggung Jawab">Penanggung Jawab</option>
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

            // Inisialisasi awal
            container.querySelectorAll('.pegawai-item').forEach(initPegawaiRow);
            updateRemoveButtons();
            syncAllDropdowns();

            // Interseptor form submit
            form.addEventListener('submit', function(e) {
                const items = container.querySelectorAll('.pegawai-item');
                const pegawaiData = [];

                items.forEach((item) => {
                    const select = item.querySelector('.pegawai-select');
                    const peranSelect = item.querySelector('.pegawai-peran');
                    if (select && select.value) {
                        const dataPegawai = cacheOptions[select.value];
                        if (dataPegawai) {
                            pegawaiData.push({
                                pegawai_id: select.value,
                                nama_pegawai: dataPegawai.text,
                                nip: dataPegawai.nip,
                                pangkat: dataPegawai.pangkat,
                                jabatan: dataPegawai.jabatan,
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