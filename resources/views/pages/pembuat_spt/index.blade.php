<x-layout.app title="Dashboard Pembuat SPT - SPJ BPHL 4">

    <div class="flex flex-1 w-full">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <main class="grow flex flex-col px-6 py-10">

                <div class="max-w-7xl mx-auto w-full">

                    {{-- Alert Notifikasi Sukses --}}
                    @if (session('success'))
                        <div class="mb-6">
                            <x-feedback.alert type="success" title="Berhasil!">
                                {{ session('success') }}
                            </x-feedback.alert>
                        </div>
                    @endif

                    {{-- Header Halaman --}}
                    <x-layout.page-header title="Dashboard Pembuat SPT" subtitle="Ringkasan Statistik dan Riwayat Singkat Data Surat Perintah Tugas (SPT).">
                        <x-slot:actions>
                            <a href="{{ route('user.spt.create') }}"
                                class="inline-flex items-center justify-center bg-primary hover:bg-primary-hover text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors duration-150 ">
                                + Buat SPT Baru
                            </a>
                        </x-slot:actions>
                    </x-layout.page-header>

                    {{-- Ringkasan Statistik --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        {{-- Total Dibuat --}}
                        <div class="bg-surface rounded-xl border border-border-custom p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted">Total SPT Dibuat</p>
                                <p class="text-3xl font-bold text-text-main mt-1">{{ $counts['dibuat'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="document-text" class="w-6 h-6" />
                            </div>
                        </div>

                        {{-- Disetujui --}}
                        <div class="bg-surface rounded-xl border border-green-200/50 p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted">Disetujui</p>
                                <p class="text-3xl font-bold text-green-700 mt-1">{{ $counts['disetujui'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="check-circle" class="w-6 h-6" />
                            </div>
                        </div>

                        {{-- Ditolak / Direvisi --}}
                        <div class="bg-surface rounded-xl border border-red-200/50 p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted">Ditolak / Direvisi</p>
                                <p class="text-3xl font-bold text-red-700 mt-1">{{ $counts['ditolak'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="x-circle" class="w-6 h-6" />
                            </div>
                        </div>

                        {{-- Selesai --}}
                        <div class="bg-surface rounded-xl border border-purple-200/50 p-6 shadow-xs flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-muted">Selesai / Dicairkan</p>
                                <p class="text-3xl font-bold text-purple-700 mt-1">{{ $counts['selesai'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center">
                                <x-utility.icon name="check-badge" class="w-6 h-6" />
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi & Navigasi Cepat --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <a href="{{ route('user.spt.kelola') }}" class="group block bg-surface rounded-xl border border-border-custom p-6 shadow-xs hover:border-primary/30 hover:shadow-sm transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-50 group-hover:bg-primary/10 rounded-lg flex items-center justify-center transition-colors">
                                    <x-utility.icon name="table-cells" class="w-6 h-6 text-muted group-hover:text-primary transition-colors" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-text-main group-hover:text-primary transition-colors">Kelola Data SPT Pegawai</h3>
                                    <p class="text-sm text-muted mt-1">Akses tabel penuh untuk mencari, mengedit, dan menghapus seluruh riwayat SPT yang telah Anda buat.</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('pembuat_spt.spj_selesai.index') }}" class="group block bg-surface rounded-xl border border-border-custom p-6 shadow-xs hover:border-blue-500/30 hover:shadow-sm transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-50 group-hover:bg-blue-50 rounded-lg flex items-center justify-center transition-colors">
                                    <x-utility.icon name="check-badge" class="w-6 h-6 text-muted group-hover:text-blue-600 transition-colors" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-text-main group-hover:text-blue-600 transition-colors">Proses Akhir SPJ Selesai</h3>
                                    <p class="text-sm text-muted mt-1">Lihat dan cetak rincian pengeluaran dokumen SPJ yang telah diverifikasi sepenuhnya oleh bagian keuangan.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

            </main>

            <x-layout.footer />
        </div>
    </div>

</x-layout.app>
