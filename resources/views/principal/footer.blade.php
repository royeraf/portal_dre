{{-- ── FOOTER ──────────────────────────────────────────────── --}}
<footer>

    {{-- Top accent stripe --}}
    <div class="h-1 bg-gradient-to-r from-dre-primary via-dre-accent to-dre-primary"></div>

    {{-- Main body --}}
    <div class="bg-dre-dark">
        <div class="max-w-screen-xl mx-auto px-4 py-6 lg:py-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                {{-- Col 1 — Brand --}}
                <div>
                    <a href="/" class="inline-block mb-5">
                        <img src="{{ asset('img/logonuevo.png') }}" alt="DRE Huánuco" class="h-14 brightness-0 invert">
                    </a>
                    <div class="space-y-2 text-sm mb-5">
                        <p><span class="text-gray-400 text-[10px] uppercase tracking-widest block">RUC</span><span class="text-white font-medium">20182362141</span></p>
                        <p><span class="text-gray-400 text-[10px] uppercase tracking-widest block">Director Regional</span><span class="text-white font-medium">Dr. Kelvin Álvarez Matos</span></p>
                        <p><span class="text-gray-400 text-[10px] uppercase tracking-widest block">Administrador</span><span class="text-white font-medium">DR. Jim C. Atencia Arbi</span></p>
                        <div class="flex items-start gap-2 pt-1">
                            <i data-lucide="map-pin" class="w-4 h-4 text-yellow-400 mt-0.5 shrink-0"></i>
                            <span class="text-gray-200">Jr. Progreso #462 — frente al parque Amarilis</span>
                        </div>
                    </div>

                    {{-- Mini mapa --}}
                    <div class="rounded-lg overflow-hidden mb-5 border border-white/10">
                        <iframe
                            src="https://maps.google.com/maps?q=-9.9256909,-76.2390337&hl=es&z=17&output=embed"
                            class="w-full h-28 sm:h-36 block border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Ubicación DRE Huánuco">
                        </iframe>
                    </div>
                    {{-- Social icons --}}
                    <div class="flex items-center gap-2">
                        <a href="https://www.facebook.com/direccionregionaldeeducacion/?locale=es_LA" target="_blank"
                           class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-gray-300 hover:bg-[#3b5998] hover:text-white transition-all duration-200" title="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="http://www.twitter.com" target="_blank"
                           class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-gray-300 hover:bg-[#00abf0] hover:text-white transition-all duration-200" title="Twitter">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                        </a>
                        <a href="https://www.tiktok.com/@drehuanuco" target="_blank"
                           class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-gray-300 hover:bg-black hover:text-white transition-all duration-200" title="TikTok">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1 0-5.78c.29 0 .57.04.84.12v-3.5a6.37 6.37 0 0 0-.84-.05A6.34 6.34 0 0 0 3.15 15.3 6.34 6.34 0 0 0 9.49 21.65a6.34 6.34 0 0 0 6.34-6.34V9.06a8.16 8.16 0 0 0 4.77 1.52V7.13a4.82 4.82 0 0 1-1.01-.44z"/></svg>
                        </a>
                        <a href="mailto:rcoronel@drehuanuco.gob.pe"
                           class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-gray-300 hover:bg-gray-600 hover:text-white transition-all duration-200" title="Correo">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

                {{-- Col 2 — Lo más buscado --}}
                <div>
                    <h6 class="font-display text-white font-bold text-base mb-4 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1 h-5 bg-yellow-400 rounded-full shrink-0"></span>
                        Lo más Buscado
                    </h6>
                    <ul class="space-y-0.5">
                        <li>
                            <a href="http://digital.regionhuanuco.gob.pe/" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                SGD DRE
                            </a>
                        </li>
                        <li>
                            <a href="http://digital.regionhuanuco.gob.pe/registro/mesa-partes-virtual/57" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                Mesa de Partes
                            </a>
                        </li>
                        <li>
                            <a href="https://enlinea.drehuanuco.gob.pe/" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                Certificados en línea
                            </a>
                        </li>
                        <li>
                            <a href="https://www.drehuanuco.gob.pe/allnoticias" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                Nota de Prensa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('convocatoriaweb') }}"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                Convocatoria
                            </a>
                        </li>
                        <li>
                            <a href="https://auladre.drehuanuco.gob.pe/login/index.php" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                Aula Virtual
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Col 3 — Info destacada --}}
                <div>
                    <h6 class="font-display text-white font-bold text-base mb-4 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1 h-5 bg-yellow-400 rounded-full shrink-0"></span>
                        Información Destacada
                    </h6>
                    <ul class="space-y-0.5">
                        <li>
                            <a href="https://escale.minedu.gob.pe/" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                ESCALE
                            </a>
                        </li>
                        <li>
                            <a href="https://siagie.minedu.gob.pe/inicio/" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                SIAGIE
                            </a>
                        </li>
                        <li>
                            <a href="https://reclamos.servicios.gob.pe/reclamos" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                Libro de Reclamaciones
                            </a>
                        </li>
                        <li>
                            <a href="https://servicios-ayni.minedu.gob.pe/" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                MI BOLETA
                            </a>
                        </li>
                        <li>
                            <a href="https://www.gob.pe/minedu" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                MINEDU
                            </a>
                        </li>
                        <li>
                            <a href="https://www.gob.pe/pcm" target="_blank"
                               class="text-gray-400 hover:text-yellow-400 text-sm transition-colors flex items-center gap-2 py-1.5 group">
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-dre-accent group-hover:text-yellow-400 shrink-0 transition-colors"></i>
                                PCM
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Col 4 — Libro de reclamaciones --}}
                <div>
                    <h6 class="font-display text-white font-bold text-base mb-4 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1 h-5 bg-yellow-400 rounded-full shrink-0"></span>
                        Libro de Reclamaciones
                    </h6>
                    <div class="rounded-lg border border-white/10 bg-white/5 p-4 mb-4">
                        <i data-lucide="book-marked" class="w-7 h-7 text-yellow-400 mb-3"></i>
                        <p class="text-gray-300 text-sm leading-relaxed">De acuerdo al D.S. N° 007-2020-PCM, la DRE pone a disposición de la ciudadanía el Libro de Reclamaciones Digital para que las personas expresen su insatisfacción o disconformidad en la atención de un bien o servicio.</p>
                    </div>
                    <a target="_blank" href="https://reclamos.servicios.gob.pe/reclamos"
                       class="flex items-center justify-center gap-2 bg-yellow-400 text-black text-sm font-bold px-4 py-2.5 rounded-lg hover:bg-yellow-300 transition-colors w-full sm:w-auto">
                        <i data-lucide="external-link" class="w-4 h-4 shrink-0"></i>
                        <span>Consultar Reclamo</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="bg-dre-darker border-t border-white/5 py-4">
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-2">
            <p class="text-gray-500 text-xs text-center md:text-left">
                © 2021 - 2025 Todos los derechos Reservados —
                <span class="text-gray-400">DRE Huánuco</span>
            </p>
            <div class="flex flex-wrap items-center justify-center md:justify-end gap-x-4 gap-y-1 text-xs">
                <a href="#" class="text-gray-500 hover:text-white transition-colors">Política de Privacidad</a>
                <span class="text-white/10 hidden md:inline">|</span>
                <a href="#" class="text-gray-500 hover:text-white transition-colors">Términos & Condiciones</a>
            </div>
        </div>
    </div>

</footer>

{{-- Scroll to top --}}
<button onclick="window.scrollTo({top:0,behavior:'smooth'})"
        id="scrollTopBtn"
        class="fixed bottom-5 right-5 z-50 w-10 h-10 rounded-full bg-dre-primary text-white flex items-center justify-center shadow-lg hover:bg-dre-accent transition-all duration-300 opacity-0 invisible"
        aria-label="Volver arriba">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
    </svg>
</button>

<script>
window.addEventListener('scroll', function() {
    var btn = document.getElementById('scrollTopBtn');
    if (window.scrollY > 300) {
        btn.classList.remove('opacity-0', 'invisible');
        btn.classList.add('opacity-100', 'visible');
    } else {
        btn.classList.remove('opacity-100', 'visible');
        btn.classList.add('opacity-0', 'invisible');
    }
});
</script>
