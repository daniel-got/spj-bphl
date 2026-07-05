<x-layout.app title="Tambah Rincian - SPJ BPHL 4">

    <!-- jQuery & Select2 CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Custom Select2 Styling */
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

                    {{-- Field Khusus Rincian (Editable) --}}
                    <div class="border-t border-border-custom pt-6 space-y-4">
                        <h3 class="text-base font-bold text-text-main mb-2">Biaya Rincian</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-form.input name="biaya_transport" label="Biaya Transport (Rp)" type="number" placeholder="Contoh: 150000"
                                :value="old('biaya_transport')" :error="$errors->first('biaya_transport')" />
                            
                            <x-form.input name="penginapan" label="Lama Penginapan (Malam)" type="number" placeholder="Contoh: 2"
                                :value="old('penginapan')" :error="$errors->first('penginapan')" />
                                
                            <x-form.input name="hotel_ril" label="Biaya Hotel/Penginapan (Rp)" type="number" placeholder="Contoh: 500000"
                                :value="old('hotel_ril')" :error="$errors->first('hotel_ril')" />
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
            });
        });
    </script>
</x-layout.app>
