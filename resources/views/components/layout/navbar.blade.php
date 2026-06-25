<nav class="bg-white border-b border-gray-200 py-4 px-6 md:px-12 flex justify-between items-center">
    <div class="flex items-center">
        <a href="{{ url('/') }}">
            <img class="h-10 w-auto" src="{{ asset('nav-banner.png') }}" alt="BPHL 4 Jambi">
        </a>
    </div>
    <div class="flex items-center space-x-6">
        <a href="{{ url('/') }}" class="text-black hover:text-blue-500 transition">Beranda</a>
        <a href="{{ url('/tentang') }}" class="text-black hover:text-blue-500 transition">Tentang</a>
        <a href="{{ url('/kontak') }}" class="text-black hover:text-blue-500 transition">Kontak</a>
    </div>
    <x-action.button-primary>
        <a href="/login">Masuk</a>
    </x-action.button-primary>
</nav>
