@extends('layouts.app')

@section('title', 'Comunal Aprende - Formación y Capacitación Comunitaria')
@section('description', 'Somos una iniciativa de servicios integrales en asesoría, consultoría y formación para organizaciones comunitarias en Colombia.')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');

:root {
    --blue-deep:  #0A2540;
    --blue-core:  #0A4D8C;
    --blue-mid:   #1E6DB8;
    --blue-light: #3B88D4;
    --blue-pale:  #EBF3FF;
    --green:      #2E7D32;
    --orange:     #E65100;
    --white:      #ffffff;
    --off-white:  #f7f9fc;
    --text:       #1a2940;
    --muted:      #64748b;
    --border:     #dde4ee;
}

/* ══════════════════════════════════
    HERO SLIDER
══════════════════════════════════ */
.hero-section {
    position: relative;
    height: 92vh;
    min-height: 680px;
    max-height: 920px;
    overflow: hidden;
    font-family: 'Outfit', sans-serif;
}

/* Slides */
.slide {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1s ease;
    display: flex; align-items: center;
}
.slide.active { opacity: 1; z-index: 1; }

/* Overlay dinámico con blur sutil en bordes */
.slide-overlay {
    position: absolute; inset: 0;
    background:
        linear-gradient(90deg, rgba(10,37,64,.72) 0%, rgba(10,37,64,.38) 45%, rgba(10,37,64,.08) 100%),
        linear-gradient(0deg, rgba(10,37,64,.35) 0%, transparent 35%);
}

/* Partículas decorativas */
.slide-particles {
    position: absolute; inset: 0;
    overflow: hidden;
    pointer-events: none;
}
.particle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
    animation: floatParticle 8s infinite ease-in-out;
}
.particle:nth-child(1) { width:300px;height:300px; top:-80px; right:8%; animation-delay:0s; }
.particle:nth-child(2) { width:180px;height:180px; top:30%; right:25%; animation-delay:2s; }
.particle:nth-child(3) { width:120px;height:120px; bottom:10%; right:15%; animation-delay:4s; }
.particle:nth-child(4) { width:60px;height:60px; top:20%; right:40%; animation-delay:1s; }

@keyframes floatParticle {
    0%,100% { transform: translateY(0) scale(1); }
    50%      { transform: translateY(-20px) scale(1.05); }
}

/* Contenido del slide */
.slide-inner {
    position: relative; z-index: 2;
    max-width: 1200px; margin: 0 auto;
    padding: 0 2rem;
    width: 100%;
    padding-bottom: 140px; 
}

.slide-tag {
    display: inline-flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.25);
    backdrop-filter: blur(8px);
    color: rgba(255,255,255,.9);
    font-size: .75rem; font-weight: 700;
    padding: .4rem 1rem; border-radius: 999px;
    text-transform: uppercase; letter-spacing: .1em;
    margin-bottom: 1.25rem;
    opacity: 0; transform: translateY(15px);
    transition: all .6s .1s ease;
}

.slide-title {
    font-size: clamp(2rem, 4.5vw, 3.5rem);
    font-weight: 900; color: #fff;
    line-height: 1.1; letter-spacing: -.02em;
    margin: 0 0 1.25rem;
    max-width: 640px;
    opacity: 0; transform: translateY(20px);
    transition: all .65s .2s ease;
}

.slide-title span {
    background: linear-gradient(90deg, #60B0FF, #A0D4FF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.slide-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.1rem; color: rgba(255,255,255,.78);
    line-height: 1.7; max-width: 520px;
    margin-bottom: 2rem;
    opacity: 0; transform: translateY(15px);
    transition: all .65s .32s ease;
}

.slide-btns {
    display: flex; gap: .875rem; flex-wrap: wrap;
    opacity: 0; transform: translateY(15px);
    transition: all .65s .44s ease;
}

.slide.active .slide-tag,
.slide.active .slide-title,
.slide.active .slide-desc,
.slide.active .slide-btns {
    opacity: 1; transform: translateY(0);
}

.hero-btn-primary {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .9rem 1.85rem;
    background: linear-gradient(135deg, var(--blue-core), var(--blue-light));
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: .95rem; font-weight: 700;
    text-decoration: none; cursor: pointer;
    box-shadow: 0 4px 20px rgba(10,77,140,.5);
    transition: transform .2s, box-shadow .2s;
}
.hero-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(10,77,140,.6);
    color: #fff;
}

