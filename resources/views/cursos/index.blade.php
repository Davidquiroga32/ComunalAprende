@extends('layouts.app')
@section('title', 'Cursos - Comunal Aprende')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --blue-deep:  #0A2540;
    --blue-core:  #0A4D8C;
    --blue-mid:   #1E6DB8;
    --blue-light: #3B88D4;
    --blue-pale:  #EBF3FF;
    --green:      #16a34a;
    --orange:     #E65100;
    --text:       #1a2940;
    --muted:      #64748b;
    --border:     #dde4ee;
    --off-white:  #f7f9fc;
}

/* ══════════════════════════════════
   HERO BANNER
══════════════════════════════════ */
.cursos-hero {
    position: relative;
    background: var(--blue-deep);
    overflow: hidden;
    padding: 5rem 1.5rem 4rem;
    margin-top: 68px;
}
.cursos-hero-bg {
    position: absolute; inset: 0;
    background:
        linear-gradient(135deg, #0A2540 0%, #0A4D8C 60%, #1E6DB8 100%);
    opacity: .95;
}
.cursos-hero-dots {
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px);
    background-size: 30px 30px;
    mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
}
.cursos-hero-glow {
    position: absolute;
    width: 500px; height: 500px; border-radius: 50%;
    background: radial-gradient(rgba(59,136,212,.25), transparent 70%);
    top: -150px; right: -100px;
    pointer-events: none;
}
.cursos-hero-inner {
    position: relative; z-index: 2;
    max-width: 1100px; margin: 0 auto;
    text-align: center;
}
.cursos-hero-eyebrow {
    display: inline-flex; align-items: center; gap: .45rem;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.85);
    font-family: 'Outfit', sans-serif;
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .12em;
    padding: .35rem 1rem; border-radius: 999px;
    margin-bottom: 1.25rem;
}
.cursos-hero h1 {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900; color: #fff;
    margin: 0 0 1rem; line-height: 1.1;
    letter-spacing: -.02em;
}
.cursos-hero h1 span {
    background: linear-gradient(90deg, #60B0FF, #A0D4FF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.cursos-hero p {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.05rem; color: rgba(255,255,255,.72);
    line-height: 1.7; max-width: 560px; margin: 0 auto 2rem;
}

/* Mini stats en el hero */
.hero-mini-stats {
    display: flex; align-items: center; justify-content: center;
    gap: 2rem; flex-wrap: wrap;
    margin-top: 1.5rem;
}
.hms-item {
    display: flex; align-items: center; gap: .5rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem; color: rgba(255,255,255,.65);
}
.hms-item i { color: #60B0FF; }
.hms-item strong { color: #fff; font-family: 'Outfit', sans-serif; font-weight: 700; }

/* Ola inferior */
.hero-wave-bottom {
    position: relative; background: var(--off-white);
    margin-top: -2px; line-height: 0;
}

/* ══════════════════════════════════
   FILTROS
══════════════════════════════════ */
.filtros-wrap {
    background: var(--off-white);
    padding: 0 1.5rem 2rem;
}
.filtros-card {
    max-width: 1100px; margin: 0 auto;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.5rem 1.75rem;
    box-shadow: 0 4px 20px rgba(10,37,64,.07);
    display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
}
.search-wrap {
    flex: 1; min-width: 220px;
    position: relative;
}
.search-wrap i {
    position: absolute; left: 1rem; top: 50%;
    transform: translateY(-50%);
    color: var(--muted); font-size: .88rem; pointer-events: none;
}
.search-input {
    width: 100%; padding: .75rem 1rem .75rem 2.75rem;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: .9rem; color: var(--text);
    outline: none; transition: border-color .18s, box-shadow .18s;
    background: var(--off-white);
}
.search-input:focus {
    border-color: var(--blue-core);
    box-shadow: 0 0 0 3px rgba(10,77,140,.08);
    background: #fff;
}
.filter-divider {
    width: 1px; height: 36px; background: var(--border);
    flex-shrink: 0;
}
.filter-pill-group {
    display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
}
.filter-label-sm {
    font-family: 'Outfit', sans-serif;
    font-size: .72rem; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .08em;
    white-space: nowrap;
}
.filter-select {
    padding: .6rem 2rem .6rem .9rem;
    border: 1.5px solid var(--border); border-radius: 10px;
    font-family: 'DM Sans', sans-serif; font-size: .86rem; color: var(--text);
    background: var(--off-white);
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    outline: none; cursor: pointer;
    transition: border-color .18s;
}
.filter-select:focus { border-color: var(--blue-core); background-color: #fff; }

.results-info {
    max-width: 1100px; margin: 0 auto;
    padding: 1rem 0 .25rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .87rem; color: var(--muted);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
}
.results-info strong { color: var(--text); }
.clear-link {
    color: var(--blue-core); font-weight: 600;
    text-decoration: none; font-size: .83rem;
    display: inline-flex; align-items: center; gap: .3rem;
    transition: opacity .18s;
}
.clear-link:hover { opacity: .75; }

/* ══════════════════════════════════
   GRID DE CURSOS
══════════════════════════════════ */
.cursos-section {
    background: var(--off-white);
    padding: 0 1.5rem 4rem;
}
.cursos-grid {
    max-width: 1100px; margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.curso-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    text-decoration: none; color: inherit;
    display: flex; flex-direction: column;
    transition: transform .22s, box-shadow .22s, border-color .22s;
    position: relative;
}
.curso-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 48px rgba(10,37,64,.13);
    border-color: #b8d4f0;
}

.curso-thumb {
    position: relative;
    height: 185px; overflow: hidden;
    flex-shrink: 0;
}
.curso-thumb img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .4s ease;
}
.curso-card:hover .curso-thumb img { transform: scale(1.04); }

.curso-thumb-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.75rem; color: rgba(255,255,255,.75);
}

/* Badges sobre la imagen */
.badge-tipo {
    position: absolute; top: .875rem; right: .875rem;
    font-family: 'Outfit', sans-serif;
    font-size: .68rem; font-weight: 800;
    padding: .25rem .65rem; border-radius: 999px;
    text-transform: uppercase; letter-spacing: .06em;
    backdrop-filter: blur(8px);
}
.badge-tipo.free { background: rgba(22,163,74,.9); color: #fff; }
.badge-tipo.paid { background: rgba(10,77,140,.9); color: #fff; }

.badge-destacado {
    position: absolute; top: .875rem; left: .875rem;
    font-family: 'Outfit', sans-serif;
    font-size: .65rem; font-weight: 800;
    background: rgba(245,158,11,.92);
    color: #fff; padding: .25rem .6rem;
    border-radius: 999px;
    display: flex; align-items: center; gap: .25rem;
    backdrop-filter: blur(8px);
}

/* Overlay gradiente bottom de imagen */
.curso-thumb-overlay {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 60px;
    background: linear-gradient(transparent, rgba(10,37,64,.35));
}

.curso-body {
    padding: 1.25rem 1.35rem 1.5rem;
    display: flex; flex-direction: column; flex: 1;
}

.curso-cat {
    font-family: 'Outfit', sans-serif;
    font-size: .7rem; font-weight: 700;
    color: var(--blue-core);
    text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: .5rem;
    display: flex; align-items: center; gap: .3rem;
}
.curso-cat::before {
    content: '';
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--blue-core); flex-shrink: 0;
}

.curso-titulo {
    font-family: 'Outfit', sans-serif;
    font-size: 1rem; font-weight: 800; color: var(--text);
    margin: 0 0 .5rem; line-height: 1.3;
}
.curso-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: .83rem; color: var(--muted);
    line-height: 1.6; margin: 0 0 1rem;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.curso-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: .875rem;
    border-top: 1px solid #f0f4f8;
    margin-top: auto;
}
.curso-stats {
    display: flex; gap: .875rem;
}
.curso-stat {
    display: flex; align-items: center; gap: .3rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem; color: var(--muted);
}
.curso-stat i { font-size: .72rem; color: var(--blue-light); }

.curso-precio {
    font-family: 'Outfit', sans-serif;
    font-size: 1rem; font-weight: 800; color: var(--text);
}
.curso-precio.free { color: var(--green); }

/* ══════════════════════════════════
   EMPTY STATE
══════════════════════════════════ */
.empty-state {
    max-width: 1100px; margin: 0 auto;
    text-align: center; padding: 5rem 2rem;
    background: #fff; border-radius: 20px;
    border: 1px dashed var(--border);
}
.empty-icon {
    width: 72px; height: 72px; border-radius: 18px;
    background: var(--blue-pale);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem; color: var(--blue-core);
    margin: 0 auto 1.25rem;
}
.empty-state h3 {
    font-family: 'Outfit', sans-serif;
    font-size: 1.25rem; font-weight: 800; color: var(--text); margin: 0 0 .5rem;
}
.empty-state p {
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem; color: var(--muted); margin: 0;
}

/* ══════════════════════════════════
   CTA FINAL
══════════════════════════════════ */
.cursos-cta {
    padding: 4.5rem 1.5rem;
    background: linear-gradient(135deg, var(--blue-deep), var(--blue-core));
    text-align: center; position: relative; overflow: hidden;
}
.cursos-cta::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.05) 1px, transparent 1px);
    background-size: 28px 28px;
}
.cursos-cta-inner { position: relative; z-index: 1; max-width: 560px; margin: 0 auto; }
.cursos-cta h2 {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 900;
    color: #fff; margin: 0 0 .875rem; letter-spacing: -.02em;
}
.cursos-cta p {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem; color: rgba(255,255,255,.7);
    margin: 0 0 2rem; line-height: 1.7;
}
.cursos-cta-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .9rem 2rem;
    background: #fff; color: var(--blue-core);
    border-radius: 12px; font-family: 'Outfit', sans-serif;
    font-size: .95rem; font-weight: 800;
    text-decoration: none; transition: all .2s;
    box-shadow: 0 4px 20px rgba(0,0,0,.2);
}
.cursos-cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(0,0,0,.3);
    color: var(--blue-core);
}

/* Responsive */
@media (max-width: 960px) { .cursos-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 580px) {
    .cursos-grid { grid-template-columns: 1fr; }
    .filtros-card { flex-direction: column; align-items: stretch; }
    .filter-divider { display: none; }
}
</style>

{{-- ══════════ HERO ══════════ --}}
<section class="cursos-hero">
    <div class="cursos-hero-bg"></div>
    <div class="cursos-hero-dots"></div>
    <div class="cursos-hero-glow"></div>
    <div class="cursos-hero-inner">
        <div class="cursos-hero-eyebrow">
            <i class="fas fa-graduation-cap"></i> Formación Comunitaria
        </div>
        <h1>Catálogo de <span>Cursos</span></h1>
        <p>Descubre programas de formación especializados, diseñados para fortalecer tu organización y comunidad.</p>
        <div class="hero-mini-stats">
            <div class="hms-item"><i class="fas fa-book-open"></i> <strong>{{ $cursos->count() }}</strong> cursos disponibles</div>
            <div class="hms-item"><i class="fas fa-users"></i> <strong>+500</strong> líderes formados</div>
            <div class="hms-item"><i class="fas fa-certificate"></i> Certificado incluido</div>
            <div class="hms-item"><i class="fas fa-infinity"></i> Acceso de por vida</div>
        </div>
    </div>
    <div style="position:absolute;bottom:-1px;left:0;right:0;line-height:0;z-index:2;">
        <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;display:block;">
            <path d="M0,48 C360,16 1080,0 1440,32 L1440,48 L0,48 Z" fill="#f7f9fc"/>
        </svg>
    </div>
</section>

{{-- ══════════ FILTROS ══════════ --}}
<div class="filtros-wrap">
    <form method="GET" action="{{ route('cursos.index') }}" id="filterForm">
        <div class="filtros-card">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="q" class="search-input"
                    placeholder="Buscar cursos por nombre o descripción..."
                    value="{{ request('q') }}"
                    oninput="debounceFilter()">
            </div>
            <div class="filter-divider"></div>
            <div class="filter-pill-group">
                <span class="filter-label-sm"><i class="fas fa-tag" style="margin-right:.25rem;"></i>Categoría</span>
                <select name="categoria" class="filter-select" onchange="this.form.submit()">
                    <option value="all" {{ request('categoria','all') === 'all' ? 'selected' : '' }}>Todas</option>
                    @foreach(['gestion'=>'Gestión Comunal','normatividad'=>'Normatividad','liderazgo'=>'Liderazgo','proyectos'=>'Formulación de Proyectos','participacion'=>'Participación Ciudadana','contabilidad'=>'Contabilidad'] as $val => $label)
                        <option value="{{ $val }}" {{ request('categoria') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-divider"></div>
            <div class="filter-pill-group">
                <span class="filter-label-sm"><i class="fas fa-filter" style="margin-right:.25rem;"></i>Tipo</span>
                <select name="tipo" class="filter-select" onchange="this.form.submit()">
                    <option value="all" {{ request('tipo','all') === 'all' ? 'selected' : '' }}>Todos</option>
                    <option value="free"  {{ request('tipo') === 'free'  ? 'selected' : '' }}>Gratuitos</option>
                    <option value="paid"  {{ request('tipo') === 'paid'  ? 'selected' : '' }}>De pago</option>
                </select>
            </div>
        </div>

        {{-- Info resultados --}}
        <div class="results-info">
            <span>
                Mostrando <strong>{{ $cursos->count() }}</strong> curso{{ $cursos->count() !== 1 ? 's' : '' }}
                @if(request('q')) para "<strong>{{ request('q') }}</strong>"@endif
                @if(request('categoria') && request('categoria') !== 'all') en <strong>{{ ['gestion'=>'Gestión Comunal','normatividad'=>'Normatividad','liderazgo'=>'Liderazgo','proyectos'=>'Formulación de Proyectos','participacion'=>'Participación Ciudadana','contabilidad'=>'Contabilidad'][request('categoria')] ?? request('categoria') }}</strong>@endif
            </span>
            @if(request()->hasAny(['q','categoria','tipo']))
                <a href="{{ route('cursos.index') }}" class="clear-link">
                    <i class="fas fa-times-circle"></i> Limpiar filtros
                </a>
            @endif
        </div>
    </form>
</div>

{{-- ══════════ GRID CURSOS ══════════ --}}
<div class="cursos-section">
    @if($cursos->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-search"></i></div>
            <h3>No se encontraron cursos</h3>
            <p>Intenta con otros filtros o <a href="{{ route('cursos.index') }}" style="color:var(--blue-core);font-weight:600;">ver todos los cursos</a>.</p>
        </div>
    @else
        <div class="cursos-grid" id="coursesGrid">
            @foreach($cursos as $curso)
                @php
                    $colores = $curso->color_gradiente ?? '#0A4D8C,#3B88D4';
                    [$c1,$c2] = array_pad(explode(',',$colores), 2, '#3B88D4');
                    $icono = $curso->icono_fa ?? 'fa-graduation-cap';
                @endphp
                <a href="{{ route('cursos.show', $curso->slug) }}" class="curso-card">

                    {{-- Thumbnail --}}
                    <div class="curso-thumb" style="background: linear-gradient(135deg, {{ $c1 }}, {{ $c2 }});">
                        @if($curso->imagen)
                            <img src="{{ $curso->imagen }}" alt="{{ $curso->titulo }}">
                        @else
                            <div class="curso-thumb-placeholder">
                                <i class="fas {{ $icono }}"></i>
                            </div>
                        @endif
                        <div class="curso-thumb-overlay"></div>

                        <span class="badge-tipo {{ $curso->tipo }}">
                            {{ $curso->tipo === 'free' ? 'Gratuito' : 'De pago' }}
                        </span>
                        @if($curso->destacado)
                            <span class="badge-destacado">
                                <i class="fas fa-star" style="font-size:.6rem;"></i> Destacado
                            </span>
                        @endif
                    </div>

                    {{-- Cuerpo --}}
                    <div class="curso-body">
                        <div class="curso-cat">{{ $curso->categoriaLabel() }}</div>
                        <h3 class="curso-titulo">{{ $curso->titulo }}</h3>
                        <p class="curso-desc">{{ $curso->descripcion_corta }}</p>
                        <div class="curso-footer">
                            <div class="curso-stats">
                                <span class="curso-stat">
                                    <i class="fas fa-clock"></i> {{ $curso->duracion_horas }}h
                                </span>
                                <span class="curso-stat">
                                    <i class="fas fa-users"></i> {{ $curso->estudiantes_count }}
                                </span>
                            </div>
                            <span class="curso-precio {{ $curso->tipo === 'free' ? 'free' : '' }}">
                                {{ $curso->precioFormateado() }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

{{-- ══════════ CTA ══════════ --}}
<div class="cursos-cta">
    <div class="cursos-cta-inner">
        <h2>¿No encuentras lo que buscas?</h2>
        <p>Contáctanos para conocer próximos lanzamientos o solicitar un programa de capacitación personalizado para tu organización.</p>
        <a href="{{ route('contacto') }}" class="cursos-cta-btn">
            <i class="fas fa-envelope"></i> Contáctanos
        </a>
    </div>
</div>

@push('scripts')
<script>
let debounceTimer;
function debounceFilter() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => document.getElementById('filterForm').submit(), 500);
}

// Animación entrada cards
const observer = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => {
                e.target.style.opacity = '1';
                e.target.style.transform = 'translateY(0)';
            }, i * 80);
        }
    });
}, { threshold: 0.05 });

document.querySelectorAll('.curso-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity .5s ease, transform .5s ease, box-shadow .22s, border-color .22s';
    observer.observe(el);
});
</script>
@endpush
@endsection