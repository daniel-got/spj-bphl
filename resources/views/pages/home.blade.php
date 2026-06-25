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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <x-dashboard.stat-card title="Total Pegawai" :value="$totalPegawai" description="Personil BPHL IV" icon="users"
                color="blue" />

            <x-dashboard.stat-card title="Golongan IV" :value="$totalPegawaiIV" description="Total Pegawai Golongan IV"
                icon="users" color="green" />

            <x-dashboard.stat-card title="Golongan III" :value="$totalPegawaiIII" description="Total Pegawai Golongan III"
                icon="users" color="yellow" />
            <x-dashboard.stat-card title="Golongan II" :value="$totalPegawaiII" description="Total Pegawai Golongan II"
                icon="users" color="red" />

        </div>

    </main>

    <x-layout.footer />

</x-layout.app>