.hero-btn-ghost {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .9rem 1.85rem;
    background: rgba(255,255,255,.1);
    border: 1.5px solid rgba(255,255,255,.35);
    backdrop-filter: blur(8px);
    color: #fff; border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: .95rem; font-weight: 600;
    text-decoration: none;
    transition: all .2s;
}
.hero-btn-ghost:hover {
    background: rgba(255,255,255,.2);
    border-color: rgba(255,255,255,.6);
    color: #fff;
    transform: translateY(-2px);
}

/* Stats flotantes */
.hero-stats {
    position: absolute; bottom: 1.5rem; left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    display: flex; gap: 1px;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 16px;
    overflow: hidden;
    max-width: 680px; width: 90%;
}   
.hero-stat {
    flex: 1; padding: 1rem 1.25rem;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,.15);
}
.hero-stat:last-child { border-right: none; }
.hero-stat-num {
    font-family: 'Outfit', sans-serif;
    font-size: 1.5rem; font-weight: 800; color: #fff;
    line-height: 1;
}
.hero-stat-num span { color: #60B0FF; }
.hero-stat-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .72rem; color: rgba(255,255,255,.6);
    margin-top: .25rem;
    text-transform: uppercase; letter-spacing: .05em;
}

/* Controles slider */
.slider-nav {
    position: absolute; bottom: 6.5rem; right: 2rem;
    z-index: 5; display: flex; gap: .5rem;
}
.slider-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgba(255,255,255,.35); border: none; cursor: pointer;
    transition: all .3s; padding: 0;
}
.slider-dot.active {
    width: 28px; border-radius: 4px;
    background: #fff;
}

/* Flecha scroll */
.scroll-hint {
    position: absolute; bottom: 1.5rem; right: 2rem;
    z-index: 5; color: rgba(255,255,255,.4);
    font-size: .72rem; font-family: 'DM Sans', sans-serif;
    display: flex; flex-direction: column; align-items: center; gap: .3rem;
    animation: scrollBounce 2s infinite;
}
@keyframes scrollBounce {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(6px); }
}

/* Ola de transición */
.hero-wave {
    position: relative; z-index: 2;
    background: #fff; margin-top: -2px;
}

/* ══════════════════════════════════
   SECCIÓN STATS / NÚMEROS
══════════════════════════════════ */
.stats-bar {
    background: #fff;
    padding: 2.5rem 1.5rem;
    border-bottom: 1px solid var(--border);
}
.stats-bar-inner {
    max-width: 1100px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 1px; background: var(--border);
    border: 1px solid var(--border); border-radius: 16px;
    overflow: hidden;
}
.stat-item {
    background: #fff; padding: 1.75rem 1.5rem;
    text-align: center;
    transition: background .2s;
}
.stat-item:hover { background: var(--blue-pale); }
.stat-number {
    font-family: 'Outfit', sans-serif;
    font-size: 2.25rem; font-weight: 900;
    color: var(--blue-core); line-height: 1;
}
.stat-number em { font-style: normal; color: var(--orange); }
.stat-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem; color: var(--muted);
    margin-top: .4rem;
}

/* ══════════════════════════════════
   SECCIONES GENERALES
══════════════════════════════════ */
.ca-section {
    padding: 5rem 1.5rem;
    font-family: 'DM Sans', sans-serif;
}
.ca-section.alt { background: var(--off-white); }
.ca-container { max-width: 1100px; margin: 0 auto; }

.sec-eyebrow {
    display: inline-flex; align-items: center; gap: .4rem;
    font-family: 'Outfit', sans-serif;
    font-size: .72rem; font-weight: 800;
    color: var(--blue-core);
    text-transform: uppercase; letter-spacing: .12em;
    background: var(--blue-pale);
    padding: .35rem .875rem; border-radius: 999px;
    margin-bottom: 1rem;
}
.sec-title {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(1.75rem, 3vw, 2.5rem);
    font-weight: 800; color: var(--text);
    margin: 0 0 1rem; line-height: 1.2;
    letter-spacing: -.02em;
}
.sec-title span { color: var(--blue-core); }
.sec-desc {
    font-size: 1rem; color: var(--muted);
    line-height: 1.75; max-width: 600px;
}

/* ══════════════════════════════════
   QUIÉNES SOMOS — layout asimétrico
══════════════════════════════════ */
.about-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem; align-items: center;
}
.about-visual {
    position: relative;
}
.about-img-wrap {
    border-radius: 20px; overflow: hidden;
    box-shadow: 0 20px 60px rgba(10,37,64,.15);
    aspect-ratio: 4/3;
    background: linear-gradient(135deg, var(--blue-core), var(--blue-light));
    display: flex; align-items: center; justify-content: center;
    font-size: 5rem; color: rgba(255,255,255,.4);
}
.about-img-wrap img {
    width: 100%; height: 100%; object-fit: cover;
}
.about-badge {
    position: absolute; bottom: -1.5rem; right: -1.5rem;
    background: var(--blue-core);
    color: #fff; border-radius: 16px; padding: 1.25rem 1.5rem;
    box-shadow: 0 8px 32px rgba(10,77,140,.35);
    text-align: center;
}
.about-badge-num {
    font-family: 'Outfit', sans-serif;
    font-size: 2rem; font-weight: 900; line-height: 1;
}
.about-badge-txt {
    font-size: .75rem; opacity: .8; margin-top: .2rem;
    font-family: 'DM Sans', sans-serif;
}

.about-cards {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;
    margin-top: 2rem;
}
.about-card-mini {
    background: var(--blue-pale);
    border-radius: 14px; padding: 1.25rem;
    border-left: 3px solid var(--blue-core);
    transition: transform .2s, box-shadow .2s;
}
.about-card-mini:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(10,77,140,.12);
}
.about-card-mini h4 {
    font-family: 'Outfit', sans-serif;
    font-size: .9rem; font-weight: 700; color: var(--text);
    margin: 0 0 .4rem; display: flex; align-items: center; gap: .4rem;
}
.about-card-mini h4 i { color: var(--blue-core); font-size: .85rem; }
.about-card-mini p {
    font-size: .83rem; color: var(--muted); margin: 0; line-height: 1.55;
}

/* ══════════════════════════════════
   VALORES — grid con iconos grandes
══════════════════════════════════ */
.valores-grid {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem; margin-top: 3rem;
}
.valor-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 18px; padding: 2rem 1.5rem;
    text-align: center;
    transition: all .25s;
    position: relative; overflow: hidden;
}
.valor-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--blue-core), var(--blue-light));
    transform: scaleX(0); transform-origin: left;
    transition: transform .3s;
}
.valor-card:hover::before { transform: scaleX(1); }
.valor-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(10,77,140,.12);
    border-color: #c5d9f0;
}
.valor-ico {
    width: 64px; height: 64px; margin: 0 auto 1.25rem;
    border-radius: 18px;
    background: linear-gradient(135deg, var(--blue-core), var(--blue-light));
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: #fff;
    box-shadow: 0 6px 20px rgba(10,77,140,.25);
}
.valor-card h3 {
    font-family: 'Outfit', sans-serif;
    font-size: 1rem; font-weight: 700; color: var(--text);
    margin: 0 0 .6rem;
}
.valor-card p {
    font-size: .83rem; color: var(--muted);
    margin: 0; line-height: 1.6;
}

/* ══════════════════════════════════
   SERVICIOS — cards grandes
══════════════════════════════════ */
.servicios-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem; margin-top: 3rem;
}
.servicio-card {
    border-radius: 20px; overflow: hidden;
    background: #fff; border: 1px solid var(--border);
    transition: all .25s;
    display: flex; flex-direction: column;
}
.servicio-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 48px rgba(10,77,140,.14);
    border-color: #b8d4f0;
}
.servicio-img {
    height: 200px;
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem; color: rgba(255,255,255,.85);
    position: relative; overflow: hidden;
}
.servicio-img-inner {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem; color: rgba(255,255,255,.9);
    background: linear-gradient(135deg, rgba(10,77,140,.3), transparent);
}
.servicio-img-bg {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
}
.servicio-body { padding: 1.75rem; flex: 1; display: flex; flex-direction: column; }
.servicio-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .7rem; font-weight: 700; color: var(--blue-core);
    background: var(--blue-pale); padding: .25rem .6rem;
    border-radius: 999px; margin-bottom: .875rem;
    font-family: 'Outfit', sans-serif; text-transform: uppercase; letter-spacing: .08em;
}
.servicio-body h3 {
    font-family: 'Outfit', sans-serif;
    font-size: 1.2rem; font-weight: 800; color: var(--text);
    margin: 0 0 .75rem; line-height: 1.2;
}
.servicio-body p {
    font-size: .88rem; color: var(--muted);
    line-height: 1.7; margin: 0 0 1.5rem; flex: 1;
}
.servicio-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
    padding: .75rem 1.25rem;
    background: linear-gradient(135deg, var(--blue-core), var(--blue-mid));
    color: #fff; border: none; border-radius: 10px;
    font-family: 'Outfit', sans-serif; font-size: .88rem; font-weight: 700;
    text-decoration: none; transition: all .2s;
    box-shadow: 0 3px 12px rgba(10,77,140,.3);
}
.servicio-btn:hover { opacity: .9; transform: translateY(-1px); color: #fff; }

/* ══════════════════════════════════
   CURSOS DESTACADOS
══════════════════════════════════ */
.cursos-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem; margin-top: 2.5rem;
}
.curso-mini-card {
    background: #fff; border: 1px solid var(--border);
    border-radius: 16px; overflow: hidden;
    transition: all .22s; text-decoration: none;
    display: flex; flex-direction: column;
}
.curso-mini-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 36px rgba(10,77,140,.12);
    border-color: #b8d4f0;
}
.curso-thumb {
    height: 130px;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.25rem; color: rgba(255,255,255,.8);
    position: relative;
}
.curso-thumb img {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
}
.curso-thumb-ico {
    position: relative; z-index: 1;
}
.curso-mini-body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
.curso-cat-badge {
    display: inline-block;
    font-size: .68rem; font-weight: 700; color: var(--blue-core);
    background: var(--blue-pale); padding: .2rem .55rem;
    border-radius: 999px; margin-bottom: .6rem;
    font-family: 'Outfit', sans-serif; text-transform: uppercase;
}
.curso-mini-body h4 {
    font-family: 'Outfit', sans-serif;
    font-size: .95rem; font-weight: 700; color: var(--text);
    margin: 0 0 .4rem; line-height: 1.3;
}
.curso-mini-meta {
    font-size: .78rem; color: var(--muted); margin-top: auto; padding-top: .75rem;
    display: flex; justify-content: space-between; align-items: center;
    border-top: 1px solid #f0f4f8;
}
.curso-free { color: #16a34a; font-weight: 700; font-family: 'Outfit', sans-serif; }

/* ══════════════════════════════════
   CTA FINAL
══════════════════════════════════ */
.cta-section {
    position: relative; overflow: hidden;
    background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue-core) 60%, var(--blue-mid) 100%);
    padding: 5rem 1.5rem; text-align: center;
    font-family: 'Outfit', sans-serif;
}
.cta-section::before {
    content: '';
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,.05) 1.5px, transparent 1.5px);
    background-size: 32px 32px;
}
.cta-section::after {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(rgba(255,255,255,.04), transparent 70%);
    top: -200px; right: -100px;
}
.cta-inner { position: relative; z-index: 2; max-width: 680px; margin: 0 auto; }
.cta-eyebrow {
    display: inline-block;
    font-size: .72rem; font-weight: 800; letter-spacing: .15em;
    text-transform: uppercase; color: #60B0FF;
    background: rgba(96,176,255,.12); border: 1px solid rgba(96,176,255,.25);
    padding: .35rem 1rem; border-radius: 999px; margin-bottom: 1.25rem;
}
.cta-title {
    font-size: clamp(1.75rem, 3.5vw, 2.75rem);
    font-weight: 900; color: #fff; line-height: 1.15;
    margin: 0 0 1rem; letter-spacing: -.02em;
}
.cta-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.05rem; color: rgba(255,255,255,.7);
    line-height: 1.7; margin-bottom: 2.5rem;
}
.cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
.cta-btn-main {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: 1rem 2.25rem;
    background: #fff; color: var(--blue-core);
    border: none; border-radius: 12px;
    font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 800;
    text-decoration: none; cursor: pointer;
    box-shadow: 0 4px 20px rgba(0,0,0,.2);
    transition: all .2s;
}
.cta-btn-main:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 32px rgba(0,0,0,.3);
    color: var(--blue-core);
}
.cta-btn-ghost {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: 1rem 2.25rem;
    background: rgba(255,255,255,.1);
    border: 1.5px solid rgba(255,255,255,.3);
    color: #fff; border-radius: 12px;
    font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700;
    text-decoration: none; transition: all .2s;
}
.cta-btn-ghost:hover {
    background: rgba(255,255,255,.2);
    color: #fff; transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 960px) {
    .about-layout { grid-template-columns: 1fr; }
    .about-visual { display: none; }
    .valores-grid { grid-template-columns: repeat(2,1fr); }
    .servicios-grid { grid-template-columns: 1fr; }
    .cursos-grid { grid-template-columns: repeat(2,1fr); }
    .stats-bar-inner { grid-template-columns: repeat(2,1fr); }
    .hero-stats { display: none; }
}
@media (max-width: 600px) {
    .valores-grid { grid-template-columns: 1fr; }
    .cursos-grid { grid-template-columns: 1fr; }
    .stats-bar-inner { grid-template-columns: 1fr 1fr; }
    .about-cards { grid-template-columns: 1fr; }
    .slide-title { font-size: 1.75rem; }
}
</style>

{{-- ══════════════ HERO SLIDER ══════════════ --}}
<section class="hero-section" id="heroSlider">

    {{-- Slide 1 --}}
    <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1600&q=80');">
        <div class="slide-overlay"></div>
        <div class="slide-particles">
            <div class="particle"></div><div class="particle"></div>
            <div class="particle"></div><div class="particle"></div>
        </div>
        <div class="slide-inner">
            <div class="slide-tag"><i class="fas fa-graduation-cap"></i> Formación Comunitaria</div>
            <h1 class="slide-title">Fortalecemos Comunidades a Través del <span>Conocimiento</span></h1>
            <p class="slide-desc">Descubre programas de formación diseñados para líderes sociales y organizaciones comunitarias que transforman territorios.</p>
            <div class="slide-btns">
                <a href="{{ route('cursos.index') }}" class="hero-btn-primary"><i class="fas fa-book-open"></i> Explorar Cursos</a>
                <a href="#acerca" class="hero-btn-ghost"><i class="fas fa-info-circle"></i> Conocer Más</a>
            </div>
        </div>
    </div>

    {{-- Slide 2 --}}
    <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1600&q=80');">
        <div class="slide-overlay"></div>
        <div class="slide-particles">
            <div class="particle"></div><div class="particle"></div>
            <div class="particle"></div><div class="particle"></div>
        </div>
        <div class="slide-inner">
            <div class="slide-tag"><i class="fas fa-users"></i> Organismos de Acción Comunal</div>
            <h1 class="slide-title">Capacitación Especializada para <span>JAC y OAC</span></h1>
            <p class="slide-desc">Herramientas técnicas y administrativas para mejorar la gestión, el cumplimiento normativo y la sostenibilidad de tu organización.</p>
            <div class="slide-btns">
                <a href="{{ route('cursos.index') }}" class="hero-btn-primary"><i class="fas fa-play-circle"></i> Ver Programas</a>
                <a href="{{ route('contacto') }}" class="hero-btn-ghost"><i class="fas fa-headset"></i> Asesoría Personalizada</a>
            </div>
        </div>
    </div>

    {{-- Slide 3 --}}
    <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1600&q=80');">
        <div class="slide-overlay"></div>
        <div class="slide-particles">
            <div class="particle"></div><div class="particle"></div>
            <div class="particle"></div><div class="particle"></div>
        </div>
        <div class="slide-inner">
            <div class="slide-tag"><i class="fas fa-certificate"></i> Aprende a tu ritmo</div>
            <h1 class="slide-title">Educación de Calidad, <span>Accesible para Todos</span></h1>
            <p class="slide-desc">Cursos gratuitos y de pago adaptados a las necesidades reales de tu organización. Aprende desde cualquier lugar, a tu propio ritmo.</p>
            <div class="slide-btns">
                <a href="{{ route('register') }}" class="hero-btn-primary"><i class="fas fa-user-plus"></i> Comenzar Gratis</a>
                <a href="#vision" class="hero-btn-ghost"><i class="fas fa-eye"></i> Nuestra Visión</a>
            </div>
        </div>
    </div>

    {{-- Controles --}}
    <div class="slider-nav">
        <button class="slider-dot active" data-slide="0"></button>
        <button class="slider-dot" data-slide="1"></button>
        <button class="slider-dot" data-slide="2"></button>
    </div>

    {{-- Stats flotantes --}}
    <div class="hero-stats">
        <div class="hero-stat">
            <div class="hero-stat-num">+<span>500</span></div>
            <div class="hero-stat-label">Líderes formados</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-num"><span>12</span></div>
            <div class="hero-stat-label">Cursos disponibles</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-num">+<span>50</span></div>
            <div class="hero-stat-label">Municipios atendidos</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-num"><span>98</span>%</div>
            <div class="hero-stat-label">Satisfacción</div>
        </div>
    </div>

    {{-- Ola SVG --}}
    <div style="position:absolute;bottom:-1px;left:0;right:0;z-index:3;line-height:0;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;display:block;">
            <path d="M0,60 C240,20 480,0 720,20 C960,40 1200,50 1440,30 L1440,60 L0,60 Z" fill="#f7f9fc"/>
        </svg>
    </div>
</section>

{{-- ══════════════ STATS BAR ══════════════ --}}
<div class="stats-bar">
    <div class="stats-bar-inner">
        <div class="stat-item">
            <div class="stat-number">+<em>500</em></div>
            <div class="stat-label">Líderes comunitarios formados</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><em>15</em>+</div>
            <div class="stat-label">Programas de capacitación</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">+<em>50</em></div>
            <div class="stat-label">Municipios en Colombia</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><em>98</em>%</div>
            <div class="stat-label">Índice de satisfacción</div>
        </div>
    </div>
</div>

{{-- ══════════════ QUIÉNES SOMOS ══════════════ --}}
<section class="ca-section" id="acerca">
    <div class="ca-container">
        <div class="about-layout">
            <div class="about-visual">
                <div class="about-img-wrap">
                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800&q=80" alt="Comunidad">
                </div>
                <div class="about-badge">
                    <div class="about-badge-num">+5</div>
                    <div class="about-badge-txt">Años de experiencia</div>
                </div>
            </div>
            <div>
                <div class="sec-eyebrow"><i class="fas fa-info-circle"></i> Quiénes Somos</div>
                <h2 class="sec-title">Somos <span>Comunal Aprende</span></h2>
                <p class="sec-desc">
                    Una iniciativa de servicios integrales en asesoría, consultoría y formación,
                    orientada al fortalecimiento institucional y organizacional de comunidades,
                    líderes sociales y entidades sin ánimo de lucro en Colombia.
                </p>
                <div class="about-cards">
                    <div class="about-card-mini">
                        <h4><i class="fas fa-bullseye"></i> Nuestra Misión</h4>
                        <p>Brindar acompañamiento profesional y herramientas prácticas que fortalezcan la capacidad de gestión y sostenibilidad de las organizaciones comunitarias.</p>
                    </div>
                    <div class="about-card-mini" id="vision">
                        <h4><i class="fas fa-eye"></i> Nuestra Visión</h4>
                        <p>Ser referentes en formación y consultoría comunitaria, generando impacto positivo en los territorios a través de soluciones adaptadas y sostenibles.</p>
                    </div>
                    <div class="about-card-mini">
                        <h4><i class="fas fa-handshake"></i> Nuestra Propuesta</h4>
                        <p>Un modelo cercano, responsable y estratégico que combina capacitación técnica con acompañamiento personalizado y herramientas digitales.</p>
                    </div>
                    <div class="about-card-mini">
                        <h4><i class="fas fa-map-marker-alt"></i> Nuestro Alcance</h4>
                        <p>Presencia en más de 50 municipios de Colombia, con enfoque en comunidades rurales y urbanas que buscan fortalecer su organización.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ VALORES ══════════════ --}}
