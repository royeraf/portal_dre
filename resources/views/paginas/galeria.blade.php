@extends('principal.plantilla')
@section('title', 'Galería Fotográfica | DRE Huánuco')
@section('content')

{{-- ── BREADCRUMB HERO ──────────────────────────────────────── --}}
<div class="relative h-36 sm:h-52 bg-cover bg-center overflow-hidden"
     style="background-image: url('{{ asset('img/bc.jpeg') }}')">
    <div class="absolute inset-0 bg-dre-dark/80"></div>
    <div class="relative h-full max-w-screen-xl mx-auto px-4 md:px-8 flex flex-col justify-center">
        <h1 class="font-display text-white text-3xl sm:text-4xl font-extrabold uppercase tracking-widest drop-shadow-lg">
            Galería Fotográfica
        </h1>
        <nav class="flex items-center gap-1.5 text-xs text-white/60 mt-2">
            <a href="/" class="hover:text-yellow-400 transition-colors">Home</a>
            <i data-lucide="chevron-right" class="w-3 h-3"></i>
            <span class="text-white/90">Galería</span>
        </nav>
    </div>
</div>

{{-- ── CONTENIDO + MODAL ────────────────────────────────────── --}}
<div x-data="{
        open: false,
        loading: false,
        galeria: { titulo: '', descripcion: '', imagenes: [] },
        current: 0,
        get total() { return this.galeria.imagenes.length },
        prev() { this.current = (this.current - 1 + this.total) % this.total; this.scrollThumb(); },
        next() { this.current = (this.current + 1) % this.total; this.scrollThumb(); },
        scrollThumb() {
            this.$nextTick(() => {
                const strip = this.$refs.thumbs;
                if (!strip) return;
                const thumb = strip.children[this.current];
                if (thumb) thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            });
        },
        async openGaleria(url) {
            this.loading = true;
            this.open = true;
            this.current = 0;
            const res = await fetch(url);
            this.galeria = await res.json();
            this.loading = false;
        },
        close() { this.open = false; this.galeria = { titulo: '', descripcion: '', imagenes: [] }; }
     }"
     @keydown.escape.window="close()">

    {{-- ── GRID ── --}}
    <section class="py-16 md:py-24 bg-gray-900 relative">
        <div class="max-w-screen-2xl mx-auto px-4 md:px-8 relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 transition-all">
                @forelse ($registrosgaleria as $index => $item)
                    <div x-data="{ shown: false }" x-intersect.once="shown = true"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         style="transition: all 0.9s cubic-bezier(0.16, 1, 0.3, 1); transition-delay: {{ ($index % 4) * 120 }}ms; padding-bottom: 20px;">

                        <button @click="openGaleria('{{ route('galeria.json', $item) }}')"
                                class="group relative flex flex-col w-full overflow-hidden rounded-3xl bg-dre-darker shadow-xl hover:shadow-2xl transition-all duration-500 border border-white/10 text-left"
                                style="height: 400px;">

                            {{-- Imagen --}}
                            <div class="absolute inset-0 overflow-hidden">
                                <img src="{{ asset('img/imageneventos/' . $item->img) }}"
                                     alt="{{ $item->titulo }}"
                                     class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-110 opacity-70 group-hover:opacity-100">
                            </div>

                            {{-- Gradiente --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent group-hover:via-black/70 transition-colors duration-700 z-0"></div>

                            {{-- Fecha --}}
                            <div class="relative pt-6 px-6 z-10 flex justify-end">
                                @if($item->fecha_publicacion)
                                    <div class="bg-black/50 backdrop-blur-md border border-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-widest translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500 shadow-lg">
                                        {{ $item->fecha_publicacion }}
                                    </div>
                                @endif
                            </div>

                            {{-- Texto --}}
                            <div class="relative mt-auto p-6 lg:p-8 z-10 flex flex-col justify-end pr-20">
                                <h3 class="text-2xl font-display font-extrabold text-white leading-tight mb-2 drop-shadow-lg group-hover:text-yellow-400 transition-colors duration-300">
                                    {{ Str::limit($item->titulo, 60) }}
                                </h3>
                                <p class="text-gray-300 text-sm font-light leading-relaxed drop-shadow-md">
                                    {{ Str::limit($item->descripcion, 100) }}
                                </p>
                                <div class="absolute bottom-6 sm:bottom-8 right-6 sm:right-8 bg-yellow-400 text-black w-12 h-12 rounded-full flex items-center justify-center opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 shadow-xl scale-90 group-hover:scale-100 pointer-events-none">
                                    <i data-lucide="expand" class="w-5 h-5"></i>
                                </div>
                            </div>

                            <div class="absolute bottom-0 left-0 h-1 bg-yellow-400 w-0 group-hover:w-full transition-all duration-700 z-20"></div>
                        </button>
                    </div>
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 py-32 text-center">
                        <div class="inline-flex items-center justify-center w-28 h-28 rounded-full bg-gray-800 mb-8 border border-gray-700 shadow-2xl">
                            <i data-lucide="image" class="w-12 h-12 text-gray-400"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-display font-bold text-white">Galería Vacía</h2>
                        <p class="text-gray-400 mt-4 max-w-lg mx-auto text-lg font-light">
                            Pronto compartiremos más momentos e iniciativas institucionales en esta sección.
                        </p>
                    </div>
                @endforelse
            </div>

            @if ($registrosgaleria->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $registrosgaleria->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- ── MODAL ── --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-8"
         @click.self="close()"
         style="display:none;">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

        {{-- Panel --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

            {{-- Header del modal --}}
            <div class="flex items-start justify-between gap-4 px-6 py-4 border-b border-gray-100 shrink-0">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-display bg-dre-primary text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                            <i data-lucide="images" class="w-3.5 h-3.5"></i>
                            Galería Institucional
                        </span>
                    </div>
                    <h2 class="font-display text-xl font-extrabold text-dre-primary leading-tight" x-text="galeria.titulo"></h2>
                    <p class="text-gray-400 text-sm mt-0.5 line-clamp-1" x-text="galeria.descripcion"></p>
                </div>
                <button @click="close()"
                        class="shrink-0 w-9 h-9 rounded-full border border-gray-200 hover:bg-red-50 hover:border-red-300 hover:text-red-500 text-gray-400 flex items-center justify-center transition-all duration-200">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            {{-- Cuerpo scrollable --}}
            <div class="overflow-y-auto flex-1 p-5">

                {{-- Spinner --}}
                <div x-show="loading" class="flex items-center justify-center py-24">
                    <div class="w-10 h-10 border-4 border-dre-primary/20 border-t-dre-primary rounded-full animate-spin"></div>
                </div>

                {{-- Visor --}}
                <div x-show="!loading && galeria.imagenes.length > 0" class="flex flex-col gap-4">

                    {{-- Imagen principal --}}
                    <div class="relative rounded-xl overflow-hidden bg-gray-100 shadow-lg" style="aspect-ratio:16/9;">

                        <template x-for="(img, i) in galeria.imagenes" :key="i">
                            <div x-show="current === i"
                                 x-transition:enter="transition ease-out duration-400"
                                 x-transition:enter-start="opacity-0 scale-[1.02]"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute inset-0">
                                <img :src="'{{ asset('img/imageneventos/') }}/' + img"
                                     :alt="galeria.titulo + ' — imagen ' + (i + 1)"
                                     class="w-full h-full object-cover">
                            </div>
                        </template>

                        {{-- Flecha anterior --}}
                        <button x-show="total > 1" @click="prev()"
                                class="group absolute left-0 top-0 h-full w-20 flex items-center justify-start pl-3 z-10
                                       bg-gradient-to-r from-black/40 to-transparent hover:from-black/60 transition-all duration-300">
                            <span class="flex items-center justify-center w-11 h-11 rounded-full
                                         bg-white/15 border border-white/30 backdrop-blur-md text-white shadow-lg
                                         group-hover:bg-yellow-400 group-hover:border-yellow-400 group-hover:text-black
                                         transition-all duration-300 group-hover:scale-110">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </span>
                        </button>

                        {{-- Flecha siguiente --}}
                        <button x-show="total > 1" @click="next()"
                                class="group absolute right-0 top-0 h-full w-20 flex items-center justify-end pr-3 z-10
                                       bg-gradient-to-l from-black/40 to-transparent hover:from-black/60 transition-all duration-300">
                            <span class="flex items-center justify-center w-11 h-11 rounded-full
                                         bg-white/15 border border-white/30 backdrop-blur-md text-white shadow-lg
                                         group-hover:bg-yellow-400 group-hover:border-yellow-400 group-hover:text-black
                                         transition-all duration-300 group-hover:scale-110">
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </span>
                        </button>

                        {{-- Dots + contador --}}
                        <div x-show="total > 1" class="absolute bottom-4 left-0 right-0 flex flex-col items-center gap-2 z-10">
                            <div class="flex gap-1.5">
                                <template x-for="(img, i) in galeria.imagenes" :key="i">
                                    <button @click="current = i; scrollThumb()"
                                            :class="current === i ? 'bg-yellow-400 w-5' : 'bg-white/50 w-2 hover:bg-white/80'"
                                            class="h-2 rounded-full transition-all duration-300"></button>
                                </template>
                            </div>
                            <div class="bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full">
                                <span x-text="current + 1"></span> / <span x-text="total"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Miniaturas --}}
                    <div x-show="total > 1" class="flex items-center gap-2 mt-1">
                        <button @click="prev()"
                                class="shrink-0 w-9 h-9 rounded-lg border border-gray-200 bg-white hover:bg-dre-primary hover:border-dre-primary hover:text-white text-gray-500 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <i data-lucide="chevron-left" class="w-4 h-4"></i>
                        </button>
                        <div class="flex-1 overflow-x-auto pb-1 scrollbar-hide">
                            <div class="flex gap-2" x-ref="thumbs">
                                <template x-for="(img, i) in galeria.imagenes" :key="i">
                                    <button @click="current = i; scrollThumb()"
                                            :class="current === i ? 'ring-2 ring-dre-primary ring-offset-2 opacity-100' : 'opacity-50 hover:opacity-80'"
                                            class="shrink-0 w-16 h-16 rounded-lg overflow-hidden transition-all duration-200">
                                        <img :src="'{{ asset('img/imageneventos/') }}/' + img"
                                             :alt="'miniatura ' + (i + 1)"
                                             class="w-full h-full object-cover">
                                    </button>
                                </template>
                            </div>
                        </div>
                        <button @click="next()"
                                class="shrink-0 w-9 h-9 rounded-lg border border-gray-200 bg-white hover:bg-dre-primary hover:border-dre-primary hover:text-white text-gray-500 flex items-center justify-center transition-all duration-200 shadow-sm">
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </div>

                </div>

                {{-- Sin imágenes --}}
                <div x-show="!loading && galeria.imagenes.length === 0" class="py-16 text-center text-gray-400">
                    <i data-lucide="image-off" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                    <p class="text-sm">Esta galería no tiene imágenes.</p>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between shrink-0 bg-gray-50/80">
                <span class="text-xs text-gray-400" x-show="!loading">
                    <span x-text="total"></span> imagen<span x-show="total !== 1">es</span>
                </span>
                <a :href="'{{ url('/portafoliodet/') }}/' + galeria.id"
                   class="flex items-center gap-1.5 text-xs font-semibold text-dre-primary hover:text-dre-dark transition-colors">
                    Ver página completa
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                </a>
            </div>

        </div>
    </div>

</div>

@endsection
