<x-layout.app title="Dashboard Pegawai - SPJ BPHL">

    <div class="flex min-h-screen bg-background">
        <x-layout.user-sidebar />

        <main class="flex-1 p-6 space-y-6 overflow-auto">

            {{-- Breadcrumb & Header --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <x-layout.breadcrumb :items="[['label' => 'Pegawai'], ['label' => 'Dashboard']]" />
                    <h1 class="text-2xl font-bold text-text-main mt-1">Dashboard Pegawai</h1>
                </div>
                <div>
                    <button id="btn-refresh" class="inline-flex items-center gap-2 bg-surface hover:bg-background text-text-main border border-border-custom hover:border-primary px-4 py-2 text-sm rounded-md transition-all shadow-sm">
                        <x-utility.icon name="clock" id="icon-refresh" class="w-4 h-4 text-muted" />
                        <span>Refresh Data</span>
                    </button>
                </div>
            </div>

            {{-- Alert/Banner Peringatan Revisi --}}
            <div id="revision-alert-container" class="{{ $revisionCount > 0 ? '' : 'hidden' }}">
                <x-feedback.alert type="warning" title="Pemberitahuan Revisi" :dismissible="false">
                    Anda memiliki <span id="revision-alert-count" class="font-bold">{{ $revisionCount }}</span> dokumen yang perlu direvisi. Silakan periksa kembali daftar dokumen Anda di bawah.
                </x-feedback.alert>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                @foreach ($stats as $index => $stat)
                    <div class="bg-surface border border-border-custom rounded-xl p-6 shadow-sm flex items-start justify-between relative group hover:shadow-md transition-all duration-150">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-muted uppercase tracking-wider">{{ $stat['title'] }}</p>
                            <p class="mt-2 text-3xl font-black text-text-main" id="stat-value-{{ $index }}">{{ $stat['value'] }}</p>
                            <p class="text-xs text-muted mt-1">{{ $stat['description'] }}</p>
                        </div>
                        <div class="shrink-0 w-12 h-12 rounded-lg flex items-center justify-center
                            {{ $stat['color'] === 'blue' ? 'bg-blue-100/50 text-blue-600' : '' }}
                            {{ $stat['color'] === 'green' ? 'bg-green-100/50 text-success' : '' }}
                            {{ $stat['color'] === 'yellow' ? 'bg-yellow-100/50 text-warning' : '' }}
                        ">
                            <x-utility.icon :name="$stat['icon']" class="w-6 h-6" />
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- 2 Column Layout untuk Riwayat & Status --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Panel Kiri: Dokumen Terbaru Saya --}}
                <div class="lg:col-span-2">
                    <x-layout.card title="5 Dokumen Terbaru" id="docs-card">
                        <x-slot:actions>
                            <button id="btn-clear-filter" class="hidden text-xs text-primary hover:underline font-medium">
                                Lihat Semua
                            </button>
                        </x-slot:actions>
                        <div class="overflow-x-auto -mx-6 -mb-6">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-background text-xs font-semibold text-muted uppercase border-b border-border-custom">
                                        <th class="px-6 py-3 w-28">Tipe Dokumen</th>
                                        <th class="px-6 py-3">Nomor Dokumen</th>
                                        <th class="px-6 py-3 w-32">Status</th>
                                        <th class="px-6 py-3 w-40">Tanggal Diajukan</th>
                                        <th class="px-6 py-3">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-docs-tbody" class="divide-y divide-border-custom">
                                    @if ($recentDocuments->isEmpty())
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-muted">
                                                Belum ada dokumen yang dibuat.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($recentDocuments as $doc)
                                            <tr class="hover:bg-background/50 transition-colors text-sm">
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wider
                                                        {{ $doc['type'] === 'SPT' ? 'bg-blue-100 text-blue-800' : '' }}
                                                        {{ $doc['type'] === 'SPD' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $doc['type'] === 'Rincian' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $doc['type'] === 'Laporan' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    ">
                                                        {{ $doc['type'] }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 font-medium text-text-main truncate max-w-[180px]" title="{{ $doc['nomor'] ?? '-' }}">
                                                    {{ $doc['nomor'] ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <x-data.status-badge :status="$doc['status']" />
                                                </td>
                                                <td class="px-6 py-4 text-sm text-text-main">
                                                    {{ $doc['tanggal_diajukan'] }}
                                                </td>
                                                <td class="px-6 py-4 text-xs text-muted truncate max-w-[200px]" title="{{ $doc['catatan_verifikator'] ?? '-' }}">
                                                    {{ $doc['catatan_verifikator'] ?? '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </x-layout.card>
                </div>

                {{-- Panel Kanan: Status Dokumen Saya --}}
                <div class="lg:col-span-1">
                    <x-layout.card title="Status Dokumen Saya" subtitle="Klik status untuk menyaring tabel dokumen">
                        <div class="space-y-3">
                            @foreach ($documentSummary as $summary)
                                <div class="status-row flex items-center justify-between py-2.5 border-b border-border-custom last:border-b-0 hover:bg-primary-light/40 px-3 rounded-lg cursor-pointer transition-all duration-150 border border-transparent" data-status="{{ $summary['status'] }}">
                                    <x-data.status-badge :status="$summary['status']" />
                                    <span class="text-sm font-bold text-text-main tabular-nums bg-background px-3 py-1 rounded-full border border-border-custom" id="summary-count-{{ $summary['status'] }}">
                                        {{ $summary['jumlah'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </x-layout.card>
                </div>

            </div>

        </main>
    </div>

    {{-- AJAX Script untuk refresh dan interaktivitas penyaringan --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnRefresh = document.getElementById('btn-refresh');
            const iconRefresh = document.getElementById('icon-refresh');
            const btnClearFilter = document.getElementById('btn-clear-filter');
            const statusRows = document.querySelectorAll('.status-row');
            
            let activeStatusFilter = 'all';

            // Definisikan class mapping untuk status badge agar sejalan dengan blade
            const badgeClasses = {
                draft: 'bg-gray-100 text-gray-800 border-gray-200',
                diajukan: 'bg-yellow-50 text-yellow-700 border-yellow-200/50',
                pending: 'bg-yellow-50 text-yellow-700 border-yellow-200/50',
                direvisi: 'bg-orange-50 text-orange-700 border-orange-200/50',
                disetujui: 'bg-green-50 text-green-700 border-green-200/50',
                completed: 'bg-green-50 text-green-700 border-green-200/50',
                ditolak: 'bg-red-50 text-red-700 border-red-200/50',
                cancelled: 'bg-red-50 text-red-700 border-red-200/50',
                ongoing: 'bg-blue-50 text-blue-700 border-blue-200/50',
                active: 'bg-blue-50 text-blue-700 border-blue-200/50',
                inactive: 'bg-gray-100 text-gray-800 border-gray-200'
            };

            const statusLabels = {
                draft: 'Draft',
                diajukan: 'Diajukan',
                pending: 'Menunggu',
                direvisi: 'Direvisi',
                disetujui: 'Disetujui',
                completed: 'Selesai',
                ditolak: 'Ditolak',
                cancelled: 'Dibatalkan',
                ongoing: 'Berlangsung',
                active: 'Aktif',
                inactive: 'Nonaktif'
            };

            function getStatusBadgeHtml(status) {
                const bgClass = badgeClasses[status] || 'bg-gray-100 text-gray-800 border-gray-200';
                const label = statusLabels[status] || status.toUpperCase();
                return `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold border ${bgClass}">${label}</span>`;
            }

            function fetchDashboardData(status = 'all', isManualRefresh = false) {
                if (isManualRefresh) {
                    iconRefresh.classList.add('animate-spin');
                    btnRefresh.disabled = true;
                }

                let url = '{{ route('user.dashboard.data') }}';
                if (status !== 'all') {
                    url += `?status=${status}`;
                }

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal mengambil data');
                        return response.json();
                    })
                    .then(data => {
                        // 1. Update Alert Peringatan Revisi
                        const alertContainer = document.getElementById('revision-alert-container');
                        const alertCountSpan = document.getElementById('revision-alert-count');
                        if (data.revisionCount > 0) {
                            alertCountSpan.textContent = data.revisionCount;
                            alertContainer.classList.remove('hidden');
                        } else {
                            alertContainer.classList.add('hidden');
                        }

                        // 2. Update Stat Cards
                        data.stats.forEach((stat, index) => {
                            const valEl = document.getElementById(`stat-value-${index}`);
                            if (valEl) {
                                valEl.textContent = stat.value;
                            }
                        });

                        // 3. Update Tabel Dokumen dan Judul Card
                        const tbody = document.getElementById('recent-docs-tbody');
                        const cardTitle = document.querySelector('#docs-card h3');
                        if (cardTitle) {
                            cardTitle.textContent = (status === 'all') ? '5 Dokumen Terbaru' : `Dokumen Saya (Status: ${statusLabels[status]})`;
                        }

                        if (data.recentDocuments.length === 0) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-muted">
                                        Tidak ada dokumen dengan status ini.
                                    </td>
                                </tr>
                            `;
                        } else {
                            let html = '';
                            data.recentDocuments.forEach(doc => {
                                let typeClass = '';
                                if (doc.type === 'SPT') typeClass = 'bg-blue-100 text-blue-800';
                                else if (doc.type === 'SPD') typeClass = 'bg-green-100 text-green-800';
                                else if (doc.type === 'Rincian') typeClass = 'bg-yellow-100 text-yellow-800';
                                else typeClass = 'bg-purple-100 text-purple-800';

                                html += `
                                    <tr class="hover:bg-background/50 transition-colors text-sm">
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wider ${typeClass}">
                                                ${doc.type}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-text-main truncate max-w-[180px]" title="${doc.nomor || '-'}">
                                            ${doc.nomor || '-'}
                                        </td>
                                        <td class="px-6 py-4">
                                            ${getStatusBadgeHtml(doc.status)}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-text-main">
                                            ${doc.tanggal_diajukan}
                                        </td>
                                        <td class="px-6 py-4 text-xs text-muted truncate max-w-[200px]" title="${doc.catatan_verifikator || '-'}">
                                            ${doc.catatan_verifikator || '-'}
                                        </td>
                                    </tr>
                                `;
                            });
                            tbody.innerHTML = html;
                        }

                        // 4. Update Status Dokumen Saya (Kanan)
                        data.documentSummary.forEach(sum => {
                            const countEl = document.getElementById(`summary-count-${sum.status}`);
                            if (countEl) {
                                countEl.textContent = sum.jumlah;
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching dashboard data:', error);
                        alert('Terjadi kesalahan saat memuat data.');
                    })
                    .finally(() => {
                        if (isManualRefresh) {
                            setTimeout(() => {
                                iconRefresh.classList.remove('animate-spin');
                                btnRefresh.disabled = false;
                            }, 500);
                        }
                    });
            }

            // Event listener klik pada baris status
            statusRows.forEach(row => {
                row.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');
                    
                    if (activeStatusFilter === status) {
                        // Jika status yang sama diklik lagi, hapus filter
                        activeStatusFilter = 'all';
                        this.classList.remove('bg-primary-light/50', 'border-primary/20');
                        btnClearFilter.classList.add('hidden');
                    } else {
                        // Pasang filter aktif baru
                        activeStatusFilter = status;
                        statusRows.forEach(r => r.classList.remove('bg-primary-light/50', 'border-primary/20'));
                        this.classList.add('bg-primary-light/50', 'border-primary/20');
                        btnClearFilter.classList.remove('hidden');
                    }

                    fetchDashboardData(activeStatusFilter);
                });
            });

            // Hapus filter
            btnClearFilter.addEventListener('click', function() {
                activeStatusFilter = 'all';
                statusRows.forEach(r => r.classList.remove('bg-primary-light/50', 'border-primary/20'));
                btnClearFilter.classList.add('hidden');
                fetchDashboardData('all');
            });

            // Refresh data manual
            btnRefresh.addEventListener('click', function() {
                fetchDashboardData(activeStatusFilter, true);
            });
        });
    </script>
    @endpush

</x-layout.app>
