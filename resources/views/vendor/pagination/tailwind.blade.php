@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-[#2d2d2d] border border-gray-700 cursor-default leading-5 rounded-md">
                Anterior
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-yellow-500 bg-[#2d2d2d] border border-yellow-500 leading-5 rounded-md hover:text-yellow-400 focus:outline-none focus:ring focus:ring-yellow-500">
                Anterior
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-[#2d2d2d] border border-gray-700 cursor-default leading-5 rounded-md">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-yellow-500 bg-[#1a1a1a] border border-yellow-500 cursor-default leading-5 rounded-md">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-yellow-500 bg-[#2d2d2d] border border-yellow-500 leading-5 rounded-md hover:text-yellow-400 focus:outline-none focus:ring focus:ring-yellow-500" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-yellow-500 bg-[#2d2d2d] border border-yellow-500 leading-5 rounded-md hover:text-yellow-400 focus:outline-none focus:ring focus:ring-yellow-500">
                Próximo
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-[#2d2d2d] border border-gray-700 cursor-default leading-5 rounded-md">
                Próximo
            </span>
        @endif
    </nav>
@endif
