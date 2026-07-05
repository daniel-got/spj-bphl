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

                    {{-- Field Khusus Rincian (Editable) --}}
                    <div class="border-t border-border-custom pt-6 space-y-4">
                        <h3 class="text-base font-bold text-text-main mb-2">Biaya Rincian</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-form.input name="biaya_transport" label="Biaya Transport (Rp)" type="number" placeholder="Contoh: 150000"
                                :value="old('biaya_transport', (int) $rincian->biaya_transport)" :error="$errors->first('biaya_transport')" />
                            
                            <x-form.input name="penginapan" label="Lama Penginapan (Malam)" type="number" placeholder="Contoh: 2"
                                :value="old('penginapan', $rincian->penginapan)" :error="$errors->first('penginapan')" />
                                
                            <x-form.input name="hotel_ril" label="Biaya Hotel/Penginapan (Rp)" type="number" placeholder="Contoh: 500000"
                                :value="old('hotel_ril', (int) $rincian->hotel_ril)" :error="$errors->first('hotel_ril')" />
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
</x-layout.app>
