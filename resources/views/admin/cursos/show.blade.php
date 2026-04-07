@extends('admin.layout')
@section('title', $curso->titulo)
@section('page-title', $curso->titulo)

@section('content')
<style>
    .show-grid { display: grid; grid-template-columns: 1fr 300px; gap: 1.25rem; align-items: start; }
    .adm-card  { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; margin-bottom: 1.25rem; }
    .adm-card-head { padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
    .adm-card-title { font-family: 'Poppins',sans-serif; font-size: .95rem; font-weight: 700; color: #1a1a2e; margin: 0; display: flex; align-items: center; gap: .45rem; }
    .adm-card-body  { padding: 1.25rem; }

    .curso-header-card {
        background: linear-gradient(135deg, #1a1a2e, #0f3460);
        border-radius: 12px; padding: 1.5rem;
        color: #fff; margin-bottom: 1.25rem;
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .curso-header-icon { width: 60px; height: 60px; border-radius: 14px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center; font-size: 1.75rem; flex-shrink: 0; }
    .curso-header-info { flex: 1; }
    .curso-header-title { font-family: 'Poppins',sans-serif; font-size: 1.3rem; font-weight: 700; margin-bottom: .3rem; }
    .curso-header-meta  { font-size: .85rem; color: rgba(255,255,255,.7); }
    .curso-header-actions { display: flex; gap: .6rem; }
    .btn-edit-curso {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1rem; background: rgba(255,255,255,.15); color: #fff;
        border: 1.5px solid rgba(255,255,255,.3); border-radius: 8px;
        font-size: .84rem; font-weight: 600; text-decoration: none; transition: background .16s;
    }
    .btn-edit-curso:hover { background: rgba(255,255,255,.25); color: #fff; }

    .curso-stats-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: .75rem; margin-bottom: 1.25rem; }
    .cstat { background: #fff; border-radius: 10px; padding: 1rem; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,.05); }
    .cstat-num   { font-family: 'Poppins',sans-serif; font-size: 1.5rem; font-weight: 700; color: #0f3460; }
    .cstat-label { font-size: .75rem; color: #94a3b8; margin-top: .2rem; }

    .modulo-item { border: 1.5px solid #e8eef5; border-radius: 10px; margin-bottom: .875rem; overflow: hidden; }
    .modulo-head {
        padding: .875rem 1.1rem; background: #f8fafc;
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer;
    }
    .modulo-head-left { display: flex; align-items: center; gap: .65rem; }
    .modulo-num { width: 26px; height: 26px; background: #0f3460; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .72rem; font-weight: 700; flex-shrink: 0; }
    .modulo-titulo { font-weight: 700; font-size: .9rem; color: #1a1a2e; }
    .modulo-actions { display: flex; gap: .35rem; }
    .mact { width: 28px; height: 28px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: .75rem; cursor: pointer; border: none; transition: all .15s; }
    .mact-edit  { background: #FFFBEB; color: #d97706; }
    .mact-del   { background: rgba(220,53,69,.1); color: #dc3545; }
    .mact-quiz  { background: rgba(124,58,237,.1); color: #7c3aed; }

    .lecciones-list { padding: 0 .875rem .875rem; }
    .leccion-item {
        display: flex; align-items: center; gap: .75rem;
        padding: .65rem .875rem; margin-top: .5rem;
        background: #fff; border: 1px solid #f1f5f9; border-radius: 8px;
    }
    .lec-tipo-icon { width: 32px; height: 32px; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: .82rem; flex-shrink: 0; }
    .tipo-texto  { background: #EBF3FF; color: #0A4D8C; }
    .tipo-video  { background: rgba(233,69,96,.1); color: #e94560; }
    .tipo-pdf    { background: rgba(217,119,6,.1); color: #d97706; }
    .tipo-quiz   { background: rgba(124,58,237,.1); color: #7c3aed; }
    .tipo-tarea  { background: rgba(40,167,69,.1); color: #16a34a; }
    .lec-titulo  { flex: 1; font-size: .84rem; font-weight: 500; color: #334155; }
    .lec-dur     { font-size: .75rem; color: #94a3b8; }
    .lec-actions { display: flex; gap: .3rem; }

    .nuevo-modulo-form {
        background: #f8fafc; border: 1.5px dashed #d1d9e0;
        border-radius: 10px; padding: 1rem; margin-top: .75rem;
    }
    .fi-sm { padding: .55rem .8rem; border: 1.5px solid #d1d9e0; border-radius: 7px; font-size: .85rem; font-family: inherit; width: 100%; outline: none; }
    .fi-sm:focus { border-color: #0f3460; }
    .btn-add-modulo {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .55rem 1rem; background: #0f3460; color: #fff;
        border: none; border-radius: 7px; font-size: .84rem; font-weight: 600; cursor: pointer;
    }
    .btn-add-leccion {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .4rem .75rem; background: transparent; color: #0f3460;
        border: 1.5px solid #0f3460; border-radius: 7px;
        font-size: .78rem; font-weight: 600; text-decoration: none; transition: all .15s;
    }
    .btn-add-leccion:hover { background: #0f3460; color: #fff; }

    .info-row { display: flex; justify-content: space-between; align-items: center; padding: .65rem 0; border-bottom: 1px solid #f8fafc; font-size: .85rem; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #94a3b8; font-weight: 500; }
    .info-value { color: #334155; font-weight: 600; }

    @media (max-width: 900px) { .show-grid { grid-template-columns: 1fr; } }
</style>

<div class="curso-header-card">
    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
        <div class="curso-header-icon">
            <i class="fas {{ $curso->icono_fa ?? 'fa-graduation-cap' }}"></i>
        </div>
        <div class="curso-header-info">
            <div class="curso-header-title">{{ $curso->titulo }}</div>
            <div class="curso-header-meta">
                {{ $curso->categoriaLabel() }} · {{ $curso->duracion_horas }}h · {{ $curso->precioFormateado() }}
            </div>
        </div>
    </div>
    <div class="curso-header-actions">
        <a href="{{ route('admin.cursos.edit', $curso) }}" class="btn-edit-curso">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('admin.cursos.estudiantes', $curso) }}" class="btn-edit-curso">
            <i class="fas fa-users"></i> Estudiantes
        </a>
    </div>
</div>

<div class="curso-stats-grid">
    <div class="cstat">
        <div class="cstat-num">{{ $totalEstudiantes }}</div>
        <div class="cstat-label">Estudiantes Inscritos</div>
    </div>
    <div class="cstat">
        <div class="cstat-num">{{ $totalLecciones }}</div>
        <div class="cstat-label">Lecciones</div>
    </div>
    <div class="cstat">
        <div class="cstat-num">{{ $completados }}</div>
        <div class="cstat-label">Completaron el Curso</div>
    </div>
</div>

<div class="show-grid">

    <div>
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><i class="fas fa-layer-group" style="color:#0f3460;"></i> Módulos y Lecciones</h3>
            </div>
            <div class="adm-card-body">

                @forelse($curso->modulos as $modulo)
                    <div class="modulo-item">
                        <div class="modulo-head">
                            <div class="modulo-head-left">
                                <div class="modulo-num">{{ $loop->iteration }}</div>
                                <div class="modulo-titulo">{{ $modulo->titulo }}</div>
                                <span style="font-size:.75rem;color:#94a3b8;">{{ $modulo->lecciones->count() }} lecciones</span>
                            </div>
                            <div class="modulo-actions" onclick="event.stopPropagation()">
                                <a href="{{ route('admin.lecciones.create', $modulo) }}" class="mact" style="background:#EBF3FF;color:#0A4D8C;text-decoration:none;" title="Agregar lección">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <button onclick="toggleEditModulo({{ $modulo->id }})" class="mact mact-edit" title="Editar módulo">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.modulos.destroy', $modulo) }}"
                                      onsubmit="return confirm('¿Eliminar módulo «{{ $modulo->titulo }}» y todas sus lecciones?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="mact mact-del" title="Eliminar módulo">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div id="edit-modulo-{{ $modulo->id }}" style="display:none;padding:.75rem;background:#f8fafc;border-top:1px solid #e8eef5;">
                            <form method="POST" action="{{ route('admin.modulos.update', $modulo) }}">
                                @csrf @method('PUT')
                                <div style="display:flex;gap:.6rem;align-items:center;">
                                    <input type="text" name="titulo" class="fi-sm" value="{{ $modulo->titulo }}" required>
                                    <button type="submit" class="btn-add-modulo" style="white-space:nowrap;">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                    <button type="button" onclick="toggleEditModulo({{ $modulo->id }})"
                                            style="padding:.55rem .75rem;background:#f0f4f8;border:none;border-radius:7px;cursor:pointer;font-size:.84rem;">
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="lecciones-list">
                            @forelse($modulo->lecciones as $leccion)
                                <div class="leccion-item">
                                    @php
                                        $tipoClass = ['texto'=>'tipo-texto','video'=>'tipo-video','pdf'=>'tipo-pdf','quiz'=>'tipo-quiz','tarea'=>'tipo-tarea'][$leccion->tipo_contenido] ?? 'tipo-texto';
                                        $tipoIcon  = ['texto'=>'fa-file-alt','video'=>'fa-play-circle','pdf'=>'fa-file-pdf','quiz'=>'fa-question-circle','tarea'=>'fa-tasks'][$leccion->tipo_contenido] ?? 'fa-file-alt';
                                    @endphp
                                    <div class="lec-tipo-icon {{ $tipoClass }}">
                                        <i class="fas {{ $tipoIcon }}"></i>
                                    </div>
                                    <div class="lec-titulo">{{ $leccion->titulo }}</div>
                                    @if($leccion->duracion_minutos)
                                        <div class="lec-dur">{{ $leccion->duracion_minutos }}min</div>
                                    @endif
                                    <div class="lec-actions">
                                        {{-- Botón editar: si es quiz va al editor de quiz, si no a editar lección --}}
                                        @if($leccion->tipo_contenido === 'quiz')
                                            <a href="{{ route('admin.quiz.edit', $leccion) }}"
                                               class="mact mact-quiz" style="text-decoration:none;" title="Editar Quiz">
                                                <i class="fas fa-question-circle"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.lecciones.edit', $leccion) }}"
                                               class="mact mact-edit" style="text-decoration:none;" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('admin.lecciones.destroy', $leccion) }}"
                                              onsubmit="return confirm('¿Eliminar lección «{{ $leccion->titulo }}»?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="mact mact-del" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align:center;padding:.75rem;font-size:.82rem;color:#94a3b8;">
                                    Sin lecciones.
                                    <a href="{{ route('admin.lecciones.create', $modulo) }}" style="color:#0f3460;font-weight:600;">Agregar una <i class="fas fa-plus"></i></a>
                                </div>
                            @endforelse

                            <div style="margin-top:.5rem;">
                                <a href="{{ route('admin.lecciones.create', $modulo) }}" class="btn-add-leccion">
                                    <i class="fas fa-plus"></i> Agregar lección
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:1.5rem;color:#94a3b8;font-size:.88rem;">
                        <i class="fas fa-layer-group" style="font-size:2rem;display:block;margin-bottom:.75rem;"></i>
                        Aún no hay módulos. Crea el primero abajo.
                    </div>
                @endforelse

                <div class="nuevo-modulo-form">
                    <form method="POST" action="{{ route('admin.modulos.store', $curso) }}">
                        @csrf
                        <label style="font-size:.82rem;font-weight:700;color:#334155;display:block;margin-bottom:.5rem;">
                            <i class="fas fa-plus-circle" style="color:#0f3460;"></i> Agregar nuevo módulo
                        </label>
                        <div style="display:flex;gap:.6rem;align-items:center;">
                            <input type="text" name="titulo" class="fi-sm" placeholder="Título del módulo" required>
                            <button type="submit" class="btn-add-modulo">
                                <i class="fas fa-plus"></i> Agregar
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div>
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><i class="fas fa-info-circle" style="color:#0f3460;"></i> Información</h3>
            </div>
            <div class="adm-card-body" style="padding:.75rem 1.25rem;">
                <div class="info-row">
                    <span class="info-label">Estado</span>
                    <span class="info-value" style="color:{{ $curso->activo ? '#16a34a' : '#dc3545' }};">
                        {{ $curso->activo ? '● Activo' : '● Inactivo' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tipo</span>
                    <span class="info-value">{{ $curso->tipo === 'free' ? 'Gratuito' : 'De Pago' }}</span>
                </div>
                @if($curso->tipo === 'paid')
                    <div class="info-row">
                        <span class="info-label">Precio</span>
                        <span class="info-value">{{ $curso->precioFormateado() }}</span>
                    </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Categoría</span>
                    <span class="info-value">{{ $curso->categoriaLabel() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Duración</span>
                    <span class="info-value">{{ $curso->duracion_horas }} horas</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Módulos</span>
                    <span class="info-value">{{ $curso->modulos->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Destacado</span>
                    <span class="info-value">{{ $curso->destacado ? 'Sí' : 'No' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Creado</span>
                    <span class="info-value">{{ $curso->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        @if($curso->descripcion)
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><i class="fas fa-align-left" style="color:#0f3460;"></i> Descripción</h3>
                </div>
                <div class="adm-card-body">
                    <p style="font-size:.86rem;color:#475569;line-height:1.6;margin:0;">{{ $curso->descripcion }}</p>
                </div>
            </div>
        @endif
    </div>

</div>

<script>
function toggleEditModulo(id) {
    const el = document.getElementById('edit-modulo-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection