@extends('admin.layout')
@section('title','Editor de Quiz')
@section('page-title','Editor de Quiz — ' . $leccion->titulo)

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --blue:    #0A4D8C;
    --blue-l:  #1E6DB8;
    --blue-p:  #EBF3FF;
    --text:    #1a2940;
    --muted:   #64748b;
    --border:  #e2e8f0;
    --bg:      #f7f9fc;
    --white:   #ffffff;
    --green:   #10b981;
    --orange:  #f59e0b;
    --red:     #ef4444;
    --purple:  #7c3aed;
    --radius:  12px;
}

* { box-sizing: border-box; }

/* ── LAYOUT ── */
.qe-back {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .83rem; color: var(--blue); font-weight: 700;
    text-decoration: none; margin-bottom: 1.25rem;
    font-family: 'DM Sans', sans-serif;
    transition: gap .18s;
}
.qe-back:hover { gap: .65rem; color: var(--blue); }

.qe-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 1.5rem;
    align-items: start;
}

/* ── CARDS ── */
.qe-card {
    background: var(--white);
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(10,37,64,.07);
    border: 1px solid var(--border);
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.qe-card-head {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
}
.qe-card-title {
    font-family: 'Outfit', sans-serif;
    font-size: .92rem; font-weight: 800; color: var(--text);
    margin: 0; display: flex; align-items: center; gap: .5rem;
}
.qe-card-title i { color: var(--blue); }
.qe-card-body { padding: 1.25rem; }

/* ── FORM FIELDS ── */
.fg { margin-bottom: 1rem; }
.fg label {
    display: block; font-family: 'Outfit', sans-serif;
    font-size: .75rem; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .07em;
    margin-bottom: .35rem;
}
.fi {
    width: 100%; padding: .6rem .9rem;
    border: 1.5px solid var(--border); border-radius: 9px;
    font-size: .87rem; color: var(--text);
    font-family: 'DM Sans', sans-serif; outline: none;
    background: var(--bg);
    transition: border-color .18s, box-shadow .18s, background .18s;
}
.fi:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(10,77,140,.08);
    background: #fff;
}
textarea.fi { resize: vertical; min-height: 68px; }
select.fi {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right .8rem center;
    cursor: pointer;
}

/* Toggle switch */
.toggle-row { display: flex; align-items: center; gap: .65rem; margin-bottom: .75rem; }
.tgl { position: relative; width: 40px; height: 22px; flex-shrink: 0; }
.tgl input { opacity: 0; width: 0; height: 0; }
.tgl-slider {
    position: absolute; inset: 0; background: #d1d9e0;
    border-radius: 999px; cursor: pointer; transition: background .2s;
}
.tgl-slider::before {
    content: ''; position: absolute;
    width: 16px; height: 16px; left: 3px; top: 3px;
    background: #fff; border-radius: 50%; transition: transform .2s;
}
.tgl input:checked + .tgl-slider { background: var(--blue); }
.tgl input:checked + .tgl-slider::before { transform: translateX(18px); }
.tgl-label { font-family: 'DM Sans', sans-serif; font-size: .84rem; font-weight: 600; color: var(--text); }

/* Btn save config */
.btn-save-config {
    width: 100%; padding: .75rem;
    background: linear-gradient(135deg, var(--blue), var(--blue-l));
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: .9rem; font-weight: 800;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: .4rem;
    box-shadow: 0 4px 16px rgba(10,77,140,.3);
    transition: all .2s;
}
.btn-save-config:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(10,77,140,.4); }

/* ── EMPTY STATE ── */
.qe-empty {
    text-align: center; padding: 4rem 2rem;
    color: var(--muted);
}
.qe-empty i { font-size: 3rem; display: block; margin-bottom: .75rem; opacity: .3; }
.qe-empty p { font-family: 'DM Sans', sans-serif; font-size: .9rem; margin: 0; }

/* ── PREGUNTAS ── */
.preguntas-wrap { margin-bottom: 1rem; }

.preg-card {
    background: #fff; border: 1.5px solid var(--border);
    border-radius: 14px; margin-bottom: .875rem;
    overflow: hidden; transition: box-shadow .2s, border-color .2s;
}
.preg-card.dragging { opacity: .5; border-style: dashed; }
.preg-card:hover { border-color: #c5d9f0; }

.preg-head {
    padding: .875rem 1.1rem;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    display: flex; align-items: center; gap: .65rem;
}
.preg-drag {
    color: #cbd5e1; cursor: grab; font-size: .9rem;
    padding: .2rem; transition: color .15s;
}
.preg-drag:hover { color: var(--blue); }
.preg-drag:active { cursor: grabbing; }

.preg-num {
    width: 28px; height: 28px; border-radius: 8px;
    background: linear-gradient(135deg, var(--blue), var(--blue-l));
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-family: 'Outfit', sans-serif; font-size: .75rem; font-weight: 800;
    flex-shrink: 0;
}
.preg-info { flex: 1; min-width: 0; }
.preg-titulo {
    font-family: 'DM Sans', sans-serif;
    font-weight: 700; font-size: .88rem; color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.tipo-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-family: 'Outfit', sans-serif;
    font-size: .66rem; font-weight: 700; padding: .15rem .55rem;
    border-radius: 999px; white-space: nowrap;
}
.badge-om  { background: #dbeafe; color: #1d4ed8; }
.badge-mr  { background: #d1fae5; color: #065f46; }
.badge-vf  { background: #fef3c7; color: #92400e; }
.badge-tl  { background: #ede9fe; color: #5b21b6; }

.preg-actions { display: flex; gap: .35rem; flex-shrink: 0; }
.pact {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .77rem; cursor: pointer; border: none; transition: all .15s;
}
.pact-expand { background: #f0f4f8; color: var(--muted); }
.pact-expand:hover { background: var(--blue-p); color: var(--blue); }
.pact-preview { background: #f0fdf4; color: var(--green); }
.pact-preview:hover { background: #dcfce7; }
.pact-del { background: #fef2f2; color: var(--red); }
.pact-del:hover { background: #fee2e2; }

/* Panel edición pregunta */
.preg-body {
    display: none; padding: 1.25rem;
    border-top: 1px solid var(--border);
    animation: slideDown .22s ease;
}
.preg-body.open { display: block; }
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Grid 2col para tipo/puntos */
.fg-row { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; }

/* ── OPCIONES ── */
.opciones-label {
    font-family: 'Outfit', sans-serif;
    font-size: .75rem; font-weight: 700; color: var(--muted);
    text-transform: uppercase; letter-spacing: .07em;
    margin-bottom: .6rem; display: flex; align-items: center; gap: .4rem;
}
.opciones-label span {
    font-size: .68rem; color: var(--green); font-weight: 600;
    background: #d1fae5; padding: .1rem .45rem; border-radius: 999px;
    text-transform: none; letter-spacing: 0;
}

.opcion-row {
    display: flex; align-items: center; gap: .6rem;
    padding: .5rem .6rem; margin-bottom: .4rem;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 9px; transition: all .15s;
}
.opcion-row:hover { border-color: #b8d4f0; background: #f0f7ff; }
.opcion-row.correct { border-color: #6ee7b7; background: #f0fdf4; }

.opcion-check {
    width: 18px; height: 18px; flex-shrink: 0; cursor: pointer;
    accent-color: var(--green);
}
.opcion-input {
    flex: 1; border: none; background: transparent;
    font-family: 'DM Sans', sans-serif; font-size: .86rem; color: var(--text);
    outline: none;
}
.opcion-del {
    width: 24px; height: 24px; border-radius: 6px;
    background: none; border: none; cursor: pointer;
    color: #cbd5e1; font-size: .75rem;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s; flex-shrink: 0;
}
.opcion-del:hover { background: #fee2e2; color: var(--red); }

.btn-add-opcion {
    width: 100%; padding: .5rem;
    border: 1.5px dashed #cbd5e1; border-radius: 9px;
    background: none; color: var(--muted);
    font-family: 'DM Sans', sans-serif; font-size: .83rem; font-weight: 600;
    cursor: pointer; transition: all .18s; margin-top: .4rem;
    display: flex; align-items: center; justify-content: center; gap: .35rem;
}
.btn-add-opcion:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-p); }

/* VF opciones especiales */
.vf-options { display: flex; gap: .75rem; margin-bottom: .5rem; }
.vf-opt {
    flex: 1; padding: .65rem; border: 2px solid var(--border);
    border-radius: 10px; cursor: pointer; text-align: center;
    font-family: 'Outfit', sans-serif; font-size: .88rem; font-weight: 700;
    transition: all .18s; user-select: none;
    display: flex; align-items: center; justify-content: center; gap: .4rem;
}
.vf-opt.verdadero { color: var(--green); }
.vf-opt.verdadero.selected { background: #d1fae5; border-color: var(--green); }
.vf-opt.falso { color: var(--red); }
.vf-opt.falso.selected { background: #fee2e2; border-color: var(--red); }
.vf-opt:not(.selected):hover { background: var(--bg); border-color: #b8d4f0; }

/* Btn guardar pregunta */
.btn-save-preg {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .55rem 1.1rem; background: var(--green);
    color: #fff; border: none; border-radius: 9px;
    font-family: 'Outfit', sans-serif; font-size: .84rem; font-weight: 700;
    cursor: pointer; margin-top: 1rem; transition: all .18s;
    box-shadow: 0 3px 12px rgba(16,185,129,.3);
}
.btn-save-preg:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(16,185,129,.4); }

/* ── NUEVA PREGUNTA ── */
.nueva-preg {
    background: linear-gradient(135deg, #f0f7ff, #e8f2ff);
    border: 1.5px dashed #93c5fd;
    border-radius: 14px; padding: 1.5rem;
}
.nueva-preg-title {
    font-family: 'Outfit', sans-serif;
    font-size: .88rem; font-weight: 800; color: var(--blue);
    margin: 0 0 1rem; display: flex; align-items: center; gap: .4rem;
}

/* Tipo selector grid */
.tipo-selector {
    display: grid; grid-template-columns: repeat(2, 1fr);
    gap: .5rem; margin-bottom: 1rem;
}
.tipo-opt {
    padding: .65rem .75rem; border: 2px solid var(--border);
    border-radius: 10px; cursor: pointer;
    font-family: 'DM Sans', sans-serif; font-size: .83rem; font-weight: 600;
    color: var(--muted); transition: all .18s; user-select: none;
    display: flex; align-items: center; gap: .45rem;
    background: #fff;
}
.tipo-opt input { display: none; }
.tipo-opt:has(input:checked) { border-color: var(--blue); background: var(--blue-p); color: var(--blue); }
.tipo-opt:not(:has(input:checked)):hover { border-color: #93c5fd; background: #f0f7ff; }
.tipo-opt i { font-size: .85rem; }

.btn-add-preg {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .7rem 1.5rem;
    background: linear-gradient(135deg, var(--blue), var(--blue-l));
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: .9rem; font-weight: 800;
    cursor: pointer; transition: all .2s;
    box-shadow: 0 4px 16px rgba(10,77,140,.3);
}
.btn-add-preg:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(10,77,140,.4); }

/* ── PREVIEW MODAL ── */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(10,37,64,.6); backdrop-filter: blur(4px);
    z-index: 9999; align-items: center; justify-content: center;
    padding: 1.5rem;
}
.modal-overlay.open { display: flex; animation: fadeOverlay .2s ease; }
@keyframes fadeOverlay { from { opacity: 0; } to { opacity: 1; } }

.preview-modal {
    background: #fff; border-radius: 20px;
    max-width: 580px; width: 100%;
    box-shadow: 0 24px 80px rgba(10,37,64,.3);
    overflow: hidden;
    animation: slideUpModal .25s cubic-bezier(.22,1,.36,1);
}
@keyframes slideUpModal {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
.preview-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, var(--blue), var(--blue-l));
    display: flex; align-items: center; justify-content: space-between;
}
.preview-header h3 {
    font-family: 'Outfit', sans-serif; font-size: .9rem; font-weight: 800;
    color: #fff; margin: 0; display: flex; align-items: center; gap: .4rem;
}
.preview-close {
    background: rgba(255,255,255,.2); border: none; border-radius: 8px;
    width: 32px; height: 32px; color: #fff; cursor: pointer; font-size: .88rem;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s;
}
.preview-close:hover { background: rgba(255,255,255,.3); }
.preview-body { padding: 1.75rem; }
.preview-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-family: 'Outfit', sans-serif;
    font-size: .7rem; font-weight: 700; padding: .2rem .6rem;
    border-radius: 999px; margin-bottom: 1rem;
}
.preview-question {
    font-family: 'Outfit', sans-serif;
    font-size: 1.1rem; font-weight: 700; color: var(--text);
    margin-bottom: 1.25rem; line-height: 1.4;
}
.preview-options { display: flex; flex-direction: column; gap: .5rem; }
.preview-option {
    padding: .75rem 1rem; border: 2px solid var(--border);
    border-radius: 10px; font-family: 'DM Sans', sans-serif;
    font-size: .9rem; color: var(--text); cursor: pointer;
    transition: all .18s; display: flex; align-items: center; gap: .65rem;
}
.preview-option:hover { border-color: var(--blue); background: var(--blue-p); }
.preview-option .opt-letter {
    width: 28px; height: 28px; border-radius: 8px;
    background: var(--bg); border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Outfit', sans-serif; font-size: .75rem; font-weight: 700;
    color: var(--muted); flex-shrink: 0; transition: all .18s;
}
.preview-option:hover .opt-letter { background: var(--blue); border-color: var(--blue); color: #fff; }
.preview-footer {
    padding: 1rem 1.5rem; border-top: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
    background: var(--bg);
}
.preview-note {
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem; color: var(--muted);
    display: flex; align-items: center; gap: .3rem;
}
.preview-note i { color: var(--orange); }

/* Stats badge */
.quiz-stats-row {
    display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.25rem;
}
.qstat {
    flex: 1; min-width: 80px; background: var(--bg);
    border: 1px solid var(--border); border-radius: 10px;
    padding: .65rem .875rem; text-align: center;
}
.qstat-num {
    font-family: 'Outfit', sans-serif;
    font-size: 1.25rem; font-weight: 800; color: var(--blue);
}
.qstat-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .68rem; color: var(--muted); margin-top: .1rem;
}

/* Responsive */
@media (max-width: 900px) { .qe-grid { grid-template-columns: 1fr; } }
</style>

<a href="{{ route('admin.cursos.show', $curso) }}" class="qe-back">
    <i class="fas fa-arrow-left"></i> Volver al curso
</a>

<div class="qe-grid">

    {{-- ══ SIDEBAR CONFIG ══ --}}
    <div>
        <div class="qe-card">
            <div class="qe-card-head">
                <h3 class="qe-card-title"><i class="fas fa-cog"></i> Configuración del Quiz</h3>
            </div>
            <div class="qe-card-body">
                <form method="POST" action="{{ route('admin.quiz.save', $leccion) }}">
                    @csrf
                    <div class="fg">
                        <label>Título del quiz</label>
                        <input type="text" name="titulo" class="fi"
                            value="{{ old('titulo', $quiz->titulo ?? '') }}"
                            placeholder="{{ $leccion->titulo }}">
                    </div>
                    <div class="fg">
                        <label>Descripción / instrucciones</label>
                        <textarea name="descripcion" class="fi">{{ old('descripcion', $quiz->descripcion ?? '') }}</textarea>
                    </div>
                    <div class="fg-row">
                        <div class="fg">
                            <label>Puntaje mínimo (%)</label>
                            <input type="number" name="puntaje_aprobatorio" class="fi" min="1" max="100"
                                value="{{ old('puntaje_aprobatorio', $quiz->puntaje_aprobatorio ?? 70) }}">
                        </div>
                        <div class="fg">
                            <label>Intentos (-1 = ∞)</label>
                            <input type="number" name="intentos_permitidos" class="fi" min="-1"
                                value="{{ old('intentos_permitidos', $quiz->intentos_permitidos ?? 3) }}">
                        </div>
                    </div>
                    <div class="fg">
                        <label>Tiempo límite (min, vacío = sin límite)</label>
                        <input type="number" name="tiempo_limite" class="fi" min="1" max="300"
                            value="{{ old('tiempo_limite', $quiz->tiempo_limite ?? '') }}"
                            placeholder="Sin límite">
                    </div>
                    <div class="toggle-row">
                        <label class="tgl">
                            <input type="checkbox" name="mostrar_respuestas" value="1"
                                {{ ($quiz->exists ? $quiz->mostrar_respuestas : true) ? 'checked' : '' }}>
                            <span class="tgl-slider"></span>
                        </label>
                        <span class="tgl-label">Mostrar respuestas al terminar</span>
                    </div>
                    <div class="toggle-row">
                        <label class="tgl">
                            <input type="checkbox" name="aleatorio" value="1"
                                {{ ($quiz->exists && $quiz->aleatorio) ? 'checked' : '' }}>
                            <span class="tgl-slider"></span>
                        </label>
                        <span class="tgl-label">Preguntas en orden aleatorio</span>
                    </div>
                    <button type="submit" class="btn-save-config" style="margin-top:.5rem;">
                        <i class="fas fa-save"></i> Guardar Configuración
                    </button>
                </form>
            </div>
        </div>

        {{-- Stats del quiz --}}
        @if($quiz->exists)
        <div class="qe-card">
            <div class="qe-card-head">
                <h3 class="qe-card-title"><i class="fas fa-chart-bar"></i> Resumen</h3>
            </div>
            <div class="qe-card-body" style="padding:1rem;">
                <div class="quiz-stats-row">
                    <div class="qstat">
                        <div class="qstat-num">{{ $quiz->preguntas->count() }}</div>
                        <div class="qstat-label">Preguntas</div>
                    </div>
                    <div class="qstat">
                        <div class="qstat-num">{{ $quiz->preguntas->sum('puntos') }}</div>
                        <div class="qstat-label">Pts totales</div>
                    </div>
                    <div class="qstat">
                        <div class="qstat-num">{{ $quiz->puntaje_aprobatorio }}%</div>
                        <div class="qstat-label">Para aprobar</div>
                    </div>
                </div>
                <a href="{{ route('admin.quiz.estadisticas', $quiz) }}"
                    style="display:flex;align-items:center;gap:.5rem;font-size:.84rem;color:var(--blue);font-weight:700;text-decoration:none;">
                    <i class="fas fa-chart-line"></i> Ver estadísticas completas
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- ══ ÁREA DE PREGUNTAS ══ --}}
    <div>
        @if(!$quiz->exists)
            <div class="qe-card">
                <div class="qe-empty">
                    <i class="fas fa-save"></i>
                    <p>Guarda la configuración primero para poder agregar preguntas.</p>
                </div>
            </div>
        @else
            <div class="qe-card">
                <div class="qe-card-head">
                    <h3 class="qe-card-title">
                        <i class="fas fa-list-ul"></i>
                        Preguntas
                        <span style="background:var(--blue-p);color:var(--blue);font-size:.72rem;padding:.1rem .5rem;border-radius:999px;">
                            {{ $quiz->preguntas->count() }}
                        </span>
                    </h3>
                    <span style="font-size:.75rem;color:var(--muted);font-family:'DM Sans',sans-serif;">
                        <i class="fas fa-grip-vertical" style="margin-right:.3rem;"></i>Arrastra para reordenar
                    </span>
                </div>
                <div class="qe-card-body">

                    {{-- Lista de preguntas --}}
                    <div class="preguntas-wrap" id="preguntasContainer">
                        @forelse($quiz->preguntas as $preg)
                        @php
                            $badgeClass = match($preg->tipo) {
                                'opcion_multiple'   => 'badge-om',
                                'multiple_respuesta'=> 'badge-mr',
                                'verdadero_falso'   => 'badge-vf',
                                'texto_libre'       => 'badge-tl',
                                default             => 'badge-om'
                            };
                            $tipoIcon = match($preg->tipo) {
                                'opcion_multiple'   => 'fa-dot-circle',
                                'multiple_respuesta'=> 'fa-check-square',
                                'verdadero_falso'   => 'fa-toggle-on',
                                'texto_libre'       => 'fa-pen',
                                default             => 'fa-dot-circle'
                            };
                        @endphp
                        <div class="preg-card" draggable="true" data-id="{{ $preg->id }}">
                            <div class="preg-head">
                                <div class="preg-drag"><i class="fas fa-grip-vertical"></i></div>
                                <div class="preg-num">{{ $loop->iteration }}</div>
                                <div class="preg-info">
                                    <div class="preg-titulo">{{ $preg->pregunta }}</div>
                                    <span class="tipo-badge {{ $badgeClass }}">
                                        <i class="fas {{ $tipoIcon }}"></i> {{ $preg->tipoLabel() }}
                                        · {{ $preg->puntos }} pt{{ $preg->puntos != 1 ? 's' : '' }}
                                    </span>
                                </div>
                                <div class="preg-actions">
                                    <button class="pact pact-preview" title="Vista previa"
                                        onclick="previewPregunta({{ $preg->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="pact pact-expand" title="Editar"
                                        onclick="togglePreg({{ $preg->id }}, this)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.quiz.eliminarPregunta', $preg) }}"
                                          onsubmit="return confirm('¿Eliminar esta pregunta?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="pact pact-del" title="Eliminar pregunta">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Panel edición --}}
                            <div class="preg-body" id="preg-body-{{ $preg->id }}">
                                <form method="POST" action="{{ route('admin.quiz.actualizarPregunta', $preg) }}">
                                    @csrf @method('PUT')

                                    <div class="fg">
                                        <label>Texto de la pregunta</label>
                                        <textarea name="pregunta" class="fi">{{ $preg->pregunta }}</textarea>
                                    </div>

                                    <div class="fg-row">
                                        <div class="fg">
                                            <label>Tipo</label>
                                            <select name="tipo" class="fi" onchange="updateTipoUI({{ $preg->id }}, this.value)">
                                                <option value="opcion_multiple"    {{ $preg->tipo==='opcion_multiple'    ?'selected':'' }}>Opción Múltiple</option>
                                                <option value="multiple_respuesta" {{ $preg->tipo==='multiple_respuesta' ?'selected':'' }}>Múltiple Respuesta</option>
                                                <option value="verdadero_falso"    {{ $preg->tipo==='verdadero_falso'    ?'selected':'' }}>Verdadero / Falso</option>
                                                <option value="texto_libre"        {{ $preg->tipo==='texto_libre'        ?'selected':'' }}>Texto Libre</option>
                                            </select>
                                        </div>
                                        <div class="fg">
                                            <label>Puntos</label>
                                            <input type="number" name="puntos" class="fi" min="1" value="{{ $preg->puntos }}">
                                        </div>
                                    </div>

                                    <div class="fg">
                                        <label>Explicación (feedback al revisar)</label>
                                        <input type="text" name="explicacion" class="fi"
                                            value="{{ $preg->explicacion }}" placeholder="Ej: La respuesta correcta es...">
                                    </div>

                                    {{-- Opciones --}}
                                    <div id="opciones-wrap-{{ $preg->id }}"
                                         data-tipo="{{ $preg->tipo }}">

                                        @if($preg->tipo === 'verdadero_falso')
                                            <div class="opciones-label">Respuesta correcta</div>
                                            <div class="vf-options">
                                                @foreach($preg->opciones as $op)
                                                    <label class="vf-opt {{ strtolower($op->texto) === 'verdadero' ? 'verdadero' : 'falso' }} {{ $op->es_correcta ? 'selected' : '' }}">
                                                        <input type="hidden" name="opciones[{{ $loop->index }}][id]" value="{{ $op->id }}">
                                                        <input type="hidden" name="opciones[{{ $loop->index }}][texto]" value="{{ $op->texto }}">
                                                        <input type="checkbox" name="opciones[{{ $loop->index }}][es_correcta]"
                                                               value="1" style="display:none;"
                                                               {{ $op->es_correcta ? 'checked' : '' }}
                                                               onchange="handleVFChange(this, {{ $preg->id }})">
                                                        <i class="fas {{ strtolower($op->texto) === 'verdadero' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                        {{ $op->texto }}
                                                    </label>
                                                @endforeach
                                            </div>

                                        @elseif($preg->tipo === 'texto_libre')
                                            <div style="background:#f8fafc;border-radius:10px;padding:1rem;border:1px solid var(--border);text-align:center;">
                                                <i class="fas fa-pen" style="color:var(--purple);font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                                                <p style="font-family:'DM Sans',sans-serif;font-size:.85rem;color:var(--muted);margin:0;">
                                                    El estudiante escribirá su respuesta libremente.<br>
                                                    <strong>La corrección es manual.</strong>
                                                </p>
                                            </div>

                                        @else
                                            <div class="opciones-label">
                                                Opciones
                                                <span>✓ marca las correctas</span>
                                            </div>
                                            <div id="opciones-list-{{ $preg->id }}">
                                                @foreach($preg->opciones as $op)
                                                <div class="opcion-row {{ $op->es_correcta ? 'correct' : '' }}"
                                                     data-index="{{ $loop->index }}">
                                                    <input type="checkbox"
                                                           name="opciones[{{ $loop->index }}][es_correcta]"
                                                           value="1" class="opcion-check"
                                                           title="Marcar como correcta"
                                                           {{ $op->es_correcta ? 'checked' : '' }}
                                                           onchange="this.closest('.opcion-row').classList.toggle('correct', this.checked)">
                                                    <input type="hidden"
                                                           name="opciones[{{ $loop->index }}][id]"
                                                           value="{{ $op->id }}">
                                                    <input type="text"
                                                           name="opciones[{{ $loop->index }}][texto]"
                                                           class="opcion-input"
                                                           value="{{ $op->texto }}"
                                                           placeholder="Texto de la opción">
                                                    <button type="button" class="opcion-del"
                                                            title="Eliminar opción"
                                                            onclick="eliminarOpcion(this)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn-add-opcion"
                                                    onclick="addOpcion({{ $preg->id }})">
                                                <i class="fas fa-plus"></i> Agregar opción
                                            </button>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn-save-preg">
                                        <i class="fas fa-save"></i> Guardar cambios
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                            <div style="text-align:center;padding:2rem;color:var(--muted);font-family:'DM Sans',sans-serif;font-size:.88rem;">
                                <i class="fas fa-question-circle" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3;"></i>
                                Aún no hay preguntas. Agrega la primera abajo.
                            </div>
                        @endforelse
                    </div>

                    {{-- Nueva pregunta --}}
                    <div class="nueva-preg">
                        <h4 class="nueva-preg-title">
                            <i class="fas fa-plus-circle"></i> Agregar nueva pregunta
                        </h4>
                        <form method="POST" action="{{ route('admin.quiz.agregarPregunta', $quiz->id) }}">
                            @csrf
                            <div class="fg">
                                <label>Texto de la pregunta</label>
                                <textarea name="pregunta" class="fi" required
                                    placeholder="Escribe aquí tu pregunta..."></textarea>
                            </div>
                            <div class="tipo-selector">
                                @foreach([
                                    'opcion_multiple'   => ['fa-dot-circle',   'Opción Múltiple'],
                                    'multiple_respuesta'=> ['fa-check-square',  'Múltiple Respuesta'],
                                    'verdadero_falso'   => ['fa-toggle-on',     'Verdadero / Falso'],
                                    'texto_libre'       => ['fa-pen',           'Texto Libre'],
                                ] as $v => [$ico, $lbl])
                                <label class="tipo-opt">
                                    <input type="radio" name="tipo" value="{{ $v }}"
                                        {{ $v === 'opcion_multiple' ? 'checked' : '' }}>
                                    <i class="fas {{ $ico }}"></i> {{ $lbl }}
                                </label>
                                @endforeach
                            </div>
                            <div class="fg-row">
                                <div class="fg">
                                    <label>Puntos</label>
                                    <input type="number" name="puntos" class="fi" value="1" min="1">
                                </div>
                                <div class="fg">
                                    <label>Explicación (opcional)</label>
                                    <input type="text" name="explicacion" class="fi" placeholder="Feedback al responder">
                                </div>
                            </div>
                            <button type="submit" class="btn-add-preg">
                                <i class="fas fa-plus"></i> Agregar Pregunta
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endif
    </div>
</div>

{{-- ══ PREVIEW MODAL ══ --}}
<div class="modal-overlay" id="previewModal" onclick="closePreview(event)">
    <div class="preview-modal">
        <div class="preview-header">
            <h3><i class="fas fa-eye"></i> Vista previa del estudiante</h3>
            <button class="preview-close" onclick="document.getElementById('previewModal').classList.remove('open')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="preview-body" id="previewBody">
            {{-- Se llena dinámicamente --}}
        </div>
        <div class="preview-footer">
            <span class="preview-note">
                <i class="fas fa-info-circle"></i>
                Así verá el estudiante esta pregunta
            </span>
            <button onclick="document.getElementById('previewModal').classList.remove('open')"
                style="padding:.5rem 1rem;background:var(--blue);color:#fff;border:none;border-radius:8px;font-family:'Outfit',sans-serif;font-size:.83rem;font-weight:700;cursor:pointer;">
                Cerrar
            </button>
        </div>
    </div>
</div>

<script>
// ── Toggle edición pregunta ──
function togglePreg(id, btn) {
    const body = document.getElementById('preg-body-' + id);
    const isOpen = body.classList.contains('open');
    // Cerrar todos
    document.querySelectorAll('.preg-body').forEach(b => b.classList.remove('open'));
    document.querySelectorAll('.pact-expand i').forEach(i => {
        i.className = 'fas fa-edit';
    });
    if (!isOpen) {
        body.classList.add('open');
        btn.querySelector('i').className = 'fas fa-chevron-up';
    }
}

// ── Agregar opción ──
function addOpcion(pregId) {
    const list = document.getElementById('opciones-list-' + pregId);
    const rows = list.querySelectorAll('.opcion-row');
    const idx = rows.length;
    const div = document.createElement('div');
    div.className = 'opcion-row';
    div.dataset.index = idx;
    div.innerHTML = `
        <input type="checkbox" name="opciones[${idx}][es_correcta]" value="1" class="opcion-check"
               title="Marcar como correcta"
               onchange="this.closest('.opcion-row').classList.toggle('correct', this.checked)">
        <input type="text" name="opciones[${idx}][texto]" class="opcion-input" placeholder="Nueva opción">
        <button type="button" class="opcion-del" title="Eliminar opción" onclick="eliminarOpcion(this)">
            <i class="fas fa-times"></i>
        </button>
    `;
    list.appendChild(div);
    div.querySelector('.opcion-input').focus();
    // Animación
    div.style.opacity = '0'; div.style.transform = 'translateY(-8px)';
    requestAnimationFrame(() => {
        div.style.transition = 'all .2s ease';
        div.style.opacity = '1'; div.style.transform = 'translateY(0)';
    });
}

// ── Eliminar opción ──
function eliminarOpcion(btn) {
    const row = btn.closest('.opcion-row');
    const list = row.parentElement;
    row.style.transition = 'all .2s ease';
    row.style.opacity = '0'; row.style.transform = 'translateX(20px)';
    setTimeout(() => {
        row.remove();
        // Reindexar nombres
        list.querySelectorAll('.opcion-row').forEach((r, i) => {
            r.querySelectorAll('input, select').forEach(inp => {
                if (inp.name) inp.name = inp.name.replace(/opciones\[\d+\]/, `opciones[${i}]`);
            });
        });
    }, 200);
}

// ── VF handler ──
function handleVFChange(checkbox, pregId) {
    const wrap = document.getElementById('opciones-wrap-' + pregId);
    wrap.querySelectorAll('.vf-opt').forEach(label => {
        const cb = label.querySelector('input[type="checkbox"]');
        label.classList.remove('selected');
        cb.checked = false;
    });
    checkbox.checked = true;
    checkbox.closest('.vf-opt').classList.add('selected');
}

// ── Vista previa ──
const preguntasData = {
    @foreach($quiz->preguntas as $preg)
    {{ $preg->id }}: {
        pregunta: @json($preg->pregunta),
        tipo: @json($preg->tipo),
        puntos: {{ $preg->puntos }},
        opciones: [
            @foreach($preg->opciones as $op)
            { texto: @json($op->texto), es_correcta: {{ $op->es_correcta ? 'true' : 'false' }} },
            @endforeach
        ]
    },
    @endforeach
};

function previewPregunta(id) {
    const p = preguntasData[id];
    if (!p) return;

    const tipos = {
        opcion_multiple:    { label: 'Opción Múltiple',    cls: 'badge-om',  icon: 'fa-dot-circle' },
        multiple_respuesta: { label: 'Múltiple Respuesta', cls: 'badge-mr',  icon: 'fa-check-square' },
        verdadero_falso:    { label: 'Verdadero / Falso',  cls: 'badge-vf',  icon: 'fa-toggle-on' },
        texto_libre:        { label: 'Texto Libre',        cls: 'badge-tl',  icon: 'fa-pen' },
    };
    const t = tipos[p.tipo] || tipos.opcion_multiple;
    const letters = ['A','B','C','D','E','F'];

    let opcionesHtml = '';
    if (p.tipo === 'texto_libre') {
        opcionesHtml = `<textarea placeholder="El estudiante escribirá su respuesta aquí..."
            style="width:100%;padding:.75rem;border:1.5px solid var(--border);border-radius:10px;font-family:'DM Sans',sans-serif;font-size:.9rem;min-height:90px;outline:none;resize:vertical;color:var(--muted);" disabled></textarea>`;
    } else {
        opcionesHtml = '<div class="preview-options">';
        p.opciones.forEach((op, i) => {
            opcionesHtml += `
                <div class="preview-option">
                    <span class="opt-letter">${letters[i] || i+1}</span>
                    ${op.texto}
                </div>`;
        });
        opcionesHtml += '</div>';
    }

    document.getElementById('previewBody').innerHTML = `
        <span class="preview-badge ${t.cls}">
            <i class="fas ${t.icon}"></i> ${t.label} · ${p.puntos} punto${p.puntos !== 1 ? 's' : ''}
        </span>
        <div class="preview-question">${p.pregunta}</div>
        ${opcionesHtml}
    `;
    document.getElementById('previewModal').classList.add('open');
}

function closePreview(e) {
    if (e.target === document.getElementById('previewModal')) {
        document.getElementById('previewModal').classList.remove('open');
    }
}

// ── Drag & Drop para reordenar ──
let dragSrc = null;

document.querySelectorAll('.preg-card[draggable]').forEach(card => {
    card.addEventListener('dragstart', function(e) {
        dragSrc = this;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    });
    card.addEventListener('dragend', function() {
        this.classList.remove('dragging');
        document.querySelectorAll('.preg-card').forEach(c => c.classList.remove('drag-over'));
        updateOrden();
    });
    card.addEventListener('dragover', function(e) {
        e.preventDefault();
        if (this !== dragSrc) {
            document.querySelectorAll('.preg-card').forEach(c => c.classList.remove('drag-over'));
            this.style.outline = '2px dashed var(--blue)';
        }
    });
    card.addEventListener('dragleave', function() {
        this.style.outline = '';
    });
    card.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.outline = '';
        if (dragSrc && dragSrc !== this) {
            const container = document.getElementById('preguntasContainer');
            const cards = [...container.querySelectorAll('.preg-card')];
            const srcIdx = cards.indexOf(dragSrc);
            const tgtIdx = cards.indexOf(this);
            if (srcIdx < tgtIdx) {
                container.insertBefore(dragSrc, this.nextSibling);
            } else {
                container.insertBefore(dragSrc, this);
            }
            // Actualizar números
            container.querySelectorAll('.preg-card').forEach((c, i) => {
                const num = c.querySelector('.preg-num');
                if (num) num.textContent = i + 1;
            });
        }
    });
});

const quizId = {{ $quiz->exists ? $quiz->id : 'null' }};
function updateOrden() {
    if (!quizId) return;

    const ids = [...document.querySelectorAll('.preg-card[data-id]')]
        .map(c => c.dataset.id);

    fetch(`/admin/quiz/${quizId}/pregunta`, {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
        },
        body: JSON.stringify({ _action: 'reorder', ids })
    }).catch(() => {});
}

// Actualizar UI según tipo seleccionado
function updateTipoUI(pregId, tipo) {
    // Solo un aviso visual, el guardado real se hace con el form
    const wrap = document.getElementById('opciones-wrap-' + pregId);
    if (wrap) wrap.dataset.tipo = tipo;
}
</script>
@endsection