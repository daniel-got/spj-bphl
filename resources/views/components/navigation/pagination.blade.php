@props(['paginator'])

@if($paginator->hasPages())
    <nav {{ $attributes->merge(['class' => 'flex items-center justify-between border-t border-border-custom pt-4']) }} aria-label="Pagination">

        {{-- Info --}}
        <div class="text-sm text-muted">
            Menampilkan
            <span class="font-medium text-text-main">{{ $paginator->firstItem() }}</span>–<span class="font-medium text-text-main">{{ $paginator->lastItem() }}</span>
            dari <span class="font-medium text-text-main">{{ $paginator->total() }}</span> data
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-sm text-muted opacity-50 border border-border-custom rounded-md cursor-not-allowed">Prev</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-1.5 text-sm text-text-main border border-border-custom rounded-md hover:bg-background transition-colors">
                    Prev
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($paginator->getUrlRange(max(1, $paginator->currentPage()-2), min($paginator->lastPage(), $paginator->currentPage()+2)) as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="px-3 py-1.5 text-sm font-medium bg-primary text-white border border-primary rounded-md">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="px-3 py-1.5 text-sm text-text-main border border-border-custom rounded-md hover:bg-background transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-1.5 text-sm text-text-main border border-border-custom rounded-md hover:bg-background transition-colors">
                    Next
                </a>
            @else
                <span class="px-3 py-1.5 text-sm text-muted opacity-50 border border-border-custom rounded-md cursor-not-allowed">Next</span>
            @endif
        </div>
    </nav>
@endif
