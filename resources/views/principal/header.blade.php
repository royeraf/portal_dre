{{-- ── LOGIN MODAL ──────────────────────────────────────────── --}}
<div x-data="{ open: false }" x-cloak
     @open-login.window="open = true">
    <template x-teleport="body">
        <div x-show="open" x-transition.opacity
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 p-4"
             @click.self="open = false">
            <div x-show="open" x-transition.scale.90
                 class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
                <div class="bg-dre-primary p-6 text-white text-center">
                    <h3 class="text-xl font-bold">INTRANET</h3>
                    <p class="text-sm text-blue-200 mt-1">DRE Huánuco</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="text" name="email" required autofocus
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-dre-accent focus:border-dre-accent outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input type="password" name="password" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-dre-accent focus:border-dre-accent outline-none">
                    </div>
                    <button type="submit"
                            class="w-full bg-dre-primary text-white font-bold py-2.5 rounded-lg hover:bg-dre-accent transition-colors">
                        Ingresar
                    </button>
                </form>
                <button @click="open = false"
                        class="absolute top-3 right-3 text-white/70 hover:text-white text-xl">&times;</button>
            </div>
        </div>
    </template>
</div>

{{-- ── HEADER ──────────────────────────────────────────────── --}}
<header class="w-full z-40 relative"
        x-data="{
            drawerOpen: false,
            openDrawer()  { this.drawerOpen = true;  document.body.classList.add('overflow-hidden'); },
            closeDrawer() { this.drawerOpen = false; document.body.classList.remove('overflow-hidden'); }
        }"
        @keydown.escape.window="closeDrawer()">

    {{-- Top bar --}}
    <div class="bg-dre-dark text-white text-xs">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between py-1.5 sm:py-2 gap-2">

            {{-- Horario --}}
            <div class="flex items-center gap-1.5 min-w-0">
                <i data-lucide="clock" class="w-3.5 h-3.5 text-yellow-400 shrink-0"></i>
                {{-- Texto completo en sm+, abreviado en móvil --}}
                <span class="hidden sm:inline truncate">HORARIO DE ATENCIÓN: Lunes - Viernes: 8:30 am - 5:30 pm</span>
                <span class="sm:hidden text-[11px]">L-V: 8:30 am – 5:30 pm</span>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="{{ route('intranet') }}"
                   @if(Auth::user() == null) @click.prevent="$dispatch('open-login')" @endif
                   class="hover:text-yellow-400 transition-colors flex items-center gap-1">
                    <i data-lucide="log-in" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Intranet</span>
                </a>
                <span class="text-white/30 hidden sm:inline">|</span>
                <a href="https://auladre.drehuanuco.gob.pe/login/index.php"
                   class="bg-yellow-500 text-black font-bold px-2 sm:px-3 py-1 rounded hover:bg-yellow-400 transition-colors flex items-center gap-1">
                    <i data-lucide="graduation-cap" class="w-3.5 h-3.5 shrink-0"></i>
                    <span class="hidden sm:inline">Aula Virtual</span>
                </a>
                <a target="_blank" href="https://www.transparencia.gob.pe/enlaces/pte_transparencia_enlaces.aspx?id_entidad=14163#.Y9SgbXbMLrd">
                    <img src="{{ asset('img/portal.png') }}" class="h-6 sm:h-8" alt="Portal de Transparencia">
                </a>
            </div>

        </div>
    </div>

    {{-- Main navbar --}}
    <div class="bg-white shadow-md">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between py-2">

            {{-- Sello institucional --}}
            <a href="/" class="flex items-center gap-2.5 shrink-0 group">
                <span class="flex items-center justify-center bg-dre-primary rounded-lg p-2 shrink-0
                             shadow-sm group-hover:shadow-md group-hover:shadow-dre-primary/30 transition-all">
                    <img src="{{ asset('img/log33.png') }}" alt="DRE Huánuco"
                         class="h-9 w-9 object-contain brightness-0 invert">
                </span>
                {{-- Móvil: nombre corto --}}
                <span class="md:hidden flex flex-col leading-none">
                    <span class="text-dre-primary font-black text-[13px] uppercase tracking-tight">DRE</span>
                    <span class="text-dre-accent font-semibold text-[11px] uppercase tracking-wide mt-0.5">Huánuco</span>
                </span>
                {{-- Desktop: nombre completo --}}
                <span class="hidden md:block border-l-2 border-dre-primary/25 pl-3">
                    <span class="block text-dre-primary font-black text-[11px] uppercase tracking-tight leading-none">Dirección Regional de Educación</span>
                    <span class="block text-dre-accent text-[11px] font-semibold uppercase tracking-[0.1em] mt-1.5">Huánuco</span>
                </span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold uppercase tracking-wide">
                <a href="{{ URL::to('/') }}"
                   class="px-3 py-2 rounded-md bg-dre-50 text-dre-primary hover:bg-dre-primary hover:text-white transition-colors flex items-center gap-1.5">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i>Inicio</a>

                @foreach($menus as $row)
                    @if($row->link_menu == '#')
                        {{-- Dropdown --}}
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <button @click="open = !open"
                                    class="px-3 py-2 rounded-md text-gray-700 hover:bg-dre-50 hover:text-dre-primary transition-colors flex items-center gap-1">
                                {{ $row->nom_menu }}
                                <svg class="w-3.5 h-3.5 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="absolute left-0 top-full mt-0.5 w-64 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50"
                                 x-cloak>
                                @foreach($submenus as $submenu)
                                    @if($submenu->categoriamenu == $row->id)
                                        @php
                                            $siteDomain = env('APP_DOMAIN', 'drehuanuco.gob.pe');
                                            $href       = $submenu->link_menu;
                                            $linkHost   = Str::startsWith($href, 'http') ? parse_url($href, PHP_URL_HOST) : null;
                                            $isExt      = $linkHost && $linkHost !== $siteDomain && $linkHost !== request()->getHost();
                                            if (!$isExt && $linkHost) {
                                                $href = parse_url($href, PHP_URL_PATH) ?: '/';
                                            }
                                        @endphp
                                        <a href="{{ $href }}"
                                           @if($isExt) target="_blank" rel="noopener noreferrer" @endif
                                           class="block px-4 py-2 text-sm text-gray-600 hover:bg-dre-50 hover:text-dre-primary transition-colors normal-case tracking-normal font-normal">
                                            {{ $submenu->nom_menu }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        @php
                            $siteDomain = env('APP_DOMAIN', 'drehuanuco.gob.pe');
                            $href       = $row->link_menu;
                            $linkHost   = Str::startsWith($href, 'http') ? parse_url($href, PHP_URL_HOST) : null;
                            $isExt      = $linkHost && $linkHost !== $siteDomain && $linkHost !== request()->getHost();
                            if (!$isExt && $linkHost) {
                                $href = parse_url($href, PHP_URL_PATH) ?: '/';
                            }
                        @endphp
                        <a href="{{ $href }}"
                           @if($isExt) target="_blank" rel="noopener noreferrer" @endif
                           class="px-3 py-2 rounded-md text-gray-700 hover:bg-dre-50 hover:text-dre-primary transition-colors">
                            {{ $row->nom_menu }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                {{-- Logo right (gob) --}}
                <a href="https://www.gob.pe/regionhuanuco-dre" class="shrink-0 hidden md:block">
                    <img src="{{ asset('img/logogob.png') }}" alt="Gobierno" class="h-10 w-auto">
                </a>

                {{-- Mobile menu button --}}
                <button @click="openDrawer()" aria-label="Abrir menú"
                        class="lg:hidden p-2 rounded-md text-gray-700 hover:bg-dre-50 hover:text-dre-primary transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

    </div>

    {{-- ── NAVIGATION DRAWER (Material Design) ──────────────── --}}

    {{-- Backdrop --}}
    <div x-show="drawerOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeDrawer()"
         class="lg:hidden fixed inset-0 z-[9990] bg-black/50"
         x-cloak></div>

    {{-- Drawer panel --}}
    <div x-show="drawerOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="lg:hidden fixed inset-y-0 left-0 z-[9991] w-[300px] max-w-[85vw]
                bg-white shadow-2xl flex flex-col overflow-hidden"
         x-cloak>

        {{-- Cabecera del drawer --}}
        <div class="bg-dre-primary px-5 pt-5 pb-6 shrink-0">
            <div class="flex items-center justify-between mb-5">
                <span class="text-white/60 text-[10px] uppercase tracking-widest font-semibold">Menú principal</span>
                <button @click="closeDrawer()" aria-label="Cerrar menú"
                        class="w-8 h-8 flex items-center justify-center rounded-full
                               bg-white/10 hover:bg-white/20 text-white transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            {{-- Sello completo --}}
            <a href="/" @click="closeDrawer()" class="flex items-center gap-3 group">
                <span class="flex items-center justify-center bg-white/15 rounded-xl p-2.5
                             border border-white/20 group-hover:border-white/40 transition-colors shrink-0">
                    <img src="{{ asset('img/log33.png') }}" alt="DRE Huánuco"
                         class="h-11 w-11 object-contain brightness-0 invert">
                </span>
                <span class="flex flex-col">
                    <span class="text-white font-black text-[13px] uppercase tracking-tight leading-tight">
                        Dirección Regional<br>de Educación
                    </span>
                    <span class="flex items-center gap-1.5 mt-1.5">
                        <span class="h-px w-3 bg-yellow-400/50"></span>
                        <span class="text-yellow-400 text-[9px] uppercase tracking-[0.18em] font-bold">Huánuco</span>
                        <span class="h-px w-3 bg-yellow-400/50"></span>
                    </span>
                </span>
            </a>
        </div>

        {{-- Cuerpo del drawer (scrollable) --}}
        <nav class="flex-1 overflow-y-auto py-2">

            {{-- Inicio --}}
            <a href="{{ URL::to('/') }}" @click="closeDrawer()"
               class="flex items-center gap-3 px-5 py-3.5 text-dre-primary font-semibold
                      hover:bg-dre-50 transition-colors border-l-[3px] border-dre-accent">
                <i data-lucide="home" class="w-5 h-5 shrink-0 text-dre-accent"></i>
                <span class="text-sm uppercase tracking-wide">Inicio</span>
            </a>

            <div class="mx-5 my-1 border-t border-gray-100"></div>

            {{-- Menús dinámicos --}}
            @foreach($menus as $row)
                @if($row->link_menu == '#')
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                                class="w-full flex items-center gap-3 px-5 py-3.5
                                       hover:bg-dre-50 transition-colors border-l-[3px]"
                                :class="open ? 'bg-dre-50 border-dre-accent' : 'border-transparent'">
                            <i data-lucide="layers" class="w-5 h-5 shrink-0 transition-colors"
                               :class="open ? 'text-dre-accent' : 'text-gray-400'"></i>
                            <span class="flex-1 text-left text-sm font-semibold uppercase tracking-wide"
                                  :class="open ? 'text-dre-primary' : 'text-gray-700'">{{ $row->nom_menu }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 shrink-0 transition-transform duration-200"
                               :class="open ? 'rotate-180 text-dre-accent' : 'text-gray-400'"></i>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="bg-gray-50 border-l-[3px] border-dre-accent">
                            @foreach($submenus as $submenu)
                                @if($submenu->categoriamenu == $row->id)
                                    @php
                                        $appUrl  = rtrim(config('app.url'), '/');
                                        $href    = $submenu->link_menu;
                                        $isExt   = Str::startsWith($href, 'http') && !Str::startsWith($href, $appUrl);
                                        if (!$isExt && Str::startsWith($href, $appUrl)) {
                                            $href = Str::after($href, $appUrl) ?: '/';
                                        }
                                    @endphp
                                    <a href="{{ $href }}" @click="closeDrawer()"
                                       @if($isExt) target="_blank" rel="noopener noreferrer" @endif
                                       class="flex items-center gap-2 px-5 py-3 pl-14
                                              text-sm text-gray-600 normal-case tracking-normal font-normal
                                              hover:bg-dre-50 hover:text-dre-primary transition-colors
                                              border-b border-gray-100/80 last:border-b-0">
                                        <i data-lucide="chevron-right" class="w-3.5 h-3.5 shrink-0 text-dre-accent/50"></i>
                                        {{ $submenu->nom_menu }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $row->link_menu }}" @click="closeDrawer()"
                       class="flex items-center gap-3 px-5 py-3.5 text-gray-700 font-semibold
                              hover:bg-dre-50 hover:text-dre-primary transition-colors
                              border-l-[3px] border-transparent hover:border-dre-50">
                        <i data-lucide="chevron-right" class="w-5 h-5 shrink-0 text-gray-400"></i>
                        <span class="text-sm uppercase tracking-wide">{{ $row->nom_menu }}</span>
                    </a>
                @endif
            @endforeach

            <div class="mx-5 my-2 border-t border-gray-100"></div>

            {{-- Accesos de utilidad --}}
            <a href="{{ route('intranet') }}"
               @if(Auth::user() == null)
                   @click.prevent="closeDrawer(); $dispatch('open-login')"
               @else
                   @click="closeDrawer()"
               @endif
               class="flex items-center gap-3 px-5 py-3 text-gray-600
                      hover:bg-dre-50 hover:text-dre-primary transition-colors border-l-[3px] border-transparent">
                <i data-lucide="log-in" class="w-4 h-4 shrink-0 text-gray-400"></i>
                <span class="text-sm font-medium">Intranet</span>
            </a>
            <a href="https://auladre.drehuanuco.gob.pe/login/index.php" target="_blank" @click="closeDrawer()"
               class="flex items-center gap-3 px-5 py-3 text-gray-600
                      hover:bg-dre-50 hover:text-dre-primary transition-colors border-l-[3px] border-transparent">
                <i data-lucide="graduation-cap" class="w-4 h-4 shrink-0 text-gray-400"></i>
                <span class="text-sm font-medium">Aula Virtual</span>
            </a>

        </nav>

        {{-- Pie del drawer --}}
        <div class="shrink-0 px-5 py-4 border-t border-gray-100 bg-gray-50">
            <a href="https://www.gob.pe/regionhuanuco-dre" target="_blank"
               class="flex items-center justify-center opacity-60 hover:opacity-100 transition-opacity">
                <img src="{{ asset('img/logogob.png') }}" alt="Gobierno del Perú" class="h-8 w-auto">
            </a>
            <p class="text-center text-[10px] text-gray-400 mt-2 uppercase tracking-widest">Gobierno del Perú</p>
        </div>

    </div>

    {{-- Quick access bar --}}
    <div class="bg-dre-primary border-t border-white/10">
        <div class="max-w-screen-xl mx-auto px-3 py-2.5">
            <div class="grid grid-cols-4 gap-1.5 sm:gap-2">

                {{-- SGD DRE --}}
                <a href="http://digital.regionhuanuco.gob.pe/login" target="_blank"
                   class="group flex flex-col sm:flex-row items-center justify-center sm:justify-start
                          gap-1.5 sm:gap-2.5 bg-white/5 hover:bg-yellow-400/10 active:scale-95
                          rounded-xl px-2 sm:px-3 py-3 sm:py-2.5 transition-all duration-150
                          border border-white/5 hover:border-yellow-400/30 text-center sm:text-left">
                    <span class="flex items-center justify-center bg-yellow-400/15 group-hover:bg-yellow-400/25
                                 rounded-lg p-2 sm:shrink-0 transition-colors">
                        <i data-lucide="monitor" class="w-5 h-5 sm:w-4 sm:h-4 text-yellow-400"></i>
                    </span>
                    <span class="flex-1 min-w-0">
                        <span class="block text-white font-bold text-[9px] sm:text-[11px] uppercase tracking-wide leading-tight">SGD DRE</span>
                    </span>
                    <i data-lucide="arrow-right" class="hidden sm:block w-3.5 h-3.5 text-white/20
                                                        group-hover:text-yellow-400 group-hover:translate-x-0.5
                                                        transition-all shrink-0"></i>
                </a>

                {{-- Mesa de Partes DRE --}}
                <a href="http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/57" target="_blank"
                   class="group flex flex-col sm:flex-row items-center justify-center sm:justify-start
                          gap-1.5 sm:gap-2.5 bg-white/5 hover:bg-sky-400/10 active:scale-95
                          rounded-xl px-2 sm:px-3 py-3 sm:py-2.5 transition-all duration-150
                          border border-white/5 hover:border-sky-400/30 text-center sm:text-left">
                    <span class="flex items-center justify-center bg-sky-400/15 group-hover:bg-sky-400/25
                                 rounded-lg p-2 sm:shrink-0 transition-colors">
                        <i data-lucide="inbox" class="w-5 h-5 sm:w-4 sm:h-4 text-sky-400"></i>
                    </span>
                    <span class="flex-1 min-w-0">
                        <span class="block text-white font-bold text-[9px] sm:text-[11px] uppercase tracking-wide leading-tight">Mesa de Partes DRE</span>
                    </span>
                    <i data-lucide="arrow-right" class="hidden sm:block w-3.5 h-3.5 text-white/20
                                                        group-hover:text-sky-400 group-hover:translate-x-0.5
                                                        transition-all shrink-0"></i>
                </a>

                {{-- Mesa de Partes UGELES --}}
                <a href="{{ route('menus.showpaginaweb', 39) }}"
                   class="group flex flex-col sm:flex-row items-center justify-center sm:justify-start
                          gap-1.5 sm:gap-2.5 bg-white/5 hover:bg-emerald-400/10 active:scale-95
                          rounded-xl px-2 sm:px-3 py-3 sm:py-2.5 transition-all duration-150
                          border border-white/5 hover:border-emerald-400/30 text-center sm:text-left">
                    <span class="flex items-center justify-center bg-emerald-400/15 group-hover:bg-emerald-400/25
                                 rounded-lg p-2 sm:shrink-0 transition-colors">
                        <i data-lucide="file-text" class="w-5 h-5 sm:w-4 sm:h-4 text-emerald-400"></i>
                    </span>
                    <span class="flex-1 min-w-0">
                        <span class="block text-white font-bold text-[9px] sm:text-[11px] uppercase tracking-wide leading-tight">Mesa de Partes UGELES</span>
                    </span>
                    <i data-lucide="arrow-right" class="hidden sm:block w-3.5 h-3.5 text-white/20
                                                        group-hover:text-emerald-400 group-hover:translate-x-0.5
                                                        transition-all shrink-0"></i>
                </a>

                {{-- Correo Institucional --}}
                <a href="https://accounts.google.com/" target="_blank"
                   class="group flex flex-col sm:flex-row items-center justify-center sm:justify-start
                          gap-1.5 sm:gap-2.5 bg-white/5 hover:bg-orange-400/10 active:scale-95
                          rounded-xl px-2 sm:px-3 py-3 sm:py-2.5 transition-all duration-150
                          border border-white/5 hover:border-orange-400/30 text-center sm:text-left">
                    <span class="flex items-center justify-center bg-orange-400/15 group-hover:bg-orange-400/25
                                 rounded-lg p-2 sm:shrink-0 transition-colors">
                        <i data-lucide="mail" class="w-5 h-5 sm:w-4 sm:h-4 text-orange-400"></i>
                    </span>
                    <span class="flex-1 min-w-0">
                        <span class="block text-white font-bold text-[9px] sm:text-[11px] uppercase tracking-wide leading-tight">Correo Institucional</span>
                    </span>
                    <i data-lucide="arrow-right" class="hidden sm:block w-3.5 h-3.5 text-white/20
                                                        group-hover:text-orange-400 group-hover:translate-x-0.5
                                                        transition-all shrink-0"></i>
                </a>

            </div>
        </div>
    </div>

</header>
