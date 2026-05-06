@extends('layouts.app')
@section('title', $curso->titulo . ' - Comunal Aprende')

@section('content')
@php
    $colores = $curso->color_gradiente ?? '#0A4D8C,#3B88D4';
    [$c1,$c2] = array_pad(explode(',',$colores),2,'#3B88D4');
    $icono = $curso->icono_fa ?? 'fa-graduation-cap';
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --c1: {{ $c1 }};
    --c2: {{ $c2 }};
    --dark: #0a0f1e;
    --card-bg: #ffffff;
    --text: #1e2a3a;
    --muted: #64748b;
    --border: #e2e8f0;
    --success: #10b981;
}

* { box-sizing: border-box; }

/* ── HERO ─────────────────────────────── */
.hero {
    position: relative;
    background: var(--dark);
    overflow: hidden;
    padding: 0;
    padding-top: 70px; /* Compensa el header fijo */
}

.hero-bg-gradient {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--c1) 0%, var(--c2) 50%, var(--dark) 100%);
    opacity: .35;
}

.hero-bg-mesh {
    position: absolute; inset: 0;
    background-image:
        radial-gradient(ellipse 80% 60% at 20% 50%, rgba(255,255,255,.05) 0%, transparent 60%),
        radial-gradient(ellipse 50% 80% at 80% 20%, rgba(255,255,255,.04) 0%, transparent 60%);
}

.hero-bg-dots {
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.12) 1px, transparent 1px);
    background-size: 28px 28px;
    mask-image: radial-gradient(ellipse 70% 70% at 30% 50%, black 30%, transparent 100%);
}

.hero-inner {
    position: relative; z-index: 2;
    max-width: 1180px; margin: 0 auto;
    padding: 4rem 1.5rem 0;
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 3rem;
    align-items: start;
}

/* Breadcrumb */
.breadcrumb {
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; color: rgba(255,255,255,.5);
    margin-bottom: 1.5rem;
    font-family: 'DM Sans', sans-serif;
}
.breadcrumb a { color: rgba(255,255,255,.5); text-decoration: none; transition: color .2s; }
.breadcrumb a:hover { color: rgba(255,255,255,.9); }
.breadcrumb span { color: rgba(255,255,255,.25); }

/* Badge categoría */
.cat-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    backdrop-filter: blur(10px);
    color: #fff; font-size: .75rem; font-weight: 700;
    padding: .35rem 1rem; border-radius: 999px;
    text-transform: uppercase; letter-spacing: .06em;
    margin-bottom: 1.1rem;
    font-family: 'DM Sans', sans-serif;
}

.hero-title {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(1.75rem, 3.5vw, 2.6rem);
    font-weight: 800; color: #fff;
    line-height: 1.15; margin: 0 0 1rem;
    letter-spacing: -.02em;
}

.hero-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.05rem; color: rgba(255,255,255,.75);
    line-height: 1.7; margin-bottom: 1.75rem;
    max-width: 560px;
}

/* Pills de meta */
.meta-pills {
    display: flex; flex-wrap: wrap; gap: .6rem;
    margin-bottom: 2rem;
}
.meta-pill {
    display: flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    color: rgba(255,255,255,.85);
    padding: .4rem .9rem; border-radius: 999px;
    font-size: .82rem; font-family: 'DM Sans', sans-serif;
    font-weight: 500;
}
.meta-pill i { font-size: .78rem; opacity: .7; }

/* Rating bar */
.hero-rating {
    display: flex; align-items: center; gap: .5rem;
    margin-bottom: 2.5rem;
}
.stars { color: #fbbf24; font-size: .85rem; letter-spacing: .05em; }
.rating-text { font-size: .82rem; color: rgba(255,255,255,.6); font-family: 'DM Sans', sans-serif; }

/* Línea decorativa bottom del hero */
.hero-bottom-wave {
    position: relative; z-index: 2;
    height: 48px; margin-top: -1px;
    background: #f8fafc;
    clip-path: ellipse(55% 100% at 50% 100%);
}

/* ── CARD INSCRIPCIÓN ─────────────────── */
.inscripcion-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 24px 80px rgba(0,0,0,.35), 0 4px 20px rgba(0,0,0,.15);
    overflow: hidden;
    position: sticky; top: 88px;
    margin-bottom: -80px;
}

