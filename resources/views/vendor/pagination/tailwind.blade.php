@if ($paginator->hasPages())
<nav role="navigation" aria-label="Navegación de páginas"
     class="flex flex-col sm:flex-row items-center justify-between gap-4 py-2">

    {{-- Info texto --}}
    <p class="text-xs text-gray-400 order-2 sm:order-1">
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

    {{-- Controles --}}
    <div class="flex items-center gap-1 order-1 sm:order-2">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="w-9 h-9 flex items-center justify-center rounded-full
                         border border-gray-200 text-gray-300 cursor-not-allowed bg-white"
                  aria-disabled="true">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               aria-label="Página anterior"
               class="w-9 h-9 flex items-center justify-center rounded-full border-2 border-dre-accent
                      text-dre-accent hover:bg-dre-accent hover:text-white transition-all duration-200 bg-white">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </a>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            {{-- Separador "..." --}}
            @if (is_string($element))
                <span class="w-9 h-9 flex items-center justify-center text-sm text-gray-400
                             select-none">
                    &hellip;
                </span>
            @endif

            {{-- Páginas --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                              class="w-9 h-9 flex items-center justify-center rounded-full text-sm font-bold
                                     bg-dre-primary text-white shadow-sm cursor-default select-none">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           aria-label="Ir a página {{ $page }}"
                           class="w-9 h-9 flex items-center justify-center rounded-full text-sm font-medium
                                  bg-white border border-gray-200 text-gray-600
                                  hover:bg-dre-50 hover:text-dre-primary hover:border-dre-accent/40
                                  transition-all duration-200">
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
               class="w-9 h-9 flex items-center justify-center rounded-full border-2 border-dre-accent
                      text-dre-accent hover:bg-dre-accent hover:text-white transition-all duration-200 bg-white">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        @else
            <span class="w-9 h-9 flex items-center justify-center rounded-full
                         border border-gray-200 text-gray-300 cursor-not-allowed bg-white"
                  aria-disabled="true">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </span>
        @endif

    </div>
</nav>
@endif
