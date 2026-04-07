@extends('layouts.dashboard')
@section('title','Realizando Quiz')
@section('page-title','Quiz en progreso')

@section('content')
<style>
    .quiz-tomar-wrap { max-width: 760px; margin: 0 auto; }
    .quiz-top-bar { background:#fff; border-radius:12px; padding:1rem 1.5rem; margin-bottom:1.25rem; box-shadow:0 2px 8px rgba(0,0,0,.06); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.75rem; }
    .qtop-progreso { flex:1; }
    .qtop-progreso-label { font-size:.78rem;color:#64748b;margin-bottom:.3rem; }
    .qtop-bar { height:8px;background:#e2e8f0;border-radius:999px;overflow:hidden; }
    .qtop-fill { height:100%;background:linear-gradient(90deg,#0f3460,#3B88D4);border-radius:999px;transition:width .4s; }
    .qtop-timer { font-family:'Poppins',sans-serif;font-size:1.2rem;font-weight:700;color:#0f3460;display:flex;align-items:center;gap:.4rem; }
    .qtop-timer.warning { color:#e94560; animation: pulse 1s infinite; }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }

    .pregunta-card { background:#fff;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.06);padding:1.75rem;margin-bottom:1rem; display:none; }
    .pregunta-card.visible { display:block; }
    .preg-num { font-size:.75rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.5rem; }
    .preg-tipo { display:inline-flex;align-items:center;gap:.3rem;font-size:.73rem;font-weight:700;padding:.2rem .65rem;border-radius:999px;background:#EBF3FF;color:#0A4D8C;margin-bottom:.75rem; }
    .preg-texto { font-size:1rem;font-weight:600;color:#1a1a2e;line-height:1.5;margin-bottom:1.25rem; }
    .opciones-list { display:flex;flex-direction:column;gap:.6rem; }
    .opcion-label { display:flex;align-items:center;gap:.75rem;padding:.875rem 1rem;border:2px solid #e8eef5;border-radius:10px;cursor:pointer;transition:all .16s;user-select:none; }
    .opcion-label:hover { border-color:#0f3460;background:#f0f4f8; }
    .opcion-label input { display:none; }
    .opcion-label:has(input:checked) { border-color:#0f3460;background:#EBF3FF; }
    .opcion-indicator { width:22px;height:22px;border:2px solid #d1d9e0;border-radius:50%;flex-shrink:0;transition:all .16s;position:relative; }
    .opcion-label:has(input[type=checkbox]) .opcion-indicator { border-radius:5px; }
    .opcion-label:has(input:checked) .opcion-indicator { background:#0f3460;border-color:#0f3460; }
    .opcion-label:has(input:checked) .opcion-indicator::after { content:''; position:absolute;left:5px;top:2px;width:6px;height:10px;border:2px solid #fff;border-top:none;border-left:none;transform:rotate(45deg); }
    .opcion-texto { font-size:.9rem;color:#334155; }
    .texto-libre-input { width:100%;padding:.75rem;border:2px solid #d1d9e0;border-radius:8px;font-size:.9rem;font-family:inherit;min-height:120px;resize:vertical;outline:none;transition:border-color .16s; }
    .texto-libre-input:focus { border-color:#0f3460; }

    .quiz-nav { display:flex;align-items:center;justify-content:space-between;margin-top:1.25rem;flex-wrap:wrap;gap:.75rem; }
    .quiz-nav-dots { display:flex;gap:.35rem;flex-wrap:wrap; }
    .nav-dot { width:10px;height:10px;border-radius:50%;background:#e2e8f0;cursor:pointer;transition:background .2s; }
    .nav-dot.respondida { background:#0f3460; }
    .nav-dot.actual { background:#3B88D4;transform:scale(1.3); }
    .btn-nav { padding:.65rem 1.25rem;border-radius:8px;font-size:.88rem;font-weight:700;cursor:pointer;border:none;transition:all .16s; }
    .btn-prev { background:#f0f4f8;color:#64748b; }
    .btn-prev:hover { background:#e2e8f0; }
    .btn-next { background:#0f3460;color:#fff; }
    .btn-next:hover { background:#1a1a2e; }
    .btn-enviar { background:#16a34a;color:#fff; padding:.75rem 1.75rem; }
    .btn-enviar:hover { background:#14532d; }
</style>

<div class="quiz-tomar-wrap">
    <div class="quiz-top-bar">
        <div class="qtop-progreso" style="min-width:200px;">
            <div class="qtop-progreso-label">Pregunta <span id="pregActual">1</span> de {{ $preguntas->count() }}</div>
            <div class="qtop-bar"><div class="qtop-fill" id="progBar" style="width:{{ 100/$preguntas->count() }}%"></div></div>
        </div>
        @if($quiz->tiempo_limite)
            <div class="qtop-timer" id="timer">
                <i class="fas fa-clock"></i> <span id="timerDisplay">{{ $quiz->tiempo_limite }}:00</span>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('quiz.enviar',$intento) }}" id="quizForm">
        @csrf
        @foreach($preguntas as $i => $pregunta)
            <div class="pregunta-card {{ $i === 0 ? 'visible' : '' }}" data-index="{{ $i }}" id="preg-{{ $i }}">
                <div class="preg-num">Pregunta {{ $i + 1 }}</div>
                <div class="preg-tipo">
                    <i class="fas {{ ['opcion_multiple'=>'fa-dot-circle','multiple_respuesta'=>'fa-check-square','verdadero_falso'=>'fa-toggle-on','texto_libre'=>'fa-pen'][$pregunta->tipo] ?? 'fa-dot-circle' }}"></i>
                    {{ $pregunta->tipoLabel() }}
                    · {{ $pregunta->puntos }} {{ $pregunta->puntos === 1 ? 'punto' : 'puntos' }}
                </div>
                <div class="preg-texto">{{ $pregunta->pregunta }}</div>

                @if($pregunta->tipo === 'texto_libre')
                    <textarea name="respuestas[{{ $pregunta->id }}]"
                            class="texto-libre-input"
                            placeholder="Escribe tu respuesta aquí..."
                            oninput="marcarRespondida({{ $i }})"></textarea>

                @elseif($pregunta->tipo === 'opcion_multiple' || $pregunta->tipo === 'verdadero_falso')
                    <div class="opciones-list">
                        @foreach($pregunta->opciones as $opcion)
                            <label class="opcion-label">
                                <input type="radio"
                                    name="respuestas[{{ $pregunta->id }}]"
                                    value="{{ $opcion->id }}"
                                    onchange="marcarRespondida({{ $i }})">
                                <div class="opcion-indicator"></div>
                                <span class="opcion-texto">{{ $opcion->texto }}</span>
                            </label>
                        @endforeach
                    </div>

                @elseif($pregunta->tipo === 'multiple_respuesta')
                    <p style="font-size:.78rem;color:#94a3b8;margin-bottom:.75rem;"><i class="fas fa-info-circle"></i> Selecciona todas las respuestas correctas.</p>
                    <div class="opciones-list">
                        @foreach($pregunta->opciones as $opcion)
                            <label class="opcion-label">
                                <input type="checkbox"
                                    name="respuestas[{{ $pregunta->id }}][]"
                                    value="{{ $opcion->id }}"
                                    onchange="marcarRespondida({{ $i }})">
                                <div class="opcion-indicator"></div>
                                <span class="opcion-texto">{{ $opcion->texto }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        <div class="quiz-nav">
            <button type="button" class="btn-nav btn-prev" id="btnPrev" onclick="navegar(-1)" style="visibility:hidden;">
                <i class="fas fa-arrow-left"></i> Anterior
            </button>
            <div class="quiz-nav-dots" id="navDots">
                @foreach($preguntas as $i => $p)
                    <div class="nav-dot {{ $i === 0 ? 'actual' : '' }}" data-idx="{{ $i }}" onclick="irA({{ $i }})"></div>
                @endforeach
            </div>
            <button type="button" class="btn-nav btn-next" id="btnNext" onclick="navegar(1)">
                Siguiente <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <div style="text-align:center;margin-top:1.25rem;display:none;" id="btnEnviarWrap">
            <button type="button" class="btn-nav btn-enviar" onclick="confirmarEnvio()">
                <i class="fas fa-paper-plane"></i> Entregar Quiz
            </button>
        </div>
    </form>
</div>

@section('extra-js')
<script>
const total     = {{ $preguntas->count() }};
const tiempoLim = {{ $quiz->tiempo_limite ?? 0 }};
let actual      = 0;
let respondidas = new Set();

function mostrar(idx) {
    document.querySelectorAll('.pregunta-card').forEach(c => c.classList.remove('visible'));
    document.querySelectorAll('.nav-dot').forEach((d,i) => {
        d.classList.toggle('actual', i === idx);
    });
    document.getElementById('preg-' + idx).classList.add('visible');
    document.getElementById('pregActual').textContent = idx + 1;
    document.getElementById('progBar').style.width = ((idx + 1) / total * 100) + '%';

    document.getElementById('btnPrev').style.visibility = idx === 0 ? 'hidden' : 'visible';
    document.getElementById('btnNext').style.display     = idx === total - 1 ? 'none' : 'block';
    document.getElementById('btnEnviarWrap').style.display = idx === total - 1 ? 'block' : 'none';
    actual = idx;
}

function navegar(dir) { mostrar(Math.max(0, Math.min(total - 1, actual + dir))); }
function irA(idx)     { mostrar(idx); }

function marcarRespondida(idx) {
    respondidas.add(idx);
    const dot = document.querySelector('.nav-dot[data-idx="' + idx + '"]');
    if (dot) { dot.classList.add('respondida'); }
}

function confirmarEnvio() {
    const sin = total - respondidas.size;
    const msg = sin > 0
        ? `Tienes ${sin} pregunta(s) sin responder. ¿Deseas entregar igual?`
        : '¿Deseas entregar el quiz?';
    if (confirm(msg)) document.getElementById('quizForm').submit();
}

// Temporizador
if (tiempoLim > 0) {
    let segundos = tiempoLim * 60;
    const display = document.getElementById('timerDisplay');
    const timerEl = document.getElementById('timer');
    const interval = setInterval(() => {
        segundos--;
        if (segundos <= 0) {
            clearInterval(interval);
            document.getElementById('quizForm').submit();
        }
        const m = Math.floor(segundos / 60);
        const s = segundos % 60;
        display.textContent = m + ':' + String(s).padStart(2,'0');
        if (segundos <= 60) timerEl.classList.add('warning');
    }, 1000);
}
</script>
@endsection
@endsection