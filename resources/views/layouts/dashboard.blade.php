<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Panel') — Comunal Aprende</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; background: #f0f4f8; font-family: 'Inter', sans-serif; }

        .db-wrap { display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .db-sidebar {
            width: 255px; flex-shrink: 0;
            background: linear-gradient(175deg, #073A6B 0%, #0A4D8C 55%, #1565C0 100%);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; height: 100vh;
            z-index: 200; transition: transform .28s ease;
            box-shadow: 3px 0 18px rgba(7,58,107,.3);
        }
        .db-logo {
            display: flex; align-items: center; gap: .7rem;
            padding: .1rem 1.4rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            text-decoration: none;
        }
        .db-logo-icon {
            width: 36px; height: 36px; background: #fff; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #0A4D8C; font-weight: 700; font-size: .85rem; flex-shrink: 0;
        }
        .db-logo-name { font-family: 'Poppins',sans-serif; font-weight: 700; font-size: .9rem; color: #fff; }

        .db-side-user {
            display: flex; align-items: center; gap: .7rem;
            padding: 1rem 1.4rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .db-side-avatar { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,.3); flex-shrink: 0; }
        .db-side-initials {
            width: 42px; height: 42px; border-radius: 50%;
            background: rgba(255,255,255,.18); color: #fff;
            font-weight: 700; font-size: 1rem;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .db-side-name { font-weight: 600; font-size: .85rem; color: #fff; display: block; }
        .db-side-cond {
            display: inline-block; margin-top: .2rem;
            font-size: .68rem; font-weight: 600;
            background: rgba(255,255,255,.14); color: rgba(255,255,255,.82);
            padding: .1rem .5rem; border-radius: 999px;
        }
        .db-nav { flex: 1; padding: .6rem 0; overflow-y: auto; }
        .db-nav-sep {
            padding: .55rem 1.4rem .2rem;
            font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: rgba(255,255,255,.38);
        }
        .db-nav-link {
            display: flex; align-items: center; gap: .7rem;
            padding: .65rem 1.4rem;
            color: rgba(255,255,255,.7); font-size: .86rem; font-weight: 500;
            text-decoration: none; border-left: 3px solid transparent; transition: all .16s;
        }
        .db-nav-link i { width: 17px; text-align: center; font-size: .92rem; }
        .db-nav-link:hover { background: rgba(255,255,255,.09); color: #fff; border-left-color: rgba(255,255,255,.35); }
        .db-nav-link.active { background: rgba(255,255,255,.16); color: #fff; border-left-color: #fff; }

        .db-side-foot { padding: .9rem 1.4rem; border-top: 1px solid rgba(255,255,255,.1); }
        .db-logout {
            width: 100%; display: flex; align-items: center; gap: .7rem;
            padding: .6rem .85rem; background: none; border: none;
            border-radius: 8px; color: rgba(255,255,255,.62);
            font-size: .86rem; font-weight: 500; cursor: pointer; text-align: left; transition: all .16s;
        }
        .db-logout:hover { background: rgba(220,53,69,.2); color: #ff8492; }

        /* ── Main ── */
        .db-main { margin-left: 255px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .db-topbar {
            background: #fff; padding: .85rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 4px rgba(10,77,140,.09);
            position: sticky; top: 0; z-index: 100;
        }
        .db-topbar-left { display: flex; align-items: center; gap: .9rem; }
        .db-topbar-title { font-family: 'Poppins',sans-serif; font-size: 1.1rem; font-weight: 700; color: #073A6B; margin: 0; }
        .db-hamburger { display: none; background: none; border: none; font-size: 1.3rem; color: #0A4D8C; cursor: pointer; }
        .db-topbar-right { display: flex; align-items: center; gap: .5rem; font-size: .86rem; color: #64748b; }
        .db-topbar-right i { color: #0A4D8C; font-size: 1rem; }

        .db-flash { padding: 1.25rem 1.75rem 0; }
        .db-alert { padding: .75rem 1rem; border-radius: 9px; display: flex; align-items: center; gap: .6rem; font-size: .86rem; font-weight: 500; margin-bottom: .6rem; }
        .db-alert.ok  { background: rgba(40,167,69,.1); border-left: 4px solid #28a745; color: #166534; }
        .db-alert.err { background: rgba(220,53,69,.1);  border-left: 4px solid #dc3545; color: #7f1d1d; }

        .db-content { padding: 1.6rem 1.75rem 3rem; }

        .db-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.42); z-index: 199; }

        @media (max-width: 1024px) {
            .db-sidebar { transform: translateX(-100%); }
            .db-sidebar.open { transform: translateX(0); }
            .db-overlay.open { display: block; }
            .db-main { margin-left: 0; }
            .db-hamburger { display: block; }
            .db-topbar, .db-content { padding-left: 1.1rem; padding-right: 1.1rem; }
        }
    </style>
</head>
<body>
<div class="db-overlay" id="dbOverlay" onclick="dbToggle()"></div>
<div class="db-wrap">

    <aside class="db-sidebar" id="dbSidebar">
        <a href="{{ route('inicio') }}" class="db-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Comunal Aprende"
                style="height:110px;width:auto;object-fit:contain;"
                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="db-logo-icon" style="display:none;">CA</div>
            <span class="db-logo-name">Comunal Aprende</span>
        </a>

        <div class="db-side-user">
            @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="avatar" class="db-side-avatar">
            @else
                <div class="db-side-initials">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            @endif
            <div>
                <span class="db-side-name">{{ Auth::user()->name }}</span>
                <span class="db-side-cond">{{ Auth::user()->condicion === 'afiliado' ? 'Afiliado' : 'Particular' }}</span>
            </div>
        </div>

        <nav class="db-nav">
            <div class="db-nav-sep">Principal</div>
            <a href="{{ route('dashboard') }}"              class="db-nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> Inicio</a>
            <a href="{{ route('dashboard.cursos') }}"       class="db-nav-link {{ Request::routeIs('dashboard.cursos') ? 'active' : '' }}"><i class="fas fa-book-open"></i> Mis Cursos</a>
            <a href="{{ route('dashboard.certificados') }}" class="db-nav-link {{ Request::routeIs('dashboard.certificados') ? 'active' : '' }}"><i class="fas fa-certificate"></i> Certificados</a>
            <div class="db-nav-sep">Mi Cuenta</div>
            <a href="{{ route('dashboard.perfil') }}"       class="db-nav-link {{ Request::routeIs('dashboard.perfil') ? 'active' : '' }}"><i class="fas fa-user-circle"></i> Mi Perfil</a>
            <div class="db-nav-sep">Plataforma</div>
            <a href="{{ route('cursos.index') }}"           class="db-nav-link"><i class="fas fa-graduation-cap"></i> Catálogo de Cursos</a>
            <a href="{{ route('inicio') }}"                 class="db-nav-link"><i class="fas fa-home"></i> Volver al Inicio</a>
        </nav>

        <div class="db-side-foot">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="db-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
            </form>
        </div>
    </aside>

    <div class="db-main">
        <div class="db-topbar">
            <div class="db-topbar-left">
                <button class="db-hamburger" onclick="dbToggle()"><i class="fas fa-bars"></i></button>
                <h1 class="db-topbar-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="db-topbar-right">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name }}</span>
            </div>
        </div>

        <div class="db-flash">
            @if(session('success'))
                <div class="db-alert ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="db-alert err"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
        </div>

        <div class="db-content">
            @yield('content')
        </div>
    </div>
</div>
<script>function dbToggle(){document.getElementById('dbSidebar').classList.toggle('open');document.getElementById('dbOverlay').classList.toggle('open');}</script>
@yield('extra-js')
</body>
</html>