<footer class="bg-surface border-t border-border-custom py-12 px-6 mt-auto">
    <div class="max-w-7xl mx-auto">

        {{-- Grid: Info + Kolom Menu dari config --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- Kolom 1: Identitas Instansi --}}
            <div class="col-span-1 md:col-span-1">
                <h3 class="text-base font-bold text-primary mb-3">BPHL Wilayah IV Jambi</h3>
                <div class="space-y-1 text-sm text-muted">
                    <p>Jl. Arief Rahmad Hakim No. 10A</p>
                    <p>Simpang IV Sipin, Telanaipura, Jambi</p>
                    <p class="mt-3">(0741) 60415</p>
                    <p class="mt-3">bphl.jambi &bull; bphljambi</p>
                </div>
            </div>

            {{-- Kolom 2–4: Menu dari config/navigation.php --}}
            @foreach (config('navigation.footer') as $title => $items)
                <div class="col-span-1">
                    <h3 class="text-xs font-semibold text-text-main uppercase tracking-wider mb-4">
                        {{ $title }}
                    </h3>
                    <ul class="space-y-3">
                        @foreach ($items as $item)
                            <li>
                                <a href="{{ url($item['url']) }}"
                                    class="text-sm text-muted hover:text-primary transition-colors duration-150">
                                    {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

        </div>

        {{-- Copyright --}}
        <div
            class="mt-10 pt-6 border-t border-border-custom flex flex-col sm:flex-row justify-between items-center gap-2 text-sm text-muted">
            <p>&copy; {{ date('Y') }} BPHL Wilayah IV Jambi. Hak cipta dilindungi.</p>
            <p>Sistem Informasi Perjalanan Dinas</p>
        </div>

    </div>
</footer>
