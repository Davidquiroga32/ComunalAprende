<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Comunal Aprende</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; background: #f0f4f8; font-family: 'Inter', sans-serif; }
        .adm-wrap { display: flex; min-height: 100vh; }

        /* ── Sidebar admin ── */
        .adm-sidebar {
            width: 255px; flex-shrink: 0;
            background: linear-gradient(175deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; height: 100vh;
            z-index: 200; transition: transform .28s ease;
            box-shadow: 3px 0 18px rgba(0,0,0,.3);
        }
        .adm-logo {
            display: flex; align-items: center; gap: .7rem;
            padding: 1.3rem 1.4rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            text-decoration: none;
        }
        .adm-logo-icon {
            width: 36px; height: 36px;
            background: #e94560; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem; flex-shrink: 0;
        }
        .adm-logo-text { line-height: 1.2; }
        .adm-logo-name { font-family: 'Poppins',sans-serif; font-weight: 700; font-size: .88rem; color: #fff; display: block; }
        .adm-logo-sub  { font-size: .68rem; color: rgba(255,255,255,.45); font-weight: 500; }

        .adm-admin-badge {
            margin: .75rem 1.4rem;
            background: rgba(233,69,96,.15);
            border: 1px solid rgba(233,69,96,.3);
            border-radius: 8px;
            padding: .5rem .875rem;
            display: flex; align-items: center; gap: .5rem;
        }
        .adm-admin-badge i { color: #e94560; font-size: .85rem; }
        .adm-admin-badge span { font-size: .8rem; font-weight: 600; color: rgba(255,255,255,.8); }

        .adm-nav { flex: 1; padding: .4rem 0; overflow-y: auto; }
        .adm-nav-sep {
            padding: .55rem 1.4rem .2rem;
            font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: rgba(255,255,255,.3);
        }
        .adm-nav-link {
            display: flex; align-items: center; gap: .7rem;
            padding: .65rem 1.4rem;
            color: rgba(255,255,255,.65); font-size: .86rem; font-weight: 500;
            text-decoration: none; border-left: 3px solid transparent; transition: all .16s;
        }
        .adm-nav-link i { width: 17px; text-align: center; font-size: .92rem; }
        .adm-nav-link:hover  { background: rgba(255,255,255,.07); color: #fff; border-left-color: rgba(233,69,96,.5); }
        .adm-nav-link.active { background: rgba(233,69,96,.12); color: #fff; border-left-color: #e94560; }

        .adm-side-foot { padding: .9rem 1.4rem; border-top: 1px solid rgba(255,255,255,.08); }
        .adm-side-foot a {
            display: flex; align-items: center; gap: .6rem;
            font-size: .84rem; color: rgba(255,255,255,.5);
            text-decoration: none; padding: .4rem 0; transition: color .15s;
        }
        .adm-side-foot a:hover { color: rgba(255,255,255,.8); }
        .adm-logout {
            width: 100%; display: flex; align-items: center; gap: .7rem;
            padding: .6rem .85rem; background: none; border: none;
            border-radius: 8px; color: rgba(255,255,255,.5);
            font-size: .86rem; font-weight: 500; cursor: pointer; text-align: left; transition: all .16s;
            margin-top: .4rem;
        }
        .adm-logout:hover { background: rgba(220,53,69,.2); color: #ff8492; }

        /* ── Main ── */
        .adm-main { margin-left: 255px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .adm-topbar {
            background: #fff; padding: .85rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
            position: sticky; top: 0; z-index: 100;
        }
        .adm-topbar-left { display: flex; align-items: center; gap: .9rem; }
        .adm-topbar-title { font-family: 'Poppins',sans-serif; font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin: 0; }
        .adm-hamburger { display: none; background: none; border: none; font-size: 1.3rem; color: #0f3460; cursor: pointer; }
        .adm-topbar-right { display: flex; align-items: center; gap: .75rem; }
        .adm-topbar-badge {
            display: flex; align-items: center; gap: .4rem;
            background: rgba(233,69,96,.1); color: #e94560;
            font-size: .78rem; font-weight: 700;
            padding: .3rem .75rem; border-radius: 999px;
        }
        .adm-topbar-user { font-size: .86rem; color: #64748b; }

        .adm-flash { padding: 1.25rem 1.75rem 0; }
        .adm-alert { padding: .75rem 1rem; border-radius: 9px; display: flex; align-items: center; gap: .6rem; font-size: .86rem; font-weight: 500; margin-bottom: .6rem; }
        .adm-alert.ok  { background: rgba(40,167,69,.1);  border-left: 4px solid #28a745; color: #166534; }
        .adm-alert.err { background: rgba(220,53,69,.1);  border-left: 4px solid #dc3545; color: #7f1d1d; }

        .adm-content { padding: 1.6rem 1.75rem 3rem; }

        .adm-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 199; }
        @media (max-width: 1024px) {
            .adm-sidebar { transform: translateX(-100%); }
            .adm-sidebar.open { transform: translateX(0); }
            .adm-overlay.open { display: block; }
            .adm-main { margin-left: 0; }
            .adm-hamburger { display: block; }
            .adm-topbar, .adm-content { padding-left: 1.1rem; padding-right: 1.1rem; }
        }
    </style>
</head>
<body>
<div class="adm-overlay" id="admOverlay" onclick="admToggle()"></div>
<div class="adm-wrap">

    <aside class="adm-sidebar" id="admSidebar">
        <a href="{{ route('admin.dashboard') }}" class="adm-logo">
            <div class="adm-logo-icon"><i class="fas fa-shield-alt"></i></div>
            <div class="adm-logo-text">
                <span class="adm-logo-name">Comunal Aprende</span>
                <span class="adm-logo-sub">Panel Administrativo</span>
            </div>
        </a>

        <div class="adm-admin-badge">
            <i class="fas fa-user-shield"></i>
            <span>{{ Auth::user()->name }}</span>
        </div>

        <nav class="adm-nav">
            <div class="adm-nav-sep">Panel</div>
            <a href="{{ route('admin.dashboard') }}"   class="adm-nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Dashboard</a>

            <div class="adm-nav-sep">Contenido</div>
            <a href="{{ route('admin.cursos.index') }}" class="adm-nav-link {{ Request::routeIs('admin.cursos.*') ? 'active' : '' }}"><i class="fas fa-graduation-cap"></i> Cursos</a>
            <a href="{{ route('admin.cursos.create') }}" class="adm-nav-link"><i class="fas fa-plus-circle"></i> Nuevo Curso</a>

            <div class="adm-nav-sep">Usuarios</div>
            <a href="{{ route('admin.estudiantes') }}"  class="adm-nav-link {{ Request::routeIs('admin.estudiantes') ? 'active' : '' }}"><i class="fas fa-users"></i> Estudiantes</a>

            <div class="adm-nav-sep">Sistema</div>
            <a href="{{ route('inicio') }}"             class="adm-nav-link"><i class="fas fa-globe"></i> Ver Sitio Web</a>
            <a href="{{ route('dashboard') }}"          class="adm-nav-link"><i class="fas fa-user"></i> Mi Panel</a>
        </nav>

        <div class="adm-side-foot">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="adm-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
            </form>
        </div>
    </aside>

    <div class="adm-main">
        <div class="adm-topbar">
            <div class="adm-topbar-left">
                <button class="adm-hamburger" onclick="admToggle()"><i class="fas fa-bars"></i></button>
                <h1 class="adm-topbar-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="adm-topbar-right">
                <div class="adm-topbar-badge"><i class="fas fa-shield-alt"></i> Admin</div>
                <span class="adm-topbar-user">{{ Auth::user()->name }}</span>
            </div>
        </div>

        <div class="adm-flash">
            @if(session('success'))
                <div class="adm-alert ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="adm-alert err"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
        </div>

        <div class="adm-content">
            @yield('content')
        </div>
    </div>
</div>
<script>function admToggle(){document.getElementById('admSidebar').classList.toggle('open');document.getElementById('admOverlay').classList.toggle('open');}</script>
@yield('extra-js')
</body>
</html>