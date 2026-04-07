@extends('layouts.dashboard')
@section('title','Quiz: ' . $quiz->leccion->titulo)
@section('page-title','Quiz')

@section('content')
@php
    $aprobatorio = $quiz->puntaje_aprobatorio;
    $maxIntentos = $quiz->intentos_permitidos;
    $usados      = $intentos->count();
@endphp
<style>
    .quiz-wrap { max-width: 700px; margin: 0 auto; }
    .quiz-header { background: linear-gradient(135deg, #1a1a2e, #0f3460); border-radius: 14px; padding: 2rem; color: #fff; margin-bottom: 1.5rem; }
    .quiz-header h1 { font-family:'Poppins',sans-serif; font-size: 1.4rem; font-weight: 800; margin-bottom: .5rem; }
    .quiz-config { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-top: 1.25rem; }
    .qconf { background: rgba(255,255,255,.12); border-radius: 10px; padding: .875rem; text-align: center; }
    .qconf-num { font-family:'Poppins',sans-serif; font-size: 1.4rem; font-weight: 700; }
    .qconf-label { font-size: .72rem; opacity: .75; margin-top: .2rem; }
    .db-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); padding: 1.5rem; margin-bottom: 1.25rem; }
    .intento-row { display:flex; align-items:center; justify-content:space-between; padding: .65rem 0; border-bottom: 1px solid #f8fafc; font-size: .86rem; gap:.75rem; flex-wrap:wrap; }
    .intento-row:last-child { border-bottom: none; }
    .badge { display:inline-flex; align-items:center; gap:.25rem; font-size:.72rem; font-weight:700; padding:.2rem .65rem; border-radius:999px; }
    .badge-ok  { background:rgba(40,167,69,.1); color:#16a34a; }
    .badge-err { background:rgba(220,53,69,.1); color:#dc3545; }
    .btn-start { display:block; width:100%; padding:1rem; background:linear-gradient(135deg,#0f3460,#1a5276); color:#fff; border:none; border-radius:10px; font-size:1rem; font-weight:700; cursor:pointer; text-align:center; transition:opacity .2s; }
    .btn-start:hover { opacity:.88; }
    .progreso-bar { height:10px; background:#e2e8f0; border-radius:999px; overflow:hidden; margin-top:.5rem; }
    .progreso-fill { height:100%; border-radius:999px; }
</style>
<div class="quiz-wrap">
    {{-- Botón volver al curso --}}
    @if($quiz->leccion && $quiz->leccion->modulo && $quiz->leccion->modulo->curso)
        <a href="{{ route('curso.player.leccion', [$quiz->leccion->modulo->curso->slug, $quiz->leccion->id]) }}"
            style="display:inline-flex;align-items:center;gap:.4rem;font-family:'Outfit',sans-serif;font-size:.84rem;font-weight:700;color:#0A4D8C;text-decoration:none;margin-bottom:1rem;padding:.5rem .9rem;background:#EBF3FF;border-radius:9px;border:1.5px solid #c5d9f0;transition:all .18s;"
            onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#EBF3FF'">
            <i class="fas fa-arrow-left"></i> Volver al curso
        </a>
    @endif
    <div class="quiz-header">
        <div style="font-size:.8rem;opacity:.7;margin-bottom:.3rem;">
            <i class="fas fa-layer-group"></i> {{ $quiz->leccion->modulo->curso->titulo ?? '' }} › {{ $quiz->leccion->modulo->titulo ?? '' }}
        </div>
        <h1>{{ $quiz->titulo ?? $quiz->leccion->titulo }}</h1>
        @if($quiz->descripcion)<p style="opacity:.85;font-size:.9rem;line-height:1.6;margin-top:.5rem;">{{ $quiz->descripcion }}</p>@endif
        <div class="quiz-config">
            <div class="qconf"><div class="qconf-num">{{ $quiz->preguntas->count() }}</div><div class="qconf-label">Preguntas</div></div>
            <div class="qconf"><div class="qconf-num">{{ $aprobatorio }}%</div><div class="qconf-label">Para aprobar</div></div>
            <div class="qconf"><div class="qconf-num">{{ $quiz->tiempo_limite ? $quiz->tiempo_limite.'min' : '∞' }}</div><div class="qconf-label">Tiempo límite</div></div>
        </div>
    </div>
    @if($mejor)
    <div class="db-card">
        <h3 style="font-family:'Poppins',sans-serif;font-size:.95rem;font-weight:700;color:#1a1a2e;margin-bottom:1rem;"><i class="fas fa-trophy" style="color:#f59e0b;"></i> Tu mejor resultado</h3>
        <div style="display:flex;align-items:center;gap:1rem;">
            <div style="text-align:center;">
                <div style="font-family:'Poppins',sans-serif;font-size:2rem;font-weight:800;color:{{ $mejor->aprobado ? '#16a34a' : '#dc3545' }};">{{ $mejor->porcentaje }}%</div>
                <span class="badge {{ $mejor->aprobado ? 'badge-ok' : 'badge-err' }}">{{ $mejor->aprobado ? '✓ Aprobado' : '✗ No aprobado' }}</span>
            </div>
            <div style="flex:1;"><div class="progreso-bar"><div class="progreso-fill" style="width:{{ $mejor->porcentaje }}%;background:{{ $mejor->aprobado ? '#16a34a' : '#dc3545' }};"></div></div><div style="font-size:.78rem;color:#94a3b8;margin-top:.4rem;">{{ $mejor->puntaje }} / {{ $mejor->puntaje_total }} puntos</div></div>
        </div>
    </div>
    @endif
    @if($intentos->count())
    <div class="db-card">
        <h3 style="font-family:'Poppins',sans-serif;font-size:.95rem;font-weight:700;color:#1a1a2e;margin-bottom:1rem;">Historial de intentos ({{ $usados }}/{{ $maxIntentos === -1 ? '∞' : $maxIntentos }})</h3>
        @foreach($intentos as $int)
        <div class="intento-row">
            <span style="color:#475569;">Intento #{{ $loop->iteration }}</span>
            <span>{{ $int->porcentaje }}% · {{ $int->puntaje }}/{{ $int->puntaje_total }} pts</span>
            <span class="badge {{ $int->aprobado ? 'badge-ok' : 'badge-err' }}">{{ $int->aprobado ? 'Aprobado' : 'No aprobado' }}</span>
            <a href="{{ route('quiz.resultado',$int) }}" style="font-size:.8rem;color:#0f3460;font-weight:600;">Ver <i class="fas fa-arrow-right"></i></a>
        </div>
        @endforeach
    </div>
    @endif
    <div class="db-card">
        @if($puedeIntentar)
        <p style="font-size:.88rem;color:#64748b;margin-bottom:1.1rem;"><i class="fas fa-info-circle" style="color:#0f3460;"></i> Una vez iniciado, las preguntas aparecerán en orden{{ $quiz->aleatorio ? ' aleatorio' : '' }}.@if($quiz->tiempo_limite) Tendrás <strong>{{ $quiz->tiempo_limite }} minutos</strong>.@endif</p>
        <form method="POST" action="{{ route('quiz.iniciar',$quiz) }}">@csrf<button type="submit" class="btn-start"><i class="fas fa-play"></i> {{ $intentos->count() ? 'Intentar de nuevo' : 'Comenzar Quiz' }}</button></form>
        @else
        <div style="text-align:center;padding:1rem;color:#94a3b8;"><i class="fas fa-lock" style="font-size:2rem;display:block;margin-bottom:.75rem;"></i><p>Has agotado los <strong>{{ $maxIntentos }}</strong> intentos permitidos.</p>@if($mejor && $mejor->aprobado)<span class="badge badge-ok" style="font-size:.85rem;padding:.4rem 1rem;">✓ Quiz aprobado</span>@endif</div>
        @endif
    </div>
</div>
@endsection