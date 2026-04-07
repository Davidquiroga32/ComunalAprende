@extends('layouts.dashboard')

@section('title', 'Mis Certificados')
@section('page-title', 'Mis Certificados')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --blue:   #0A4D8C;
    --blue-l: #1E6DB8;
    --blue-p: #EBF3FF;
    --text:   #1a2940;
    --muted:  #64748b;
    --border: #e2e8f0;
    --bg:     #f7f9fc;
    --gold:   #f59e0b;
}

.certs-header {
    margin-bottom: 1.5rem;
}
.certs-header p {
    font-family: 'DM Sans', sans-serif;
    color: var(--muted); font-size: .9rem; margin: 0;
}

.certs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.25rem;
}

.cert-card {
    background: #fff; border-radius: 16px;
    box-shadow: 0 4px 16px rgba(10,37,64,.08);
    border: 1px solid var(--border); overflow: hidden;
    transition: transform .22s, box-shadow .22s;
    display: flex; flex-direction: column;
}
.cert-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 36px rgba(10,37,64,.14);
}

/* Header de la card */
.cert-card-header {
    background: linear-gradient(135deg, #0A2540 0%, #0A4D8C 60%, #1E6DB8 100%);
    padding: 1.75rem 1.5rem 2rem;
    text-align: center; position: relative; overflow: hidden;
}
.cert-card-header::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.05) 1px, transparent 1px);
    background-size: 20px 20px;
}
.cert-card-header::after {
    content: '';
    position: absolute; bottom: -1px; left: 0; right: 0;
    height: 20px; background: #fff;
    border-radius: 50% 50% 0 0 / 100% 100% 0 0;
}
.cert-award-icon {
    position: relative; z-index: 1;
    width: 56px; height: 56px; border-radius: 50%;
    background: rgba(255,255,255,.15); border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: var(--gold);
    margin: 0 auto .875rem;
}
.cert-card-label {
    position: relative; z-index: 1;
    font-family: 'Outfit', sans-serif; font-size: .65rem; font-weight: 700;
    color: rgba(255,255,255,.65); text-transform: uppercase; letter-spacing: .12em;
}

/* Body de la card */
.cert-card-body { padding: 1.25rem 1.5rem 1.5rem; flex: 1; display: flex; flex-direction: column; }

.cert-curso-name {
    font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 800;
    color: var(--text); margin-bottom: .4rem; line-height: 1.3; text-align: center;
}
.cert-fecha {
    font-family: 'DM Sans', sans-serif; font-size: .78rem; color: var(--muted);
    text-align: center; margin-bottom: 1.25rem;
    display: flex; align-items: center; justify-content: center; gap: .3rem;
}

/* Código */
.cert-code-wrap {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 9px; padding: .6rem .875rem;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 1rem;
}
.cert-code-label { font-size: .65rem; color: var(--muted); text-transform: uppercase; letter-spacing: .08em; }
.cert-code-value { font-family: 'Courier New', monospace; font-size: .78rem; font-weight: 700; color: var(--blue); letter-spacing: 1px; }

/* Botones */
.cert-actions { display: flex; gap: .6rem; margin-top: auto; }
.btn-descargar {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .65rem; background: linear-gradient(135deg, var(--blue), var(--blue-l));
    color: #fff; border-radius: 10px; font-family: 'Outfit', sans-serif;
    font-size: .84rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 3px 12px rgba(10,77,140,.3); transition: all .2s;
}
.btn-descargar:hover { transform: translateY(-1px); box-shadow: 0 5px 18px rgba(10,77,140,.4); color: #fff; }

.btn-verificar {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .65rem .875rem; background: var(--bg);
    color: var(--blue); border: 1.5px solid var(--border); border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: .84rem; font-weight: 700;
    text-decoration: none; transition: all .18s;
}
.btn-verificar:hover { border-color: var(--blue); background: var(--blue-p); }

/* Empty state */
.empty-state {
    background: #fff; border-radius: 16px;
    box-shadow: 0 2px 12px rgba(10,37,64,.06);
    text-align: center; padding: 4rem 2rem;
}
.empty-icon {
    width: 88px; height: 88px; border-radius: 50%;
    background: var(--blue-p); display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem; font-size: 2.2rem; color: var(--blue);
}
.empty-state h3 {
    font-family: 'Outfit', sans-serif; font-size: 1.15rem; font-weight: 800;
    color: var(--text); margin-bottom: .5rem;
}
.empty-state p {
    font-family: 'DM Sans', sans-serif; font-size: .9rem; color: var(--muted);
    max-width: 380px; margin: 0 auto 1.5rem; line-height: 1.6;
}
.btn-primary {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .875rem 2rem; background: linear-gradient(135deg, var(--blue), var(--blue-l));
    color: #fff; border-radius: 12px; font-family: 'Outfit', sans-serif;
    font-size: 1rem; font-weight: 700; text-decoration: none;
    box-shadow: 0 4px 16px rgba(10,77,140,.3); transition: all .2s;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(10,77,140,.4); color: #fff; }

@media (max-width: 560px) { .certs-grid { grid-template-columns: 1fr; } }
</style>

<div class="certs-header">
    <p>Aquí aparecen los certificados de los cursos que hayas completado al 100%.</p>
</div>

@if($certificados->isEmpty())
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-certificate"></i></div>
        <h3>Aún no tienes certificados</h3>
        <p>Completa un curso al 100% para recibir tu certificado de participación con QR de verificación.</p>
        <a href="{{ route('dashboard.cursos') }}" class="btn-primary">
            <i class="fas fa-book-open"></i> Ver mis cursos
        </a>
    </div>
@else
    <div class="certs-grid">
        @foreach($certificados as $curso)
            @php
                $certModel = \App\Models\Certificado::where('user_id', auth()->id())
                    ->where('curso_id', $curso->id)->first();
            @endphp
            <div class="cert-card">
                <div class="cert-card-header">
                    <div class="cert-award-icon"><i class="fas fa-award"></i></div>
                    <div class="cert-card-label">Certificado de Participación</div>
                </div>
                <div class="cert-card-body">
                    <div class="cert-curso-name">{{ $curso->titulo }}</div>
                    <div class="cert-fecha">
                        <i class="fas fa-calendar-check" style="color:var(--blue);"></i>
                        Completado el {{ $curso->pivot->updated_at?->format('d/m/Y') ?? 'N/A' }}
                    </div>

                    @if($certModel)
                        <div class="cert-code-wrap">
                            <span class="cert-code-label">Código</span>
                            <span class="cert-code-value">{{ $certModel->codigo }}</span>
                        </div>
                    @endif

                    <div class="cert-actions">
                        <a href="{{ route('certificado.descargar', $curso) }}" class="btn-descargar">
                            <i class="fas fa-download"></i> Descargar PDF
                        </a>
                        @if($certModel)
                            <a href="{{ route('certificado.verificar', $certModel->codigo) }}"
                                target="_blank" class="btn-verificar" title="Ver página de verificación">
                                <i class="fas fa-qrcode"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection