@extends('layouts.app')
@section('title', 'Normatividad - Comunal Aprende')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=DM+Sans:wght@400;500;600&display=swap');

:root {
    --blue-deep:  #0A2540;
    --blue-core:  #0A4D8C;
    --blue-mid:   #1E6DB8;
    --blue-light: #3B88D4;
    --blue-pale:  #EBF3FF;
    --green:      #16a34a;
    --text:       #1a2940;
    --muted:      #64748b;
    --border:     #dde4ee;
    --off-white:  #f7f9fc;
}

/* ══ HERO ══ */
.norm-hero {
    position: relative;
    background: var(--blue-deep);
    padding: 5rem 1.5rem 4rem;
    overflow: hidden;
    margin-top: 68px;
    text-align: center;
}
.norm-hero-bg {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, #0A2540 0%, #0A4D8C 55%, #1E6DB8 100%);
}
.norm-hero-dots {
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.07) 1px, transparent 1px);
    background-size: 28px 28px;
    mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%);
}
.norm-hero-glow {
    position: absolute; width: 500px; height: 500px; border-radius: 50%;
    background: radial-gradient(rgba(59,136,212,.2), transparent 70%);
    top: -150px; right: -80px; pointer-events: none;
}
.norm-hero-inner {
    position: relative; z-index: 2;
    max-width: 680px; margin: 0 auto;
}
.norm-hero-eyebrow {
    display: inline-flex; align-items: center; gap: .45rem;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.85); font-family: 'Outfit', sans-serif;
    font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em;
    padding: .35rem 1rem; border-radius: 999px; margin-bottom: 1.25rem;
}
.norm-hero h1 {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(2rem, 4vw, 3rem); font-weight: 900; color: #fff;
    margin: 0 0 1rem; line-height: 1.1; letter-spacing: -.02em;
}
.norm-hero h1 span {
    background: linear-gradient(90deg, #60B0FF, #A0D4FF);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}
.norm-hero p {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.05rem; color: rgba(255,255,255,.72); line-height: 1.7; margin: 0;
}

/* ══ BODY ══ */
.norm-body {
    background: var(--off-white);
    padding: 3.5rem 1.5rem 5rem;
}
.norm-container { max-width: 1100px; margin: 0 auto; }

/* Intro strip */
.intro-strip {
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; padding: 2rem 2.5rem;
    display: flex; align-items: flex-start; gap: 1.5rem;
    margin-bottom: 3rem;
    box-shadow: 0 4px 20px rgba(10,37,64,.05);
}
.intro-strip-ico {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--blue-core), var(--blue-light));
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; color: #fff;
}
.intro-strip h2 {
    font-family: 'Outfit', sans-serif;
    font-size: 1.2rem; font-weight: 800; color: var(--text); margin: 0 0 .4rem;
}
.intro-strip p {
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem; color: var(--muted); margin: 0; line-height: 1.7;
}

/* ══ SECCIÓN TITLE ══ */
.sec-header {
    display: flex; align-items: center; gap: .75rem;
    margin-bottom: 1.5rem;
}
.sec-header-line {
    flex: 1; height: 1px; background: var(--border);
}
.sec-tag {
    display: inline-flex; align-items: center; gap: .4rem;
    font-family: 'Outfit', sans-serif; font-size: .72rem; font-weight: 800;
    color: var(--blue-core); text-transform: uppercase; letter-spacing: .1em;
    background: var(--blue-pale); padding: .3rem .875rem; border-radius: 999px;
}

/* ══ LEY PRINCIPAL ══ */
.ley-principal {
    background: linear-gradient(135deg, var(--blue-deep), var(--blue-core));
    border-radius: 20px; overflow: hidden;
    display: grid; grid-template-columns: 280px 1fr;
    margin-bottom: 3rem;
    box-shadow: 0 12px 40px rgba(10,37,64,.2);
    position: relative;
}
.ley-principal::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.04) 1px, transparent 1px);
    background-size: 24px 24px;
}
.ley-visual {
    display: flex; align-items: center; justify-content: center;
    padding: 2.5rem;
    background: rgba(0,0,0,.15);
    position: relative; z-index: 1;
}
.ley-gavel-wrap {
    width: 100px; height: 100px; border-radius: 24px;
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; color: #fff;
}
.ley-content {
    padding: 2.5rem; position: relative; z-index: 1;
}
.ley-tag {
    display: inline-flex; align-items: center; gap: .35rem;
    background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
    color: rgba(255,255,255,.9); font-family: 'Outfit', sans-serif;
    font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em;
    padding: .25rem .75rem; border-radius: 999px; margin-bottom: 1rem;
}
.ley-numero {
    font-family: 'Outfit', sans-serif;
    font-size: 1.75rem; font-weight: 900; color: #fff;
    margin: 0 0 .75rem; letter-spacing: -.02em;
}
.ley-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: .9rem; color: rgba(255,255,255,.75); line-height: 1.75;
    margin: 0 0 1.75rem; max-width: 520px;
}
.ley-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .75rem 1.5rem;
    background: #fff; color: var(--blue-core);
    border-radius: 10px; font-family: 'Outfit', sans-serif;
    font-size: .88rem; font-weight: 800; text-decoration: none;
    transition: all .2s; box-shadow: 0 4px 16px rgba(0,0,0,.15);
}
.ley-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.2); color: var(--blue-core); }

/* ══ DECRETOS GRID ══ */
.decretos-grid {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 1.25rem; margin-bottom: 3rem;
}
.decreto-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; overflow: hidden;
    transition: all .22s; display: flex; flex-direction: column;
}
.decreto-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 36px rgba(10,37,64,.11);
    border-color: #b8d4f0;
}
.decreto-thumb {
    height: 110px; display: flex; align-items: center; justify-content: center;
    font-size: 2.25rem; color: rgba(255,255,255,.8);
    position: relative;
}
.decreto-thumb-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,.1);
}
.decreto-thumb-ico { position: relative; z-index: 1; }
.decreto-body { padding: 1.25rem 1.35rem 1.5rem; flex: 1; display: flex; flex-direction: column; }
.decreto-tag {
    font-family: 'Outfit', sans-serif; font-size: .68rem; font-weight: 700;
    color: var(--blue-core); text-transform: uppercase; letter-spacing: .08em;
    margin-bottom: .5rem; display: flex; align-items: center; gap: .25rem;
}
.decreto-tag::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: var(--blue-core); }
.decreto-num {
    font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 800;
    color: var(--text); margin: 0 0 .5rem;
}
.decreto-desc {
    font-family: 'DM Sans', sans-serif; font-size: .83rem; color: var(--muted);
    line-height: 1.6; flex: 1; margin: 0 0 1.25rem;
}
.decreto-btn {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    padding: .6rem 1rem;
    border: 1.5px solid var(--border); border-radius: 9px; background: var(--off-white);
    color: var(--blue-core); font-family: 'Outfit', sans-serif;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    transition: all .18s;
}
.decreto-btn:hover { background: var(--blue-pale); border-color: var(--blue-light); }

/* ══ OTRAS NORMAS ══ */
.otras-normas {
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; padding: 2rem 2.25rem;
    margin-bottom: 3rem;
    box-shadow: 0 4px 16px rgba(10,37,64,.04);
}
.norma-item {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: 1rem 0; border-bottom: 1px solid #f0f4f8;
}
.norma-item:last-child { border-bottom: none; padding-bottom: 0; }
.norma-ico {
    width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
    background: var(--blue-pale);
    display: flex; align-items: center; justify-content: center;
    color: var(--blue-core); font-size: .88rem;
    margin-top: .1rem;
}
.norma-titulo {
    font-family: 'Outfit', sans-serif;
    font-size: .92rem; font-weight: 800; color: var(--text); margin-bottom: .3rem;
}
.norma-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: .84rem; color: var(--muted); line-height: 1.6; margin: 0;
}

/* ══ RECURSOS ══ */
.recursos-grid {
    display: grid; grid-template-columns: repeat(3,1fr);
    gap: 1.25rem; margin-bottom: 3rem;
}
.recurso-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; padding: 1.75rem 1.5rem;
    text-align: center; transition: all .22s;
}
.recurso-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 32px rgba(10,37,64,.1);
    border-color: #b8d4f0;
}
.recurso-ico {
    width: 64px; height: 64px; border-radius: 18px;
    background: linear-gradient(135deg, var(--blue-core), var(--blue-light));
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: #fff;
    margin: 0 auto 1.25rem;
    box-shadow: 0 6px 20px rgba(10,77,140,.25);
}
.recurso-card h4 {
    font-family: 'Outfit', sans-serif;
    font-size: .95rem; font-weight: 800; color: var(--text); margin: 0 0 .4rem;
}
.recurso-card p {
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem; color: var(--muted); margin: 0 0 1.25rem; line-height: 1.5;
}
.recurso-btn {
    display: flex; align-items: center; justify-content: center; gap: .4rem;
    width: 100%; padding: .65rem 1rem;
    border: 1.5px solid var(--border); border-radius: 9px; background: var(--off-white);
    color: var(--blue-core); font-family: 'Outfit', sans-serif;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    transition: all .18s;
}
.recurso-btn:hover { background: var(--blue-pale); border-color: var(--blue-light); }

/* ══ CTA ══ */
.norm-cta {
    background: linear-gradient(135deg, var(--blue-deep), var(--blue-core));
    border-radius: 20px; padding: 3rem 2.5rem;
    text-align: center; position: relative; overflow: hidden;
}
.norm-cta::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.05) 1px, transparent 1px);
    background-size: 24px 24px;
}
.norm-cta-inner { position: relative; z-index: 1; max-width: 520px; margin: 0 auto; }
.norm-cta h2 {
    font-family: 'Outfit', sans-serif;
    font-size: 1.75rem; font-weight: 900; color: #fff; margin: 0 0 .75rem; letter-spacing: -.02em;
}
.norm-cta p {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem; color: rgba(255,255,255,.7); margin: 0 0 2rem; line-height: 1.7;
}
.norm-cta-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .9rem 2rem; background: #fff; color: var(--blue-core);
    border-radius: 12px; font-family: 'Outfit', sans-serif;
    font-size: .95rem; font-weight: 800; text-decoration: none;
    transition: all .2s; box-shadow: 0 4px 20px rgba(0,0,0,.2);
}
.norm-cta-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(0,0,0,.25); color: var(--blue-core); }

