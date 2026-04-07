@extends('layouts.dashboard')

@section('title', 'Mis Cursos')
@section('page-title', 'Mis Cursos')

@section('content')
<style>
    .cursos-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
    .cursos-head p { color: #64748b; margin: 0; font-size: .9rem; }

    .cursos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 1.1rem; }

    .curso-card {
        background: #fff; border-radius: 12px;
        box-shadow: 0 2px 8px rgba(10,77,140,.07); overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }
    .curso-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(10,77,140,.13); }

    .curso-card-img {
        height: 120px; display: flex; align-items: center;
        justify-content: center; font-size: 2.5rem; color: #fff;
    }
    .curso-card-body { padding: 1.1rem 1.25rem; }
    .curso-cat { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #0A4D8C; margin-bottom: .3rem; }
    .curso-title { font-family: 'Poppins',sans-serif; font-weight: 700; font-size: .95rem; color: #073A6B; margin-bottom: .85rem; line-height: 1.3; }

    .badge-done { display: inline-flex; align-items: center; gap: .3rem; background: #ECFDF5; color: #16a34a; font-size: .75rem; font-weight: 700; padding: .2rem .65rem; border-radius: 999px; margin-bottom: .85rem; }

    .prog-label { display: flex; justify-content: space-between; font-size: .75rem; color: #94a3b8; margin-bottom: .3rem; }
    .prog-bar   { height: 7px; background: #e2e8f0; border-radius: 999px; overflow: hidden; margin-bottom: 1rem; }
    .prog-fill  { height: 100%; border-radius: 999px; background: linear-gradient(90deg,#0A4D8C,#3B88D4); }
    .prog-fill.done { background: linear-gradient(90deg,#16a34a,#22c55e); }

    .btn-curso {
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        width: 100%; padding: .6rem; background: #0A4D8C; color: #fff;
        border-radius: 8px; font-size: .86rem; font-weight: 600;
        text-decoration: none; transition: background .16s;
    }
    .btn-curso:hover { background: #073A6B; color: #fff; }

    .db-empty { text-align: center; padding: 3.5rem 2rem; color: #94a3b8; }
    .db-empty i { font-size: 3rem; display: block; margin-bottom: 1rem; }
    .db-empty h3 { color: #073A6B; margin-bottom: .5rem; font-size: 1.1rem; }
    .db-empty p { font-size: .9rem; max-width: 380px; margin: 0 auto 1.25rem; }

    @media (max-width: 560px) { .cursos-grid { grid-template-columns: 1fr; } }
</style>

<div class="cursos-head">
    <p>Todos los cursos en los que estás inscrito.</p>
    <a href="{{ route('cursos.index') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Inscribirse en más cursos
    </a>
</div>

@if($cursos->isEmpty())
    <div style="background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(10,77,140,.07);">
        <div class="db-empty">
            <i class="fas fa-book-open"></i>
            <h3>No tienes cursos inscritos</h3>
            <p>Explora nuestro catálogo y comienza a fortalecer tus habilidades comunitarias.</p>
            <a href="{{ route('cursos.index') }}" class="btn btn-primary" style="font-size:1rem;padding:.875rem 2rem;">
                <i class="fas fa-search"></i> Explorar Catálogo
            </a>
        </div>
    </div>
@else
    <div class="cursos-grid">
        @foreach($cursos as $curso)
            @php $prog = $curso->pivot->progreso ?? 0; @endphp
            <div class="curso-card">
                <div class="curso-card-img"
                    style="background: linear-gradient(135deg, #0A4D8C, #3B88D4);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="curso-card-body">
                    <div class="curso-cat">{{ $curso->categoria ?? 'Curso' }}</div>
                    <div class="curso-title">{{ $curso->titulo }}</div>
                    @if($prog >= 100)
                        <div class="badge-done"><i class="fas fa-check-circle"></i> Completado</div>
                    @endif
                    <div class="prog-label"><span>Progreso</span><span>{{ $prog }}%</span></div>
                    <div class="prog-bar">
                        <div class="prog-fill {{ $prog >= 100 ? 'done' : '' }}" style="width:{{ $prog }}%"></div>
                    </div>
                    <a href="{{ route('curso.player', $curso->slug) }}" class="btn-curso">
                        {{ $prog >= 100 ? 'Revisar Curso' : 'Continuar' }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection