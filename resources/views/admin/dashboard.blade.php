@extends('admin.layout')
@section('title','Dashboard Admin')
@section('page-title','Dashboard')

@section('content')
<style>
    .adm-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .adm-stat {
        background: #fff; border-radius: 12px; padding: 1.25rem;
        display: flex; align-items: center; gap: .9rem;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        transition: transform .2s, box-shadow .2s;
    }
    .adm-stat:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.1); }
    .adm-stat-icon { width: 50px; height: 50px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .ic-red    { background: rgba(233,69,96,.1);  color: #e94560; }
    .ic-blue   { background: rgba(10,77,140,.1);  color: #0A4D8C; }
    .ic-green  { background: rgba(40,167,69,.1);  color: #28a745; }
    .ic-gold   { background: rgba(217,119,6,.1);  color: #d97706; }
    .adm-stat-num   { font-family: 'Poppins',sans-serif; font-size: 1.7rem; font-weight: 700; color: #1a1a2e; line-height: 1; margin-bottom: .15rem; }
    .adm-stat-label { font-size: .8rem; color: #64748b; font-weight: 500; }

    .adm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .adm-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; }
    .adm-card-head { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
    .adm-card-title { font-family: 'Poppins',sans-serif; font-size: .95rem; font-weight: 700; color: #1a1a2e; margin: 0; display: flex; align-items: center; gap: .45rem; }
    .adm-card-body  { padding: 1.1rem; }

    .adm-row { display: flex; align-items: center; gap: .9rem; padding: .75rem 0; border-bottom: 1px solid #f8fafc; }
    .adm-row:last-child { border-bottom: none; padding-bottom: 0; }
    .adm-row-icon { width: 40px; height: 40px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #fff; flex-shrink: 0; }
    .adm-row-info { flex: 1; min-width: 0; }
    .adm-row-name  { font-weight: 600; font-size: .86rem; color: #1a1a2e; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .adm-row-sub   { font-size: .75rem; color: #94a3b8; margin-top: .1rem; }
    .adm-row-badge { font-size: .72rem; font-weight: 700; padding: .2rem .6rem; border-radius: 999px; white-space: nowrap; }
    .badge-free { background: rgba(40,167,69,.1); color: #16a34a; }
    .badge-paid { background: rgba(217,119,6,.1); color: #d97706; }
    .badge-on   { background: rgba(40,167,69,.1); color: #16a34a; }
    .badge-off  { background: rgba(220,53,69,.1); color: #dc3545; }

    .adm-link { font-size: .82rem; color: #0f3460; font-weight: 600; text-decoration: none; }
    .adm-link:hover { text-decoration: underline; }

    @media (max-width: 900px) { .adm-stats { grid-template-columns: 1fr 1fr; } .adm-grid { grid-template-columns: 1fr; } }
</style>

<div class="adm-stats">
    <div class="adm-stat">
        <div class="adm-stat-icon ic-blue"><i class="fas fa-graduation-cap"></i></div>
        <div><div class="adm-stat-num">{{ $totalCursos }}</div><div class="adm-stat-label">Total Cursos</div></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon ic-green"><i class="fas fa-check-circle"></i></div>
        <div><div class="adm-stat-num">{{ $cursosActivos }}</div><div class="adm-stat-label">Cursos Activos</div></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon ic-red"><i class="fas fa-users"></i></div>
        <div><div class="adm-stat-num">{{ $totalEstudiantes }}</div><div class="adm-stat-label">Estudiantes</div></div>
    </div>
    <div class="adm-stat">
        <div class="adm-stat-icon ic-gold"><i class="fas fa-book-open"></i></div>
        <div><div class="adm-stat-num">{{ $totalInscripciones }}</div><div class="adm-stat-label">Inscripciones</div></div>
    </div>
</div>

<div class="adm-grid">
    {{-- Cursos recientes --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title"><i class="fas fa-graduation-cap" style="color:#0f3460;"></i> Cursos Recientes</h3>
            <a href="{{ route('admin.cursos.index') }}" class="adm-link">Ver todos <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="adm-card-body">
            @forelse($cursosRecientes as $curso)
                <div class="adm-row">
                    <div class="adm-row-icon" style="background: linear-gradient(135deg,#0A4D8C,#3B88D4);">
                        <i class="fas {{ $curso->icono_fa ?? 'fa-graduation-cap' }}"></i>
                    </div>
                    <div class="adm-row-info">
                        <div class="adm-row-name">{{ $curso->titulo }}</div>
                        <div class="adm-row-sub">{{ $curso->estudiantes_count }} estudiantes · {{ $curso->categoriaLabel() }}</div>
                    </div>
                    <div>
                        <span class="adm-row-badge {{ $curso->tipo === 'free' ? 'badge-free' : 'badge-paid' }}">
                            {{ $curso->tipo === 'free' ? 'Gratis' : 'Pago' }}
                        </span>
                    </div>
                </div>
            @empty
                <p style="color:#94a3b8;font-size:.88rem;text-align:center;padding:1rem 0;">No hay cursos aún.</p>
            @endforelse
        </div>
    </div>

    {{-- Estudiantes recientes --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title"><i class="fas fa-users" style="color:#e94560;"></i> Estudiantes Recientes</h3>
            <a href="{{ route('admin.estudiantes') }}" class="adm-link">Ver todos <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="adm-card-body">
            @forelse($estudiantesRecientes as $est)
                <div class="adm-row">
                    <div class="adm-row-icon" style="background: linear-gradient(135deg,#e94560,#ff6b8a);">
                        <span style="font-weight:700;font-size:.9rem;">{{ strtoupper(substr($est->name,0,1)) }}</span>
                    </div>
                    <div class="adm-row-info">
                        <div class="adm-row-name">{{ $est->name }}</div>
                        <div class="adm-row-sub">{{ $est->email }} · {{ $est->municipio ?? 'Sin ubicación' }}</div>
                    </div>
                    <span class="adm-row-badge {{ $est->condicion === 'afiliado' ? 'badge-on' : 'badge-off' }}">
                        {{ $est->condicion === 'afiliado' ? 'Afiliado' : 'Particular' }}
                    </span>
                </div>
            @empty
                <p style="color:#94a3b8;font-size:.88rem;text-align:center;padding:1rem 0;">No hay estudiantes aún.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection