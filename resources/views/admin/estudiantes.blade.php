@extends('admin.layout')
@section('title','Estudiantes')
@section('page-title','Estudiantes')

@section('content')
<style>
    .adm-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem; }
    .adm-table-wrap { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead { background: #f8fafc; }
    th { padding: .75rem 1rem; text-align: left; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #64748b; border-bottom: 1px solid #e8eef5; }
    td { padding: .875rem 1rem; font-size: .86rem; color: #334155; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafcff; }
    .est-init { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg,#e94560,#ff6b8a); color: #fff; font-weight: 700; font-size: .88rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .badge { display: inline-flex; align-items: center; gap: .25rem; font-size: .72rem; font-weight: 700; padding: .2rem .65rem; border-radius: 999px; }
    .badge-afil { background: rgba(10,77,140,.1); color: #0A4D8C; }
    .badge-part { background: rgba(100,116,139,.1); color: #64748b; }
    .badge-oac  { background: rgba(40,167,69,.1); color: #16a34a; }
    .paginator { padding: 1rem 1.25rem; display: flex; justify-content: center; }
    .empty-table { text-align: center; padding: 3rem 2rem; color: #94a3b8; }
    .empty-table i { font-size: 2.5rem; display: block; margin-bottom: .75rem; }
    .search-bar { display: flex; align-items: center; gap: .6rem; }
    .search-input { padding: .6rem .9rem; border: 1.5px solid #d1d9e0; border-radius: 8px; font-size: .86rem; font-family: inherit; outline: none; width: 240px; }
    .search-input:focus { border-color: #0f3460; }
    @media (max-width: 768px) { .hide-sm { display: none; } }
</style>

<div class="adm-toolbar">
    <div style="font-size:.9rem;color:#64748b;">
        <strong style="color:#1a1a2e;">{{ $estudiantes->total() }}</strong> estudiantes registrados
    </div>
</div>

<div class="adm-table-wrap">
    @if($estudiantes->isEmpty())
        <div class="empty-table">
            <i class="fas fa-users"></i>
            <p>No hay estudiantes registrados aún.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th class="hide-sm">Documento</th>
                    <th class="hide-sm">Ubicación</th>
                    <th>Condición</th>
                    <th class="hide-sm">OAC</th>
                    <th class="hide-sm">Cursos</th>
                    <th class="hide-sm">Registrado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($estudiantes as $est)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:.75rem;">
                                <div class="est-init">{{ strtoupper(substr($est->name,0,1)) }}</div>
                                <div>
                                    <div style="font-weight:600;color:#1a1a2e;">{{ $est->name }}</div>
                                    <div style="font-size:.75rem;color:#94a3b8;">{{ $est->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="hide-sm">{{ $est->documento ?? '—' }}</td>
                        <td class="hide-sm">
                            @if($est->municipio)
                                {{ $est->municipio }}, {{ $est->departamento }}
                            @else
                                <span style="color:#d1d9e0;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $est->condicion === 'afiliado' ? 'badge-afil' : 'badge-part' }}">
                                {{ $est->condicion === 'afiliado' ? 'Afiliado' : 'Particular' }}
                            </span>
                        </td>
                        <td class="hide-sm">
                            @if($est->pertenece_oac)
                                <span class="badge badge-oac"><i class="fas fa-check"></i> {{ Str::limit($est->organismo_accion_comunal, 25) }}</span>
                            @else
                                <span style="color:#d1d9e0;">No</span>
                            @endif
                        </td>
                        <td class="hide-sm">
                            <strong>{{ $est->cursos_count }}</strong>
                        </td>
                        <td class="hide-sm">{{ $est->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($estudiantes->hasPages())
            <div class="paginator">{{ $estudiantes->links() }}</div>
        @endif
    @endif
</div>
@endsection