.card-thumb {
    width: 100%; height: 175px;
    object-fit: cover; display: block;
}
.card-thumb-placeholder {
    width: 100%; height: 175px;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, var(--c1), var(--c2));
    font-size: 3rem; color: #fff;
}

.card-body { padding: 1.5rem; }

.precio-tag {
    font-family: 'Poppins', sans-serif;
    font-size: 2.25rem; font-weight: 800;
    color: var(--text); line-height: 1;
    margin-bottom: 1.25rem;
}
.precio-tag.free { color: var(--success); }

/* Barra de progreso */
.progress-wrap { margin-bottom: 1rem; }
.progress-label {
    display: flex; justify-content: space-between;
    font-size: .78rem; color: var(--muted);
    margin-bottom: .4rem; font-family: 'DM Sans', sans-serif;
}
.progress-bar {
    height: 7px; background: #e2e8f0; border-radius: 999px; overflow: hidden;
}
.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--c1), var(--c2));
    border-radius: 999px;
    transition: width .6s ease;
}

/* Botón inscribir */
.btn-primary {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    width: 100%; padding: 1rem;
    background: linear-gradient(135deg, var(--c1) 0%, var(--c2) 100%);
    color: #fff; border: none; border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    font-size: .95rem; font-weight: 700;
    cursor: pointer; text-decoration: none;
    transition: transform .18s, box-shadow .18s, opacity .18s;
    box-shadow: 0 4px 20px rgba(10,77,140,.4);
    margin-bottom: .75rem;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(10,77,140,.5);
    color: #fff; opacity: .95;
}
.btn-primary.enrolled { background: linear-gradient(135deg, #059669, #10b981); box-shadow: 0 4px 20px rgba(16,185,129,.3); }
.btn-primary.login { background: linear-gradient(135deg, #1e2a3a, #334155); box-shadow: 0 4px 20px rgba(30,42,58,.3); }

.btn-secondary {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    width: 100%; padding: .75rem;
    background: transparent;
    color: var(--c1); border: 1.5px solid var(--c1); border-radius: 12px;
    font-family: 'DM Sans', sans-serif; font-size: .88rem; font-weight: 600;
    cursor: pointer; text-decoration: none;
    transition: all .18s;
}
.btn-secondary:hover { background: var(--c1); color: #fff; }

.garantia-note {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    font-size: .76rem; color: var(--muted);
    font-family: 'DM Sans', sans-serif; margin-top: .6rem; text-align: center;
}

/* Incluye */
.incluye-list { margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid var(--border); }
.incluye-title {
    font-family: 'Poppins', sans-serif;
    font-size: .78rem; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: .75rem;
}
.incluye-item {
    display: flex; align-items: center; gap: .65rem;
    padding: .4rem 0; font-size: .84rem;
    color: var(--text); font-family: 'DM Sans', sans-serif;
    border-bottom: 1px solid #f8fafc;
}
.incluye-item:last-child { border-bottom: none; }
.incluye-item i { width: 18px; color: var(--c1); text-align: center; font-size: .85rem; }

/* ── BODY ─────────────────────────────── */
.page-body {
    max-width: 1180px; margin: 0 auto;
    padding: 3rem 1.5rem 4rem;
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 3rem;
}

/* ── LO QUE APRENDERÁS ───────────────── */
.aprende-section {
    background: linear-gradient(135deg, #f0f7ff, #e8f2ff);
    border: 1px solid #c7dfff;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
}
.section-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.2rem; font-weight: 700; color: var(--text);
    margin: 0 0 1.25rem; display: flex; align-items: center; gap: .6rem;
}
.section-title i { color: var(--c1); }
.aprende-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: .65rem;
}
.aprende-item {
    display: flex; align-items: flex-start; gap: .65rem;
    font-size: .87rem; color: var(--text); line-height: 1.5;
    font-family: 'DM Sans', sans-serif;
}
.aprende-check {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--c1); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; flex-shrink: 0; margin-top: .1rem;
}

/* ── TABS ─────────────────────────────── */
.tab-nav {
    display: flex; gap: 0;
    border-bottom: 2px solid var(--border);
    margin-bottom: 1.75rem;
}
.tab-btn {
    padding: .75rem 1.35rem;
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem; font-weight: 600; color: var(--muted);
    border: none; background: none; cursor: pointer;
    border-bottom: 2.5px solid transparent; margin-bottom: -2px;
    transition: all .18s;
}
.tab-btn.active { color: var(--c1); border-bottom-color: var(--c1); }
.tab-btn:hover:not(.active) { color: var(--text); }

/* ── MÓDULOS ──────────────────────────── */
.modulos-header {
    font-family: 'DM Sans', sans-serif;
    font-size: .88rem; color: var(--muted);
    margin-bottom: 1rem;
}
.modulos-header strong { color: var(--text); }

.modulo-wrap {
    border: 1px solid var(--border);
    border-radius: 12px; margin-bottom: .75rem;
    overflow: hidden; transition: box-shadow .2s;
}
.modulo-wrap:hover { box-shadow: 0 4px 16px rgba(0,0,0,.06); }

.modulo-hd {
    padding: 1rem 1.25rem;
    background: #f8fafc;
    display: flex; align-items: center; justify-content: space-between;
    cursor: pointer; user-select: none;
    transition: background .16s;
}
.modulo-hd:hover { background: #f1f5f9; }

.modulo-hd-left { display: flex; align-items: center; gap: .75rem; flex: 1; }

.modulo-num {
    width: 28px; height: 28px; border-radius: 8px;
    background: linear-gradient(135deg, var(--c1), var(--c2));
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 800; flex-shrink: 0;
    font-family: 'Poppins', sans-serif;
}
.modulo-titulo {
    font-family: 'DM Sans', sans-serif;
    font-weight: 700; font-size: .92rem; color: var(--text);
}
.modulo-count {
    font-size: .75rem; color: var(--muted);
    font-family: 'DM Sans', sans-serif;
}
.modulo-chevron {
    color: var(--muted); font-size: .82rem;
    transition: transform .25s cubic-bezier(.4,0,.2,1);
    flex-shrink: 0;
}
.modulo-chevron.open { transform: rotate(180deg); }

.modulo-body { display: none; border-top: 1px solid var(--border); }
.modulo-body.open { display: block; }

.leccion-row {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1.25rem;
    border-bottom: 1px solid #f8fafc;
    transition: background .15s;
}
.leccion-row:last-child { border-bottom: none; }
.leccion-row:hover { background: #f8fafc; }

.lec-ico {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; flex-shrink: 0;
}
.tipo-texto  { background: #EBF3FF; color: #0A4D8C; }
.tipo-video  { background: #FEE2E2; color: #dc2626; }
.tipo-pdf    { background: #FEF3C7; color: #d97706; }
.tipo-quiz   { background: #EDE9FE; color: #7c3aed; }
.tipo-tarea  { background: #D1FAE5; color: #059669; }

.lec-titulo {
    flex: 1; font-size: .87rem; color: #475569;
    font-family: 'DM Sans', sans-serif;
}
.lec-dur {
    font-size: .75rem; color: var(--muted);
    font-family: 'DM Sans', sans-serif; white-space: nowrap;
}
.lec-lock { color: #cbd5e1; font-size: .82rem; }
.lec-free-badge {
    font-size: .68rem; font-weight: 700; color: var(--success);
    background: #d1fae5; padding: .15rem .5rem; border-radius: 999px;
    font-family: 'DM Sans', sans-serif;
}

/* ── SIDEBAR ──────────────────────────── */
.sidebar-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; padding: 1.5rem; margin-bottom: 1rem;
}
.sidebar-title {
    font-family: 'Poppins', sans-serif;
    font-size: .85rem; font-weight: 700; color: var(--text);
    margin-bottom: 1rem; text-transform: uppercase; letter-spacing: .06em;
}

/* Cursos relacionados */
.relac-item {
    display: flex; gap: .875rem; padding: .75rem 0;
    border-bottom: 1px solid #f8fafc; text-decoration: none;
    transition: transform .16s;
}
.relac-item:last-child { border-bottom: none; }
.relac-item:hover { transform: translateX(4px); }
.relac-thumb {
    width: 58px; height: 48px; border-radius: 8px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.1rem;
}
.relac-info h4 {
    font-family: 'DM Sans', sans-serif;
    font-size: .85rem; font-weight: 700; color: var(--text);
    margin: 0 0 .2rem; line-height: 1.3;
}
.relac-info p {
    font-size: .75rem; color: var(--muted); margin: 0;
    font-family: 'DM Sans', sans-serif;
}

/* ── DIVIDER ──────────────────────────── */
.body-divider {
    height: 80px; background: #f8fafc;
    margin-bottom: 0;
}

/* ── RESPONSIVE ───────────────────────── */
@media (max-width: 960px) {
    .hero-inner { grid-template-columns: 1fr; padding-bottom: 2rem; }
    .inscripcion-card { position: static; margin-bottom: 0; }
    .page-body { grid-template-columns: 1fr; }
    .aprende-grid { grid-template-columns: 1fr; }
    .hero-title { font-size: 1.9rem; }
}

/* Animaciones entrada */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
.hero-content > * {
    animation: fadeUp .55s cubic-bezier(.22,1,.36,1) both;
}
.hero-content > *:nth-child(1) { animation-delay: .05s; }
.hero-content > *:nth-child(2) { animation-delay: .12s; }
.hero-content > *:nth-child(3) { animation-delay: .18s; }
.hero-content > *:nth-child(4) { animation-delay: .24s; }
.hero-content > *:nth-child(5) { animation-delay: .30s; }

.inscripcion-card {
    animation: fadeUp .55s .15s cubic-bezier(.22,1,.36,1) both;
}
</style>

{{-- ═══════════════ HERO ═══════════════ --}}
<section class="hero">
    <div class="hero-bg-gradient"></div>
    <div class="hero-bg-mesh"></div>
    <div class="hero-bg-dots"></div>

    <div class="hero-inner">
        {{-- Lado izquierdo --}}
        <div class="hero-content">
            <nav class="breadcrumb">
                <a href="{{ route('cursos.index') }}">Cursos</a>
                <span>›</span>
                <a href="{{ route('cursos.index') }}?categoria={{ $curso->categoria }}">{{ $curso->categoriaLabel() }}</a>
                <span>›</span>
                <span style="color:rgba(255,255,255,.7);">{{ Str::limit($curso->titulo, 40) }}</span>
            </nav>

            <div class="cat-badge">
                <i class="fas fa-tag"></i> {{ $curso->categoriaLabel() }}
            </div>

            <h1 class="hero-title">{{ $curso->titulo }}</h1>

            <p class="hero-desc">{{ $curso->descripcion_corta ?? Str::limit($curso->descripcion, 200) }}</p>

            <div class="meta-pills">
                <div class="meta-pill"><i class="fas fa-clock"></i> {{ $curso->duracion_horas }} horas</div>
                <div class="meta-pill"><i class="fas fa-list-ul"></i> {{ $totalLecciones }} lecciones</div>
                <div class="meta-pill"><i class="fas fa-users"></i> {{ $curso->totalEstudiantes() }} estudiantes</div>
                @if($curso->modulos->count())
                    <div class="meta-pill"><i class="fas fa-layer-group"></i> {{ $curso->modulos->count() }} módulos</div>
                @endif
                <div class="meta-pill">
                    <i class="fas fa-signal"></i>
                    {{ $curso->tipo === 'free' ? 'Gratuito' : 'De pago' }}
                </div>
            </div>

            <div class="hero-rating">
                <span class="stars">★★★★★</span>
                <span class="rating-text">Actualizado recientemente · Certificado incluido</span>
            </div>
        </div>

        {{-- Card inscripción --}}
        <div>
            <div class="inscripcion-card">
                @if($curso->imagen)
                    <img src="{{ $curso->imagen }}" alt="{{ $curso->titulo }}" class="card-thumb">
                @else
                    <div class="card-thumb-placeholder">
                        <i class="fas {{ $icono }}"></i>
                    </div>
                @endif

                <div class="card-body">
                    <div class="precio-tag {{ $curso->tipo === 'free' ? 'free' : '' }}">
                        {{ $curso->precioFormateado() }}
                    </div>

                    @if($yaInscrito && $progreso > 0)
                        <div class="progress-wrap">
                            <div class="progress-label">
                                <span>Tu progreso</span>
                                <strong style="color:var(--c1)">{{ $progreso }}%</strong>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:{{ $progreso }}%"></div>
                            </div>
                        </div>
                    @endif

                    @if($yaInscrito)
                        <a href="{{ route('dashboard.cursos') }}" class="btn-primary enrolled">
                            <i class="fas fa-play-circle"></i> Continuar Curso
                        </a>
                        <div class="garantia-note">
                            <i class="fas fa-check-circle" style="color:var(--success)"></i>
                            Ya estás inscrito en este curso
                        </div>
                    @elseif(auth()->check())
                        <form method="POST" action="{{ route('cursos.inscribir', $curso->slug) }}">
                            @csrf
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-graduation-cap"></i>
                                {{ $curso->tipo === 'free' ? 'Inscribirme Gratis' : 'Inscribirme Ahora' }}
                            </button>
                        </form>
                        <div class="garantia-note">
                            <i class="fas fa-shield-alt"></i> Acceso de por vida · Sin compromisos
                        </div>
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->url()) }}" class="btn-primary login">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión para Inscribirme
                        </a>
                        <a href="{{ route('register') }}" class="btn-secondary" style="margin-top:.5rem;">
                            <i class="fas fa-user-plus"></i> Crear cuenta gratis
                        </a>
                        <div class="garantia-note">
                            <i class="fas fa-lock"></i> Registro gratuito · Sin tarjeta
                        </div>
                    @endif

                    <div class="incluye-list">
                        <div class="incluye-title">Este curso incluye</div>
                        <div class="incluye-item"><i class="fas fa-clock"></i> {{ $curso->duracion_horas }} horas de contenido</div>
                        <div class="incluye-item"><i class="fas fa-video"></i> {{ $totalLecciones }} lecciones en total</div>
                        <div class="incluye-item"><i class="fas fa-certificate"></i> Certificado de participación</div>
                        <div class="incluye-item"><i class="fas fa-infinity"></i> Acceso de por vida</div>
                        <div class="incluye-item"><i class="fas fa-mobile-alt"></i> Acceso en cualquier dispositivo</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ola inferior --}}
    <div style="height:56px;position:relative;z-index:2;margin-top:2rem;">
        <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:100%;display:block;">
            <path d="M0,56 C360,0 1080,0 1440,56 L1440,56 L0,56 Z" fill="#f8fafc"/>
        </svg>
    </div>
</section>

{{-- ═══════════════ CUERPO ═══════════════ --}}
<div style="background:#f8fafc; padding-top: 1rem;">
<div class="page-body">

    {{-- Columna principal --}}
    <div>

        {{-- Lo que aprenderás --}}
        <div class="aprende-section">
            <h2 class="section-title">
                <i class="fas fa-check-circle"></i> Lo que aprenderás
            </h2>
            <div class="aprende-grid">
                @php
                    // Genera ítems desde los módulos y lecciones del curso
                    $items = $curso->modulos->flatMap(fn($m) => $m->lecciones)->take(8)->map(fn($l) => $l->titulo);
                    if($items->isEmpty()) {
                        $items = collect([
                            'Fundamentos de ' . $curso->categoriaLabel(),
                            'Aplicación práctica de conceptos',
                            'Herramientas y metodologías actuales',
                            'Casos reales y ejercicios prácticos',
                        ]);
                    }
                @endphp
                @foreach($items as $item)
                    <div class="aprende-item">
                        <div class="aprende-check"><i class="fas fa-check" style="font-size:.6rem;"></i></div>
                        <span>{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tabs --}}
        <div class="tab-nav">
            <button class="tab-btn active" onclick="showTab('contenido',this)">
                <i class="fas fa-list-ul" style="margin-right:.35rem;font-size:.82rem;"></i>Contenido del Curso
            </button>
            @if($curso->descripcion)
                <button class="tab-btn" onclick="showTab('descripcion',this)">
                    <i class="fas fa-align-left" style="margin-right:.35rem;font-size:.82rem;"></i>Descripción
                </button>
            @endif
        </div>

        {{-- Tab: Contenido --}}
        <div id="tab-contenido">
            <p class="modulos-header">
                <strong>{{ $curso->modulos->count() }} módulos</strong> ·
                <strong>{{ $totalLecciones }} lecciones</strong> ·
                <strong>{{ $curso->duracion_horas }} horas</strong> en total
            </p>

            @foreach($curso->modulos as $modulo)
                <div class="modulo-wrap">
                    <div class="modulo-hd" onclick="toggleModulo(this)">
                        <div class="modulo-hd-left">
                            <div class="modulo-num">{{ $loop->iteration }}</div>
                            <div>
                                <div class="modulo-titulo">{{ $modulo->titulo }}</div>
                                <div class="modulo-count">{{ $modulo->lecciones->count() }} lecciones</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down modulo-chevron {{ $loop->first ? 'open' : '' }}"></i>
                    </div>
                    <div class="modulo-body {{ $loop->first ? 'open' : '' }}">
                        @foreach($modulo->lecciones as $leccion)
                            @php
                                $tipoClass = ['texto'=>'tipo-texto','video'=>'tipo-video','pdf'=>'tipo-pdf','quiz'=>'tipo-quiz','tarea'=>'tipo-tarea'][$leccion->tipo_contenido] ?? 'tipo-texto';
                                $tipoIco   = ['texto'=>'fa-file-alt','video'=>'fa-play-circle','pdf'=>'fa-file-pdf','quiz'=>'fa-question-circle','tarea'=>'fa-tasks'][$leccion->tipo_contenido] ?? 'fa-file-alt';
                            @endphp
                            <div class="leccion-row">
                                <div class="lec-ico {{ $tipoClass }}">
                                    <i class="fas {{ $tipoIco }}"></i>
                                </div>
                                <span class="lec-titulo">{{ $leccion->titulo }}</span>
                                @if($leccion->duracion_minutos)
                                    <span class="lec-dur">
                                        <i class="fas fa-clock" style="font-size:.7rem;margin-right:.2rem;"></i>
                                        {{ $leccion->duracion_minutos }}min
                                    </span>
                                @endif
                                @if($yaInscrito)
                                    <span class="lec-free-badge"><i class="fas fa-unlock" style="font-size:.6rem;"></i> Disponible</span>
                                @else
                                    <i class="fas fa-lock lec-lock"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if($curso->modulos->isEmpty())
                <div style="text-align:center;padding:3rem;color:var(--muted);font-family:'DM Sans',sans-serif;">
                    <i class="fas fa-layer-group" style="font-size:2rem;display:block;margin-bottom:.75rem;opacity:.3;"></i>
                    Contenido próximamente disponible.
                </div>
            @endif
        </div>

        {{-- Tab: Descripción --}}
        @if($curso->descripcion)
            <div id="tab-descripcion" style="display:none;">
                <div style="font-size:.95rem;color:#475569;line-height:1.85;font-family:'DM Sans',sans-serif;">
                    {!! nl2br(e($curso->descripcion)) !!}
                </div>
            </div>
        @endif

    </div>

    {{-- Sidebar --}}
    <div>

        {{-- Cursos relacionados --}}
        @if($cursosRelacionados->count())
            <div class="sidebar-card">
                <div class="sidebar-title">También te puede interesar</div>
                @foreach($cursosRelacionados as $rel)
                    @php $rc = explode(',', $rel->color_gradiente ?? '#0A4D8C,#3B88D4'); @endphp
                    <a href="{{ route('cursos.show', $rel->slug) }}" class="relac-item">
                        <div class="relac-thumb" style="background:linear-gradient(135deg,{{ $rc[0] }},{{ $rc[1] ?? '#3B88D4' }});">
                            <i class="fas {{ $rel->icono_fa ?? 'fa-graduation-cap' }}"></i>
                        </div>
                        <div class="relac-info">
                            <h4>{{ Str::limit($rel->titulo, 45) }}</h4>
                            <p>{{ $rel->precioFormateado() }} · {{ $rel->duracion_horas }}h · {{ $rel->categoriaLabel() }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Stats del curso --}}
        <div class="sidebar-card">
            <div class="sidebar-title">Detalles del curso</div>
            <div class="incluye-item"><i class="fas fa-tag"></i> {{ $curso->categoriaLabel() }}</div>
            <div class="incluye-item"><i class="fas fa-clock"></i> {{ $curso->duracion_horas }} horas de duración</div>
            <div class="incluye-item"><i class="fas fa-list"></i> {{ $totalLecciones }} lecciones</div>
            <div class="incluye-item"><i class="fas fa-layer-group"></i> {{ $curso->modulos->count() }} módulos</div>
            <div class="incluye-item"><i class="fas fa-users"></i> {{ $curso->totalEstudiantes() }} estudiantes inscritos</div>
            <div class="incluye-item"><i class="fas fa-certificate"></i> Certificado al completar</div>
            <div class="incluye-item">
                <i class="fas fa-signal"></i>
                Nivel: {{ $curso->tipo === 'free' ? 'Gratuito' : 'De pago' }}
            </div>
        </div>

        {{-- CTA si no inscrito --}}
        @if(!$yaInscrito)
            <div style="background:linear-gradient(135deg,var(--c1),var(--c2));border-radius:16px;padding:1.5rem;text-align:center;">
                <i class="fas {{ $icono }}" style="font-size:2rem;color:rgba(255,255,255,.6);display:block;margin-bottom:.75rem;"></i>
                <p style="color:#fff;font-family:'DM Sans',sans-serif;font-size:.9rem;margin:0 0 1rem;line-height:1.5;">
                    ¿Listo para empezar? Inscríbete ahora y accede a todo el contenido.
                </p>
                @if(auth()->check())
                    <form method="POST" action="{{ route('cursos.inscribir', $curso->slug) }}">
                        @csrf
                        <button type="submit" style="width:100%;padding:.8rem;background:#fff;color:var(--c1);border:none;border-radius:10px;font-family:'Poppins',sans-serif;font-size:.88rem;font-weight:700;cursor:pointer;transition:opacity .2s;">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $curso->tipo === 'free' ? 'Inscribirme Gratis' : 'Inscribirme' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="display:block;width:100%;padding:.8rem;background:#fff;color:var(--c1);border-radius:10px;font-family:'Poppins',sans-serif;font-size:.88rem;font-weight:700;text-decoration:none;transition:opacity .2s;">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                @endif
            </div>
        @endif

    </div>
</div>
</div>

@push('scripts')
<script>
function showTab(id, btn) {
    document.querySelectorAll('[id^="tab-"]').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + id).style.display = 'block';
    btn.classList.add('active');
}

function toggleModulo(el) {
    const body = el.nextElementSibling;
    const icon = el.querySelector('.modulo-chevron');
    const isOpen = body.classList.contains('open');
    body.classList.toggle('open', !isOpen);
    icon.classList.toggle('open', !isOpen);
}

document.addEventListener('DOMContentLoaded', () => {
    // Abrir primer módulo
    const firstChevron = document.querySelector('.modulo-chevron');
    if (firstChevron) firstChevron.classList.add('open');
});
</script>
@endpush
@endsection