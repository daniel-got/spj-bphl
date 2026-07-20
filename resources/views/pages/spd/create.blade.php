<x-layout.app title="Tambah SPD - SPJ BPHL 4">


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
                        <div>
                            <x-form.input name="nomor_spd" label="Nomor SPD" placeholder="Contoh: 094/01/SPD/2026"
                                :value="old('nomor_spd')" :required="true" :error="$errors->first('nomor_spd')" />
                            <p id="nomor-spd-hint" class="hidden text-xs text-primary mt-1 font-medium"></p>
                        </div>
                        <x-form.date-picker name="tgl_spd" label="Tanggal SPD" :value="old('tgl_spd')" :required="true"
                            :error="$errors->first('tgl_spd')" />
                    </div>

                    {{-- Pegawai yang Ditugaskan --}}
                    <div class="border-t border-border-custom pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-text-main">Pegawai yang Ditugaskan</h3>
                            <div id="spt-info-badge" class="hidden">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Data dari SPT
                                </span>
                            </div>
                        </div>

                        <div id="assigned-pegawai-list" class="hidden mb-6 bg-background/50 border border-border-custom rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-border-custom">
                                <thead class="bg-surface">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-muted uppercase">Nama</th>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-muted uppercase">NIP</th>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-muted uppercase">Peran</th>
                                    </tr>
                                </thead>
                                <tbody id="assigned-pegawai-body" class="divide-y divide-border-custom">
                                    <!-- Diisi via JS -->
                                </tbody>
                            </table>
                        </div>

                        @if ($myPegawai)
                            {{-- SPD dibuat per akun: identitas pegawai otomatis dari akun yang login --}}
                            <input type="hidden" name="nip_pegawai" value="{{ $myPegawai->nip }}">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <x-form.input name="nama_pegawai_display" label="Nama Pegawai"
                                    :value="$myPegawai->nama_pegawai" :disabled="true" />
                                <x-form.input name="nip_display" label="NIP"
                                    :value="$myPegawai->nip" :disabled="true" />
                                <x-form.input name="pangkat_display" label="Pangkat/Golongan"
                                    :value="trim(($myPegawai->pangkat ?? '').' / '.($myPegawai->golongan ?? ''), ' /')" :disabled="true" />
                                <x-form.input name="jabatan_display" label="Jabatan"
                                    :value="$myPegawai->jabatan" :disabled="true" />
                            </div>
                            <p class="text-[10px] text-muted mt-2">* SPD dibuat untuk akun Anda sendiri. Identitas terisi otomatis dan tidak dapat diubah.</p>
                        @else
                            <div class="rounded-lg border border-danger/40 bg-danger/5 px-4 py-3">
                                <p class="text-sm font-medium text-danger">Akun Anda belum tertaut dengan data pegawai.</p>
                                <p class="text-xs text-muted mt-1">SPD tidak dapat dibuat sampai akun Anda dihubungkan dengan data pegawai. Silakan hubungi admin.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Tujuan & Tempat (otomatis dari SPT yang dipilih, tidak dapat diubah) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-border-custom pt-6">
                        <x-form.textarea name="tujuan_kegiatan" label="Tujuan Kegiatan" :rows="3"
                            hint="Isi tujuan kegiatan."  :required="true" :error="$errors->first('tujuan_kegitan')"/>

                        <x-form.input name="tempat_tujuan" label="Tempat Tujuan" :value="old('tempat_tujuan')"
                            :disabled="true" hint="Terisi otomatis dari SPT yang dipilih."  />
                    </div>

                    {{-- Tanggal & Lama --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.date-picker name="tgl_berangkat" label="Tanggal Berangkat" :value="old('tgl_berangkat')"
                            :required="true" :error="$errors->first('tgl_berangkat')" />
                        <x-form.date-picker name="tgl_kembali" label="Tanggal Kembali" :value="old('tgl_kembali')"
                            :required="true" :error="$errors->first('tgl_kembali')" />
                        <x-form.input name="lama_kegiatan" label="Durasi Penugasan (hari)" type="number"
                            placeholder="Jumlah hari" :value="old('lama_kegiatan')" :required="true" :error="$errors->first('lama_kegiatan')" />
                    </div> {{-- Kode, Jenis, Berangkat, Alat Angkut --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-t border-border-custom pt-6">
                        <x-form.input name="kode_mak" label="Kode MAK" placeholder="Kode MAK" :value="old('kode_mak')"
                            :required="true" :error="$errors->first('kode_mak')" />
                        <x-form.select name="jenis_perjalanan" label="Jenis Perjalanan Dinas" :options="[
                            'Dalam Kota' => 'Dalam Kota',
                            'Luar Kota' => 'Luar Kota',
                        ]"
                            :selected="old('jenis_perjalanan')" :required="true" :error="$errors->first('jenis_perjalanan')" placeholder="Pilih Jenis" />
                        <x-form.input name="berangkat_dari" label="Berangkat Dari" placeholder="Asal keberangkatan"
                            :value="old('berangkat_dari')" :required="true" :error="$errors->first('berangkat_dari')" />
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
                        ]" :selected="old('ppk')"
                            :required="true" :error="$errors->first('ppk')" placeholder="Pilih Pejabat Pembuat" />
                        <x-form.input name="nama_ppk" label="Nama Pejabat PPK" placeholder="Nama Pejabat"
                            :value="old('nama_ppk')" :required="true" :error="$errors->first('nama_ppk')" />
                        <x-form.input name="nip_ppk" label="NIP Pejabat PPK" placeholder="NIP Pejabat" id="nip_ppk"
                            :value="old('nip_ppk')" :required="true" :error="$errors->first('nip_ppk')" />
                    </div>

                    {{-- Pejabat Instansi/Perusahaan (Tujuan) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-border-custom pt-6">
                        <x-form.input name="pejabat_instansi_perusahaan" label="Jabatan Pejabat Tujuan" placeholder="Contoh: Kepala Desa"
                            :value="old('pejabat_instansi_perusahaan')" :error="$errors->first('pejabat_instansi_perusahaan')" />
                        <x-form.input name="pejabat_instansi_perusahaan_nama" label="Nama Pejabat Tujuan" placeholder="Contoh: Budi Santoso"
                            :value="old('pejabat_instansi_perusahaan_nama')" :error="$errors->first('pejabat_instansi_perusahaan_nama')" />
                        <x-form.input name="pejabat_instansi_perusahaan_nip" label="NIP Pejabat Tujuan" placeholder="Opsional"
                            :value="old('pejabat_instansi_perusahaan_nip')" :error="$errors->first('pejabat_instansi_perusahaan_nip')" />
                    </div>

                    {{-- Kepala Seksi --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-t border-border-custom pt-6">
                        <div class="md:col-span-1">
                            <label for="kepala_seksi_select" class="text-sm font-semibold text-text-main mb-2 block">
                                Pilih Kepala Seksi
                            </label>
                            <select id="kepala_seksi_select" class="w-full">
                                <option value="">Pilih Pegawai...</option>
                                @foreach($pegawaiData as $pegawai)
                                    <option value="{{ $pegawai->id }}" data-nama="{{ $pegawai->nama_pegawai }}" data-nip="{{ $pegawai->nip }}" data-jabatan="{{ $pegawai->jabatan }}">
                                        {{ $pegawai->nama_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <x-form.input name="kepala_seksi_jabatan" id="kepala_seksi_jabatan" label="Jabatan Kepala Seksi" placeholder="Jabatan"
                                :value="old('kepala_seksi_jabatan')" :error="$errors->first('kepala_seksi_jabatan')" readonly class="bg-background text-muted cursor-not-allowed" />
                        </div>
                        <div class="md:col-span-1">
                            <x-form.input name="kepala_seksi_nama" id="kepala_seksi_nama" label="Nama Kepala Seksi" placeholder="Nama"
                                :value="old('kepala_seksi_nama')" :error="$errors->first('kepala_seksi_nama')" readonly class="bg-background text-muted cursor-not-allowed" />
                        </div>
                        <div class="md:col-span-1">
                            <x-form.input name="kepala_seksi_nip" id="kepala_seksi_nip" label="NIP Kepala Seksi" placeholder="NIP"
                                :value="old('kepala_seksi_nip')" :error="$errors->first('kepala_seksi_nip')" readonly class="bg-background text-muted cursor-not-allowed" />
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
                        Simpan & Buat SPD
                    </x-action.button-primary>
                </div>

            </form>

        </div>

    </main>

    <x-layout.footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('alatangkuts-list');
            const addBtn = document.getElementById('add-alatangkut-btn');

            // --- Select2 for Referensi SPT ---
            $('#spt_id').select2({
                placeholder: 'Contoh: 094/01/SPT/2026',
                allowClear: true,
                ajax: {
                    url: '{{ route('user.spt.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                }
            });

            $('#spt_id').on('select2:select', function(e) {
                const sptId = e.params.data.id;
                if (sptId) {
                    let url = '{{ route('user.spt.ajax', ['id' => ':id']) }}';
                    url = url.replace(':id', sptId);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Note: tujuan_kegiatan is NOT auto-filled from SPT, per user requirement.
                            if (data.kode_mak) {
                                document.getElementById('kode_mak').value = data.kode_mak;
                            }
                            if (data.tgl_berangkat) {
                                document.getElementById('tgl_berangkat').value = data
                                    .tgl_berangkat;
                            }
                            if (data.tgl_kembali) {
                                document.getElementById('tgl_kembali').value = data.tgl_kembali;
                            }
                            if (data.lama_kegiatan) {
                                document.getElementById('lama_kegiatan').value = data
                                    .lama_kegiatan;
                            }

                            if (data.tempat_tujuan) {
                                const tempatTujuanInput = document.getElementById('tempat_tujuan');
                                if (tempatTujuanInput) {
                                    tempatTujuanInput.value = data.tempat_tujuan;
                                }
                            }

                            // Tampilkan daftar pegawai dari SPT sebagai informasi (read-only).
                            // Identitas pelaksana SPD tetap mengikuti akun yang login.
                            if (data.pegawai_list && data.pegawai_list.length > 0) {
                                const badge = document.getElementById('spt-info-badge');
                                const listContainer = document.getElementById('assigned-pegawai-list');
                                const tableBody = document.getElementById('assigned-pegawai-body');

                                badge.classList.remove('hidden');
                                listContainer.classList.remove('hidden');
                                tableBody.innerHTML = '';

                                data.pegawai_list.forEach(function(p) {
                                    const row = `
                                        <tr class="hover:bg-background/80 transition-colors">
                                            <td class="px-4 py-2 text-xs text-text-main font-medium">${p.nama_pegawai}</td>
                                            <td class="px-4 py-2 text-xs text-muted">${p.nip}</td>
                                            <td class="px-4 py-2 text-xs">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold ${p.peran === 'Penanggung Jawab' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600'}">
                                                    ${p.peran}
                                                </span>
                                            </td>
                                        </tr>
                                    `;
                                    tableBody.insertAdjacentHTML('beforeend', row);
                                });
                            } else {
                                document.getElementById('spt-info-badge').classList.add('hidden');
                                document.getElementById('assigned-pegawai-list').classList.add('hidden');
                            }

                            // Nomor SPD di-shared per SPT.
                            // Jika sudah ada SPD dari SPT ini, prefill & kunci field nomor_spd.
                            const nomorSpdInput = document.getElementById('nomor_spd');
                            const nomorSpdHint = document.getElementById('nomor-spd-hint');
                            if (data.nomor_spd_existing) {
                                nomorSpdInput.value = data.nomor_spd_existing;
                                nomorSpdInput.setAttribute('readonly', 'readonly');
                                nomorSpdInput.classList.add('bg-background', 'text-muted', 'cursor-not-allowed');
                                if (nomorSpdHint) {
                                    nomorSpdHint.textContent = 'Nomor SPD diambil otomatis dari SPD yang sudah ada dalam SPT ini.';
                                    nomorSpdHint.classList.remove('hidden');
                                }
                            } else {
                                nomorSpdInput.removeAttribute('readonly');
                                nomorSpdInput.classList.remove('bg-background', 'text-muted', 'cursor-not-allowed');
                                if (nomorSpdHint) {
                                    nomorSpdHint.classList.add('hidden');
                                }
                            }
                        }
                    });
                }
            });

            // Reset nomor_spd field jika SPT di-clear
            $('#spt_id').on('select2:clear', function() {
                const nomorSpdInput = document.getElementById('nomor_spd');
                const nomorSpdHint = document.getElementById('nomor-spd-hint');
                nomorSpdInput.removeAttribute('readonly');
                nomorSpdInput.classList.remove('bg-background', 'text-muted', 'cursor-not-allowed');
                if (nomorSpdHint) {
                    nomorSpdHint.classList.add('hidden');
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

            function updateRemoveButtons() {
                const items = container.querySelectorAll('.alatangkut-item');
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
                container.appendChild(newItem);

                // Initialize Select2 on the dynamically created select element with tags: true
                $(newItem).find('select').select2({
                    placeholder: 'Pilih Alat Angkut',
                    tags: true
                });

                updateRemoveButtons();
            });

            container.querySelectorAll('.remove-alatangkut-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.closest('.alatangkut-item').remove();
                    updateRemoveButtons();
                });
            });

            updateRemoveButtons();
        });
    </script>

</x-layout.app>
