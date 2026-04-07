<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Certificado · Comunal Aprende</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Outfit:wght@300;400;500;600;700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:    #071D36;
            --blue:    #0A2540;
            --mid:     #0A4D8C;
            --gold:    #C9A84C;
            --gold-lt: #e8d49c;
            --offwhite:#f5f7fa;
            --slate:   #64748b;
            --muted:   #94a3b8;
            --border:  #e2e8f0;
            --card-bg: #ffffff;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--offwhite);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: var(--navy);
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 15% 10%, rgba(10,77,140,0.06) 0%, transparent 70%),
                radial-gradient(ellipse 60% 40% at 85% 90%, rgba(10,77,140,0.05) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* Header */
        .vf-header {
            position: relative;
            z-index: 10;
            background: linear-gradient(105deg, #071D36 0%, #0A2F58 60%, #0C3A6B 100%);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            border-bottom: 2px solid var(--gold);
            box-shadow: 0 4px 32px rgba(7,29,54,0.35);
        }
        .vf-header::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.4), transparent);
        }
        .vf-header-logo { height: 46px; width: auto; }
        .vf-header-divider {
            width: 1px; height: 36px;
            background: linear-gradient(180deg, transparent, rgba(201,168,76,0.5), transparent);
        }
        .vf-header-text h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.02em;
        }
        .vf-header-text p {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-top: 0.15rem;
        }
        .vf-header-badge {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(201,168,76,0.12);
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 100px;
            padding: 0.35rem 0.85rem;
            font-size: 0.7rem;
            color: var(--gold-lt);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        /* Main */
        .vf-main {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 3rem 1rem 2rem;
        }
        .vf-container {
            max-width: 700px;
            width: 100%;
        }

        /* Hero */
        .vf-hero {
            background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
            border-radius: 20px 20px 0 0;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .vf-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .vf-hero-icon {
            position: relative; z-index: 1;
            width: 80px; height: 80px;
            margin: 0 auto 1.25rem;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2.25rem; color: #fff;
            box-shadow: 0 0 0 8px rgba(255,255,255,0.07);
        }
        .vf-hero-title {
            position: relative; z-index: 1;
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
        }
        .vf-hero-sub {
            position: relative; z-index: 1;
            font-size: 0.88rem;
            color: rgba(255,255,255,0.8);
            max-width: 420px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Card */
        .vf-card {
            background: var(--card-bg);
            border-radius: 0 0 20px 20px;
            box-shadow: 0 12px 50px rgba(7,29,54,0.12);
        }
        .vf-card-inner { padding: 2rem 2rem 1.75rem; }

        /* Sello */
        .vf-sello {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: linear-gradient(105deg, #EBF3FF, #f5f9ff);
            border: 1px solid #c5d9f0;
            border-left: 3px solid var(--mid);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.75rem;
        }
        .vf-sello-icon {
            flex-shrink: 0;
            width: 44px; height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--blue), var(--mid));
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(10,77,140,0.25);
        }
        .vf-sello-text h4 {
            font-family: 'Outfit', sans-serif;
            font-size: 0.88rem;
            font-weight: 800;
            color: var(--blue);
            margin-bottom: 0.2rem;
        }
        .vf-sello-text p {
            font-size: 0.78rem;
            color: var(--slate);
            line-height: 1.5;
        }

        /* Section label */
        .vf-section-label {
            font-family: 'Outfit', sans-serif;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .vf-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Grid */
        .vf-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.875rem;
            margin-bottom: 1.75rem;
        }
        .vf-info-item {
            background: var(--offwhite);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1rem 1.1rem;
            position: relative;
            overflow: hidden;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .vf-info-item::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--mid), transparent);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .vf-info-item:hover { border-color: #b8d0ef; box-shadow: 0 4px 16px rgba(10,77,140,0.08); }
        .vf-info-item:hover::before { opacity: 1; }
        .vf-info-item.highlight {
            background: linear-gradient(135deg, #EBF3FF, #f0f7ff);
            border-color: #c5d9f0;
        }
        .vf-info-item.highlight::before { opacity: 1; }

        .vf-label {
            font-size: 0.67rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .vf-label i { font-size: 0.6rem; color: var(--mid); }
        .vf-value {
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--navy);
            line-height: 1.3;
        }
        .vf-value.large { font-size: 1.1rem; }
        .vf-value.code {
            font-family: 'Courier New', monospace;
            font-size: 0.88rem;
            color: var(--mid);
            letter-spacing: 2px;
            background: rgba(10,77,140,0.06);
            display: inline-block;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
            border: 1px solid rgba(10,77,140,0.12);
        }

        .vf-divider { height: 1px; background: var(--border); margin: 1.5rem 0; }

        /* Botones */
        .vf-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.7rem 1.35rem;
            background: linear-gradient(135deg, var(--blue), var(--mid));
            color: #fff;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.875rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 16px rgba(10,77,140,0.3);
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--navy), var(--blue));
            box-shadow: 0 6px 24px rgba(10,77,140,0.4);
            transform: translateY(-1px);
        }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.7rem 1.35rem;
            background: #fff; color: var(--slate);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-ghost:hover {
            border-color: var(--mid); color: var(--mid);
            background: #f0f6ff;
            transform: translateY(-1px);
        }

        /* Footer */
        .vf-footer {
            background: var(--navy);
            padding: 1rem 2rem;
            text-align: center;
            font-size: 0.72rem;
            color: rgba(255,255,255,0.35);
            position: relative;
        }
        .vf-footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201,168,76,0.3), transparent);
        }
        .vf-footer strong { color: rgba(255,255,255,0.5); }
    </style>
</head>
<body>

<header class="vf-header">
    <img src="{{ asset('images/logo.png') }}" class="vf-header-logo" alt="Comunal Aprende"
         onerror="this.style.display='none'">
    <div class="vf-header-divider"></div>
    <div class="vf-header-text">
        <h1>Comunal Aprende</h1>
        <p>Sistema de Verificación de Certificados</p>
    </div>
    <div class="vf-header-badge">
        <i class="fas fa-shield-alt"></i>
        Verificación Oficial
    </div>
</header>

<main class="vf-main">
    <div class="vf-container">

        <div class="vf-hero">
            <div class="vf-hero-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="vf-hero-title">Certificado Auténtico y Válido</div>
            <div class="vf-hero-sub">
                Este certificado ha sido verificado exitosamente en los registros oficiales de Comunal Aprende
            </div>
        </div>

        <div class="vf-card">
            <div class="vf-card-inner">

                <div class="vf-sello">
                    <div class="vf-sello-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="vf-sello-text">
                        <h4>Verificación Oficial · Comunal Aprende</h4>
                        <p>Este documento es emitido y respaldado por Comunal Aprende, plataforma oficial de formación para organizaciones comunitarias en Colombia.</p>
                    </div>
                </div>

                <div class="vf-section-label">
                    <i class="fas fa-id-card"></i>
                    Información del Certificado
                </div>

                <div class="vf-grid">
                    <div class="vf-info-item highlight">
                        <div class="vf-label"><i class="fas fa-user"></i> Participante</div>
                        <div class="vf-value large">{{ $certificado->user->name }}</div>
                    </div>
                    <div class="vf-info-item">
                        <div class="vf-label"><i class="fas fa-book-open"></i> Curso Completado</div>
                        <div class="vf-value">{{ $certificado->curso->titulo }}</div>
                    </div>
                    <div class="vf-info-item">
                        <div class="vf-label"><i class="fas fa-calendar"></i> Fecha de Expedición</div>
                        <div class="vf-value">
                            {{ $certificado->fecha_emision->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                        </div>
                    </div>
                    <div class="vf-info-item">
                        <div class="vf-label"><i class="fas fa-clock"></i> Duración</div>
                        <div class="vf-value">{{ $certificado->curso->duracion_horas }} horas académicas</div>
                    </div>
                    <div class="vf-info-item">
                        <div class="vf-label"><i class="fas fa-tag"></i> Categoría</div>
                        <div class="vf-value">{{ $certificado->curso->categoriaLabel() }}</div>
                    </div>
                    <div class="vf-info-item">
                        <div class="vf-label"><i class="fas fa-fingerprint"></i> Código de Verificación</div>
                        <div class="vf-value code">{{ $certificado->codigo }}</div>
                    </div>
                </div>

                <div class="vf-divider"></div>

                <div class="vf-actions">
                    <a href="{{ route('inicio') }}" class="btn-primary">
                        <i class="fas fa-home"></i> Ir a Comunal Aprende
                    </a>
                    <a href="{{ route('cursos.index') }}" class="btn-ghost">
                        <i class="fas fa-book-open"></i> Ver Cursos
                    </a>
                </div>

            </div>
        </div>

    </div>
</main>

<footer class="vf-footer">
    © {{ date('Y') }} <strong>Comunal Aprende</strong> · Sistema de verificación de certificados · Colombia
</footer>

</body>
</html>