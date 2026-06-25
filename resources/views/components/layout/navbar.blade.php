<nav class="bg-surface border-b border-border-custom py-4 px-6 md:px-12 flex justify-between items-center">
    {{-- Logo --}}
    <div class="flex items-center">
        <a href="{{ url('/') }}">
            <img class="h-10 w-auto" src="{{ asset('nav-banner.png') }}" alt="BPHL 4 Jambi">
        </a>
    </div>

    {{-- Menu Links — dari config/navigation.php --}}
    <div class="hidden md:flex items-center space-x-6">
        @foreach(config('navigation.navbar') as $item)
            <a
                href="{{ url($item['url']) }}"
                class="text-sm font-medium transition-colors duration-150
                    {{ request()->is(ltrim($item['url'], '/') ?: '/')
                        ? 'text-primary font-semibold'
                        : 'text-text-main hover:text-primary' }}"
            >
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>

    {{-- CTA Button --}}
    <x-action.button
        onclick="window.location='/login'"
        class="bg-primary hover:bg-primary-hover text-white text-sm font-medium px-4 py-2 rounded-md"
    >
        Masuk
    </x-action.button>
</nav>
