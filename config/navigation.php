<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navbar (Publik — Landing Page)
    |--------------------------------------------------------------------------
    | Link navigasi yang tampil di navbar halaman publik.
    */
    'navbar' => [
        ['label' => 'Beranda', 'url' => '/'],
        ['label' => 'Tentang',  'url' => '/tentang'],
        ['label' => 'Kontak',   'url' => '/kontak'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sidebar (Dashboard — Setelah Login)
    |--------------------------------------------------------------------------
    | Item menu sidebar dashboard. Setiap item mendukung:
    | - label   : teks yang ditampilkan
    | - url     : route URL
    | - icon    : nama icon dari x-utility.icon (Heroicons)
    | - active  : ditentukan secara dinamis di komponen (bukan di sini)
    */
    'sidebar' => [
        ['label' => 'Dashboard',  'url' => '/dashboard',  'icon' => 'home'],
        ['label' => 'Pegawai',    'url' => '/pegawai',    'icon' => 'users'],
        ['label' => 'Daftar SPT', 'url' => '/spt',        'icon' => 'document-text'],
            ['label' => 'Daftar SPD', 'url' => '/user/spd',        'icon' => 'clipboard'],
        ['label' => 'Laporan',    'url' => '/laporan',    'icon' => 'chart-bar'],
        ['label' => 'Pengaturan', 'url' => '/pengaturan', 'icon' => 'cog'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer (Kolom Menu Publik)
    |--------------------------------------------------------------------------
    | Kolom-kolom menu yang tampil di bagian footer. Format:
    | 'Judul Kolom' => [
    |     ['label' => '...', 'url' => '...'],
    | ]
    */
    'footer' => [
        'Layanan' => [
            ['label' => 'Surat Perintah Tugas (SPT)', 'url' => '/spt'],
            ['label' => 'Surat Perjalanan Dinas (SPD)', 'url' => '/user/spd'],
            ['label' => 'Laporan Pertanggungjawaban',  'url' => '/lpj'],
        ],
        'Navigasi' => [
            ['label' => 'Beranda', 'url' => '/'],
            ['label' => 'Tentang', 'url' => '/tentang'],
            ['label' => 'Kontak',  'url' => '/kontak'],
        ],
        'Legal' => [
            ['label' => 'Kebijakan Privasi', 'url' => '/privasi'],
            ['label' => 'Syarat & Ketentuan', 'url' => '/syarat'],
        ],
    ],

];
