{{--
    Dashboard Admin — resources/views/pages/admin/dashboard.blade.php

    Data yang diterima dari DashboardController (via DashboardService):
    - $stats           : array of stat cards
    - $recentUsers     : Collection<User> with pegawai relation
    - $documentSummary : array of ['status' => ..., 'jumlah' => ...]

    Komponen yang digunakan sesuai developing_view.md:
    - <x-layout.app>
    - <x-layout.sidebar>
    - <x-layout.page-header>
    - <x-layout.breadcrumb>
    - <x-dashboard.stat-card>
    - <x-layout.card>
    - <x-data.badge>
    - <x-data.empty-state>
    - <x-utility.avatar>
    - <x-feedback.alert>
--}}

<x-layout.app title="Dashboard Admin — SPJ BPHL">

    {{-- =====================================================================
         SIDEBAR — Menu khusus admin
    ====================================================================== --}}
    <div class="flex min-h-screen bg-background">
        <x-layout.sidebar />

        {{-- ================================================================
             MAIN CONTENT AREA
        ================================================================= --}}
        <main class="flex-1 p-6 space-y-6 overflow-auto">

            {{-- Breadcrumb --}}
            <x-layout.breadcrumb :items="[['label' => 'Pegawai'], ['label' => 'Dashboard']]" />

            {{-- Page Header --}}
            <x-layout.page-header title="Dashboard Administrator"
                description="Ringkasan sistem dan aktivitas terkini SPJ BPHL Wilayah IV Jambi" />

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
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                @foreach ($stats as $stat)
                    <x-dashboard.stat-card :title="$stat['title']" :value="$stat['value']" :description="$stat['description']" :icon="$stat['icon']"
                        :color="$stat['color']" />
                @endforeach
            </div>

            {{-- ===========================================================
                 ROW 2 — Pengguna Terbaru & Ringkasan Dokumen
            ============================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Pengguna Terbaru (lebar 2/3) --}}
                <div class="lg:col-span-2">
                    <x-layout.card title="Pengguna Terbaru" subtitle="5 akun yang baru ditambahkan ke sistem">

                        @if ($recentUsers->isEmpty())
                            <x-data.empty-state title="Belum ada pengguna"
                                description="Belum ada akun yang dibuat di sistem ini." />
                        @else
                            <div class="divide-y divide-border-custom -mx-6 -mb-6">
                                @foreach ($recentUsers as $user)
                                    <div
                                        class="flex items-center justify-between px-6 py-3 hover:bg-background transition-colors">
                                        <div class="flex items-center gap-3 min-w-0">
                                            {{-- Avatar dengan inisial otomatis dari komponen --}}
                                            <x-utility.avatar :name="$user->name" size="sm" />
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-text-main truncate">
                                                    {{ $user->name }}
                                                </p>
                                                <p class="text-xs text-muted truncate">
                                                    {{ $user->pegawai?->nip ?? $user->email }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3 flex-shrink-0">
                                            {{--
                                                Badge Role — mapping ke warna palette
                                                Hindari warna arbitrary, gunakan nilai color yang
                                                didukung komponen <x-data.badge>
                                            --}}
                                            @php
                                                $roleColor = match ($user->role) {
                                                    'admin' => 'purple',
                                                    'verifikator' => 'blue',
                                                    'kepala_balai',
                                                    'kepala_tu',
                                                    'kepala_seksi_pephphl',
                                                    'kepala_seksi_ppphphl'
                                                        => 'yellow',
                                                    default => 'gray',
                                                };
                                            @endphp
                                            <x-data.badge :label="$user->roleLabel()" :color="$roleColor" />
                                            <span class="text-xs text-muted hidden sm:block whitespace-nowrap">
                                                {{ $user->created_at->diffForHumans() }}
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
                    <x-layout.card title="Status Dokumen" subtitle="Ringkasan SPT per status">

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
