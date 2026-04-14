<style>
.header {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    background: rgba(255,255,255,.97);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(0,0,0,.07);
    box-shadow: 0 2px 20px rgba(10,37,64,.06);
    transition: all .25s;
    font-family: 'Outfit', sans-serif;
}

.nav-container {
    max-width: 1200px; margin: 0 auto;
    padding: 0 1.5rem;
    height: 68px; /* ← bajado de 80px para que el logo quepa */
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem;
}

/* ── LOGO ── */
.logo {
    display: flex; align-items: center; gap: .6rem;
    text-decoration: none; flex-shrink: 0;
}
.logo-img {
    height: 52px; /* ← antes era 120px — demasiado grande */
    width: auto;
    object-fit: contain;
    display: block;
}
.logo-text {
    display: flex; flex-direction: column; line-height: 1.1;
}
.logo-text-top {
    font-family: 'Outfit', sans-serif;
    font-size: 1.05rem; font-weight: 800;
    color: #0A4D8C; letter-spacing: -.01em;
}
.logo-text-bottom {
    font-family: 'Outfit', sans-serif;
    font-size: .75rem; font-weight: 700;
    color: #3B88D4; letter-spacing: .1em;
    text-transform: uppercase;
}

/* ── NAV MENU ── */
.nav-menu {
    display: flex; align-items: center; gap: .25rem;
    list-style: none; margin: 0; padding: 0; flex: 1; justify-content: center;
}
.nav-menu li a {
    display: inline-flex; align-items: center;
    padding: .5rem .9rem; border-radius: 8px;
    font-size: .9rem; font-weight: 600; color: #334155;
    text-decoration: none; transition: all .18s;
    position: relative;
}
.nav-menu li a::after {
    content: '';
    position: absolute; bottom: 4px; left: 50%; right: 50%;
    height: 2px; border-radius: 999px;
    background: #0A4D8C;
    transition: all .22s;
}
.nav-menu li a:hover { color: #0A4D8C; background: #EBF3FF; }
.nav-menu li a.active { color: #0A4D8C; }
.nav-menu li a.active::after { left: .9rem; right: .9rem; }

/* ── NAV ACTIONS ── */
.nav-actions {
    display: flex; align-items: center; gap: .6rem; flex-shrink: 0;
}

.btn-nav-ghost {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1.1rem; border-radius: 8px;
    border: 1.5px solid #dde4ee; background: transparent;
    color: #334155; font-size: .87rem; font-weight: 600;
    text-decoration: none; transition: all .18s;
    font-family: 'Outfit', sans-serif;
}
.btn-nav-ghost:hover { border-color: #0A4D8C; color: #0A4D8C; background: #EBF3FF; }

.btn-nav-primary {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1.25rem; border-radius: 8px;
    background: linear-gradient(135deg, #0A4D8C, #1E6DB8);
    color: #fff; font-size: .87rem; font-weight: 700;
    text-decoration: none; transition: all .18s;
    box-shadow: 0 2px 12px rgba(10,77,140,.3);
    font-family: 'Outfit', sans-serif;
}
.btn-nav-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(10,77,140,.4);
    color: #fff;
}

/* ── USER DROPDOWN ── */
.user-dropdown { position: relative; }
.user-dropdown-btn {
    display: flex; align-items: center; gap: .5rem;
    background: #f0f7ff; border: 1.5px solid #c5d9f0;
    border-radius: 10px; padding: .45rem .95rem;
    color: #073A6B; font-size: .88rem; font-weight: 700;
    cursor: pointer; transition: all .18s;
    font-family: 'Outfit', sans-serif;
}
.user-dropdown-btn:hover { background: #dbeafe; border-color: #93c5fd; }

.user-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, #0A4D8C, #3B88D4);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: .78rem; color: #fff;
}

.user-menu {
    display: none;
    position: absolute; top: calc(100% + 10px); right: 0;
    background: white; border-radius: 14px;
    box-shadow: 0 12px 40px rgba(10,37,64,.15), 0 2px 8px rgba(0,0,0,.06);
    min-width: 220px; z-index: 999;
    overflow: hidden; border: 1px solid #dde4ee;
}
.user-menu.open { display: block; animation: menuFadeIn .18s ease; }
@keyframes menuFadeIn {
    from { opacity:0; transform:translateY(-6px); }
    to   { opacity:1; transform:translateY(0); }
}

.user-menu-header {
    padding: .875rem 1.1rem; border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(135deg, #f0f7ff, #e8f2ff);
}
.user-menu-name { font-weight: 800; font-size: .9rem; color: #073A6B; }
.user-menu-email { font-size: .74rem; color: #94a3b8; margin-top: .1rem; font-family: 'DM Sans', sans-serif; }

.user-menu a, .user-menu button {
    display: flex; align-items: center; gap: .6rem;
    width: 100%; padding: .7rem 1.1rem;
    font-family: 'Outfit', sans-serif;
    font-size: .86rem; font-weight: 600; color: #334155;
    text-decoration: none; background: none; border: none;
    cursor: pointer; text-align: left; transition: background .15s;
}
.user-menu a:hover, .user-menu button:hover { background: #f7f9fc; }
.user-menu a i, .user-menu button i { width: 18px; color: #0A4D8C; text-align: center; font-size: .82rem; }
.user-menu .logout-btn { color: #dc2626; border-top: 1px solid #f1f5f9; }
.user-menu .logout-btn i { color: #dc2626; }

/* ── MOBILE TOGGLE ── */
.mobile-menu-toggle {
    display: none; /* se muestra con media query */
    background: none; border: 1.5px solid #dde4ee;
    border-radius: 8px; width: 40px; height: 40px;
    align-items: center; justify-content: center;
    color: #334155; cursor: pointer; transition: all .18s;
    flex-shrink: 0;
}
.mobile-menu-toggle:hover { background: #EBF3FF; border-color: #0A4D8C; color: #0A4D8C; }

/* ── PANEL MENÚ MÓVIL ── */
.mobile-nav-overlay {
    display: none; position: fixed; inset: 0; z-index: 998;
    background: rgba(0,0,0,.4);
}
.mobile-nav-overlay.open { display: block; }

.mobile-nav-panel {
    position: fixed; top: 0; right: -100%; z-index: 999;
    width: min(300px, 82vw); height: 100vh;
    background: #fff;
    box-shadow: -6px 0 40px rgba(10,37,64,.18);
    transition: right .28s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    overflow-y: auto;
}
.mobile-nav-panel.open { right: 0; }

/* Cabecera del panel */
.mnp-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.1rem;
    background: linear-gradient(135deg, #071D36, #0A4D8C);
    flex-shrink: 0;
}
.mnp-logo { display: flex; align-items: center; gap: .55rem; text-decoration: none; }
.mnp-logo img { height: 38px; width: auto; }
.mnp-logo-text { display: flex; flex-direction: column; line-height: 1.1; }
.mnp-logo-text span:first-child {
    font-family: 'Outfit', sans-serif; font-size: .9rem;
    font-weight: 800; color: #fff;
}
.mnp-logo-text span:last-child {
    font-family: 'Outfit', sans-serif; font-size: .62rem;
    font-weight: 700; color: rgba(255,255,255,.6);
    text-transform: uppercase; letter-spacing: .1em;
}
.mnp-close {
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
    border-radius: 8px; width: 34px; height: 34px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; cursor: pointer; font-size: .95rem;
    transition: background .18s;
}
.mnp-close:hover { background: rgba(255,255,255,.22); }

/* Links del panel */
.mnp-section-label {
    padding: .85rem 1.1rem .35rem;
    font-family: 'Outfit', sans-serif;
    font-size: .67rem; font-weight: 700;
    color: #94a3b8; text-transform: uppercase; letter-spacing: .1em;
}
.mnp-links { list-style: none; padding: 0 .5rem; margin: 0; }
.mnp-links li a {
    display: flex; align-items: center; gap: .7rem;
    padding: .8rem .75rem; border-radius: 8px;
    font-family: 'Outfit', sans-serif;
    font-size: .92rem; font-weight: 600; color: #334155;
    text-decoration: none; transition: all .15s;
}
.mnp-links li a:hover, .mnp-links li a.active {
    background: #EBF3FF; color: #0A4D8C;
}
.mnp-links li a i {
    width: 20px; text-align: center;
    color: #0A4D8C; opacity: .75; font-size: .82rem;
}
.mnp-divider { height: 1px; background: #f1f5f9; margin: .5rem 1.1rem; }

/* Usuario autenticado en panel */
.mnp-user-info {
    margin: .5rem; padding: .8rem 1rem;
    background: linear-gradient(135deg, #f0f7ff, #e8f2ff);
    border-radius: 10px; border: 1px solid #c5d9f0;
}
.mnp-user-name { font-family: 'Outfit', sans-serif; font-weight: 800; font-size: .88rem; color: #073A6B; }
.mnp-user-email { font-size: .72rem; color: #94a3b8; margin-top: .1rem; }

.mnp-auth-btns {
    display: flex; flex-direction: column; gap: .5rem;
    padding: .75rem .5rem 1rem;
}
.mnp-auth-btns .btn-nav-ghost,
.mnp-auth-btns .btn-nav-primary {
    width: 100%; justify-content: center;
    padding: .7rem; font-size: .9rem; border-radius: 8px;
}

/* ── MEDIA QUERIES ── */
@media (max-width: 860px) {
    .nav-menu { display: none; }
    .mobile-menu-toggle { display: flex; } /* ← muestra el botón hamburger */
    .nav-actions .btn-nav-ghost { display: none; }
    .nav-actions .btn-nav-primary { display: none; }
    .nav-actions .user-dropdown { display: none; }
}
@media (max-width: 480px) {
    .logo-text { display: none; }
    .nav-container { padding: 0 1rem; height: 60px; }
    .logo-img { height: 44px; }
}

/* Padding compensación header fijo */
body > section:first-child,
body > div:first-child,
.hero-section { padding-top: 68px; }

.hero-section { padding-top: 0; margin-top: 68px; }
</style>

<header class="header" id="header">
    <nav class="nav-container">

        {{-- LOGO --}}
        <a href="{{ route('inicio') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Comunal Aprende" class="logo-img"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="logo-text" style="display:none;">
                <span class="logo-text-top">Comunal</span>
                <span class="logo-text-bottom">Aprende</span>
            </div>
            {{-- Fallback si no hay imagen --}}
            <div class="logo-text">
                <span class="logo-text-top">Comunal</span>
                <span class="logo-text-bottom">Aprende</span>
            </div>
        </a>

        {{-- MENÚ PRINCIPAL (desktop) --}}
        <ul class="nav-menu" id="navMenu">
            <li>
                <a href="{{ route('inicio') }}" class="{{ Request::routeIs('inicio') ? 'active' : '' }}">
                    Inicio
                </a>
            </li>
            <li>
                <a href="{{ route('cursos.index') }}" class="{{ Request::routeIs('cursos.*') ? 'active' : '' }}">
                    Cursos
                </a>
            </li>
            <li>
                <a href="{{ route('contacto') }}" class="{{ Request::routeIs('contacto') ? 'active' : '' }}">
                    Contáctanos
                </a>
            </li>
            <li>
                <a href="{{ route('normatividad') }}" class="{{ Request::routeIs('normatividad') ? 'active' : '' }}">
                    Normatividad
                </a>
            </li>
        </ul>

        {{-- ACCIONES DESKTOP --}}
        <div class="nav-actions">
            @auth
                <div class="user-dropdown">
                    <button class="user-dropdown-btn" onclick="toggleUserMenu()" id="userDropBtn">
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        {{ explode(' ', Auth::user()->name)[0] }}
                        <i class="fas fa-chevron-down" style="font-size:.7rem; opacity:.7;"></i>
                    </button>

                    <div id="userMenu" class="user-menu">
                        <div class="user-menu-header">
                            <div class="user-menu-name">{{ Auth::user()->name }}</div>
                            <div class="user-menu-email">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-th-large"></i> Mi Panel
                        </a>
                        <a href="{{ route('dashboard.perfil') }}">
                            <i class="fas fa-user-circle"></i> Mi Perfil
                        </a>
                        <a href="{{ route('dashboard.cursos') }}">
                            <i class="fas fa-book-open"></i> Mis Cursos
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-shield-alt"></i> Panel Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-nav-ghost">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="btn-nav-primary">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            @endauth
        </div>

        {{-- TOGGLE MÓVIL --}}
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Abrir menú">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
</header>

{{-- OVERLAY + PANEL MÓVIL --}}
<div class="mobile-nav-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>

<div class="mobile-nav-panel" id="mobileNavPanel">

    {{-- Cabecera del panel --}}
    <div class="mnp-header">
        <a href="{{ route('inicio') }}" class="mnp-logo" onclick="closeMobileMenu()">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <div class="mnp-logo-text">
                <span>Comunal</span>
                <span>Aprende</span>
            </div>
        </a>
        <button class="mnp-close" onclick="closeMobileMenu()" aria-label="Cerrar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- Links de navegación --}}
    <div class="mnp-section-label">Navegación</div>
    <ul class="mnp-links">
        <li>
            <a href="{{ route('inicio') }}" class="{{ Request::routeIs('inicio') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-home"></i> Inicio
            </a>
        </li>
        <li>
            <a href="{{ route('cursos.index') }}" class="{{ Request::routeIs('cursos.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-graduation-cap"></i> Cursos
            </a>
        </li>
        <li>
            <a href="{{ route('contacto') }}" class="{{ Request::routeIs('contacto') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-envelope"></i> Contáctanos
            </a>
        </li>
        <li>
            <a href="{{ route('normatividad') }}" class="{{ Request::routeIs('normatividad') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-file-alt"></i> Normatividad
            </a>
        </li>
    </ul>

    <div class="mnp-divider"></div>

    {{-- Usuario autenticado o botones de acceso --}}
    @auth
        <div class="mnp-section-label">Mi Cuenta</div>
        <div style="padding: 0 .5rem .5rem;">
            <div class="mnp-user-info">
                <div class="mnp-user-name">{{ Auth::user()->name }}</div>
                <div class="mnp-user-email">{{ Auth::user()->email }}</div>
            </div>
        </div>
        <ul class="mnp-links">
            <li>
                <a href="{{ route('dashboard') }}" onclick="closeMobileMenu()">
                    <i class="fas fa-th-large"></i> Mi Panel
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.perfil') }}" onclick="closeMobileMenu()">
                    <i class="fas fa-user-circle"></i> Mi Perfil
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.cursos') }}" onclick="closeMobileMenu()">
                    <i class="fas fa-book-open"></i> Mis Cursos
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.certificados') }}" onclick="closeMobileMenu()">
                    <i class="fas fa-certificate"></i> Certificados
                </a>
            </li>
            @if(Auth::user()->isAdmin())
            <li>
                <a href="{{ route('admin.dashboard') }}" onclick="closeMobileMenu()">
                    <i class="fas fa-shield-alt"></i> Panel Admin
                </a>
            </li>
            @endif
        </ul>
        <div class="mnp-divider"></div>
        <div style="padding: .5rem;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%;display:flex;align-items:center;justify-content:center;gap:.5rem;padding:.75rem;background:none;border:1.5px solid #fee2e2;border-radius:8px;color:#dc2626;font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:700;cursor:pointer;">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    @else
        <div class="mnp-auth-btns">
            <a href="{{ route('login') }}" class="btn-nav-ghost" onclick="closeMobileMenu()">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="btn-nav-primary" onclick="closeMobileMenu()">
                <i class="fas fa-user-plus"></i> Registrarse
            </a>
        </div>
    @endauth

</div>

<script>
function toggleUserMenu() {
    document.getElementById('userMenu').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.user-dropdown')) {
        const m = document.getElementById('userMenu');
        if (m) m.classList.remove('open');
    }
});

function openMobileMenu() {
    document.getElementById('mobileNavPanel').classList.add('open');
    document.getElementById('mobileOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
    const icon = document.querySelector('#mobileMenuToggle i');
    if (icon) { icon.classList.remove('fa-bars'); icon.classList.add('fa-times'); }
}

function closeMobileMenu() {
    document.getElementById('mobileNavPanel').classList.remove('open');
    document.getElementById('mobileOverlay').classList.remove('open');
    document.body.style.overflow = '';
    const icon = document.querySelector('#mobileMenuToggle i');
    if (icon) { icon.classList.remove('fa-times'); icon.classList.add('fa-bars'); }
}

document.getElementById('mobileMenuToggle')?.addEventListener('click', function() {
    const panel = document.getElementById('mobileNavPanel');
    if (panel.classList.contains('open')) {
        closeMobileMenu();
    } else {
        openMobileMenu();
    }
});

// Cerrar con tecla Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeMobileMenu();
});
</script>