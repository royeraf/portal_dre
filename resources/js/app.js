import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

Alpine.plugin(intersect);
Alpine.plugin(collapse);

window.Alpine = Alpine;

/* ── Lucide Icons ──────────────────────────────────────────── */
import { createIcons } from 'lucide';
import {
    // Header / General
    Clock, MapPin, LogIn, GraduationCap, Globe, Mail, Menu, X, Home, Layers,
    ChevronDown, ChevronLeft, ChevronRight, ChevronUp, Search,
    FileText, Monitor, Inbox,
    // Quick access grid
    Users, BarChart3, FolderOpen, Camera, Heart, PieChart, DollarSign,
    ClipboardList, BookOpen, Newspaper, Link, CalendarDays,
    // News & Comunicados
    ArrowLeft, ArrowRight, Eye, ExternalLink,
    // Counters
    School, UserCheck, Building,
    // Footer
    MapPinned, MailOpen,
    Briefcase, FileCheck, BarChart2, Receipt, Landmark, Building2, BookMarked,
    // Multimedia
    Video, Play,
    // Directorio
    Phone,
    // Convocatorias
    SlidersHorizontal, Filter, Paperclip, LayoutGrid, List, Sparkles,
    FileSpreadsheet, Presentation, FileArchive, FileImage, FileType, File, Flag,
    // Infraestructura slider
    Expand,
    // Direcciones / show
    Download, Info, AlertCircle, User, Network, Calendar, CalendarCheck, Tag,
    Zap, Megaphone, PlayCircle, Smartphone,
    Lightbulb, Images, ImageOff, Image
} from 'lucide';

const icons = {
    Clock, MapPin, LogIn, GraduationCap, Globe, Mail, Menu, X, Home, Layers,
    ChevronDown, ChevronLeft, ChevronRight, ChevronUp, Search,
    FileText, Monitor, Inbox,
    Users, BarChart3, FolderOpen, Camera, Heart, PieChart, DollarSign,
    ClipboardList, BookOpen, Newspaper, Link, CalendarDays,
    ArrowLeft, ArrowRight, Eye, ExternalLink,
    School, UserCheck, Building,
    MapPinned, MailOpen,
    Briefcase, FileCheck, BarChart2, Receipt, Landmark, Building2, BookMarked,
    Video, Play,
    Phone,
    SlidersHorizontal, Filter, Paperclip, LayoutGrid, List, Sparkles,
    FileSpreadsheet, Presentation, FileArchive, FileImage, FileType, File, Flag,
    Expand,
    Download, Info, AlertCircle, User, Network, Calendar, CalendarCheck, Tag,
    Zap, Megaphone, PlayCircle, Smartphone,
    Lightbulb, Images, ImageOff, Image
};

createIcons({ icons, attrs: { 'stroke-width': 1.75 } });
window.reInitLucideIcons = () => createIcons({ icons, attrs: { 'stroke-width': 1.75 } });

// ── Skeleton removal on image load ─────────────────────────
document.querySelectorAll('.img-wrap').forEach(wrap => {
    const img = wrap.querySelector('img');
    if (!img) return;
    const done = () => wrap.classList.remove('skeleton');
    if (img.complete && img.naturalWidth > 0) done();
    else { img.addEventListener('load', done); img.addEventListener('error', done); }
});

// Re-create icons when Alpine.js updates the DOM — debounced to avoid thrashing
document.addEventListener('alpine:initialized', () => {
    // Pass inicial: Alpine ya renderizó x-if/x-show durante la init
    setTimeout(() => createIcons({ icons, attrs: { 'stroke-width': 1.75 } }), 100);

    let iconTimer;
    const observer = new MutationObserver(() => {
        clearTimeout(iconTimer);
        iconTimer = setTimeout(() => {
            createIcons({ icons, attrs: { 'stroke-width': 1.75 } });
        }, 50);
    });
    observer.observe(document.body, { childList: true, subtree: true });
});

// Alpine.start() dispara 'alpine:initialized' de forma sincrona, por lo que
// debe llamarse despues de registrar el listener de arriba para que lo capture.
Alpine.start();

/* ── Asistente virtual DRE Huánuco ─────────────────────────────────────── */
function initDreChatbot() {
    const root = document.getElementById('dre-chatbot');
    if (!root || root.dataset.ready === 'true') return;
    root.dataset.ready = 'true';

    const panel = root.querySelector('.dre-chatbot__panel');
    const messages = root.querySelector('[data-chat-messages]');
    const form = root.querySelector('[data-chat-form]');
    const input = root.querySelector('[data-chat-input]');
    const send = root.querySelector('.dre-chatbot__send');
    const launcher = root.querySelector('[data-chat-open]');
    const status = root.querySelector('[data-chat-status]');
    let suggestions = root.querySelector('[data-chat-suggestions]');
    const initialMessagesMarkup = messages.innerHTML;
    const storageKey = 'dre-huanuco-chat-v2';
    let busy = false;
    let welcomeAnimated = false;
    let previousActiveElement = null;
    let inertedElements = [];
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const scrollToEnd = () => { messages.scrollTop = messages.scrollHeight; };

    const setOutsideInert = (enabled) => {
        if (!enabled) {
            inertedElements.forEach(({ element, inert, ariaHidden }) => {
                element.inert = inert;
                if (ariaHidden === null) element.removeAttribute('aria-hidden');
                else element.setAttribute('aria-hidden', ariaHidden);
            });
            inertedElements = [];
            return;
        }

        let current = root;
        while (current?.parentElement) {
            Array.from(current.parentElement.children).forEach((element) => {
                if (element === current || element.contains(root)) return;
                inertedElements.push({
                    element,
                    inert: element.inert,
                    ariaHidden: element.getAttribute('aria-hidden'),
                });
                element.inert = true;
                element.setAttribute('aria-hidden', 'true');
            });
            current = current.parentElement;
        }
    };

    const setOpen = (open) => {
        const wasOpen = root.dataset.open === 'true';
        root.dataset.open = open ? 'true' : 'false';
        panel.setAttribute('aria-hidden', open ? 'false' : 'true');
        launcher.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open && !wasOpen) {
            previousActiveElement = document.activeElement;
            setOutsideInert(true);
            window.setTimeout(() => {
                input.focus();
                animateWelcomeMessage();
            }, 180);
        } else if (!open && wasOpen) {
            setOutsideInert(false);
            if (previousActiveElement instanceof HTMLElement && document.contains(previousActiveElement)) {
                previousActiveElement.focus();
            } else {
                launcher.focus();
            }
        }
        saveSession();
    };

    async function typeInto(element, text, delay) {
        if (!element) return;
        if (reducedMotion) {
            element.textContent = text;
            return;
        }

        element.textContent = '';
        element.classList.add('dre-chatbot__typing');
        for (const character of Array.from(text)) {
            element.textContent += character;
            scrollToEnd();
            await new Promise((resolve) => window.setTimeout(resolve, delay));
        }
        element.classList.remove('dre-chatbot__typing');
    }

    async function animateWelcomeMessage() {
        if (welcomeAnimated) return;
        const title = messages.querySelector('[data-chat-welcome-title]');
        const body = messages.querySelector('[data-chat-welcome-body]');
        if (!title || !body) return;

        welcomeAnimated = true;
        const titleText = title.textContent.trim();
        const bodyText = body.textContent.trim();
        body.textContent = '';
        await typeInto(title, titleText, 24);
        await new Promise((resolve) => window.setTimeout(resolve, 120));
        await typeInto(body, bodyText, 13);
    }

    function createMessage(role, text, typing = false) {
        const article = document.createElement('article');
        article.className = `dre-chatbot__message dre-chatbot__message--${role}`;
        if (typing) article.classList.add('dre-chatbot__message--loading');

        if (role === 'assistant') {
            const avatar = document.createElement('div');
            avatar.className = 'dre-chatbot__avatar';
            avatar.setAttribute('aria-hidden', 'true');
            const avatarImage = document.createElement('img');
            avatarImage.src = root.querySelector('.dre-chatbot__seal img')?.src || '/img/iconchat.svg';
            avatarImage.alt = '';
            avatarImage.width = 34;
            avatarImage.height = 34;
            avatarImage.decoding = 'async';
            avatar.appendChild(avatarImage);
            article.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = 'dre-chatbot__bubble dre-chatbot__bubble--dynamic';
        if (typing) {
            for (let i = 0; i < 3; i += 1) {
                const dot = document.createElement('span');
                dot.className = 'dre-chatbot__dot';
                bubble.appendChild(dot);
            }
        } else {
            bubble.textContent = text;
        }
        article.appendChild(bubble);
        messages.appendChild(article);
        scrollToEnd();
        return { article, bubble };
    }

    function setBusy(isBusy, announcement = '') {
        busy = isBusy;
        send.disabled = isBusy;
        messages.setAttribute('aria-busy', isBusy ? 'true' : 'false');
        status.textContent = announcement;
    }

    function appendLinks(links = []) {
        if (!Array.isArray(links) || links.length === 0) return;
        const group = document.createElement('div');
        group.className = 'dre-chatbot__links';
        if (!reducedMotion) group.classList.add('dre-chatbot__links--entering');
        links.slice(0, 3).forEach((link) => {
            if (!link?.url || !link?.title) return;
            const anchor = document.createElement('a');
            anchor.className = 'dre-chatbot__link';
            anchor.href = link.url;
            anchor.target = '_blank';
            anchor.rel = 'noopener noreferrer';
            anchor.textContent = link.title;
            anchor.title = `${link.title} (se abre en una pestaña nueva)`;
            anchor.setAttribute('aria-label', `${link.title}, abrir fuente en una pestaña nueva`);
            group.appendChild(anchor);
        });
        messages.appendChild(group);
        if (reducedMotion) {
            scrollToEnd();
        } else {
            window.requestAnimationFrame(() => {
                messages.scrollTo({ top: messages.scrollHeight, behavior: 'smooth' });
            });
            window.setTimeout(() => group.classList.remove('dre-chatbot__links--entering'), 700);
        }
    }

    function appendError(text) {
        const error = document.createElement('p');
        error.className = 'dre-chatbot__error';
        error.textContent = text;
        messages.appendChild(error);
        scrollToEnd();
    }

    async function typeAnswer(bubble, answer) {
        const chars = Array.from(answer || '');
        if (reducedMotion) {
            bubble.textContent = answer || '';
            return;
        }

        bubble.setAttribute('aria-hidden', 'true');
        bubble.textContent = '';
        bubble.classList.add('dre-chatbot__typing');
        const delay = chars.length > 900 ? 5 : chars.length > 500 ? 7 : 11;
        for (let index = 0; index < chars.length; index += 1) {
            bubble.textContent += chars[index];
            if (index % 8 === 0) {
                scrollToEnd();
            }
            await new Promise((resolve) => window.setTimeout(resolve, delay));
        }
        bubble.classList.remove('dre-chatbot__typing');
        bubble.removeAttribute('aria-hidden');
    }

    function history() {
        return Array.from(messages.querySelectorAll('.dre-chatbot__message'))
            .filter((item) => item.querySelector('.dre-chatbot__bubble--dynamic'))
            // Veinte mensajes (diez intercambios completos aproximadamente) permiten
            // continuar una consulta tras navegar o hacer varios seguimientos cortos.
            // El servidor vuelve a seleccionar solo el tramo relevante para buscar.
            .slice(-20)
            .map((item) => ({
                role: item.classList.contains('dre-chatbot__message--user') ? 'user' : 'assistant',
                content: item.querySelector('.dre-chatbot__bubble')?.textContent?.trim() || '',
            }))
            .filter((item) => item.content);
    }

    // Identificador aleatorio de conversación. La ruta del chat no usa sesión de servidor,
    // así que sin esto el registro no permite seguir un hilo de preguntas. No identifica
    // a la persona: se descarta al cerrar la pestaña.
    function conversationId() {
        try {
            let id = window.sessionStorage.getItem('dre-chat-conv');
            if (!id) {
                id = Math.random().toString(36).slice(2) + Date.now().toString(36);
                window.sessionStorage.setItem('dre-chat-conv', id);
            }
            return id;
        } catch (_) {
            return null;
        }
    }

    async function sendMessage(raw) {
        const message = raw.trim();
        if (message.length < 2 || busy) return;
        const priorHistory = history();
        setBusy(true, 'Consultando fuentes oficiales.');
        input.value = '';
        input.style.height = '44px';
        suggestions?.remove();
        createMessage('user', message);
        const loading = createMessage('assistant', '', true);
        // Guardar inmediatamente la pregunta: si el ciudadano cambia de página mientras
        // llega la respuesta, al volver seguirá viendo al menos el mensaje que envió.
        saveSession();

        try {
              const response = await fetch(root.dataset.endpoint, {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
                  body: JSON.stringify({
                      message,
                      history: priorHistory,
                      conversacion: conversationId(),
                      page: { path: window.location.pathname, title: document.title },
                  }),
              });
              const data = await response.json().catch(() => ({}));
              if (!response.ok) {
                  const messageByStatus = {
                      422: 'Revisa la consulta e intenta nuevamente.',
                      429: 'Has enviado varias consultas seguidas. Espera un minuto antes de continuar.',
                      500: 'El asistente no está disponible en este momento. Intenta nuevamente en unos segundos.',
                  };
                  throw new Error(messageByStatus[response.status] || data.message || data.error || 'No pude procesar la consulta.');
              }
            loading.article.classList.remove('dre-chatbot__message--loading');
            await typeAnswer(loading.bubble, data.answer || 'No encontré una respuesta disponible.');
            appendLinks(data.links);
            status.textContent = `Respuesta del asistente: ${data.answer || 'No encontré una respuesta disponible.'}`;
            saveSession();
        } catch (error) {
            loading.article.remove();
            appendError(error instanceof Error ? error.message : 'El asistente no está disponible en este momento.');
            status.textContent = 'No se pudo obtener una respuesta.';
            saveSession();
        } finally {
            busy = false;
            send.disabled = false;
            messages.setAttribute('aria-busy', 'false');
            input.focus();
        }
    }

    function savedEntries() {
        // Además de los 20 mensajes se conservan sus grupos de enlaces y posibles errores.
        // Cincuenta nodos siguen siendo pequeños para sessionStorage y evitan cortar una
        // tarjeta de fuente al cambiar de página.
        return Array.from(messages.children).slice(-50).map((item) => {
            if (item.classList.contains('dre-chatbot__message')) {
                return {
                    type: 'message',
                    role: item.classList.contains('dre-chatbot__message--user') ? 'user' : 'assistant',
                    content: item.querySelector('.dre-chatbot__bubble')?.textContent?.trim() || '',
                };
            }

            if (item.classList.contains('dre-chatbot__links')) {
                return {
                    type: 'links',
                    links: Array.from(item.querySelectorAll('a')).map((link) => ({
                        title: link.textContent?.trim() || '',
                        url: link.href,
                    })),
                };
            }

            if (item.classList.contains('dre-chatbot__error')) {
                return { type: 'error', content: item.textContent?.trim() || '' };
            }

            return null;
        }).filter(Boolean);
    }

    function saveSession() {
        try {
            window.sessionStorage.setItem(storageKey, JSON.stringify({
                open: root.dataset.open === 'true',
                entries: savedEntries(),
            }));
        } catch (_) {}
    }

    function restoreSession(saved) {
        const entries = Array.isArray(saved?.entries) ? saved.entries : [];
        const hasConversation = entries.some((entry) => entry?.type === 'message' && entry.role === 'user');
        if (!hasConversation) return;

        messages.innerHTML = '';
        entries.forEach((entry) => {
            if (entry?.type === 'message' && entry.content) createMessage(entry.role, entry.content);
            if (entry?.type === 'links') appendLinks(entry.links);
            if (entry?.type === 'error' && entry.content) appendError(entry.content);
        });
        suggestions = null;
        welcomeAnimated = true;
        scrollToEnd();
    }

    function bindSuggestions() {
        suggestions?.querySelectorAll('button').forEach((button) => {
            button.addEventListener('click', () => sendMessage(button.textContent || ''));
        });
    }

    async function resetConversation() {
        if (busy) return;
        let id = null;
        try {
            id = window.sessionStorage.getItem('dre-chat-conv');
            window.sessionStorage.removeItem(storageKey);
            window.sessionStorage.removeItem('dre-chat-conv');
        } catch (_) {}

        if (id && root.dataset.resetEndpoint) {
            fetch(root.dataset.resetEndpoint, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
                body: JSON.stringify({ conversacion: id }),
            }).catch(() => {});
        }
        messages.innerHTML = initialMessagesMarkup;
        suggestions = messages.querySelector('[data-chat-suggestions]');
        welcomeAnimated = false;
        bindSuggestions();
        input.value = '';
        input.style.height = '44px';
        input.focus();
        scrollToEnd();
        animateWelcomeMessage();
    }

    launcher.addEventListener('click', () => setOpen(true));
    root.querySelector('[data-chat-open-message]')?.addEventListener('click', () => setOpen(true));
    root.querySelector('[data-chat-greeting-close]')?.addEventListener('click', () => {
        const greeting = root.querySelector('[data-chat-greeting]');
        if (greeting) greeting.hidden = true;
        try { window.sessionStorage.setItem('dre-chat-greeting-closed', '1'); } catch (_) {}
    });
    root.querySelector('[data-chat-close]').addEventListener('click', () => {
        setOpen(false);
    });
    root.querySelector('[data-chat-reset]').addEventListener('click', resetConversation);
    bindSuggestions();
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        sendMessage(input.value);
    });
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            form.requestSubmit();
        }
    });
    input.addEventListener('input', () => {
        input.style.height = '44px';
        input.style.height = `${Math.min(input.scrollHeight, 118)}px`;
    });
    document.addEventListener('keydown', (event) => {
        if (root.dataset.open !== 'true') return;

        if (event.key === 'Escape') {
            setOpen(false);
            return;
        }

        if (event.key === 'Tab') {
            const focusable = Array.from(panel.querySelectorAll(
                'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])'
            )).filter((element) => !element.hidden && element.getClientRects().length > 0);
            if (focusable.length === 0) return;

            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });
    // `pagehide` se dispara tanto al navegar a otra sección como al usar atrás/adelante.
    // sessionStorage pertenece a la pestaña y al mismo dominio, por eso conserva el chat
    // entre páginas sin dejar conversaciones guardadas permanentemente en el equipo.
    window.addEventListener('pagehide', saveSession);

    try {
        const saved = JSON.parse(window.sessionStorage.getItem(storageKey) || 'null');
        restoreSession(saved);
        if (saved?.open) setOpen(true);
        if (window.sessionStorage.getItem('dre-chat-greeting-closed') === '1') {
            const greeting = root.querySelector('[data-chat-greeting]');
            if (greeting) greeting.hidden = true;
        }
    } catch (_) {}
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDreChatbot, { once: true });
} else {
    initDreChatbot();
}
