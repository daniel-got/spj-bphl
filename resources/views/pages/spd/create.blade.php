<x-layout.app title="Tambah SPD - SPJ BPHL 4">

    <x-layout.navbar />

    <!-- jQuery & Select2 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Custom Select2 Styling to match premium theme */
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            background-color: var(--color-surface, #ffffff);
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            height: 42px;
            display: flex;
            align-items: center;
            position: relative;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1f2937;
            font-size: 0.875rem;
            padding-left: 0.75rem;
            padding-right: 2rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 8px;
        }
        .select2-dropdown {
            background-color: #ffffff;
            border-color: #e5e7eb;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 1050;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            background-color: #f9fafb;
            color: #1f2937;
            font-size: 0.875rem;
            padding: 6px 10px;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6;
            color: white;
        }
        .select2-container--default .select2-results__option {
            font-size: 0.875rem;
            padding: 8px 12px;
            color: #1f2937;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 32px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.125rem;
            color: #9ca3af;
            cursor: pointer;
            font-weight: normal;
            margin-right: 0;
            line-height: 1;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear:hover {
            color: #ef4444;
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
                <a href="{{ route('user.spd.index') }}" class="text-muted hover:text-text-main transition font-medium">
                    ← Kembali
                </a>
                <h1 class="text-2xl font-extrabold tracking-tight text-text-main">
                    Tambah SPD Baru
                </h1>
            </div>

            <form action="{{ route('user.spd.store') }}" method="POST">
                @csrf

                <div class="bg-surface border border-border-custom rounded-xl shadow-sm p-6 space-y-6">

                    {{-- Pencarian SPT (Select2 Autocomplete) --}}
                    <div class="pb-6 flex flex-col gap-1 border-b border-border-custom">
                        <label for="spt_id" class="text-sm font-semibold text-text-main">
                            Masukkan No SPT
                        </label>
                        <select name="spt_id" id="spt_id" class="w-full">
                            <option value="">Contoh: 094/01/SPT/2026</option>
                        </select>
                        @if ($errors->has('spt_id'))
                            <p class="text-xs text-danger mt-1">{{ $errors->first('spt_id') }}</p>
                        @endif
                    </div>

                    {{-- Nomor & Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nomor_spd" label="Nomor SPD" placeholder="Contoh: 094/01/SPD/2026"
                            :value="old('nomor_spd')" :required="true" :error="$errors->first('nomor_spd')" />
                        <x-form.date-picker name="tgl_spd" label="Tanggal SPD" :value="old('tgl_spd')" :required="true"
                            :error="$errors->first('tgl_spd')" />
                    </div>

                    {{-- Pegawai yang Ditugaskan --}}
                    <div class="border-t border-border-custom pt-6">
                        <h3 class="text-sm font-bold text-text-main mb-4">Pegawai yang Ditugaskan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            @php
                                $pegawaiOptions = [];
                                foreach ($pegawais as $pegawai) {
                                    $pegawaiOptions[$pegawai->nama_pegawai] = $pegawai->nama_pegawai;
                                }
                            @endphp
                            <x-form.select name="pegawai_ditugaskan" label="Nama Pegawai" :options="$pegawaiOptions"
                                :selected="old('pegawai_ditugaskan')" :required="true" :error="$errors->first('pegawai_ditugaskan')" placeholder="Pilih Pegawai" />
                            <x-form.input name="nip_pegawai" label="NIP" placeholder="NIP" :value="old('nip_pegawai')"
                                :required="true" :error="$errors->first('nip_pegawai')" />
                            <x-form.input name="pangkat_pegawai" label="Pangkat/Golongan" placeholder="Pangkat/Golongan"
                                :value="old('pangkat_pegawai')" :error="$errors->first('pangkat_pegawai')" />
                            <x-form.input name="jabatan_pegawai" label="Jabatan" placeholder="Jabatan"
                                :value="old('jabatan_pegawai')" :error="$errors->first('jabatan_pegawai')" />
                        </div>
                    </div>

                    {{-- Tujuan & Tempat --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-border-custom pt-6">
                        <x-form.textarea name="tujuan_kegiatan" label="Tujuan Kegiatan"
                            placeholder="Tuliskan tujuan kegiatan perjalanan dinas..." :rows="3"
                            :value="old('tujuan_kegiatan')" :required="true" :error="$errors->first('tujuan_kegiatan')" />

                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-text-main mb-2">
                                Tempat Tujuan <span class="text-danger">*</span>
                            </label>

                            @php
                                $destinations = old('tempat_tujuan');
                                if (!$destinations || !is_array($destinations)) {
                                    $destinations = [''];
                                }
                            @endphp

                            <div id="destinations-list" class="space-y-3">
                                @foreach ($destinations as $index => $destination)
                                    <div class="flex items-center gap-2 destination-item">
                                        <div class="grow">
                                            <input type="text" name="tempat_tujuan[]" placeholder="Contoh: Jakarta"
                                                value="{{ $destination }}" required
                                                class="w-full px-3 py-2 text-sm border rounded-md shadow-sm placeholder-muted bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary disabled:bg-background disabled:text-muted disabled:cursor-not-allowed border-border-custom" />
                                        </div>
                                        @if (count($destinations) > 1 || $index > 0)
                                            <button type="button"
                                                class="remove-destination-btn text-danger hover:text-red-700 transition duration-150 p-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-2">
                                <button type="button" id="add-destination-btn"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:text-primary-hover transition duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Tempat Tujuan
                                </button>
                            </div>
                            @if ($errors->has('tempat_tujuan'))
                                <p class="text-xs text-danger mt-1">{{ $errors->first('tempat_tujuan') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Tanggal & Lama --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.date-picker name="tgl_berangkat" label="Tanggal Berangkat" :value="old('tgl_berangkat')"
                            :required="true" :error="$errors->first('tgl_berangkat')" />
                        <x-form.date-picker name="tgl_kembali" label="Tanggal Kembali" :value="old('tgl_kembali')"
                            :required="true" :error="$errors->first('tgl_kembali')" />
                        <x-form.input name="lama_kegiatan" label="Durasi Penugasan (hari)" type="number"
                            placeholder="Jumlah hari" :value="old('lama_kegiatan')" :required="true" :error="$errors->first('lama_kegiatan')" />
                    </div>

                    {{-- Kode, Jenis, Berangkat, Alat Angkut --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-t border-border-custom pt-6">
                        <x-form.input name="kode_mak" label="Kode MAK" placeholder="Kode MAK" :value="old('kode_mak')"
                            :error="$errors->first('kode_mak')" />
                        <x-form.select name="jenis_perjalanan" label="Jenis Perjalanan Dinas" :options="[
                            'Dalam Kota' => 'Dalam Kota',
                            'Luar Kota' => 'Luar Kota',
                        ]"
                            :selected="old('jenis_perjalanan')" :error="$errors->first('jenis_perjalanan')" placeholder="Pilih Jenis" />
                        <x-form.input name="berangkat_dari" label="Berangkat Dari" placeholder="Asal keberangkatan"
                            :value="old('berangkat_dari')" :error="$errors->first('berangkat_dari')" />
                        <x-form.select name="alat_angkut" label="Alat Angkut" :options="[
                            'Kendaraan Dinas' => 'Kendaraan Dinas',
                            'Kendaraan Pribadi' => 'Kendaraan Pribadi',
                            'Kendaraan Sewa' => 'Kendaraan Sewa',
                            'Kendaraan Umum' => 'Kendaraan Umum',
                            'Pesawat Terbang' => 'Pesawat Terbang',
                        ]" :selected="old('alat_angkut')"
                            :error="$errors->first('alat_angkut')" placeholder="Pilih Alat Angkut" />
                    </div>

                    {{-- PPK --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.select name="ppk" label="Pejabat Pembuat" :options="[
                            'Pejabat Pembuat Komitmen 1' => 'Pejabat Pembuat Komitmen 1',
                            'Pejabat Pembuat Komitmen 2' => 'Pejabat Pembuat Komitmen 2',
                            'Pejabat Pembuat Komitmen 3' => 'Pejabat Pembuat Komitmen 3',
                            'Bendahara Pengeluaran' => 'Bendahara Pengeluaran',
                        ]" :selected="old('ppk')"
                            :error="$errors->first('ppk')" placeholder="Pilih Pejabat Pembuat" />
                        <x-form.input name="nama_ppk" label="Nama Pejabat PPK" placeholder="Nama Pejabat"
                            :value="old('nama_ppk')" :error="$errors->first('nama_ppk')" />
                        <x-form.input name="nip_ppk" label="NIP Pejabat PPK" placeholder="NIP Pejabat"
                            :value="old('nip_ppk')" :error="$errors->first('nip_ppk')" />
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('user.spd.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-md border border-border-custom text-sm font-medium text-text-main hover:bg-background transition duration-150 ease-in-out">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold py-2.5 px-5 rounded-md transition duration-150 ease-in-out border border-transparent">
                        Simpan
                    </button>
                </div>

            </form>

        </div>

    </main>

    <x-layout.footer />

    <script id="pegawai-data" type="application/json">
        @json($pegawais)
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('destinations-list');
            const addBtn = document.getElementById('add-destination-btn');

            // --- Auto Fill Pegawai Data ---
            const selectPegawai = document.getElementById('pegawai_ditugaskan');
            const nipInput = document.getElementById('nip_pegawai');
            const pangkatInput = document.getElementById('pangkat_pegawai');
            const jabatanInput = document.getElementById('jabatan_pegawai');
            const pegawaiData = JSON.parse(document.getElementById('pegawai-data').textContent);

            selectPegawai.addEventListener('change', function() {
                const selectedName = this.value;
                const employee = pegawaiData.find(p => p.nama_pegawai === selectedName);
                if (employee) {
                    nipInput.value = employee.nip || '';
                    pangkatInput.value = employee.pangkat || '';
                    jabatanInput.value = employee.jabatan || '';
                } else {
                    nipInput.value = '';
                    pangkatInput.value = '';
                    jabatanInput.value = '';
                }
            });

            // --- Select2 for Referensi SPT ---
            $('#spt_id').select2({
                placeholder: 'Contoh: 094/01/SPT/2026',
                allowClear: true,
                ajax: {
                    url: '{{ route("user.spt.search") }}',
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

            $('#spt_id').on('select2:select', function (e) {
                const sptId = e.params.data.id;
                if (sptId) {
                    let url = '{{ route("user.spt.ajax", ["id" => ":id"]) }}';
                    url = url.replace(':id', sptId);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            if (data.tujuan_kegiatan) {
                                document.getElementById('tujuan_kegiatan').value = data.tujuan_kegiatan;
                            }
                            if (data.kode_mak) {
                                document.getElementById('kode_mak').value = data.kode_mak;
                            }
                            if (data.tgl_berangkat) {
                                document.getElementById('tgl_berangkat').value = data.tgl_berangkat;
                            }
                            if (data.tgl_kembali) {
                                document.getElementById('tgl_kembali').value = data.tgl_kembali;
                            }
                            if (data.lama_kegiatan) {
                                document.getElementById('lama_kegiatan').value = data.lama_kegiatan;
                            }
                            
                            if (data.tempat_tujuan) {
                                const destinationsList = document.getElementById('destinations-list');
                                destinationsList.innerHTML = '';
                                
                                const places = data.tempat_tujuan.split(',').map(p => p.trim()).filter(p => p !== '');
                                if (places.length > 0) {
                                    places.forEach(place => {
                                        const newItem = document.createElement('div');
                                        newItem.className = 'flex items-center gap-2 destination-item';
                                        newItem.innerHTML = `
                                            <div class="grow">
                                                <input
                                                    type="text"
                                                    name="tempat_tujuan[]"
                                                    placeholder="Contoh: Jakarta"
                                                    value="${place}"
                                                    required
                                                    class="w-full px-3 py-2 text-sm border rounded-md shadow-sm placeholder-muted bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary disabled:bg-background disabled:text-muted disabled:cursor-not-allowed border-border-custom"
                                                />
                                            </div>
                                        `;
                                        destinationsList.appendChild(newItem);
                                    });
                                } else {
                                    const newItem = document.createElement('div');
                                    newItem.className = 'flex items-center gap-2 destination-item';
                                    newItem.innerHTML = `
                                        <div class="grow">
                                            <input
                                                type="text"
                                                name="tempat_tujuan[]"
                                                placeholder="Contoh: Jakarta"
                                                required
                                                class="w-full px-3 py-2 text-sm border rounded-md shadow-sm placeholder-muted bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary disabled:bg-background disabled:text-muted disabled:cursor-not-allowed border-border-custom"
                                            />
                                        </div>
                                    `;
                                    destinationsList.appendChild(newItem);
                                }
                                updateRemoveButtons();
                            }

                            if (data.pegawai_list && data.pegawai_list.length > 0) {
                                const firstPegawai = data.pegawai_list[0];
                                const name = firstPegawai.nama_pegawai;
                                
                                const selectPeg = document.getElementById('pegawai_ditugaskan');
                                if (selectPeg) {
                                    let optionExists = false;
                                    for (let i = 0; i < selectPeg.options.length; i++) {
                                        if (selectPeg.options[i].value === name) {
                                            optionExists = true;
                                            selectPeg.selectedIndex = i;
                                            break;
                                        }
                                    }
                                    if (!optionExists) {
                                        const newOpt = document.createElement('option');
                                        newOpt.value = name;
                                        newOpt.text = name;
                                        newOpt.selected = true;
                                        selectPeg.appendChild(newOpt);
                                    }
                                    
                                    // Trigger change event to fill NIP/pangkat/jabatan
                                    const event = new Event('change');
                                    selectPeg.dispatchEvent(event);
                                }
                            }
                        }
                    });
                }
            });

            // --- Auto Calculate Lama Kegiatan (hari) ---
            const tglBerangkatInput = document.getElementById('tgl_berangkat');
            const tglKembaliInput = document.getElementById('tgl_kembali');
            const lamaKegiatanInput = document.getElementById('lama_kegiatan');

            function calculateDays() {
                const startVal = tglBerangkatInput.value;
                const endVal = tglKembaliInput.value;
                if (startVal && endVal) {
                    const startDate = new Date(startVal);
                    const endDate = new Date(endVal);
                    
                    // Reset hours to avoid timezone/DST differences
                    startDate.setHours(0, 0, 0, 0);
                    endDate.setHours(0, 0, 0, 0);

                    const timeDiff = endDate.getTime() - startDate.getTime();
                    const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                    
                    lamaKegiatanInput.value = dayDiff > 0 ? dayDiff : '';
                } else {
                    lamaKegiatanInput.value = '';
                }
            }

            tglBerangkatInput.addEventListener('change', calculateDays);
            tglKembaliInput.addEventListener('change', calculateDays);

            function updateRemoveButtons() {
                const items = container.querySelectorAll('.destination-item');
                items.forEach((item, index) => {
                    let removeBtn = item.querySelector('.remove-destination-btn');
                    if (items.length > 1) {
                        if (!removeBtn) {
                            removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.className =
                                'remove-destination-btn text-danger hover:text-red-700 transition duration-150 p-2';
                            removeBtn.innerHTML =
                                `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`;
                            removeBtn.addEventListener('click', function() {
                                item.remove();
                                updateRemoveButtons();
                            });
                            item.appendChild(removeBtn);
                        }
                    } else {
                        if (removeBtn) {
                            removeBtn.remove();
                        }
                    }
                });
            }

            addBtn.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'flex items-center gap-2 destination-item';
                newItem.innerHTML = `
                <div class="grow">
                    <input
                        type="text"
                        name="tempat_tujuan[]"
                        placeholder="Contoh: Jakarta"
                        required
                        class="w-full px-3 py-2 text-sm border rounded-md shadow-sm placeholder-muted bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary disabled:bg-background disabled:text-muted disabled:cursor-not-allowed border-border-custom"
                    />
                </div>
            `;
                container.appendChild(newItem);
                updateRemoveButtons();
            });

            container.querySelectorAll('.remove-destination-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.closest('.destination-item').remove();
                    updateRemoveButtons();
                });
            });

            updateRemoveButtons();
        });
    </script>

</x-layout.app>
