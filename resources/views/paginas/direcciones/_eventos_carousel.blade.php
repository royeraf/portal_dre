{{-- Partial: carousel de eventos. Requiere: $chunks, $trackId, $dotsId --}}
<div data-carousel>
    {{-- Track --}}
    <div class="overflow-hidden rounded-xl">
        <div data-track class="flex transition-transform duration-400 ease-in-out">
            @foreach($chunks as $chunk)
                <div class="min-w-full grid grid-cols-1 sm:grid-cols-3 gap-4 px-1">
                    @foreach($chunk as $evento)
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex flex-col hover:-translate-y-0.5 transition-transform">
                            <div class="flex items-center justify-center w-10 h-10 bg-dre-primary rounded-lg mb-3 shrink-0">
                                <i data-lucide="calendar-check" class="w-5 h-5 text-white"></i>
                            </div>
                            @if(isset($evento->area))
                                <span class="inline-flex items-center gap-1 text-[10px] font-medium bg-dre-50 text-dre-accent px-2 py-0.5 rounded-full mb-2 w-fit">
                                    <i data-lucide="tag" class="w-2.5 h-2.5"></i>
                                    {{ $evento->area->nombre }}
                                </span>
                            @endif
                            <h4 class="text-sm font-semibold text-gray-800 leading-snug mb-1">{{ $evento->titulo }}</h4>
                            <p class="text-xs text-gray-400 leading-relaxed mb-3 flex-1">{{ Str::limit($evento->descripcion, 80) }}</p>
                            <div class="flex flex-wrap gap-1.5 mt-auto">
                                @foreach($evento->enlaces as $enlace)
                                    <a href="{{ $enlace['url'] }}" target="_blank"
                                       class="flex items-center gap-1 text-[10px] font-semibold bg-dre-primary hover:bg-dre-accent text-white px-2 py-1 rounded-md transition-colors">
                                        <i data-lucide="link" class="w-3 h-3"></i>
                                        {{ Str::limit($enlace['descripcion'], 15) }}
                                    </a>
                                @endforeach
                                @if($evento->enlace_externo)
                                    <a href="{{ $evento->enlace_externo }}" target="_blank"
                                       class="flex items-center gap-1 text-[10px] font-semibold bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded-md transition-colors">
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                        Ver más
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    {{-- Controles y dots --}}
    @if($chunks->count() > 1)
        <div class="flex items-center justify-center gap-3 mt-4">
            <button data-prev type="button"
                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-dre-50 text-gray-600 hover:text-dre-primary
                           flex items-center justify-center transition-colors">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
            <div class="flex items-center gap-1.5">
                @foreach($chunks as $i => $_)
                    <button data-dot type="button"
                            class="w-2 h-2 rounded-full transition-all {{ $i === 0 ? 'bg-dre-accent scale-125' : 'bg-gray-200' }}">
                    </button>
                @endforeach
            </div>
            <button data-next type="button"
                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-dre-50 text-gray-600 hover:text-dre-primary
                           flex items-center justify-center transition-colors">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
        </div>
    @endif
</div>
