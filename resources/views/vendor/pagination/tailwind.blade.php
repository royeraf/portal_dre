@if ($paginator->hasPages())
<nav role="navigation" aria-label="Navegación de páginas"
     class="flex flex-col items-center gap-3 py-2 w-full">

    {{-- Controles --}}
    <div class="flex items-center flex-wrap justify-center gap-1 w-full">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-full
                         border border-gray-200 text-gray-300 cursor-not-allowed bg-white shrink-0"
                  aria-disabled="true">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               aria-label="Página anterior"
               class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-full border-2 border-dre-accent
                      text-dre-accent hover:bg-dre-accent hover:text-white transition-all duration-200 bg-white shrink-0">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </a>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            {{-- Separador "..." --}}
            @if (is_string($element))
                <span class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center text-sm text-gray-400 select-none shrink-0">
                    &hellip;
                </span>
            @endif

            {{-- Páginas --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                              class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-full text-xs sm:text-sm font-bold
                                     bg-dre-primary text-white shadow-sm cursor-default select-none shrink-0">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           aria-label="Ir a página {{ $page }}"
                           class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-full text-xs sm:text-sm font-medium
                                  bg-white border border-gray-200 text-gray-600
                                  hover:bg-dre-50 hover:text-dre-primary hover:border-dre-accent/40
                                  transition-all duration-200 shrink-0">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               aria-label="Página siguiente"
               class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-full border-2 border-dre-accent
                      text-dre-accent hover:bg-dre-accent hover:text-white transition-all duration-200 bg-white shrink-0">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        @else
            <span class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-full
                         border border-gray-200 text-gray-300 cursor-not-allowed bg-white shrink-0"
                  aria-disabled="true">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </span>
        @endif

    </div>

    {{-- Info texto --}}
    <p class="text-xs text-gray-400 text-center">
        Mostrando
        @if ($paginator->firstItem())
            <span class="font-semibold text-gray-700">{{ $paginator->firstItem() }}</span>
            al
            <span class="font-semibold text-gray-700">{{ $paginator->lastItem() }}</span>
        @else
            <span class="font-semibold text-gray-700">{{ $paginator->count() }}</span>
        @endif
        de <span class="font-semibold text-gray-700">{{ $paginator->total() }}</span> resultados
    </p>

</nav>
@endif