/* Responsive */
@media (max-width: 900px) {
    .ley-principal { grid-template-columns: 1fr; }
    .ley-visual { padding: 2rem; }
    .decretos-grid, .recursos-grid { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 580px) {
    .decretos-grid, .recursos-grid { grid-template-columns: 1fr; }
    .intro-strip { flex-direction: column; }
}
</style>

{{-- ══ HERO ══ --}}
<section class="norm-hero">
    <div class="norm-hero-bg"></div>
    <div class="norm-hero-dots"></div>
    <div class="norm-hero-glow"></div>
    <div class="norm-hero-inner">
        <div class="norm-hero-eyebrow">
            <i class="fas fa-gavel"></i> Marco Normativo
        </div>
        <h1>Normatividad <span>Comunitaria</span></h1>
        <p>Conoce las leyes, decretos y regulaciones que rigen las organizaciones comunitarias en Colombia.</p>
    </div>
    <div style="position:absolute;bottom:-1px;left:0;right:0;line-height:0;z-index:2;">
        <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;display:block;">
            <path d="M0,48 C360,16 1080,0 1440,32 L1440,48 L0,48 Z" fill="#f7f9fc"/>
        </svg>
    </div>
</section>

{{-- ══ BODY ══ --}}
<div class="norm-body">
    <div class="norm-container">

        {{-- Intro --}}
        <div class="intro-strip">
            <div class="intro-strip-ico"><i class="fas fa-balance-scale"></i></div>
            <div>
                <h2>Marco Legal de las Organizaciones Comunitarias</h2>
                <p>Las Juntas de Acción Comunal y organizaciones comunitarias en Colombia se rigen por un marco normativo específico que garantiza su funcionamiento, autonomía y reconocimiento legal. Aquí encontrarás toda la normatividad vigente de manera organizada.</p>
            </div>
        </div>

        {{-- Ley principal --}}
        <div class="sec-header">
            <div class="sec-tag"><i class="fas fa-star"></i> Ley Principal</div>
            <div class="sec-header-line"></div>
        </div>

        <div class="ley-principal">
            <div class="ley-visual">
                <div class="ley-gavel-wrap"><i class="fas fa-gavel"></i></div>
            </div>
            <div class="ley-content">
                <div class="ley-tag"><i class="fas fa-certificate"></i> Ley Fundamental</div>
                <h2 class="ley-numero">Ley 743 de 2002</h2>
                <p class="ley-desc">
                    Por la cual se desarrolla el artículo 38 de la Constitución Política de Colombia en lo referente a los organismos de acción comunal. Establece el marco legal para la organización, funcionamiento y registro de las JAC, juntas de vivienda comunitaria y demás organismos de acción comunal.
                </p>
                <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=5301"
                    target="_blank" class="ley-btn">
                        <i class="fas fa-external-link-alt"></i> Ver Ley Oficial
                </a>
            </div>
        </div>

        {{-- Decretos --}}
        <div class="sec-header">
            <div class="sec-tag"><i class="fas fa-file-alt"></i> Decretos Reglamentarios</div>
            <div class="sec-header-line"></div>
        </div>

        @php
            $decretos = [
                ['gradiente' => '#1E6DB8, #3B88D4', 'numero' => 'Decreto 2350 de 2003',
                'descripcion' => 'Reglamenta parcialmente la Ley 743 de 2002 en cuanto al registro, reconocimiento y supervisión de los organismos de acción comunal.',
                'url' => 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=9583'],
                ['gradiente' => '#0A4D8C, #1E6DB8', 'numero' => 'Decreto 890 de 2008',
                'descripcion' => 'Reglamenta el registro único nacional de organizaciones de acción comunal y establece procedimientos administrativos.',
                'url' => 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=29343'],
                ['gradiente' => '#3B88D4, #5CA3E6', 'numero' => 'Decreto 1066 de 2015',
                'descripcion' => 'Decreto único reglamentario del sector administrativo del Interior que compila normas sobre participación ciudadana y acción comunal.',
                'url' => 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=77104'],
            ];
        @endphp

        <div class="decretos-grid">
            @foreach($decretos as $d)
                <div class="decreto-card">
                    <div class="decreto-thumb" style="background: linear-gradient(135deg, {{ $d['gradiente'] }});">
                        <div class="decreto-thumb-overlay"></div>
                        <div class="decreto-thumb-ico"><i class="fas fa-file-alt" style="color:rgba(255,255,255,.85);font-size:2rem;"></i></div>
                    </div>
                    <div class="decreto-body">
                        <div class="decreto-tag">Decreto Reglamentario</div>
                        <h3 class="decreto-num">{{ $d['numero'] }}</h3>
                        <p class="decreto-desc">{{ $d['descripcion'] }}</p>
                        <a href="{{ $d['url'] }}" target="_blank" class="decreto-btn">
                            <i class="fas fa-external-link-alt"></i> Ver Decreto Oficial
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Otras normas --}}
        <div class="sec-header">
            <div class="sec-tag"><i class="fas fa-list-ul"></i> Otras Normas Relevantes</div>
            <div class="sec-header-line"></div>
        </div>

        @php
            $otrasNormas = [
                        ['titulo' => 'Ley 134 de 1994', 'icon' => 'fa-users',
                'url' => 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=329',
                'descripcion' => 'Sobre mecanismos de participación ciudadana: referendo, consulta popular, revocatoria del mandato, plebiscito y cabildo abierto.'],
                ['titulo' => 'Ley 1551 de 2012', 'icon' => 'fa-city',
                'url' => 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=48267',
                'descripcion' => 'Por la cual se dictan normas para modernizar la organización y el funcionamiento de los municipios, incluyendo participación comunitaria.'],
                ['titulo' => 'Decreto 2499 de 2011', 'icon' => 'fa-handshake',
                'url' => 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=44580',
                'descripcion' => 'Reglamenta la participación de organizaciones de economía solidaria en contratación estatal.'],
                ['titulo' => 'Ley 1757 de 2015', 'icon' => 'fa-vote-yea',
                'url' => 'https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=61264',
                'descripcion' => 'Disposiciones en materia de promoción y protección del derecho a la participación democrática en Colombia.'],
            ];
        @endphp

        <div class="otras-normas">
            @foreach($otrasNormas as $norma)
                <div class="norma-item">
                    <div class="norma-ico"><i class="fas {{ $norma['icon'] }}"></i></div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;margin-bottom:.3rem;">
                            <div class="norma-titulo">{{ $norma['titulo'] }}</div>
                            <a href="{{ $norma['url'] }}" target="_blank"
                                style="display:inline-flex;align-items:center;gap:.3rem;font-family:'Outfit',sans-serif;font-size:.72rem;font-weight:700;color:var(--blue-core);text-decoration:none;background:var(--blue-pale);padding:.2rem .6rem;border-radius:999px;white-space:nowrap; flex-shrink:0;">
                                <i class="fas fa-external-link-alt"></i> Ver oficial
                            </a>
                        </div>
                        <p class="norma-desc">{{ $norma['descripcion'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Recursos --}}
        <div class="sec-header">
            <div class="sec-tag"><i class="fas fa-folder-open"></i> Recursos y Formatos</div>
            <div class="sec-header-line"></div>
        </div>

        @php
            $recursos = [
                ['icon' => 'fa-file-contract', 'titulo' => 'Estatutos Modelo',
                'url' => 'https://www.mininterior.gov.co/sites/default/files/estatutos_modelo_jac.pdf',
                'descripcion' => 'Plantilla base de estatutos para Junta de Acción Comunal lista para personalizar.'],
                ['icon' => 'fa-clipboard-list', 'titulo' => 'Formatos de Actas',
                'url' => 'https://www.mininterior.gov.co/sites/default/files/formatos_actas_jac.pdf',
                'descripcion' => 'Modelos de actas de asamblea, comités y reuniones de junta directiva.'],
                ['icon' => 'fa-book', 'titulo' => 'Libros Reglamentarios',
                'url' => 'https://www.mininterior.gov.co/sites/default/files/guia_libros_reglamentarios.pdf',
                'descripcion' => 'Guía completa para el manejo de los libros oficiales requeridos por ley.'],
            ];
        @endphp

        <div class="recursos-grid">
            @foreach($recursos as $r)
                <div class="recurso-card">
                    <div class="recurso-ico"><i class="fas {{ $r['icon'] }}"></i></div>
                    <h4>{{ $r['titulo'] }}</h4>
                    <p>{{ $r['descripcion'] }}</p>
                    <a href="{{ $r['url'] }}" target="_blank" class="recurso-btn">
                        <i class="fas fa-external-link-alt"></i> Ver Documento
                    </a>
                </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="norm-cta">
            <div class="norm-cta-inner">
                <h2>¿Necesitas Asesoría Normativa?</h2>
                <p>Nuestro equipo de expertos puede ayudarte con consultas específicas sobre normatividad y cumplimiento legal de tu organización.</p>
                <a href="{{ route('contacto') }}" class="norm-cta-btn">
                    <i class="fas fa-headset"></i> Solicitar Asesoría
                </a>
            </div>
        </div>

    </div>
</div>

@endsection