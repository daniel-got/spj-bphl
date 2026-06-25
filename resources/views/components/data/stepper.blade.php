@props([
    'steps'   => [], // [['label' => 'Data Pegawai', 'description' => null]]
    'current' => 1,  // step aktif saat ini (1-based)
])

<nav {{ $attributes->merge(['class' => 'flex items-start']) }} aria-label="Progress">
    @foreach($steps as $index => $step)
        @php
            $stepNumber = $index + 1;
            $isCompleted = $stepNumber < $current;
            $isActive    = $stepNumber === $current;
            $isPending   = $stepNumber > $current;
        @endphp
        <div class="flex-1 flex flex-col items-center">
            {{-- Connector --}}
            <div class="flex items-center w-full">
                {{-- Left line --}}
                <div class="flex-1 h-0.5 {{ $index === 0 ? 'invisible' : ($isCompleted || $isActive ? 'bg-primary' : 'bg-border-custom') }}"></div>

                {{-- Circle --}}
                <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors
                    {{ $isCompleted ? 'bg-primary text-white' : ($isActive ? 'border-2 border-primary text-primary' : 'border-2 border-border-custom text-muted') }}">
                    @if($isCompleted)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    @else
                        {{ $stepNumber }}
                    @endif
                </div>

                {{-- Right line --}}
                <div class="flex-1 h-0.5 {{ $loop->last ? 'invisible' : ($isCompleted ? 'bg-primary' : 'bg-border-custom') }}"></div>
            </div>

            {{-- Label --}}
            <div class="mt-2 text-center px-1">
                <p class="text-xs font-semibold {{ $isActive ? 'text-primary' : ($isCompleted ? 'text-text-main' : 'text-muted') }}">
                    {{ $step['label'] }}
                </p>
                @if(isset($step['description']))
                    <p class="text-xs text-muted mt-0.5">{{ $step['description'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</nav>
