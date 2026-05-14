@extends('layouts.dashboard')

@section('title', $curso->titulo)
@section('page-title', $curso->titulo)

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --blue:   #0A4D8C;
    --blue-l: #1E6DB8;
    --blue-p: #EBF3FF;
    --green:  #10b981;
    --green-d:#059669;
    --text:   #1a2940;
    --muted:  #64748b;
    --border: #e2e8f0;
    --bg:     #f7f9fc;
    --purple: #7c3aed;
}

/* ── BARRA SUPERIOR ── */
.player-topbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1.25rem; flex-wrap: wrap; gap: .75rem;
}
.btn-volver-cursos {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .55rem 1.1rem;
    background: #fff; border: 1.5px solid var(--border);
    border-radius: 10px; color: var(--text);
    font-family: 'Outfit', sans-serif; font-size: .84rem; font-weight: 700;
    text-decoration: none; transition: all .18s;
    box-shadow: 0 1px 4px rgba(10,37,64,.06);
}
.btn-volver-cursos:hover {
    border-color: var(--blue); color: var(--blue);
    background: var(--blue-p); transform: translateX(-2px);
}

.player-topbar-centro {
    display: flex; align-items: center; gap: .75rem;
    flex: 1; min-width: 0; justify-content: center;
}
.player-topbar-titulo {
    font-family: 'Outfit', sans-serif;
    font-size: .95rem; font-weight: 800; color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 300px;
}
.topbar-prog-wrap { display: flex; align-items: center; gap: .5rem; flex-shrink: 0; }
.topbar-prog-bar {
    width: 80px; height: 5px; background: #e2e8f0;
    border-radius: 999px; overflow: hidden;
}
.topbar-prog-fill {
    height: 100%; background: linear-gradient(90deg, var(--blue), var(--blue-l));
    border-radius: 999px;
}
.topbar-prog-pct {
    font-family: 'Outfit', sans-serif;
    font-size: .78rem; font-weight: 800; color: var(--blue);
}

/* ── LAYOUT ── */
.player-wrap {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 1.25rem; align-items: start;
}

/* ── CARD PRINCIPAL ── */
.player-card {
    background: #fff; border-radius: 18px;
    box-shadow: 0 4px 20px rgba(10,37,64,.08);
    border: 1px solid var(--border); overflow: hidden;
}

.player-header {
    padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, #f8fafc, #eef2f7);
    display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
}
.player-lec-modulo {
    font-family: 'Outfit', sans-serif; font-size: .68rem; font-weight: 700;
    color: var(--muted); text-transform: uppercase; letter-spacing: .1em;
    margin-bottom: .3rem; display: flex; align-items: center; gap: .3rem;
}
.player-lec-titulo {
    font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 800;
    color: var(--text); margin: 0 0 .5rem; line-height: 1.2;
}
.player-lec-meta { display: flex; gap: .5rem; flex-wrap: wrap; align-items: center; }

.tipo-chip {
    display: inline-flex; align-items: center; gap: .3rem;
    font-family: 'Outfit', sans-serif; font-size: .7rem; font-weight: 800;
    padding: .22rem .65rem; border-radius: 999px;
}
.tc-video { background:#fee2e2;color:#dc2626; }
.tc-texto { background:#dbeafe;color:#1d4ed8; }
.tc-pdf   { background:#fef3c7;color:#d97706; }
.tc-quiz  { background:#ede9fe;color:#7c3aed; }
.tc-tarea { background:#d1fae5;color:#059669; }

.meta-chip {
    display: inline-flex; align-items: center; gap: .3rem;
    font-family: 'DM Sans', sans-serif; font-size: .74rem; font-weight: 600;
    padding: .22rem .65rem; border-radius: 999px;
    border: 1px solid var(--border); background: #fff; color: var(--muted);
}
.meta-chip.completada { background:#d1fae5;border-color:#6ee7b7;color:var(--green-d); }

.btn-completar {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .6rem 1.2rem;
    background: linear-gradient(135deg, var(--green), var(--green-d));
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: .84rem; font-weight: 800;
    cursor: pointer; white-space: nowrap;
    box-shadow: 0 3px 14px rgba(16,185,129,.35);
    text-decoration: none; transition: all .2s; flex-shrink: 0;
}
.btn-completar:hover { transform:translateY(-1px); box-shadow:0 5px 18px rgba(16,185,129,.45); color:#fff; }
.btn-completar.done { background:#f1f5f9;color:#94a3b8;box-shadow:none;cursor:default;border:1px solid var(--border); }
.btn-completar.btn-bloqueada {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    box-shadow: 0 3px 14px rgba(245,158,11,.35);
    cursor: pointer;
}
.btn-completar.btn-bloqueada:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 18px rgba(245,158,11,.45);
}

.player-content { padding: 1.75rem; }

/* Video */
.video-wrap {
    position:relative;padding-bottom:56.25%;height:0;overflow:hidden;
    border-radius:14px;background:#000;margin-bottom:1.25rem;
    box-shadow:0 8px 32px rgba(0,0,0,.12);
}
.video-wrap iframe { position:absolute;top:0;left:0;width:100%;height:100%;border:0; }
.video-placeholder {
    aspect-ratio:16/9;background:linear-gradient(135deg,#0a0f1e,#0A4D8C);
    border-radius:14px;display:flex;flex-direction:column;
    align-items:center;justify-content:center;color:rgba(255,255,255,.5);
    margin-bottom:1.25rem;
}
.video-placeholder i { font-size:3.5rem;margin-bottom:.75rem; }
.video-placeholder p { font-family:'DM Sans',sans-serif;font-size:.9rem;margin:0; }

.texto-content {
    font-family:'DM Sans',sans-serif;font-size:.96rem;color:#334155;line-height:1.9;
}
.pdf-embed { width:100%;height:600px;border-radius:12px;border:1px solid var(--border); }
.pdf-fallback {
    background:var(--bg);border:2px dashed var(--border);
    border-radius:14px;padding:3rem;text-align:center;color:var(--muted);
}

/* Quiz CTA */
.quiz-cta-wrap {
    background:linear-gradient(135deg,#2e1065,#4c1d95,#6d28d9);
    border-radius:18px;overflow:hidden;position:relative;
    box-shadow:0 8px 32px rgba(109,40,217,.3);
}
.quiz-cta-wrap::before {
    content:'';position:absolute;inset:0;
    background-image:radial-gradient(rgba(255,255,255,.05) 1px,transparent 1px);
    background-size:22px 22px;
}
.quiz-cta-wrap::after {
    content:'';position:absolute;width:300px;height:300px;border-radius:50%;
    background:radial-gradient(rgba(255,255,255,.06),transparent 70%);
    top:-100px;right:-80px;
}
.quiz-cta-inner { position:relative;z-index:1;padding:2.5rem;text-align:center; }
.quiz-cta-icon {
    width:72px;height:72px;border-radius:20px;
    background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.2);
    display:flex;align-items:center;justify-content:center;
    font-size:1.75rem;color:#fff;margin:0 auto 1.25rem;
}
.quiz-cta-titulo { font-family:'Outfit',sans-serif;font-size:1.4rem;font-weight:900;color:#fff;margin:0 0 .5rem; }
.quiz-cta-desc { font-family:'DM Sans',sans-serif;font-size:.9rem;color:rgba(255,255,255,.7);margin:0 0 1.75rem; }
.quiz-stats-row { display:flex;gap:1rem;justify-content:center;margin-bottom:1.75rem;flex-wrap:wrap; }
.qstat {
    background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
    border-radius:12px;padding:.875rem 1.25rem;text-align:center;min-width:80px;
}
.qstat-num { font-family:'Outfit',sans-serif;font-size:1.4rem;font-weight:900;color:#fff;line-height:1; }
.qstat-label { font-family:'DM Sans',sans-serif;font-size:.68rem;color:rgba(255,255,255,.6);margin-top:.2rem;text-transform:uppercase; }
.btn-iniciar-quiz {
    display:inline-flex;align-items:center;gap:.5rem;
    padding:.9rem 2.25rem;background:#fff;color:var(--purple);
    border-radius:12px;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;
    text-decoration:none;box-shadow:0 4px 20px rgba(0,0,0,.2);transition:all .2s;
}
.btn-iniciar-quiz:hover { transform:translateY(-2px);box-shadow:0 8px 28px rgba(0,0,0,.25);color:var(--purple); }

.quiz-historial {
    margin-top:1.25rem;padding:1.25rem;
    background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:12px;
}
.quiz-historial-title {
    font-family:'Outfit',sans-serif;font-size:.72rem;font-weight:700;
    color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.08em;margin-bottom:.75rem;
}
.intento-row {
    display:flex;align-items:center;justify-content:space-between;gap:.75rem;
    padding:.5rem 0;border-bottom:1px solid rgba(255,255,255,.1);
    font-family:'DM Sans',sans-serif;font-size:.83rem;color:rgba(255,255,255,.8);
}
.intento-row:last-child { border-bottom:none; }
.intento-badge { font-family:'Outfit',sans-serif;font-size:.7rem;font-weight:700;padding:.15rem .55rem;border-radius:999px; }
.intento-badge.ok  { background:rgba(16,185,129,.25);color:#6ee7b7; }
.intento-badge.err { background:rgba(239,68,68,.25);color:#fca5a5; }

/* Nav */
.player-nav {
    display:flex;gap:.75rem;justify-content:space-between;
    padding:1rem 1.5rem;border-top:1px solid var(--border);
    background:linear-gradient(135deg,#f8fafc,#f1f5f9);
}
.nav-btn {
    display:inline-flex;align-items:center;gap:.45rem;
    padding:.65rem 1.2rem;border-radius:10px;
    font-family:'Outfit',sans-serif;font-size:.84rem;font-weight:700;
    text-decoration:none;transition:all .18s;
    border:1.5px solid var(--border);background:#fff;color:var(--text);
}
.nav-btn:hover { border-color:var(--blue);color:var(--blue);background:var(--blue-p); }
.nav-btn.next {
    background:linear-gradient(135deg,var(--blue),var(--blue-l));
    color:#fff;border-color:transparent;box-shadow:0 3px 12px rgba(10,77,140,.3);
}
.nav-btn.next:hover { transform:translateY(-1px);box-shadow:0 5px 18px rgba(10,77,140,.4);color:#fff; }
.nav-btn.fin { background:linear-gradient(135deg,var(--green),var(--green-d));color:#fff;border-color:transparent;cursor:default; }
.nav-btn.disabled { opacity:.35;pointer-events:none; }

/* ── SIDEBAR ── */
.sidebar-card {
    background:#fff;border-radius:18px;
    box-shadow:0 4px 20px rgba(10,37,64,.08);
    border:1px solid var(--border);overflow:hidden;
    position:sticky;top:16px;
}
.sidebar-head {
    padding:1rem 1.25rem;border-bottom:1px solid var(--border);
    background:linear-gradient(135deg,#0A2540,var(--blue));
    display:flex;align-items:center;justify-content:space-between;
}
.sidebar-title {
    font-family:'Outfit',sans-serif;font-size:.88rem;font-weight:800;
    color:#fff;margin:0;display:flex;align-items:center;gap:.45rem;
}
.curso-prog-wrap { padding:.875rem 1.25rem;border-bottom:1px solid var(--border); }
.prog-row { display:flex;justify-content:space-between;align-items:center;margin-bottom:.4rem; }
.prog-label { font-family:'DM Sans',sans-serif;font-size:.78rem;color:var(--muted); }
.prog-pct { font-family:'Outfit',sans-serif;font-size:.85rem;font-weight:800;color:var(--blue); }
.prog-bar { height:6px;background:#e2e8f0;border-radius:999px;overflow:hidden; }
.prog-fill { height:100%;background:linear-gradient(90deg,var(--blue),var(--blue-l));border-radius:999px;transition:width .6s; }
.prog-sub { font-family:'DM Sans',sans-serif;font-size:.7rem;color:#94a3b8;margin-top:.3rem; }

.modulos-list { max-height:calc(100vh - 320px);overflow-y:auto; }
.modulos-list::-webkit-scrollbar { width:3px; }
.modulos-list::-webkit-scrollbar-thumb { background:#d1d9e0;border-radius:999px; }

.modulo-group { border-bottom:1px solid #f1f5f9; }
.modulo-group:last-child { border-bottom:none; }
.modulo-label {
    padding:.7rem 1.25rem;
    font-family:'Outfit',sans-serif;font-size:.68rem;font-weight:800;color:var(--muted);
    text-transform:uppercase;letter-spacing:.07em;background:#f8fafc;
    display:flex;align-items:center;justify-content:space-between;
    cursor:pointer;user-select:none;transition:background .15s;
}
.modulo-label:hover { background:#f1f5f9; }
.modulo-label-left { display:flex;align-items:center;gap:.5rem; }
.mod-num {
    width:18px;height:18px;border-radius:5px;background:var(--blue);color:#fff;
    font-size:.58rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;
}

.lec-item {
    display:flex;align-items:center;gap:.6rem;padding:.6rem 1.25rem;
    border-bottom:1px solid #f8fafc;text-decoration:none;transition:background .15s;
}
.lec-item:last-child { border-bottom:none; }
.lec-item:hover { background:#f0f7ff; }
.lec-item.active { background:var(--blue-p);border-left:3px solid var(--blue);padding-left:calc(1.25rem - 3px); }

.lec-ico {
    width:26px;height:26px;border-radius:7px;
    display:flex;align-items:center;justify-content:center;font-size:.68rem;flex-shrink:0;
}
.li-video{background:#fee2e2;color:#dc2626;}
.li-texto{background:#dbeafe;color:#1d4ed8;}
.li-pdf  {background:#fef3c7;color:#d97706;}
.li-quiz {background:#ede9fe;color:#7c3aed;}
.li-tarea{background:#d1fae5;color:#059669;}

.lec-info { flex:1;min-width:0; }
.lec-titulo {
    font-family:'DM Sans',sans-serif;font-size:.81rem;font-weight:600;color:var(--text);
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.3;
}
.lec-item.active .lec-titulo { color:var(--blue);font-weight:700; }
.lec-dur { font-size:.66rem;color:#94a3b8;margin-top:.1rem; }
.lec-state {
    width:18px;height:18px;border-radius:50%;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;font-size:.58rem;
}
.ls-done   { background:var(--green);color:#fff; }
.ls-active { background:var(--blue);color:#fff; }
.ls-pending{ background:#e2e8f0;color:#94a3b8; }

.sidebar-footer { padding:.875rem 1.25rem;border-top:1px solid var(--border);background:#f8fafc; }
.btn-ver-curso {
    display:flex;align-items:center;justify-content:center;gap:.4rem;
    width:100%;padding:.6rem;background:#fff;border:1.5px solid var(--border);
    border-radius:9px;font-family:'Outfit',sans-serif;font-size:.82rem;font-weight:700;
    color:var(--muted);text-decoration:none;transition:all .18s;
}
.btn-ver-curso:hover { border-color:var(--blue);color:var(--blue);background:var(--blue-p); }

/* Flash */
.player-flash {
    display:flex;align-items:center;gap:.65rem;
    background:#f0fdf4;border:1px solid #6ee7b7;border-radius:12px;
    padding:.875rem 1.25rem;font-family:'DM Sans',sans-serif;font-size:.88rem;color:#065f46;
    margin-bottom:1.25rem;animation:flashIn .3s ease;
}
@keyframes flashIn { from{opacity:0;transform:translateY(-8px);} to{opacity:1;transform:translateY(0);} }

@media (max-width:1100px) {
    .player-wrap { grid-template-columns:1fr; }
    .sidebar-card { position:static; }
    .modulos-list { max-height:280px; }
}
@media (max-width:600px) {
    .player-topbar-centro { display:none; }
}
</style>

{{-- Barra superior --}}
<div class="player-topbar">
    <a href="{{ route('dashboard.cursos') }}" class="btn-volver-cursos">
        <i class="fas fa-arrow-left"></i> Mis Cursos
    </a>
    <div class="player-topbar-centro">
        <span class="player-topbar-titulo">{{ $curso->titulo }}</span>
        <div class="topbar-prog-wrap">
            <div class="topbar-prog-bar">
                <div class="topbar-prog-fill" style="width:{{ $progreso }}%"></div>
            </div>
            <span class="topbar-prog-pct">{{ $progreso }}%</span>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="player-flash">
        <i class="fas fa-check-circle" style="color:var(--green);font-size:1.1rem;flex-shrink:0;"></i>
        {{ session('success') }}
    </div>
@endif

<div class="player-wrap">
    <div>
        <div class="player-card">
            {{-- Header --}}
            <div class="player-header">
                <div style="flex:1;min-width:0;">
                    <div class="player-lec-modulo">
                        <i class="fas fa-layer-group"></i>
                        {{ $leccionActiva->modulo->titulo ?? 'Módulo' }}
                    </div>
                    <h2 class="player-lec-titulo">{{ $leccionActiva->titulo }}</h2>
                    <div class="player-lec-meta">
                        @php
                            $tcMap = ['texto'=>['tc-texto','fa-file-alt','Lectura'],'video'=>['tc-video','fa-play-circle','Video'],'pdf'=>['tc-pdf','fa-file-pdf','PDF'],'quiz'=>['tc-quiz','fa-question-circle','Quiz'],'tarea'=>['tc-tarea','fa-tasks','Tarea']];
                            [$tcClass,$tcIco,$tcLabel] = $tcMap[$leccionActiva->tipo_contenido] ?? ['tc-texto','fa-file-alt','Contenido'];
                        @endphp
                        <span class="tipo-chip {{ $tcClass }}"><i class="fas {{ $tcIco }}"></i> {{ $tcLabel }}</span>
                        @if($leccionActiva->duracion_minutos)
                            <span class="meta-chip"><i class="fas fa-clock"></i> {{ $leccionActiva->duracion_minutos }} min</span>
                        @endif
                        @if($leccionCompletada)
                            <span class="meta-chip completada"><i class="fas fa-check-circle"></i> Completada</span>
                        @endif
                    </div>
                </div>
                @if(!$leccionCompletada && $leccionActiva->tipo_contenido !== 'quiz')
                    @php
                        $tipoConTimer = in_array($leccionActiva->tipo_contenido, ['texto', 'tarea']);
                        $minSegundos  = 300; // 5 minutos
                        $yaAcumulo    = $tiempoAcumulado >= $minSegundos;
                    @endphp
                    @if($leccionBloqueada)
                        {{-- Lección bloqueada: botón que abre modal de aviso --}}
                        <button type="button" class="btn-completar btn-bloqueada"
                            onclick="abrirModalBloqueada()">
                            <i class="fas fa-lock"></i> Completa la lección anterior
                        </button>
                    @else
                        <form method="POST" action="{{ route('leccion.completar', $leccionActiva) }}" id="form-completar">
                            @csrf
                            <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                            @if($tipoConTimer && !$yaAcumulo)
                                <button type="button" id="btn-completar-timer"
                                    class="btn-completar"
                                    style="background:#94a3b8;cursor:not-allowed;opacity:.75;"
                                    disabled>
                                    <i class="fas fa-clock"></i>
                                    <span id="timer-label">Disponible en 5:00</span>
                                </button>
                            @else
                                <button type="submit" class="btn-completar" id="btn-completar-ok">
                                    <i class="fas fa-check"></i> Marcar completada
                                </button>
                            @endif
                        </form>
                    @endif
                @elseif($leccionCompletada)
                    <span class="btn-completar done"><i class="fas fa-check-double"></i> Completada</span>
                @endif
            </div>

            {{-- Contenido --}}
            <div class="player-content">
                @if($leccionActiva->tipo_contenido === 'video')
                    @php
                        $videoUrl   = $leccionActiva->video_url ?? '';
                        $videoLocal = $leccionActiva->video_local ?? '';
                        $videoUrl   = $leccionActiva->video_url ?? '';
                        $embedUrl   = '';
                        $esLocal    = !empty($videoLocal); // video_local = public_id de Cloudinary
                        if (!$esLocal) {
                            if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                preg_match('/(?:v=|youtu\.be\/)([^&\?]+)/', $videoUrl, $m);
                                $embedUrl = 'https://www.youtube.com/embed/' . ($m[1] ?? '') . '?rel=0';
                            } elseif (str_contains($videoUrl, 'vimeo.com')) {
                                preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $m);
                                $embedUrl = 'https://player.vimeo.com/video/' . ($m[1] ?? '');
                            }
                        }
                    @endphp
                    @if($esLocal)
                        {{-- Video subido al servidor: reproductor nativo --}}
                        <div class="video-wrap" style="background:#000;">
                            <video controls style="width:100%;max-height:480px;display:block;"
                                preload="metadata"
                                controlslist="nodownload">
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                Tu navegador no soporta la reproducción de video.
                            </video>
                        </div>
                    @elseif($embedUrl)
                        <div class="video-wrap"><iframe src="{{ $embedUrl }}" allowfullscreen loading="lazy"></iframe></div>
                    @elseif($videoUrl)
                        <div class="video-placeholder">
                            <i class="fas fa-play-circle"></i>
                            <p>No se puede incrustar este video</p>
                            <a href="{{ $videoUrl }}" target="_blank" style="color:#60B0FF;margin-top:.75rem;font-size:.85rem;font-family:'DM Sans',sans-serif;">
                                <i class="fas fa-external-link-alt"></i> Abrir en nueva pestaña
                            </a>
                        </div>
                    @else
                        <div class="video-placeholder"><i class="fas fa-video"></i><p>Video próximamente disponible</p></div>
                    @endif
                    @if($leccionActiva->contenido)
                        <div class="texto-content" style="margin-top:1.5rem;">{!! $leccionActiva->contenido !!}</div>
                    @endif

                @elseif($leccionActiva->tipo_contenido === 'pdf')
                    @if($leccionActiva->archivo)
                        <iframe src="{{ $leccionActiva->archivo }}" class="pdf-embed"></iframe>
                    @else
                        <div class="pdf-fallback"><i class="fas fa-file-pdf" style="font-size:3rem;color:#d97706;display:block;margin-bottom:1rem;"></i><p style="font-family:'DM Sans',sans-serif;">PDF próximamente disponible.</p></div>
                    @endif

                @elseif($leccionActiva->tipo_contenido === 'quiz')
                    @if($leccionActiva->quiz)
                        @php $quiz = $leccionActiva->quiz; $intentosUser = $quiz->intentosDeUsuario(auth()->id()); $puedeIntentar = $quiz->puedeIntentar(auth()->id()); @endphp
                        <div class="quiz-cta-wrap">
                            <div class="quiz-cta-inner">
                                <div class="quiz-cta-icon"><i class="fas fa-question-circle"></i></div>
                                <h3 class="quiz-cta-titulo">{{ $quiz->titulo ?? $leccionActiva->titulo }}</h3>
                                <p class="quiz-cta-desc">{{ $quiz->descripcion ?? 'Pon a prueba tu conocimiento con este quiz.' }}</p>
                                <div class="quiz-stats-row">
                                    <div class="qstat"><div class="qstat-num">{{ $quiz->preguntas->count() }}</div><div class="qstat-label">Preguntas</div></div>
                                    <div class="qstat"><div class="qstat-num">{{ $quiz->puntaje_aprobatorio }}%</div><div class="qstat-label">Para aprobar</div></div>
                                    @if($quiz->tiempo_limite)<div class="qstat"><div class="qstat-num">{{ $quiz->tiempo_limite }}</div><div class="qstat-label">Minutos</div></div>@endif
                                    <div class="qstat"><div class="qstat-num">{{ $quiz->intentos_permitidos == -1 ? '∞' : $quiz->intentos_permitidos }}</div><div class="qstat-label">Intentos</div></div>
                                </div>
                                @if($leccionBloqueada)
                                    <a href="#" onclick="event.preventDefault();abrirModalBloqueada();" class="btn-iniciar-quiz"
                                        style="background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 4px 20px rgba(245,158,11,.3);">
                                        <i class="fas fa-lock"></i> Completa la lección anterior primero
                                    </a>
                                @elseif($puedeIntentar)
                                    <a href="{{ route('quiz.show', $quiz) }}" class="btn-iniciar-quiz">
                                        <i class="fas fa-play-circle"></i> {{ $intentosUser->count() > 0 ? 'Reintentar Quiz' : 'Iniciar Quiz' }}
                                    </a>
                                @else
                                    <div style="display:inline-flex;align-items:center;gap:.5rem;padding:.9rem 2rem;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);border-radius:12px;color:rgba(255,255,255,.7);font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:700;">
                                        <i class="fas fa-lock"></i> Sin intentos disponibles
                                    </div>
                                @endif
                                @if($intentosUser->count() > 0)
                                    <div class="quiz-historial">
                                        <div class="quiz-historial-title"><i class="fas fa-history" style="margin-right:.3rem;"></i> Mis intentos anteriores</div>
                                        @foreach($intentosUser->take(5) as $intento)
                                            <div class="intento-row">
                                                <span>Intento {{ $loop->iteration }}</span>
                                                <span>{{ number_format($intento->porcentaje, 1) }}%</span>
                                                <span class="intento-badge {{ $intento->aprobado ? 'ok' : 'err' }}">{{ $intento->aprobado ? 'Aprobado' : 'No aprobado' }}</span>
                                                <a href="{{ route('quiz.resultado', $intento) }}" style="color:rgba(255,255,255,.6);font-size:.75rem;font-family:'DM Sans',sans-serif;text-decoration:none;">
                                                    Ver <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div style="text-align:center;padding:3rem;color:var(--muted);"><i class="fas fa-tools" style="font-size:2.5rem;display:block;margin-bottom:1rem;opacity:.3;"></i><p style="font-family:'DM Sans',sans-serif;">Quiz en construcción.</p></div>
                    @endif

                @elseif($leccionActiva->tipo_contenido === 'tarea')
                    <div style="background:var(--bg);border:1px solid var(--border);border-radius:14px;padding:1.75rem;">
                        <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:1rem;">
                            <div style="width:38px;height:38px;border-radius:10px;background:#d1fae5;color:#059669;display:flex;align-items:center;justify-content:center;font-size:.95rem;"><i class="fas fa-tasks"></i></div>
                            <h4 style="font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;color:var(--text);margin:0;">Tarea</h4>
                        </div>
                        @if($leccionActiva->contenido)<div class="texto-content">{!! $leccionActiva->contenido !!}</div>
                        @else<p style="font-family:'DM Sans',sans-serif;color:var(--muted);font-size:.9rem;margin:0;">Instrucciones próximamente disponibles.</p>@endif
                    </div>

                @else
                    @if($leccionActiva->contenido)<div class="texto-content">{!! $leccionActiva->contenido !!}</div>
                    @else<div style="text-align:center;padding:3rem;color:var(--muted);"><i class="fas fa-file-alt" style="font-size:2.5rem;display:block;margin-bottom:.75rem;opacity:.25;"></i><p style="font-family:'DM Sans',sans-serif;">Contenido próximamente disponible.</p></div>@endif
                @endif
            </div>

            {{-- Nav --}}
            <div class="player-nav">
                @if($leccionAnterior)
                    <a href="{{ route('curso.player.leccion', [$curso->slug, $leccionAnterior->id]) }}" class="nav-btn"><i class="fas fa-arrow-left"></i> Anterior</a>
                @else
                    <span class="nav-btn disabled"><i class="fas fa-arrow-left"></i> Anterior</span>
                @endif
                @if($leccionSiguiente)
                    <a href="{{ route('curso.player.leccion', [$curso->slug, $leccionSiguiente->id]) }}" class="nav-btn next">Siguiente <i class="fas fa-arrow-right"></i></a>
                @else
                    <span class="nav-btn fin"><i class="fas fa-flag-checkered"></i> Fin del curso</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div>
        <div class="sidebar-card">
            <div class="sidebar-head">
                <h3 class="sidebar-title"><i class="fas fa-list-ul"></i> Contenido del Curso</h3>
            </div>
            <div class="curso-prog-wrap">
                <div class="prog-row">
                    <span class="prog-label">Tu progreso</span>
                    <span class="prog-pct">{{ $progreso }}%</span>
                </div>
                <div class="prog-bar"><div class="prog-fill" style="width:{{ $progreso }}%"></div></div>
                <div class="prog-sub">{{ $leccionesCompletadasCount }} de {{ $totalLecciones }} lecciones completadas</div>
            </div>
            <div class="modulos-list">
                @foreach($curso->modulos as $modulo)
                    <div class="modulo-group">
                        <div class="modulo-label" onclick="toggleMod({{ $modulo->id }})">
                            <div class="modulo-label-left">
                                <div class="mod-num">{{ $loop->iteration }}</div>
                                {{ Str::limit($modulo->titulo, 26) }}
                            </div>
                            <div style="display:flex;align-items:center;gap:.35rem;">
                                <span style="font-size:.65rem;color:#94a3b8;font-weight:600;">{{ $modulo->lecciones->count() }}</span>
                                <i class="fas fa-chevron-down" id="chev-{{ $modulo->id }}" style="font-size:.58rem;color:#94a3b8;transition:transform .2s;"></i>
                            </div>
                        </div>
                        <div id="mod-{{ $modulo->id }}">
                            @foreach($modulo->lecciones as $lec)
                                @php
                                    $liMap = ['texto'=>'li-texto','video'=>'li-video','pdf'=>'li-pdf','quiz'=>'li-quiz','tarea'=>'li-tarea'];
                                    $liIco = ['texto'=>'fa-file-alt','video'=>'fa-play-circle','pdf'=>'fa-file-pdf','quiz'=>'fa-question-circle','tarea'=>'fa-tasks'];
                                    $isActive    = $lec->id === $leccionActiva->id;
                                    $isDone      = in_array($lec->id, $leccionesCompletadas);
                                    $isLocked    = !in_array($lec->id, $leccionesDesbloqueadas);
                                @endphp
                                {{-- Todas las lecciones son clickeables (vista libre) --}}
                                <a href="{{ route('curso.player.leccion', [$curso->slug, $lec->id]) }}"
                                   class="lec-item {{ $isActive ? 'active' : '' }} {{ $isLocked ? 'lec-bloqueada' : '' }}">
                                    <div class="lec-ico {{ $liMap[$lec->tipo_contenido] ?? 'li-texto' }}" style="{{ $isLocked ? 'position:relative;' : '' }}">
                                        <i class="fas {{ $liIco[$lec->tipo_contenido] ?? 'fa-file-alt' }}"></i>
                                        @if($isLocked)
                                            <span style="position:absolute;top:-4px;right:-4px;width:14px;height:14px;background:#f59e0b;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                                <i class="fas fa-lock" style="font-size:7px;color:#fff;"></i>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="lec-info">
                                        <div class="lec-titulo">{{ $lec->titulo }}</div>
                                        @if($lec->duracion_minutos)<div class="lec-dur">{{ $lec->duracion_minutos }} min</div>@endif
                                    </div>
                                    <div class="lec-state {{ $isActive ? 'ls-active' : ($isDone ? 'ls-done' : 'ls-pending') }}">
                                        <i class="fas {{ $isActive ? 'fa-play' : ($isDone ? 'fa-check' : 'fa-circle') }}" style="font-size:.5rem;"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="sidebar-footer">
                <a href="{{ route('cursos.show', $curso->slug) }}" class="btn-ver-curso">
                    <i class="fas fa-info-circle"></i> Ver página del curso
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal: lección bloqueada --}}
@if($leccionBloqueada)
<div id="modal-bloqueada"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.55);align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#fff;border-radius:16px;max-width:420px;width:100%;padding:2rem;box-shadow:0 20px 60px rgba(0,0,0,.3);position:relative;text-align:center;">
        <button onclick="cerrarModalBloqueada()"
            style="position:absolute;top:1rem;right:1rem;background:none;border:none;font-size:1.2rem;color:#94a3b8;cursor:pointer;">
            <i class="fas fa-times"></i>
        </button>
        <div style="width:64px;height:64px;background:#FEF3C7;border:2px solid #fbbf24;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.75rem;">
            🔒
        </div>
        <h3 style="font-size:1.1rem;font-weight:700;color:#071D36;margin-bottom:.75rem;">
            Lección no disponible aún
        </h3>
        <p style="font-size:.9rem;color:#64748b;line-height:1.6;margin-bottom:1.5rem;">
            Para continuar con esta lección debes completar primero
            <strong style="color:#0A4D8C;">la lección anterior</strong>.
            El curso está diseñado para seguirse en orden.
        </p>
        <button onclick="cerrarModalBloqueada()"
            style="background:#0A4D8C;color:#fff;border:none;border-radius:8px;padding:.7rem 1.75rem;font-size:.9rem;font-weight:700;cursor:pointer;width:100%;">
            Entendido
        </button>
    </div>
</div>
@endif

<script>
function toggleMod(id) {
    const el = document.getElementById('mod-' + id);
    const chev = document.getElementById('chev-' + id);
    const isOpen = el.style.display !== 'none';
    el.style.display = isOpen ? 'none' : 'block';
    if (chev) chev.style.transform = isOpen ? '' : 'rotate(180deg)';
}
document.addEventListener('DOMContentLoaded', () => {
    const active = document.querySelector('.lec-item.active');
    if (active) active.scrollIntoView({ block: 'center', behavior: 'smooth' });
    document.querySelectorAll('.modulo-group').forEach(g => {
        if (g.querySelector('.lec-item.active')) {
            const id = g.querySelector('[id^="mod-"]')?.id?.replace('mod-','');
            if (id) { const c = document.getElementById('chev-'+id); if(c) c.style.transform='rotate(180deg)'; }
        }
    });
});

// ── Modal lección bloqueada ──
function abrirModalBloqueada() {
    document.getElementById('modal-bloqueada').style.display = 'flex';
}
function cerrarModalBloqueada() {
    document.getElementById('modal-bloqueada').style.display = 'none';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') cerrarModalBloqueada();
});

// ── Timer de 5 minutos para lecciones teóricas ──
(function() {
    const timerBtn   = document.getElementById('btn-completar-timer');
    if (!timerBtn) return; // No aplica a esta lección

    const MIN_SEG    = 300; // 5 minutos
    const ACUMULADO  = {{ $tiempoAcumulado ?? 0 }};
    let restante     = Math.max(0, MIN_SEG - ACUMULADO);
    let contando     = restante > 0;
    const label      = document.getElementById('timer-label');

    function formatear(s) {
        const m = Math.floor(s / 60);
        const ss = s % 60;
        return m + ':' + String(ss).padStart(2, '0');
    }

    function desbloquear() {
        timerBtn.disabled          = false;
        timerBtn.style.background  = '';
        timerBtn.style.cursor      = '';
        timerBtn.style.opacity     = '';
        timerBtn.innerHTML         = '<i class="fas fa-check"></i> Marcar completada';
        timerBtn.type              = 'submit'; 
        contando = false;
    }

    if (restante === 0) {
        desbloquear();
        return;
    }

    label.textContent = 'Disponible en ' + formatear(restante);

    const tick = setInterval(() => {
        if (document.hidden) return; // Solo cuenta cuando la pestaña está activa
        restante--;
        if (restante <= 0) {
            clearInterval(tick);
            desbloquear();
        } else {
            label.textContent = 'Disponible en ' + formatear(restante);
        }
    }, 1000);
})();

// Contador de tiempo de estudio
(function() {
    const LECCION_ID = {{ $leccionActiva->id }};
    const CSRF = '{{ csrf_token() }}';
    let segundos = 0;
    let intervalo;

    function enviarTiempo() {
        if (segundos < 10) return;
        fetch(`/leccion/${LECCION_ID}/tiempo`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF
            },
            body: JSON.stringify({ segundos })
        });
        segundos = 0;
    }

    // Contar solo cuando la pestaña está activa
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(intervalo);
            enviarTiempo();
        } else {
            intervalo = setInterval(() => segundos++, 1000);
        }
    });

    // Enviar cada 30 segundos
    setInterval(enviarTiempo, 30000);

    // Enviar al salir de la página
    window.addEventListener('beforeunload', enviarTiempo);

    // Iniciar
    intervalo = setInterval(() => segundos++, 1000);
})();
</script>
@endsection