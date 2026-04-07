@extends('layouts.dashboard')

@section('title', 'Mi Panel')
@section('page-title', 'Mi Panel')

@section('content')
<style>
    /* ── Stats ── */
    .db-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .db-stat {
        background: #fff; border-radius: 12px; padding: 1.25rem;
        display: flex; align-items: center; gap: .9rem;
        box-shadow: 0 2px 8px rgba(10,77,140,.07);
        transition: transform .2s, box-shadow .2s;
    }
    .db-stat:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(10,77,140,.12); }
    .db-stat-icon {
        width: 48px; height: 48px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }
    .ic-blue   { background: #EBF3FF; color: #0A4D8C; }
    .ic-green  { background: #ECFDF5; color: #16a34a; }
    .ic-gold   { background: #FFFBEB; color: #d97706; }
    .ic-purple { background: #F5F3FF; color: #7c3aed; }
    .db-stat-num   { font-family: 'Poppins',sans-serif; font-size: 1.6rem; font-weight: 700; color: #073A6B; line-height: 1; margin-bottom: .15rem; }
    .db-stat-label { font-size: .8rem; color: #64748b; font-weight: 500; }

    /* ── Bienvenida banner ── */
    .db-welcome {
        background: linear-gradient(135deg, #073A6B 0%, #0A4D8C 50%, #1565C0 100%);
        border-radius: 14px; padding: 1.5rem 1.75rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(7,58,107,.2);
    }
    .db-welcome h2 { color: #fff; margin: 0 0 .3rem; font-size: 1.3rem; }
    .db-welcome p  { color: rgba(255,255,255,.78); margin: 0; font-size: .9rem; }
    .db-welcome-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .65rem 1.25rem;
        background: rgba(255,255,255,.15); color: #fff;
        border: 1.5px solid rgba(255,255,255,.4);
        border-radius: 8px; text-decoration: none;
        font-size: .88rem; font-weight: 600;
        transition: background .18s;
        white-space: nowrap;
    }
    .db-welcome-btn:hover { background: rgba(255,255,255,.25); color: #fff; }

    /* ── Grid 2 columnas ── */
    .db-grid { display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem; }

    /* ── Card genérica ── */
    .db-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(10,77,140,.07); overflow: hidden; }
    .db-card-head {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e8eef5;
        display: flex; align-items: center; justify-content: space-between;
    }
    .db-card-title { font-family: 'Poppins',sans-serif; font-size: .95rem; font-weight: 700; color: #073A6B; margin: 0; display: flex; align-items: center; gap: .45rem; }
    .db-card-title i { color: #0A4D8C; }
    .db-card-link { font-size: .82rem; color: #0A4D8C; font-weight: 600; text-decoration: none; }
    .db-card-link:hover { text-decoration: underline; }
    .db-card-body { padding: 1.25rem; }

    /* ── Cursos en progreso ── */
    .db-course-item {
        display: flex; align-items: center; gap: .9rem;
        padding: .85rem 0; border-bottom: 1px solid #f1f5f9;
    }
    .db-course-item:last-child { border-bottom: none; padding-bottom: 0; }
    .db-course-ico {
        width: 44px; height: 44px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; color: #fff; flex-shrink: 0;
    }
    .db-course-info { flex: 1; min-width: 0; }
    .db-course-name { font-weight: 600; font-size: .86rem; color: #073A6B; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: .35rem; }
    .db-bar-wrap { height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden; }
    .db-bar-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #0A4D8C, #3B88D4); transition: width .7s ease; }
    .db-bar-pct  { font-size: .72rem; color: #94a3b8; margin-top: .2rem; }

    /* ── Historial ── */
    .db-act-item { display: flex; align-items: flex-start; gap: .75rem; padding: .75rem 0; border-bottom: 1px solid #f1f5f9; }
    .db-act-item:last-child { border-bottom: none; padding-bottom: 0; }
    .db-act-dot { width: 9px; height: 9px; border-radius: 50%; margin-top: 5px; flex-shrink: 0; }
    .db-act-text { font-size: .84rem; color: #334155; line-height: 1.4; }
    .db-act-time { font-size: .72rem; color: #94a3b8; margin-top: .15rem; }

    /* ── Perfil rápido ── */
    .db-profile-top { text-align: center; padding: 1.5rem 1.25rem 1rem; border-bottom: 1px solid #e8eef5; }
    .db-profile-avatar-wrap { position: relative; width: 80px; height: 80px; margin: 0 auto .9rem; }
    .db-profile-avatar { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #EBF3FF; }
    .db-profile-initial {
        width: 80px; height: 80px; border-radius: 50%;
        background: linear-gradient(135deg, #0A4D8C, #3B88D4);
        color: #fff; font-size: 2rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 3px solid #EBF3FF;
    }
    .db-profile-name  { font-family: 'Poppins',sans-serif; font-weight: 700; font-size: 1rem; color: #073A6B; margin-bottom: .25rem; }
    .db-profile-depto { font-size: .8rem; color: #64748b; }

    .db-profile-data { padding: .75rem 1.25rem; }
    .db-profile-row  { display: flex; align-items: center; gap: .65rem; padding: .55rem 0; border-bottom: 1px solid #f1f5f9; font-size: .83rem; color: #475569; }
    .db-profile-row:last-child { border-bottom: none; }
    .db-profile-row i { color: #0A4D8C; width: 15px; text-align: center; flex-shrink: 0; }
    .db-profile-foot { padding: .75rem 1.25rem 1.25rem; }

    /* ── Certificados mini ── */
    .db-cert-empty { text-align: center; padding: 1.5rem 1rem; color: #94a3b8; }
    .db-cert-empty i { font-size: 2rem; display: block; margin-bottom: .6rem; }
    .db-cert-empty p { font-size: .84rem; margin: 0 0 .75rem; }

    /* ── Estado vacío ── */
    .db-empty { text-align: center; padding: 2.25rem 1rem; color: #94a3b8; }
    .db-empty i { font-size: 2.5rem; display: block; margin-bottom: .75rem; }
    .db-empty p { font-size: .88rem; margin: 0 0 1rem; }

    /* ── Btn mini ── */
    .btn-sm {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .45rem .9rem; border-radius: 7px;
        font-size: .82rem; font-weight: 600; text-decoration: none;
        background: #0A4D8C; color: #fff; border: none; cursor: pointer;
        transition: background .16s;
    }
    .btn-sm:hover { background: #073A6B; color: #fff; }
    .btn-sm-outline {
        background: transparent; color: #0A4D8C;
        border: 1.5px solid #0A4D8C;
    }
    .btn-sm-outline:hover { background: #EBF3FF; color: #073A6B; }

    @media (max-width: 1100px) {
        .db-stats { grid-template-columns: repeat(2, 1fr); }
        .db-grid  { grid-template-columns: 1fr; }
    }
    @media (max-width: 560px) {
        .db-stats { grid-template-columns: 1fr 1fr; }
    }
</style>

{{-- Bienvenida --}}
<div class="db-welcome">
    <div>
        <h2>¡Hola, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
        <p>Bienvenido a tu panel. Continúa aprendiendo y fortaleciendo tu comunidad.</p>
    </div>
    <a href="{{ route('cursos.index') }}" class="db-welcome-btn">
        <i class="fas fa-search"></i> Explorar Cursos
    </a>
</div>

{{-- Estadísticas --}}
<div class="db-stats">
    <div class="db-stat">
        <div class="db-stat-icon ic-blue"><i class="fas fa-book-open"></i></div>
        <div>
            <div class="db-stat-num">{{ $cursosInscritos->count() }}</div>
            <div class="db-stat-label">Cursos Inscritos</div>
        </div>
    </div>
    <div class="db-stat">
        <div class="db-stat-icon ic-green"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="db-stat-num">{{ $cursosCompletados }}</div>
            <div class="db-stat-label">Completados</div>
        </div>
    </div>
    <div class="db-stat">
        <div class="db-stat-icon ic-gold"><i class="fas fa-certificate"></i></div>
        <div>
            <div class="db-stat-num">{{ $certificados }}</div>
            <div class="db-stat-label">Certificados</div>
        </div>
    </div>
    <div class="db-stat">
        <div class="db-stat-icon ic-purple"><i class="fas fa-clock"></i></div>
        <div>
            <div class="db-stat-num">{{ $horasEstudio }}h</div>
            <div class="db-stat-label">Horas de Estudio</div>
        </div>
    </div>
</div>

{{-- Grid principal --}}
<div class="db-grid">

    {{-- Columna izquierda --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Cursos en progreso --}}
        <div class="db-card">
            <div class="db-card-head">
                <h3 class="db-card-title"><i class="fas fa-book-open"></i> Mis Cursos en Progreso</h3>
                <a href="{{ route('dashboard.cursos') }}" class="db-card-link">Ver todos <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="db-card-body">
                @if($cursosInscritos->isEmpty())
                    <div class="db-empty">
                        <i class="fas fa-book"></i>
                        <p>Aún no estás inscrito en ningún curso.</p>
                        <a href="{{ route('cursos.index') }}" class="btn-sm"><i class="fas fa-search"></i> Explorar Cursos</a>
                    </div>
                @else
                    @foreach($cursosInscritos->take(4) as $curso)
                        <div class="db-course-item">
                            <div class="db-course-ico" style="background: linear-gradient(135deg,#0A4D8C,#3B88D4);">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="db-course-info">
                                <div class="db-course-name">{{ $curso->titulo }}</div>
                                <div class="db-bar-wrap">
                                    <div class="db-bar-fill" style="width:{{ $curso->pivot->progreso ?? 0 }}%"></div>
                                </div>
                                <div class="db-bar-pct">{{ $curso->pivot->progreso ?? 0 }}% completado</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Historial de actividad --}}
        <div class="db-card">
            <div class="db-card-head">
                <h3 class="db-card-title"><i class="fas fa-history"></i> Actividad Reciente</h3>
            </div>
            <div class="db-card-body">
                <div class="db-empty">
                    <i class="fas fa-history"></i>
                    <p>Tu historial de actividad aparecerá aquí cuando comiences a tomar cursos.</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Columna derecha --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Perfil rápido --}}
        <div class="db-card">
            <div class="db-profile-top">
                <div class="db-profile-avatar-wrap">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="avatar" class="db-profile-avatar">
                    @else
                        <div class="db-profile-initial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    @endif
                </div>
                <div class="db-profile-name">{{ Auth::user()->name }}</div>
                <div class="db-profile-depto">
                    @if(Auth::user()->municipio)
                        <i class="fas fa-map-marker-alt" style="color:#0A4D8C;"></i>
                        {{ Auth::user()->municipio }}, {{ Auth::user()->departamento }}
                    @endif
                </div>
            </div>
            <div class="db-profile-data">
                <div class="db-profile-row"><i class="fas fa-envelope"></i> {{ Auth::user()->email }}</div>
                @if(Auth::user()->celular)
                    <div class="db-profile-row"><i class="fas fa-mobile-alt"></i> {{ Auth::user()->celular }}</div>
                @endif
                @if(Auth::user()->documento)
                    <div class="db-profile-row"><i class="fas fa-id-card"></i> {{ Auth::user()->documento }}</div>
                @endif
                @if(Auth::user()->pertenece_oac && Auth::user()->organismo_accion_comunal)
                    <div class="db-profile-row"><i class="fas fa-users"></i> {{ Auth::user()->organismo_accion_comunal }}</div>
                @endif
                <div class="db-profile-row">
                    <i class="fas fa-id-badge"></i>
                    {{ Auth::user()->condicion === 'afiliado' ? 'Afiliado' : 'Persona Particular' }}
                </div>
            </div>
            <div class="db-profile-foot">
                <a href="{{ route('dashboard.perfil') }}" class="btn-sm btn-sm-outline" style="width:100%;justify-content:center;">
                    <i class="fas fa-edit"></i> Editar Perfil
                </a>
            </div>
        </div>

        {{-- Certificados mini --}}
        <div class="db-card">
            <div class="db-card-head">
                <h3 class="db-card-title"><i class="fas fa-certificate"></i> Certificados</h3>
                <a href="{{ route('dashboard.certificados') }}" class="db-card-link">Ver todos <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="db-card-body">
                <div class="db-cert-empty">
                    <i class="fas fa-award"></i>
                    <p>Completa cursos para obtener certificados.</p>
                    <a href="{{ route('dashboard.cursos') }}" class="btn-sm"><i class="fas fa-book-open"></i> Ver mis cursos</a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection