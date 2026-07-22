<x-layout.app title="Edit SPD - SPJ BPHL 4">

    <!-- jQuery & Select2 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <x-style.select2 />

    <x-layout.navbar />

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
                    Edit SPD
                </h1>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.spd.update', $spd->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- SPT induk tidak dapat diubah saat edit, nilainya dipertahankan. --}}
                <input type="hidden" name="spt_id" value="{{ $spd->spt_id }}">

                <div class="bg-surface border border-border-custom rounded-xl shadow-sm p-6 space-y-6">

                    {{-- Nomor & Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nomor_spd" label="Nomor SPD" placeholder="Contoh: 094/01/SPD/2026"
                            :value="old('nomor_spd', $spd->nomor_spd)" :required="true" :error="$errors->first('nomor_spd')" />
                        <x-form.date-picker name="tgl_spd" label="Tanggal SPD" :value="old('tgl_spd', $spd->tgl_spd)" :required="true"
                            :error="$errors->first('tgl_spd')" />
                    </div>

                    {{-- Pegawai yang Ditugaskan (identitas mengikuti akun pemilik SPD, tidak dapat diubah) --}}
                    <div class="border-t border-border-custom pt-6">
                        <h3 class="text-sm font-bold text-text-main mb-4">Pegawai yang Ditugaskan</h3>
                        <input type="hidden" name="nip_pegawai" value="{{ $spd->nip_pegawai }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <x-form.input name="nama_pegawai_display" label="Nama Pegawai" :value="$spd->pegawai_ditugaskan"
                                :disabled="true" />
                            <x-form.input name="nip_display" label="NIP" :value="$spd->nip_pegawai" :disabled="true" />
                            <x-form.input name="pangkat_display" label="Pangkat/Golongan" :value="$spd->pangkat_pegawai ?? '-'"
                                :disabled="true" />
                            <x-form.input name="jabatan_display" label="Jabatan" :value="$spd->jabatan_pegawai ?? '-'"
                                :disabled="true" />
                        </div>
                        <p class="text-[10px] text-muted mt-2">* Identitas pelaksana terisi otomatis dari akun pemilik
                            SPD dan tidak dapat diubah.</p>
                    </div>

                    {{-- Tujuan & Tempat --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-border-custom pt-6">
                        <x-form.textarea name="tujuan_kegiatan" label="Tujuan Kegiatan" hint="Terisi otomatis dari SPT."
                            :rows="3" :value="old('tujuan_kegiatan', $spd->tujuan_kegiatan)" :error="$errors->first('tujuan_kegiatan')" />

                        <x-form.input name="tempat_tujuan" label="Tempat Tujuan" :value="is_array($spd->tempat_tujuan)
                            ? implode(', ', $spd->tempat_tujuan)
                            : $spd->tempat_tujuan" :disabled="true"
                            hint="Terisi otomatis dari SPT." />
                    </div>

                    {{-- Tanggal & Lama --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.date-picker name="tgl_berangkat" label="Tanggal Berangkat" :value="old('tgl_berangkat', $spd->tgl_berangkat)"
                            :disabled="true" :error="$errors->first('tgl_berangkat')" />
                        <x-form.date-picker name="tgl_kembali" label="Tanggal Kembali" :value="old('tgl_kembali', $spd->tgl_kembali)"
                            :disabled="true" :error="$errors->first('tgl_kembali')" />
                        <x-form.input name="lama_kegiatan" label="Durasi Penugasan (hari)" type="number"
                            placeholder="Jumlah hari" :value="old('lama_kegiatan', $spd->lama_kegiatan)" :disabled="true" :error="$errors->first('lama_kegiatan')" />
                    </div>

                    {{-- Kode, Jenis, Berangkat, Alat Angkut --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-t border-border-custom pt-6">
                        <x-form.input name="kode_mak" label="Kode MAK" placeholder="Kode MAK" :value="old('kode_mak', $spd->kode_mak)"
                            :disabled="true" :error="$errors->first('kode_mak')" />
                        <x-form.select name="jenis_perjalanan" label="Jenis Perjalanan Dinas" :options="[
                            'Dalam Kota' => 'Dalam Kota',
                            'Luar Kota' => 'Luar Kota',
                        ]"
                            :selected="old('jenis_perjalanan', $spd->jenis_perjalanan)" :required="true" :error="$errors->first('jenis_perjalanan')" placeholder="Pilih Jenis" />
                        <x-form.input name="berangkat_dari" label="Berangkat Dari" placeholder="Asal keberangkatan"
                            :value="old('berangkat_dari', $spd->berangkat_dari)" :required="true" :error="$errors->first('berangkat_dari')" />
                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-text-main mb-2">
                                Alat Angkut <span class="text-danger">*</span>
                            </label>
                            @php
                                $alatAngkutOptions = [
                                    'Angkutan Umum' => 'Angkutan Umum (Angkot)',
                                    'Bus' => 'Bus',
                                    'Drop Out' => 'Drop Out',
                                    'GoCar' => 'GoCar',
                                    'GoJek' => 'GoJek',
                                    'Kapal Laut' => 'Kapal Laut',
                                    'Kereta' => 'Kereta',
                                    'KRL' => 'KRL',
                                    'Mobil Dinas' => 'Mobil Dinas',
                                    'Mobil Pribadi' => 'Mobil Pribadi',
                                    'Mobil Travel' => 'Mobil Travel',
                                    'Motor Dinas' => 'Motor Dinas',
                                    'Motor Pribadi' => 'Motor Pribadi',
                                    'Perahu Ces' => 'Perahu Ces',
                                    'Perahu Dinas' => 'Perahu Dinas',
                                    'Perahu Klotok' => 'Perahu Klotok',
                                    'Perahu Sungai' => 'Perahu Sungai/Sampan',
                                    'Pesawat' => 'Pesawat',
                                    'Pesawat Tanpa Merek' => 'Pesawat (Tanpa Merk Maskapai)',
                                    'Sewa' => 'Sewa Mobil',
                                    'Taxi' => 'Taxi',
                                    'Transportasi Online' => 'Transportasi Online',
                                    'Travel' => 'Travel',
                                ];

                                $alatangkuts = old('alat_angkut');
                                if (!$alatangkuts) {
                                    $alatangkuts = $spd->alat_angkut;
                                    if (!is_array($alatangkuts)) {
                                        $alatangkuts = json_decode($alatangkuts, true);
                                    }
                                    if (!is_array($alatangkuts)) {
                                        $alatangkuts = array_filter(array_map('trim', explode(',', $spd->alat_angkut)));
                                    }
                                }
                                if (!$alatangkuts || !is_array($alatangkuts)) {
                                    $alatangkuts = [''];
                                }
                            @endphp

                            <div id="alatangkuts-list" class="space-y-3">
                                @foreach ($alatangkuts as $index => $val)
                                    <div class="flex items-center gap-2 alatangkut-item">
                                        <div class="grow">
                                            <select name="alat_angkut[]" required
                                                class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary disabled:bg-background disabled:text-muted disabled:cursor-not-allowed border-border-custom">
                                                <option value="" disabled {{ !$val ? 'selected' : '' }}>Pilih Alat
                                                    Angkut</option>
                                                @foreach ($alatAngkutOptions as $optValue => $optLabel)
                                                    <option value="{{ $optValue }}"
                                                        {{ $val == $optValue ? 'selected' : '' }}>
                                                        {{ $optLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($index > 0)
                                            <x-action.icon-button color="danger" class="remove-alatangkut-btn p-1">
                                                <x-utility.icon name="trash" class="w-4 h-4" />
                                            </x-action.icon-button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if ($errors->has('alat_angkut'))
                                <p class="text-xs text-danger mt-1">{{ $errors->first('alat_angkut') }}</p>
                            @endif

                            <div class="mt-2">
                                <x-action.button id="add-alatangkut-btn"
                                    class="border-primary text-primary text-sm hover:bg-primary hover:text-white px-3 py-1.5 gap-1.5 mt-2">
                                    <x-utility.icon name="plus" class="w-4 h-4" />
                                    Tambah Alat Angkut
                                </x-action.button>
                            </div>
                        </div>
                    </div>

                    {{-- PPK --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.select name="ppk" label="Pejabat Pembuat" :options="[
                            'Pejabat Pembuat Komitmen 1' => 'Pejabat Pembuat Komitmen 1',
                            'Pejabat Pembuat Komitmen 2' => 'Pejabat Pembuat Komitmen 2',
                            'Pejabat Pembuat Komitmen 3' => 'Pejabat Pembuat Komitmen 3',
                            'Bendahara Pengeluaran' => 'Bendahara Pengeluaran',
                        ]" :selected="old('ppk', $spd->ppk)"
                            :required="true" :error="$errors->first('ppk')" placeholder="Pilih Pejabat Pembuat" />
                        <x-form.input name="nama_ppk" label="Nama Pejabat PPK" placeholder="Nama Pejabat"
                            :value="old('nama_ppk', $spd->nama_ppk)" :required="true" :error="$errors->first('nama_ppk')" />
                        <x-form.input name="nip_ppk" label="NIP Pejabat PPK" placeholder="NIP Pejabat" id="nip_ppk"
                            :value="old('nip_ppk', $spd->nip_ppk)" :required="true" :error="$errors->first('nip_ppk')" />
                    </div>

                    {{-- Destinasi & Pejabat Instansi (Dinamis Multi-Tujuan) --}}
                    @php
                        $defaultDestinasi = [
                            [
                                'tiba_di' => '',
                                'tgl_tiba' => '',
                                'berangkat_dari' => '',
                                'tujuan_selanjutnya' => '',
                                'tgl_berangkat' => '',
                                'pejabat_jabatan' => '',
                                'pejabat_nama' => '',
                                'pejabat_nip' => '',
                            ],
                        ];
                        $destinasiData = old('destinasi', $spd->destinasi ?? $defaultDestinasi);
                    @endphp
                    <div class="border-t border-border-custom pt-6"
                        x-data='{
                        destinasi: @json($destinasiData),
                        addDestinasi() {
                            if (this.destinasi.length >= 6) return;
                            this.destinasi.push({tiba_di: "", tgl_tiba: "", berangkat_dari: "", tujuan_selanjutnya: "", tgl_berangkat: "", pejabat_jabatan: "", pejabat_nama: "", pejabat_nip: ""});
                        },
                        removeDestinasi(index) {
                            if (this.destinasi.length <= 1) return;
                            this.destinasi.splice(index, 1);
                        }
                    }'>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-text-main">Destinasi & Pejabat Instansi Tujuan</h3>
                            <x-action.button type="button" x-show="destinasi.length < 6" @click="addDestinasi()"
                                class="border-primary text-primary text-sm hover:bg-primary hover:text-white px-3 py-1.5 gap-1.5">
                                <x-utility.icon name="plus" class="w-4 h-4" />
                                Tambah Tujuan
                            </x-action.button>
                        </div>

                        <template x-for="(dest, index) in destinasi" :key="index">
                            <div class="relative border border-border-custom rounded-lg p-4 mb-4 bg-surface-light">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-bold text-text-muted uppercase"
                                        x-text="'Tujuan ' + (index + 1) + ' (Baris ' + ['II','III','IV','V','VI','VII'][index] + ')'"></span>
                                    <button type="button" x-show="destinasi.length > 1"
                                        @click="removeDestinasi(index)"
                                        class="text-danger hover:text-red-700 text-xs font-semibold">✕ Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="text-sm font-semibold text-text-main mb-1 block">Jabatan Pejabat
                                            Tujuan</label>
                                        <input type="text" :name="'destinasi[' + index + '][pejabat_jabatan]'"
                                            x-model="dest.pejabat_jabatan" placeholder="Contoh: Kepala Desa"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                    <div>
                                        <label class="text-sm font-semibold text-text-main mb-1 block">Nama Pejabat
                                            Tujuan</label>
                                        <input type="text" :name="'destinasi[' + index + '][pejabat_nama]'"
                                            x-model="dest.pejabat_nama" placeholder="Contoh: Budi Santoso"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                    <div>
                                        <label class="text-sm font-semibold text-text-main mb-1 block">NIP Pejabat
                                            Tujuan</label>
                                        <input type="text" :name="'destinasi[' + index + '][pejabat_nip]'"
                                            x-model="dest.pejabat_nip" placeholder="Opsional"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                </div>
                                {{-- Fields for destinasi location data (auto-filled but editable) --}}
                                <div
                                    class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4 border-t border-border-custom/50">
                                    <div>
                                        <label class="text-xs font-semibold text-text-main mb-1 block">Tiba Di</label>
                                        <input type="text" :name="'destinasi[' + index + '][tiba_di]'"
                                            x-model="dest.tiba_di"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-text-main mb-1 block">Tgl Tiba</label>
                                        <input type="date" :name="'destinasi[' + index + '][tgl_tiba]'"
                                            x-model="dest.tgl_tiba"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                    <div>
                                        <label class="text-xs font-semibold text-text-main mb-1 block">Berangkat
                                            Dari</label>
                                        <input type="text" :name="'destinasi[' + index + '][berangkat_dari]'"
                                            x-model="dest.berangkat_dari"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-text-main mb-1 block">Tujuan
                                            Selanjutnya</label>
                                        <input type="text" :name="'destinasi[' + index + '][tujuan_selanjutnya]'"
                                            x-model="dest.tujuan_selanjutnya"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-text-main mb-1 block">Tgl
                                            Berangkat</label>
                                        <input type="date" :name="'destinasi[' + index + '][tgl_berangkat]'"
                                            x-model="dest.tgl_berangkat"
                                            class="w-full rounded-md border border-border-custom bg-surface-light px-3 py-2 text-sm text-text-main focus:ring-2 focus:ring-primary focus:border-primary" />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Kepala Seksi --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-t border-border-custom pt-6">
                        <div class="md:col-span-1">
                            <label for="kepala_seksi_select" class="text-sm font-semibold text-text-main mb-2 block">
                                Pilih Kepala Seksi
                            </label>
                            <select id="kepala_seksi_select" class="w-full">
                                <option value="">Pilih Pegawai...</option>
                                @foreach ($pegawaiData as $pegawai)
                                    <option value="{{ $pegawai->id }}" data-nama="{{ $pegawai->nama_pegawai }}"
                                        data-nip="{{ $pegawai->nip }}" data-jabatan="{{ $pegawai->jabatan }}"
                                        {{ old('kepala_seksi_nip', $spd->kepala_seksi_nip) == $pegawai->nip ? 'selected' : '' }}>
                                        {{ $pegawai->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <x-form.input name="kepala_seksi_jabatan" id="kepala_seksi_jabatan"
                                label="Jabatan Kepala Seksi" placeholder="Jabatan" :value="old('kepala_seksi_jabatan', $spd->kepala_seksi_jabatan)"
                                :error="$errors->first('kepala_seksi_jabatan')" readonly class="bg-background text-muted cursor-not-allowed" />
                        </div>
                        <div class="md:col-span-1">
                            <x-form.input name="kepala_seksi_nama" id="kepala_seksi_nama" label="Nama Kepala Seksi"
                                placeholder="Nama" :value="old('kepala_seksi_nama', $spd->kepala_seksi_nama)" :error="$errors->first('kepala_seksi_nama')" readonly
                                class="bg-background text-muted cursor-not-allowed" />
                        </div>
                        <div class="md:col-span-1">
                            <x-form.input name="kepala_seksi_nip" id="kepala_seksi_nip" label="NIP Kepala Seksi"
                                placeholder="NIP" :value="old('kepala_seksi_nip', $spd->kepala_seksi_nip)" :error="$errors->first('kepala_seksi_nip')" readonly
                                class="bg-background text-muted cursor-not-allowed" />
                        </div>
                    </div>

                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('user.spd.index') }}"
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
        document.addEventListener('DOMContentLoaded', function() {
            // --- Destinations Dynamic List ---
            const destContainer = document.getElementById('destinations-list');
            const destAddBtn = document.getElementById('add-destination-btn');

            function updateDestRemoveButtons() {
                const items = destContainer.querySelectorAll('.destination-item');
                items.forEach((item, index) => {
                    let removeBtn = item.querySelector('.remove-destination-btn');
                    if (items.length > 1) {
                        if (!removeBtn) {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = `
                                <x-action.icon-button color="danger" class="remove-destination-btn p-2">
                                    <x-utility.icon name="trash" class="w-5 h-5" />
                                </x-action.icon-button>
                            `.trim();
                            removeBtn = tempDiv.firstChild;
                            removeBtn.addEventListener('click', function() {
                                item.remove();
                                updateDestRemoveButtons();
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

            destAddBtn.addEventListener('click', function() {
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
                destContainer.appendChild(newItem);
                updateDestRemoveButtons();
            });

            destContainer.querySelectorAll('.remove-destination-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.closest('.destination-item').remove();
                    updateDestRemoveButtons();
                });
            });

            updateDestRemoveButtons();

            // --- Kepala Seksi Autofill ---
            $('#kepala_seksi_select').select2({
                placeholder: 'Pilih Pegawai...',
                allowClear: true
            });

            $('#kepala_seksi_select').on('select2:select', function(e) {
                const data = e.params.data.element.dataset;
                document.getElementById('kepala_seksi_jabatan').value = data.jabatan || '';
                document.getElementById('kepala_seksi_nama').value = data.nama || '';
                document.getElementById('kepala_seksi_nip').value = data.nip || '';
            });

            $('#kepala_seksi_select').on('select2:clear', function() {
                document.getElementById('kepala_seksi_jabatan').value = '';
                document.getElementById('kepala_seksi_nama').value = '';
                document.getElementById('kepala_seksi_nip').value = '';
            });

            // Initialize Select2 for existing alat_angkut fields with tags: true to allow manual typing
            $('select[name="alat_angkut[]"]').select2({
                placeholder: 'Pilih Alat Angkut',
                tags: true
            });

            // --- Transportation Dynamic List ---
            const transportContainer = document.getElementById('alatangkuts-list');
            const transportAddBtn = document.getElementById('add-alatangkut-btn');

            function updateTransportRemoveButtons() {
                const items = transportContainer.querySelectorAll('.alatangkut-item');
                items.forEach((item, index) => {
                    let removeBtn = item.querySelector('.remove-alatangkut-btn');
                    if (index > 0) {
                        if (!removeBtn) {
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = `
                                <x-action.icon-button color="danger" class="remove-alatangkut-btn p-1">
                                    <x-utility.icon name="trash" class="w-4 h-4" />
                                </x-action.icon-button>
                            `.trim();
                            removeBtn = tempDiv.firstChild;
                            removeBtn.addEventListener('click', function() {
                                item.remove();
                                updateTransportRemoveButtons();
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

            transportAddBtn.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'flex items-center gap-2 alatangkut-item';

                let optionsHtml = '<option value="" disabled selected>Pilih Alat Angkut</option>';
                const options = {
                    'Angkutan Umum': 'Angkutan Umum (Angkot)',
                    'Bus': 'Bus',
                    'Drop Out': 'Drop Out',
                    'GoCar': 'GoCar',
                    'GoJek': 'GoJek',
                    'Kapal Laut': 'Kapal Laut',
                    'Kereta': 'Kereta',
                    'KRL': 'KRL',
                    'Mobil Dinas': 'Mobil Dinas',
                    'Mobil Pribadi': 'Mobil Pribadi',
                    'Mobil Travel': 'Mobil Travel',
                    'Motor Dinas': 'Motor Dinas',
                    'Motor Pribadi': 'Motor Pribadi',
                    'Perahu Ces': 'Perahu Ces',
                    'Perahu Dinas': 'Perahu Dinas',
                    'Perahu Klotok': 'Perahu Klotok',
                    'Perahu Sungai': 'Perahu Sungai/Sampan',
                    'Pesawat': 'Pesawat',
                    'Pesawat Tanpa Merek': 'Pesawat (Tanpa Merk Maskapai)',
                    'Sewa': 'Sewa Mobil',
                    'Taxi': 'Taxi',
                    'Transportasi Online': 'Transportasi Online',
                    'Travel': 'Travel'
                };

                for (const [val, label] of Object.entries(options)) {
                    optionsHtml += `<option value="${val}">${label}</option>`;
                }

                newItem.innerHTML = `
                    <div class="grow">
                        <select name="alat_angkut[]" required
                            class="w-full px-3 py-2 text-sm border rounded-md shadow-sm bg-surface text-text-main focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary disabled:bg-background disabled:text-muted disabled:cursor-not-allowed border-border-custom">
                            ${optionsHtml}
                        </select>
                    </div>
                `;
                transportContainer.appendChild(newItem);

                // Initialize Select2 on the dynamically created select element with tags: true
                $(newItem).find('select').select2({
                    placeholder: 'Pilih Alat Angkut',
                    tags: true
                });

                updateTransportRemoveButtons();
            });

            transportContainer.querySelectorAll('.remove-alatangkut-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.closest('.alatangkut-item').remove();
                    updateTransportRemoveButtons();
                });
            });

            updateTransportRemoveButtons();

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

            // --- PPK Autofill ---
            const ppkData = @json($ppkData);
            const ppkSelect = document.getElementById('ppk');
            const namaPpkInput = document.getElementById('nama_ppk');
            const nipPpkInput = document.getElementById('nip_ppk');

            if (ppkSelect) {
                ppkSelect.addEventListener('change', function() {
                    const selectedRole = this.value;
                    if (ppkData[selectedRole]) {
                        namaPpkInput.value = ppkData[selectedRole].nama;
                        nipPpkInput.value = ppkData[selectedRole].nip;
                    } else {
                        namaPpkInput.value = '';
                        nipPpkInput.value = '';
                    }
                });
            }
        });
    </script>

</x-layout.app>
