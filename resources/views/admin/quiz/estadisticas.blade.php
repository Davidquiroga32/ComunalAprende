@extends('admin.layout')
@section('title','Estadísticas Quiz')
@section('page-title','Estadísticas del Quiz')

@section('content')
<style>
    .stat-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:1rem;margin-bottom:1.5rem;}
    .stat-box{background:#fff;border-radius:10px;padding:1.1rem;box-shadow:0 2px 6px rgba(0,0,0,.05);text-align:center;}
    .stat-num{font-family:'Poppins',sans-serif;font-size:1.6rem;font-weight:700;color:#0f3460;}
    .stat-label{font-size:.75rem;color:#94a3b8;margin-top:.2rem;}
    .adm-table-wrap{background:#fff;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:hidden;}
    table{width:100%;border-collapse:collapse;}
    thead{background:#f8fafc;}
    th{padding:.7rem 1rem;text-align:left;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;border-bottom:1px solid #e8eef5;}
    td{padding:.8rem 1rem;font-size:.85rem;color:#334155;border-bottom:1px solid #f8fafc;}
    tr:last-child td{border-bottom:none;}
    .badge{display:inline-flex;align-items:center;gap:.25rem;font-size:.72rem;font-weight:700;padding:.2rem .65rem;border-radius:999px;}
    .badge-ok{background:rgba(40,167,69,.1);color:#16a34a;}
    .badge-err{background:rgba(220,53,69,.1);color:#dc3545;}
    .adm-back{display:inline-flex;align-items:center;gap:.4rem;font-size:.84rem;color:#0f3460;font-weight:600;text-decoration:none;margin-bottom:1.1rem;}
</style>

<a href="{{ route('admin.quiz.edit',$quiz->leccion_id) }}" class="adm-back"><i class="fas fa-arrow-left"></i> Volver al editor</a>

<div class="stat-grid">
    <div class="stat-box"><div class="stat-num">{{ $stats['total_intentos'] }}</div><div class="stat-label">Total Intentos</div></div>
    <div class="stat-box"><div class="stat-num">{{ $stats['usuarios_unicos'] }}</div><div class="stat-label">Usuarios Únicos</div></div>
    <div class="stat-box"><div class="stat-num" style="color:#16a34a;">{{ $stats['aprobados'] }}</div><div class="stat-label">Aprobaron</div></div>
    <div class="stat-box"><div class="stat-num">{{ $stats['promedio'] }}%</div><div class="stat-label">Promedio</div></div>
    <div class="stat-box"><div class="stat-num">{{ $stats['mejor_puntaje'] }}%</div><div class="stat-label">Mejor Puntaje</div></div>
</div>

<div class="adm-table-wrap">
    @if($intentos->isEmpty())
        <div style="text-align:center;padding:2.5rem;color:#94a3b8;"><i class="fas fa-chart-bar" style="font-size:2.5rem;display:block;margin-bottom:.75rem;"></i><p>No hay intentos aún.</p></div>
    @else
    <table>
        <thead><tr><th>Estudiante</th><th>Puntaje</th><th>%</th><th>Estado</th><th>Fecha</th><th>Tiempo</th></tr></thead>
        <tbody>
            @foreach($intentos as $int)
            <tr>
                <td>
                    <div style="font-weight:600;color:#1a1a2e;">{{ $int->user->name }}</div>
                    <div style="font-size:.75rem;color:#94a3b8;">{{ $int->user->email }}</div>
                </td>
                <td>{{ $int->puntaje }}/{{ $int->puntaje_total }}</td>
                <td><strong>{{ $int->porcentaje }}%</strong></td>
                <td><span class="badge {{ $int->aprobado?'badge-ok':'badge-err' }}">{{ $int->aprobado?'Aprobado':'No aprobado' }}</span></td>
                <td>{{ $int->finalizado_at?->format('d/m/Y H:i') ?? '—' }}</td>
                <td>{{ $int->tiempo_usado ? gmdate('i:s',$int->tiempo_usado) : '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection