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
    height: 80px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 1.5rem;
}

/* ── LOGO ── */
.logo {
    display: flex; align-items: center; gap: .6rem;
    text-decoration: none; flex-shrink: 0;
}
.logo-img {
    height: 120px; width: auto;
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

/* ── MOBILE ── */
.mobile-menu-toggle {
    display: none; background: none; border: 1.5px solid #dde4ee;
    border-radius: 8px; width: 38px; height: 38px;
    align-items: center; justify-content: center;
    color: #334155; cursor: pointer; transition: all .18s;
}
.mobile-menu-toggle:hover { background: #EBF3FF; border-color: #0A4D8C; color: #0A4D8C; }

@media (max-width: 860px) {
    .nav-menu { display: none; }
    .mobile-menu-toggle { display: flex; }
    .nav-actions .btn-nav-ghost { display: none; }
}
@media (max-width: 480px) {
    .logo-text { display: none; }
}

/* Padding compensación header fijo */
body > section:first-child,
body > div:first-child,
.hero-section { padding-top: 68px; }

/* Para la página de inicio el hero ya ocupa todo el viewport */
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

        {{-- MENÚ PRINCIPAL --}}
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

        {{-- ACCIONES --}}
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

// Mobile menu
document.getElementById('mobileMenuToggle')?.addEventListener('click', function() {
    const menu = document.getElementById('navMenu');
    if (menu.style.display === 'flex') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'flex';
        menu.style.flexDirection = 'column';
        menu.style.position = 'absolute';
        menu.style.top = '68px';
        menu.style.left = '0';
        menu.style.right = '0';
        menu.style.background = '#fff';
        menu.style.padding = '1rem';
        menu.style.borderBottom = '1px solid #dde4ee';
        menu.style.boxShadow = '0 8px 24px rgba(0,0,0,.08)';
        menu.style.zIndex = '999';
    }
});
</script>