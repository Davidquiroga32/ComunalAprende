@extends('admin.layout')
@section('title','Estudiantes - ' . $curso->titulo)
@section('page-title','Estudiantes: ' . Str::limit($curso->titulo, 35))

@section('content')
<style>
    .adm-back { display: inline-flex; align-items: center; gap: .4rem; font-size: .84rem; color: #0f3460; font-weight: 600; text-decoration: none; margin-bottom: 1.1rem; }
    .adm-back:hover { text-decoration: underline; }
    .adm-table-wrap { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f8fafc; }
    th { padding: .75rem 1rem; text-align: left; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border-bottom: 1px solid #e8eef5; }
    td { padding: .875rem 1rem; font-size: .86rem; color: #334155; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafcff; }

    .est-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg,#0A4D8C,#3B88D4); color: #fff; font-weight: 700; font-size: .88rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .prog-mini-wrap { height: 8px; background: #e2e8f0; border-radius: 999px; overflow: hidden; width: 100px; }
    .prog-mini-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg,#0f3460,#3B88D4); }
    .prog-mini-fill.done { background: linear-gradient(90deg,#16a34a,#22c55e); }
    .badge { display: inline-flex; align-items: center; gap: .25rem; font-size: .72rem; font-weight: 700; padding: .2rem .65rem; border-radius: 999px; }
    .badge-done { background: rgba(40,167,69,.1); color: #16a34a; }
    .badge-prog { background: rgba(10,77,140,.1); color: #0A4D8C; }

    .empty-table { text-align: center; padding: 3rem 2rem; color: #94a3b8; }
    .empty-table i { font-size: 2.5rem; display: block; margin-bottom: .75rem; }

    .stats-bar { display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
    .sbar { background: #fff; border-radius: 10px; padding: .875rem 1.25rem; box-shadow: 0 2px 6px rgba(0,0,0,.05); display: flex; align-items: center; gap: .65rem; }
    .sbar-num { font-family: 'Poppins',sans-serif; font-size: 1.3rem; font-weight: 700; color: #0f3460; }
    .sbar-label { font-size: .78rem; color: #94a3b8; }
</style>

<a href="{{ route('admin.cursos.show', $curso) }}" class="adm-back">
    <i class="fas fa-arrow-left"></i> Volver al curso
</a>

<div class="stats-bar">
    <div class="sbar">
        <div><div class="sbar-num">{{ $estudiantes->count() }}</div><div class="sbar-label">Total inscritos</div></div>
    </div>
    <div class="sbar">
        <div><div class="sbar-num">{{ $estudiantes->where('pivot.completado', true)->count() }}</div><div class="sbar-label">Completaron</div></div>
    </div>
    <div class="sbar">
        <div>
            <div class="sbar-num">
                {{ $estudiantes->count() > 0 ? round($estudiantes->avg('pivot.progreso')) : 0 }}%
            </div>
            <div class="sbar-label">Progreso promedio</div>
        </div>
    </div>
</div>

<div class="adm-table-wrap">
    @if($estudiantes->isEmpty())
        <div class="empty-table">
            <i class="fas fa-users"></i>
            <p>Ningún estudiante inscrito aún.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Ubicación</th>
                    <th>Condición</th>
                    <th>Inscrito</th>
                    <th>Progreso</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estudiantes as $est)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <div class="est-avatar">{{ strtoupper(substr($est->name,0,1)) }}</div>
                                <div>
                                    <div style="font-weight:600;color:#1a1a2e;">{{ $est->name }}</div>
                                    <div style="font-size:.75rem;color:#94a3b8;">{{ $est->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($est->municipio)
                                <span>{{ $est->municipio }}, {{ $est->departamento }}</span>
                            @else
                                <span style="color:#d1d9e0;">—</span>
                            @endif
                        </td>
                        <td>{{ $est->condicion === 'afiliado' ? 'Afiliado' : 'Particular' }}</td>
                        <td>{{ \Carbon\Carbon::parse($est->pivot->fecha_inscripcion)->format('d/m/Y') }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <div class="prog-mini-wrap">
                                    <div class="prog-mini-fill {{ $est->pivot->completado ? 'done' : '' }}"
                                        style="width:{{ $est->pivot->progreso }}%"></div>
                                </div>
                                <span style="font-size:.78rem;font-weight:600;color:#475569;">{{ $est->pivot->progreso }}%</span>
                            </div>
                        </td>
                        <td>
                            @if($est->pivot->completado)
                                <span class="badge badge-done"><i class="fas fa-check-circle"></i> Completado</span>
                            @else
                                <span class="badge badge-prog"><i class="fas fa-spinner"></i> En progreso</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection