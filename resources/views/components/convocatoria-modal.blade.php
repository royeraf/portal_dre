<div x-data="convocatoriaModal"
     @open-convocatoria-modal.window="open($event.detail)"
     @keydown.escape.window="if (modal) close()"
     x-show="modal"
     x-cloak
     class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center p-0 sm:p-4"
     role="dialog" aria-modal="true">

    <div class="absolute inset-0 bg-black/60"
         x-show="modal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close()">
    </div>

    <div class="relative w-full sm:max-w-2xl rounded-t-2xl sm:rounded-2xl shadow-[0_24px_70px_rgba(1,48,114,0.18)] border border-slate-100 overflow-hidden"
         style="will-change: transform"
         x-show="modal"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
         @click.stop>
        <div class="bg-white overflow-y-auto max-h-[92dvh] sm:max-h-[85vh]
                    [&::-webkit-scrollbar]:w-2
                    [&::-webkit-scrollbar-track]:bg-slate-100/80
                    [&::-webkit-scrollbar-thumb]:rounded-full
                    [&::-webkit-scrollbar-thumb]:bg-slate-400/80
                    hover:[&::-webkit-scrollbar-thumb]:bg-slate-500">

            <div class="sticky top-0 z-20 flex flex-col gap-3 px-6 py-4 border-b border-black/5"
                 :class="modal?.hbg ?? 'bg-white'">
                <div class="flex items-center justify-between w-full">
                    <span class="font-display font-bold text-gray-700 text-xs sm:text-sm uppercase tracking-wider">Convocatoria</span>
                    <button @click="close()"
                            class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-black/5 hover:bg-black/10 text-gray-500 hover:text-gray-800 transition-all duration-200">
                        <i data-lucide="x" class="w-4 h-4 pointer-events-none"></i>
                    </button>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-widest"
                          :class="modal?.pill"
                          x-text="modal?.tipo">
                    </span>
                    <template x-if="modal?.finalizado">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-red-700 border border-red-100/80 shadow-sm">
                            <i data-lucide="flag" class="w-3 h-3 text-red-500 shrink-0"></i>
                            FINALIZADO
                        </span>
                    </template>
                    <template x-if="modal?.abierto && !modal?.finalizado">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/80 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            ABIERTO
                        </span>
                    </template>
                    <template x-if="!modal?.abierto && !modal?.finalizado && modal?.estado !== 'PUBLICACION'">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-50 text-slate-600 border border-slate-200/80 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            <span x-text="modal?.estado"></span>
                        </span>
                    </template>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 px-6 py-3 bg-gray-50 border-b border-gray-100 text-xs">
                <div class="flex items-center gap-1.5 text-gray-500">
                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 text-dre-accent shrink-0"></i>
                    Inicia: <span class="font-semibold text-gray-700 ml-1" x-text="modal?.fi"></span>
                </div>
                <div class="flex items-center gap-1.5"
                     :class="modal?.abierto ? 'text-amber-500' : 'text-gray-500'">
                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 shrink-0"></i>
                    Termina: <span class="font-semibold ml-1"
                                  :class="modal?.abierto ? 'text-amber-600' : 'text-gray-700'"
                                  x-text="modal?.ft"></span>
                </div>
            </div>

            <div class="px-6 py-5 space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h2 class="font-display font-bold text-gray-900 text-base sm:text-xl leading-snug"
                        x-text="modal?.titulo">
                    </h2>
                </div>

                <template x-if="modal?.descripcion">
                    <div>
                        <p class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                            <i data-lucide="file-text" class="w-3.5 h-3.5 shrink-0"></i>
                            Descripción
                        </p>
                        <div class="w-full min-w-0 max-w-full overflow-x-auto overscroll-x-contain text-sm text-gray-700 leading-relaxed prose prose-sm"
                             role="region"
                             aria-label="Descripción de la convocatoria"
                             tabindex="0"
                             x-html="modal?.descripcion">
                        </div>
                    </div>
                </template>

                <template x-if="modal?.archivos?.length > 0">
                    <div>
                        <p class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                            <i data-lucide="paperclip" class="w-3.5 h-3.5 shrink-0"></i>
                            Documentos adjuntos
                            (<span x-text="modal?.archivos?.length"></span>)
                        </p>
                        <ul class="space-y-2">
                            <template x-for="(archivo, i) in modal?.archivos" :key="i">
                                <li>
                                    <a :href="archivo.url" target="_blank"
                                       class="flex items-start gap-3 p-3 rounded-xl border border-gray-100 bg-gray-50
                                              hover:bg-dre-50 hover:border-dre-accent/30 transition-all duration-200 group/file">
                                        <span class="relative w-8 h-8 rounded-lg border flex items-center justify-center shrink-0 transition-colors mt-0.5"
                                              :class="archivo.iconBg">
                                            <i class="w-4 h-4" :class="archivo.iconText" :data-lucide="archivo.icon"></i>
                                            <template x-if="archivo.externo">
                                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-sky-500 border border-white flex items-center justify-center"
                                                      title="Enlace externo">
                                                    <i data-lucide="external-link" class="w-2 h-2 text-white"></i>
                                                </span>
                                            </template>
                                        </span>
                                        <span class="flex-1 min-w-0 mt-0.5">
                                            <span class="flex items-center gap-1.5 flex-wrap">
                                                <span class="text-xs font-medium text-gray-700 group-hover/file:text-dre-accent transition-colors break-words leading-normal"
                                                      x-text="archivo.nom">
                                                </span>
                                                <template x-if="archivo.nuevo">
                                                    <span class="hidden sm:inline-flex shrink-0 items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/80 tag-nuevo-pulse">
                                                        NUEVO
                                                    </span>
                                                </template>
                                            </span>
                                            <span class="block text-[11px] text-gray-400 mt-0.5" x-text="archivo.fecha"></span>
                                            <template x-if="archivo.nuevo">
                                                <span class="sm:hidden inline-flex shrink-0 items-center gap-1 px-1.5 py-0.5 rounded-md text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100/80 tag-nuevo-pulse mt-1">
                                                    NUEVO
                                                </span>
                                            </template>
                                        </span>
                                        <i data-lucide="external-link" class="w-3.5 h-3.5 text-gray-300 group-hover/file:text-dre-accent shrink-0 transition-colors mt-1.5"></i>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>
            </div>

            <div class="sticky bottom-0 z-20 px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button @click="close()"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-dre-primary text-white text-sm font-semibold hover:bg-dre-accent transition-colors shadow-sm">
                    <i data-lucide="x" class="w-4 h-4 pointer-events-none"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
