<x-layout.app title="Beranda - SPJ BPHL 4">

    <x-layout.navbar />

    <main class="grow flex flex-col justify-center items-center px-6 py-16 md:py-24 text-center">

        <div class="max-w-3xl mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 text-black">
                Sistem Informasi Perjalanan Dinas
            </h1>
            <p class="text-lg text-gray-600 leading-relaxed mb-8">
                Portal resmi Balai Pengelolaan Hutan Lestari (BPHL) Wilayah IV Jambi untuk pengelolaan administrasi
                Surat Perintah Tugas (SPT), Surat Perjalanan Dinas (SPD), dan Rincian Biaya secara terintegrasi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-dashboard.stat-card title="Total Pegawai" :value="$totalPegawai" description="Personil BPHL IV" icon="users"
                color="blue" />

            <x-dashboard.stat-card title="SPT" :value="$totalSPT" description="Total Surat Perintah Tugas"
                icon="document-text" color="green" />

            <x-dashboard.stat-card title="SPD" :value="$totalSPD" description="Total Surat Perjalanan Dinas"
                icon="clipboard" color="yellow" />
        </div>

    </main>

    <x-layout.footer />

</x-layout.app>
