@props(['paginator'])

@if($paginator->hasPages())
    <nav {{ $attributes->merge(['class' => 'flex items-center justify-between border-t border-gray-200 pt-4']) }} aria-label="Pagination">

        {{-- Info --}}
        <div class="text-sm text-gray-500">
            Menampilkan
            <span class="font-medium text-gray-900">{{ $paginator->firstItem() }}</span>–<span class="font-medium text-gray-900">{{ $paginator->lastItem() }}</span>
            dari <span class="font-medium text-gray-900">{{ $paginator->total() }}</span> data
        </div>

        {{-- Buttons --}}
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if($paginator->onFirstPage())
                <span class="px-3 py-1.5 text-sm text-gray-300 border border-gray-200 rounded-md cursor-not-allowed">Prev</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-1.5 text-sm text-gray-600 border border-gray-200 rounded-md hover:bg-gray-50 transition-colors">
                    Prev
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach($paginator->getUrlRange(max(1, $paginator->currentPage()-2), min($paginator->lastPage(), $paginator->currentPage()+2)) as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="px-3 py-1.5 text-sm font-medium bg-gray-900 text-white border border-gray-900 rounded-md">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="px-3 py-1.5 text-sm text-gray-600 border border-gray-200 rounded-md hover:bg-gray-50 transition-colors">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-1.5 text-sm text-gray-600 border border-gray-200 rounded-md hover:bg-gray-50 transition-colors">
                    Next
                </a>
            @else
                <span class="px-3 py-1.5 text-sm text-gray-300 border border-gray-200 rounded-md cursor-not-allowed">Next</span>
            @endif
        </div>
    </nav>
@endif
