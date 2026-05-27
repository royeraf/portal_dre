import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';

Alpine.plugin(intersect);
Alpine.plugin(collapse);

window.Alpine = Alpine;
Alpine.start();

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
