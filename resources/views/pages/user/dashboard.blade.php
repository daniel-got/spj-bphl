{{--
    Dashboard Pegawai — resources/views/pages/user/dashboard.blade.php

    Data yang diterima dari DashboardController (via DashboardService):
    - $stats           : array of stat cards
    - $recentSpt       : Collection<Spt>
    - $documentSummary : array of ['status' => ..., 'jumlah' => ...]
--}}

<x-layout.app title="Dashboard Pegawai — SPJ BPHL">

    <div class="flex min-h-screen bg-background">
        <x-layout.sidebar />

        <main class="flex-1 p-6 space-y-6 overflow-auto">

            {{-- Breadcrumb --}}
            <x-layout.breadcrumb :items="[['label' => 'Pegawai'], ['label' => 'Dashboard']]" />

            {{-- Page Header --}}
            <x-layout.page-header title="Dashboard Pegawai"
                description="Selamat datang kembali! Berikut ringkasan tugas dan perjalanan dinas Anda." />

            {{-- Flash message dari session --}}
            @if (session('success'))
                <x-feedback.alert type="success" title="Berhasil!" :dismissible="true">
                    {{ session('success') }}
                </x-feedback.alert>
            @endif

            @if (session('error'))
                <x-feedback.alert type="error" title="Gagal!" :dismissible="true">
                    {{ session('error') }}
                </x-feedback.alert>
            @endif

            {{-- ===========================================================
                 STAT CARDS — 4 kartu ringkasan di bagian atas
                 Data dikirim oleh DashboardService::getStatCards()
            ============================================================ --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($stats as $stat)
                    <x-dashboard.stat-card :title="$stat['title']" :value="$stat['value']" :description="$stat['description']" :icon="$stat['icon']"
                        :color="$stat['color']" />
                @endforeach
            </div>

            @if(isset($tuStats))
                <div class="mt-6">
                    <x-layout.card title="Statistik Verifikasi (TU)">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            <div class="p-4 bg-primary/10 border border-primary/20 rounded-xl text-center">
                                <p class="text-sm font-medium text-primary">Total Dokumen Masuk</p>
                                <p class="text-2xl font-bold text-text-main mt-1">{{ $tuStats['total'] }}</p>
                            </div>
                            <div class="p-4 bg-green-100 border border-green-200 rounded-xl text-center">
                                <p class="text-sm font-medium text-green-700">Disetujui</p>
                                <p class="text-2xl font-bold text-text-main mt-1">{{ $tuStats['disetujui'] }}</p>
                            </div>
                            <div class="p-4 bg-red-100 border border-red-200 rounded-xl text-center">
                                <p class="text-sm font-medium text-red-700">Ditolak</p>
                                <p class="text-2xl font-bold text-text-main mt-1">{{ $tuStats['ditolak'] }}</p>
                            </div>
                        </div>
                    </x-layout.card>
                </div>
            @endif

            {{-- ===========================================================
                 ROW 2 — SPT Terbaru & Ringkasan Status
            ============================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- SPT Terbaru (lebar 2/3) --}}
                <div class="lg:col-span-2">
                    <x-layout.card title="SPT Terbaru" subtitle="5 surat perintah tugas terakhir Anda">

                        @if ($recentSpt->isEmpty())
                            <x-data.empty-state title="Belum ada SPT"
                                description="Anda belum memiliki riwayat SPT di sistem." />
                        @else
                            <div class="divide-y divide-border-custom -mx-6 -mb-6">
                                @foreach ($recentSpt as $spt)
                                    <div
                                        class="flex items-center justify-between px-6 py-4 hover:bg-background transition-colors">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="p-2 bg-primary/10 rounded-lg">
                                                <x-utility.icon name="document-text" class="w-5 h-5 text-primary" />
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ route('user.spt.show', $spt->id) }}" class="text-sm font-medium text-text-main hover:text-primary truncate block">
                                                    {{ $spt->nomor_spt ?? 'Belum ada nomor' }}
                                                </a>
                                                <p class="text-xs text-muted truncate">
                                                    {{ $spt->tujuan_kegiatan }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4 flex-shrink-0">
                                            <x-data.status-badge :status="$spt->status" />
                                            <span class="text-xs text-muted hidden sm:block whitespace-nowrap">
                                                {{ $spt->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </x-layout.card>
                </div>

                {{-- Ringkasan Dokumen SPT per Status (lebar 1/3) --}}
                <div class="lg:col-span-1">
                    <x-layout.card title="Status SPT" subtitle="Ringkasan status seluruh SPT Anda">

                        @if (empty($documentSummary))
                            <x-data.empty-state title="Belum ada dokumen" description="Belum ada SPT yang dibuat." />
                        @else
                            <div class="space-y-3">
                                @foreach ($documentSummary as $doc)
                                    <div class="flex items-center justify-between py-1">
                                        {{--
                                            Status Badge — komponen khusus untuk status dokumen.
                                            Otomatis mapping status ke label & warna yang sesuai.
                                            Lihat: developing_view.md section 8
                                        --}}
                                        <x-data.status-badge :status="$doc['status']" />
                                        <span class="text-sm font-semibold text-text-main tabular-nums">
                                            {{ $doc['jumlah'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </x-layout.card>
                </div>

            </div>

        </main>
    </div>

</x-layout.app>