<section class="ca-section alt" id="valores">
    <div class="ca-container">
        <div style="text-align:center; margin-bottom: .5rem;">
            <div class="sec-eyebrow"><i class="fas fa-heart"></i> Nuestros Principios</div>
        </div>
        <h2 class="sec-title" style="text-align:center;">Valores que nos <span>Guían</span></h2>
        <div class="valores-grid">
            <div class="valor-card">
                <div class="valor-ico"><i class="fas fa-users"></i></div>
                <h3>Participación</h3>
                <p>Promovemos la inclusión y el protagonismo activo de las comunidades en sus procesos de desarrollo.</p>
            </div>
            <div class="valor-card">
                <div class="valor-ico"><i class="fas fa-star"></i></div>
                <h3>Excelencia</h3>
                <p>Nos comprometemos con la calidad, el rigor técnico y la mejora continua en todos nuestros servicios.</p>
            </div>
            <div class="valor-card">
                <div class="valor-ico"><i class="fas fa-shield-alt"></i></div>
                <h3>Transparencia</h3>
                <p>Actuamos con honestidad, ética y rendición de cuentas en todos nuestros procesos.</p>
            </div>
            <div class="valor-card">
                <div class="valor-ico"><i class="fas fa-seedling"></i></div>
                <h3>Sostenibilidad</h3>
                <p>Buscamos generar impacto duradero a través de capacidades instaladas en las comunidades.</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ SERVICIOS ══════════════ --}}
<section class="ca-section" id="servicios">
    <div class="ca-container">
        <div style="text-align:center; margin-bottom: .5rem;">
            <div class="sec-eyebrow"><i class="fas fa-cogs"></i> Qué Ofrecemos</div>
        </div>
        <h2 class="sec-title" style="text-align:center;">Nuestros <span>Servicios</span></h2>
        <p class="sec-desc" style="text-align:center; margin: 0 auto 0;">Soluciones integrales para el fortalecimiento organizacional y comunitario</p>
        <div class="servicios-grid">
            <div class="servicio-card">
                <div class="servicio-img" style="background: linear-gradient(135deg, #0A4D8C, #1E6DB8);">
                    <div class="servicio-img-bg" style="background-image:url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&q=70'); opacity:.25;"></div>
                    <div class="servicio-img-inner"><i class="fas fa-graduation-cap"></i></div>
                </div>
                <div class="servicio-body">
                    <div class="servicio-badge"><i class="fas fa-book"></i> Educación</div>
                    <h3>Formación y Capacitación</h3>
                    <p>Cursos especializados en gestión comunal, normatividad, participación ciudadana, formulación de proyectos y desarrollo organizacional.</p>
                    <a href="{{ route('cursos.index') }}" class="servicio-btn"><i class="fas fa-arrow-right"></i> Ver Cursos</a>
                </div>
            </div>
            <div class="servicio-card">
                <div class="servicio-img" style="background: linear-gradient(135deg, #1E6DB8, #3B88D4);">
                    <div class="servicio-img-bg" style="background-image:url('https://images.unsplash.com/photo-1531482615713-2afd69097998?w=600&q=70'); opacity:.25;"></div>
                    <div class="servicio-img-inner"><i class="fas fa-clipboard-list"></i></div>
                </div>
                <div class="servicio-body">
                    <div class="servicio-badge"><i class="fas fa-handshake"></i> Consultoría</div>
                    <h3>Asesoría y Consultoría</h3>
                    <p>Acompañamiento personalizado en procesos administrativos, legales y técnicos para Organismos de Acción Comunal y organizaciones sociales.</p>
                    <a href="{{ route('contacto') }}" class="servicio-btn"><i class="fas fa-arrow-right"></i> Solicitar Asesoría</a>
                </div>
            </div>
            <div class="servicio-card">
                <div class="servicio-img" style="background: linear-gradient(135deg, #3B88D4, #5CA3E6);">
                    <div class="servicio-img-bg" style="background-image:url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=70'); opacity:.25;"></div>
                    <div class="servicio-img-inner"><i class="fas fa-tools"></i></div>
                </div>
                <div class="servicio-body">
                    <div class="servicio-badge"><i class="fas fa-file-alt"></i> Recursos</div>
                    <h3>Herramientas y Recursos</h3>
                    <p>Material didáctico, plantillas, formatos y recursos digitales para facilitar la gestión y cumplimiento normativo de las organizaciones.</p>
                    <a href="{{ route('normatividad') }}" class="servicio-btn"><i class="fas fa-arrow-right"></i> Conocer Más</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ CURSOS DESTACADOS ══════════════ --}}
@php
    $cursosDestacados = \App\Models\Curso::where('activo', true)
        ->orderByDesc('destacado')->orderBy('orden')->take(3)->get();
@endphp
@if($cursosDestacados->count())
<section class="ca-section alt">
    <div class="ca-container">
        <div style="display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:2.5rem;">
            <div>
                <div class="sec-eyebrow"><i class="fas fa-fire"></i> Cursos Populares</div>
                <h2 class="sec-title" style="margin-bottom:0;">Aprende con Nuestros <span>Mejores Cursos</span></h2>
            </div>
            <a href="{{ route('cursos.index') }}" style="display:inline-flex;align-items:center;gap:.4rem;color:var(--blue-core);font-family:'Outfit',sans-serif;font-weight:700;font-size:.9rem;text-decoration:none;">
                Ver todos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="cursos-grid">
            @foreach($cursosDestacados as $c)
                @php $rc = explode(',', $c->color_gradiente ?? '#0A4D8C,#3B88D4'); @endphp
                <a href="{{ route('cursos.show', $c->slug) }}" class="curso-mini-card">
                    <div class="curso-thumb" style="background:linear-gradient(135deg,{{ $rc[0] }},{{ $rc[1] ?? '#3B88D4' }});">
                        @if($c->imagen)
                            <img src="{{ $c->imagen }}" alt="{{ $c->titulo }}">
                        @endif
                        <div class="curso-thumb-ico"><i class="fas {{ $c->icono_fa ?? 'fa-graduation-cap' }}"></i></div>
                    </div>
                    <div class="curso-mini-body">
                        <span class="curso-cat-badge">{{ $c->categoriaLabel() }}</span>
                        <h4>{{ $c->titulo }}</h4>
                        <p style="font-size:.82rem;color:var(--muted);margin:.25rem 0 0;line-height:1.5;">{{ Str::limit($c->descripcion_corta, 80) }}</p>
                        <div class="curso-mini-meta">
                            <span style="font-size:.78rem;color:var(--muted);"><i class="fas fa-clock" style="margin-right:.25rem;"></i>{{ $c->duracion_horas }}h</span>
                            <span class="curso-free">{{ $c->precioFormateado() }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════ CTA FINAL ══════════════ --}}
<section class="cta-section">
    <div class="cta-inner">
        <div class="cta-eyebrow">Únete hoy</div>
        <h2 class="cta-title">¿Listo para Fortalecer tu Organización?</h2>
        <p class="cta-desc">Únete a cientos de líderes y organizaciones que ya están transformando sus comunidades a través de la formación y el conocimiento.</p>
        <div class="cta-btns">
            @guest
                <a href="{{ route('register') }}" class="cta-btn-main">
                    <i class="fas fa-user-plus"></i> Crear Cuenta Gratuita
                </a>
            @endguest
            <a href="{{ route('cursos.index') }}" class="cta-btn-ghost">
                <i class="fas fa-book-open"></i> Explorar Cursos
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function() {
    const slides = document.querySelectorAll('#heroSlider .slide');
    const dots   = document.querySelectorAll('.slider-dot');
    let current  = 0;
    let timer;

    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function next() { goTo(current + 1); }

    function startAuto() {
        clearInterval(timer);
        timer = setInterval(next, 5500);
    }

    dots.forEach((d, i) => {
        d.addEventListener('click', () => { goTo(i); startAuto(); });
    });

    startAuto();
})();

// Animación scroll reveal
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.style.opacity = '1';
            e.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.valor-card, .servicio-card, .about-card-mini, .curso-mini-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(24px)';
    el.style.transition = 'opacity .55s ease, transform .55s ease';
    observer.observe(el);
});
</script>
@endpush
@endsection