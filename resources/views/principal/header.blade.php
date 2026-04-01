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
<header class="w-full z-40 relative" x-data="{ mobileOpen: false }">

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
    <div class="bg-white shadow-sm">
        <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between py-2">

            {{-- Logo left --}}
            <a href="/" class="shrink-0">
                <img src="{{ asset('img/logonuevo.png') }}" alt="DRE Huánuco" class="h-14 md:h-16 w-auto">
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-1 text-sm font-semibold uppercase tracking-wide">
                <a href="{{ URL::to('/') }}"
                   class="px-3 py-2 rounded-md text-dre-primary hover:bg-dre-50 transition-colors">HOME</a>

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
                                        <a href="{{ $submenu->link_menu }}"
                                           class="block px-4 py-2 text-sm text-gray-600 hover:bg-dre-50 hover:text-dre-primary transition-colors normal-case tracking-normal font-normal">
                                            {{ $submenu->nom_menu }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $row->link_menu }}"
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
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-gray-700 hover:text-dre-primary">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile nav --}}
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden border-t border-gray-100 bg-white max-h-[80vh] overflow-y-auto"
             x-cloak>
            <div class="px-4 py-3 space-y-1">
                <a href="{{ URL::to('/') }}"
                   class="block px-3 py-2 rounded-md text-dre-primary font-semibold hover:bg-dre-50">HOME</a>

                @foreach($menus as $row)
                    @if($row->link_menu == '#')
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2 rounded-md text-gray-700 hover:bg-dre-50 font-semibold">
                                <span>{{ $row->nom_menu }}</span>
                                <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-collapse x-cloak class="pl-4">
                                @foreach($submenus as $submenu)
                                    @if($submenu->categoriamenu == $row->id)
                                        <a href="{{ $submenu->link_menu }}"
                                           class="block px-3 py-2 text-sm text-gray-600 hover:text-dre-primary hover:bg-dre-50 rounded-md">
                                            {{ $submenu->nom_menu }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $row->link_menu }}"
                           class="block px-3 py-2 rounded-md text-gray-700 hover:bg-dre-50 font-semibold">
                            {{ $row->nom_menu }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- Quick access bar --}}
    <div class="bg-dre-primary">
        <div class="max-w-screen-xl mx-auto px-4">
            <nav class="flex">
                <a class="flex-1 text-center text-white text-[10px] sm:text-[11px] font-bold py-2 sm:py-2.5 hover:bg-white/10 transition-colors flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 border-r border-white/10"
                   href="http://digital.regionhuanuco.gob.pe/login">
                    <i data-lucide="monitor" class="w-4 h-4 shrink-0"></i>
                    <span class="hidden sm:inline">SGD DRE</span>
                    <span class="sm:hidden text-[9px] leading-tight text-center">SGD<br>DRE</span>
                </a>
                <a class="flex-1 text-center text-white text-[10px] sm:text-[11px] font-bold py-2 sm:py-2.5 hover:bg-white/10 transition-colors flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 border-r border-white/10"
                   href="http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/57">
                    <i data-lucide="inbox" class="w-4 h-4 shrink-0"></i>
                    <span class="hidden sm:inline">MESA DE PARTES DRE</span>
                    <span class="sm:hidden text-[9px] leading-tight text-center">PARTES<br>DRE</span>
                </a>
                <a class="flex-1 text-center text-white text-[10px] sm:text-[11px] font-bold py-2 sm:py-2.5 hover:bg-white/10 transition-colors flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5 border-r border-white/10"
                   href="{{ route('menus.showpaginaweb', 39) }}">
                    <i data-lucide="file-text" class="w-4 h-4 shrink-0"></i>
                    <span class="hidden sm:inline">MESA DE PARTES UGELES</span>
                    <span class="sm:hidden text-[9px] leading-tight text-center">PARTES<br>UGELES</span>
                </a>
                <a class="flex-1 text-center text-white text-[10px] sm:text-[11px] font-bold py-2 sm:py-2.5 hover:bg-white/10 transition-colors flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-1.5"
                   href="https://accounts.google.com/">
                    <i data-lucide="mail" class="w-4 h-4 shrink-0"></i>
                    <span class="hidden sm:inline">CORREO INSTITUCIONAL</span>
                    <span class="sm:hidden text-[9px] leading-tight text-center">CORREO<br>INST.</span>
                </a>
            </nav>
        </div>
    </div>

</header>
