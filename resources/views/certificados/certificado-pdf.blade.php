<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    @page {
        size: 297mm 210mm landscape;
        margin: 0;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #ffffff;
        width: 297mm;
        height: 210mm;
        overflow: hidden;
    }

    .cert {
        width: 297mm;
        height: 210mm;
        position: relative;
        background: #ffffff;
    }

    /* ── Fondo izquierdo con banda decorativa ── */
    .bg-left-band {
        position: absolute;
        top: 0; left: 0;
        width: 18mm; height: 100%;
        background: linear-gradient(180deg, #071D36 0%, #0A2F58 50%, #071D36 100%);
    }
    .bg-left-band::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 3px; height: 100%;
        background: linear-gradient(180deg, #C9A84C 0%, #e8d49c 50%, #C9A84C 100%);
    }

    /* Patrón de rombos en la banda lateral */
    .bg-left-pattern {
        position: absolute;
        top: 0; left: 0;
        width: 18mm; height: 100%;
        background-image:
            repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.03) 0px,
                rgba(255,255,255,0.03) 1px,
                transparent 1px,
                transparent 8px
            ),
            repeating-linear-gradient(
                -45deg,
                rgba(255,255,255,0.03) 0px,
                rgba(255,255,255,0.03) 1px,
                transparent 1px,
                transparent 8px
            );
    }

    /* Texto vertical en banda */
    .band-text {
        position: absolute;
        top: 50%;
        left: 3mm;
        transform: translateY(-50%) rotate(-90deg);
        transform-origin: center center;
        font-size: 5.5pt;
        color: rgba(201,168,76,0.5);
        text-transform: uppercase;
        letter-spacing: 3px;
        white-space: nowrap;
        font-weight: 700;
    }

    /* ── Fondo principal con degradado sutil ── */
    .cert-bg {
        position: absolute;
        top: 0; left: 18mm; right: 0; bottom: 0;
        background:
            radial-gradient(ellipse 70% 50% at 60% 110%, #dce8f7 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 95% 5%,   #e5eef8 0%, transparent 55%);
    }

    /* ── Marco dorado derecho ── */
    .frame-outer {
        position: absolute;
        top: 5mm; left: 20mm; right: 5mm; bottom: 5mm;
        border: 2px solid #C9A84C;
    }
    .frame-inner {
        position: absolute;
        top: 8mm; left: 23mm; right: 8mm; bottom: 8mm;
        border: 0.75px solid rgba(201,168,76,0.35);
    }

    /* ── Esquinas (solo en las 3 esquinas sin banda) ── */
    .corner {
        position: absolute;
        width: 14mm; height: 14mm;
    }
    .corner::before {
        content: '';
        position: absolute;
        width: 4px; height: 4px;
        background: #C9A84C;
    }
    .corner.tr { top:4mm; right:4mm;   border-top:2.5px solid #C9A84C; border-right:2.5px solid #C9A84C; }
    .corner.bl { bottom:4mm; left:20mm; border-bottom:2.5px solid #C9A84C; border-left:2.5px solid #C9A84C; }
    .corner.br { bottom:4mm; right:4mm; border-bottom:2.5px solid #C9A84C; border-right:2.5px solid #C9A84C; }
    .corner.tr::before { top:-2px; right:-2px; }
    .corner.bl::before { bottom:-2px; left:-2px; }
    .corner.br::before { bottom:-2px; right:-2px; }

    /* Esquina superior izquierda (sobre la banda) */
    .corner-tl-top {
        position: absolute;
        top: 4mm; left: 20mm;
        width: 14mm; height: 14mm;
        border-top: 2.5px solid #C9A84C;
        border-left: 2.5px solid #C9A84C;
    }
    .corner-tl-top::before {
        content: '';
        position: absolute;
        top: -2px; left: -2px;
        width: 4px; height: 4px;
        background: #C9A84C;
    }

    /* ── Marca de agua ── */
    .watermark {
        position: absolute;
        top: 50%; left: calc(18mm + 50%);
        transform: translate(-50%, -50%) rotate(-20deg);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 50pt;
        font-weight: 700;
        color: rgba(10,46,88,0.04);
        text-transform: uppercase;
        letter-spacing: 6px;
        white-space: nowrap;
        pointer-events: none;
        z-index: 0;
    }

    /* ── Header ── */
    .header {
        position: absolute;
        top: 10mm; left: 21mm; right: 12mm;
        height: 26mm;
        background: linear-gradient(108deg, #071D36 0%, #0A2F58 50%, #0C3870 100%);
        display: flex;
        align-items: center;
        padding: 0 8mm;
        gap: 6mm;
        overflow: hidden;
    }
    .header::after {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, transparent, #C9A84C 25%, #C9A84C 75%, transparent);
    }
    .header::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: repeating-linear-gradient(
            0deg, transparent, transparent 3px,
            rgba(255,255,255,0.015) 3px,
            rgba(255,255,255,0.015) 6px
        );
    }

    .header-logo {
        height: 18mm; width: auto;
        flex-shrink: 0;
        position: relative; z-index: 1;
    }
    .header-divider {
        width: 1px; height: 14mm;
        background: linear-gradient(180deg, transparent, rgba(201,168,76,0.6), transparent);
        flex-shrink: 0;
        position: relative; z-index: 1;
    }
    .header-text {
        flex: 1;
        position: relative; z-index: 1;
    }
    .header-eyebrow {
        font-size: 5.5pt;
        color: #C9A84C;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-weight: 700;
        margin-bottom: 2mm;
    }
    .header-title {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 22pt;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 3px;
        line-height: 1;
        margin-bottom: 2mm;
    }
    .header-subtitle {
        font-size: 6.5pt;
        color: rgba(255,255,255,0.5);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 400;
    }
    .header-seal {
        flex-shrink: 0;
        width: 18mm; height: 18mm;
        border-radius: 50%;
        border: 1.5px solid rgba(201,168,76,0.4);
        background: rgba(201,168,76,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative; z-index: 1;
        flex-direction: column;
        gap: 1px;
    }
    .header-seal-star {
        font-size: 14pt;
        color: #C9A84C;
        line-height: 1;
    }
    .header-seal-text {
        font-size: 4pt;
        color: rgba(201,168,76,0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    /* ── Líneas decorativas ── */
    .deco-line {
        position: absolute;
        left: 24mm; right: 13mm;
        height: 1px;
    }
    .deco-line.top {
        top: 39mm;
        background: linear-gradient(90deg, #C9A84C, rgba(201,168,76,0.2) 80%, transparent);
    }
    .deco-line.bottom {
        bottom: 28mm;
        background: linear-gradient(90deg, #C9A84C, rgba(201,168,76,0.2) 80%, transparent);
    }

    /* ── Contenido: layout en dos columnas ── */
    .content-area {
        position: absolute;
        top: 39mm; left: 21mm; right: 12mm;
        bottom: 28mm;
        display: flex;
        align-items: stretch;
        gap: 0;
    }

    /* Columna principal (izquierda) */
    .col-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4mm 6mm 4mm 4mm;
        border-right: 1px solid rgba(201,168,76,0.2);
    }

    .se-certifica {
        font-size: 6pt;
        color: #8a9ab5;
        text-transform: uppercase;
        letter-spacing: 4px;
        font-weight: 700;
        margin-bottom: 2mm;
    }

    .nombre {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 26pt;
        font-weight: 700;
        color: #071D36;
        line-height: 1.1;
        margin-bottom: 1mm;
    }

    .nombre-underline {
        width: 40mm;
        height: 2px;
        background: linear-gradient(90deg, #C9A84C, transparent);
        margin-bottom: 3mm;
    }

    .por-haber {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 8.5pt;
        font-style: italic;
        color: #5a6e8a;
        margin-bottom: 3mm;
        line-height: 1.4;
    }

    /* Banda del curso */
    .curso-wrap {
        display: flex;
        align-items: stretch;
        margin-bottom: 3mm;
    }
    .curso-bar {
        width: 3px;
        background: linear-gradient(180deg, #C9A84C, #e8d49c);
        flex-shrink: 0;
    }
    .curso-content {
        background: linear-gradient(108deg, #071D36 0%, #0A4D8C 100%);
        padding: 2mm 6mm;
        flex: 1;
    }
    .curso-label {
        font-size: 5pt;
        color: rgba(201,168,76,0.7);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        margin-bottom: 1mm;
    }
    .curso-titulo {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 13pt;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.3px;
        line-height: 1.2;
    }

    /* Info del curso en pills */
    .curso-meta {
        display: flex;
        gap: 3mm;
        flex-wrap: wrap;
    }
    .meta-pill {
        display: flex;
        align-items: center;
        gap: 1.5mm;
        background: rgba(10,77,140,0.06);
        border: 0.75px solid rgba(10,77,140,0.15);
        border-radius: 100px;
        padding: 1mm 3mm;
    }
    .meta-pill-dot {
        width: 2.5mm; height: 2.5mm;
        border-radius: 50%;
        background: #C9A84C;
        flex-shrink: 0;
    }
    .meta-pill-text {
        font-size: 6pt;
        color: #3a5070;
        font-weight: 600;
    }
    .meta-pill-value {
        font-size: 6pt;
        color: #0A4D8C;
        font-weight: 700;
    }

    /* Descripción */
    .descripcion {
        font-size: 6pt;
        color: #8a9ab5;
        line-height: 1.7;
        margin-top: 3mm;
        padding-top: 3mm;
        border-top: 0.75px solid rgba(201,168,76,0.2);
    }

    /* Columna secundaria (derecha) */
    .col-side {
        width: 52mm;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 4mm 4mm 4mm 6mm;
    }

    /* Bloque firma */
    .firma-block {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .firma-img {
        height: 14mm; width: auto;
        max-width: 42mm;
        display: block;
        margin-bottom: 2mm;
    }
    .firma-placeholder {
        height: 14mm;
    }
    .firma-line-under {
        width: 40mm;
        height: 1px;
        background-color: #1a2940;
        margin-bottom: 2mm;
    }
    .firma-nombre {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 8pt;
        font-weight: 700;
        color: #071D36;
        margin-bottom: 1mm;
        text-align: center;
    }
    .firma-cargo {
        font-size: 5.5pt;
        color: #C9A84C;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        text-align: center;
    }

    /* Bloque verificación */
    .verify-block {
        background: rgba(10,77,140,0.04);
        border: 1px solid rgba(201,168,76,0.25);
        padding: 3mm;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2mm;
    }
    .verify-top {
        display: flex;
        align-items: center;
        gap: 3mm;
        width: 100%;
    }
    .qr-wrap {
        border: 1px solid rgba(201,168,76,0.5);
        padding: 1.5mm;
        background: #ffffff;
        flex-shrink: 0;
    }
    .qr-img {
        width: 18mm; height: 18mm;
        display: block;
    }
    .verify-info {
        flex: 1;
    }
    .verify-label {
        font-size: 5pt;
        color: #8a9ab5;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 1.5mm;
    }
    .verify-fecha {
        font-size: 6.5pt;
        color: #3a4e6a;
        font-weight: 600;
        margin-bottom: 1.5mm;
        line-height: 1.4;
    }
    .verify-code {
        font-size: 6.5pt;
        color: #0A4D8C;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        background: rgba(10,77,140,0.06);
        padding: 1mm 2mm;
        display: inline-block;
    }
    .verify-bottom {
        font-size: 5pt;
        color: #8a9ab5;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
</style>
</head>
<body>
<div class="cert">

    <!-- Banda lateral izquierda -->
    <div class="bg-left-band"></div>
    <div class="bg-left-pattern"></div>
    <div class="band-text">Comunal Aprende · Colombia</div>

    <!-- Fondo y marca de agua -->
    <div class="cert-bg"></div>
    <div class="watermark">Comunal Aprende</div>

    <!-- Marcos y esquinas -->
    <div class="frame-outer"></div>
    <div class="frame-inner"></div>
    <div class="corner-tl-top"></div>
    <div class="corner tr"></div>
    <div class="corner bl"></div>
    <div class="corner br"></div>

    <!-- Líneas decorativas -->
    <div class="deco-line top"></div>
    <div class="deco-line bottom"></div>

    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="header-logo" alt="Logo">
        <div class="header-divider"></div>
        <div class="header-text">
            <div class="header-eyebrow">Comunal Aprende &nbsp;&middot;&nbsp; Colombia</div>
            <div class="header-title">Certificado</div>
            <div class="header-subtitle">de Participaci&oacute;n y Formaci&oacute;n Comunitaria</div>
        </div>
        <div class="header-seal">
            <div class="header-seal-star">&#9733;</div>
            <div class="header-seal-text">Oficial</div>
        </div>
    </div>

    <!-- Contenido principal en dos columnas -->
    <div class="content-area">

        <!-- Columna izquierda -->
        <div class="col-main">
            <div class="se-certifica">Se certifica que</div>

            <div class="nombre">{{ $user->name }}</div>
            <div class="nombre-underline"></div>

            <div class="por-haber">ha completado satisfactoriamente el programa de formaci&oacute;n</div>

            <div class="curso-wrap">
                <div class="curso-bar"></div>
                <div class="curso-content">
                    <div class="curso-label">Programa de formaci&oacute;n</div>
                    <div class="curso-titulo">{{ $curso->titulo }}</div>
                </div>
            </div>

            <div class="curso-meta">
                <div class="meta-pill">
                    <div class="meta-pill-dot"></div>
                    <span class="meta-pill-text">Duración:</span>
                    <span class="meta-pill-value">{{ $curso->duracion_horas }} horas</span>
                </div>
                <div class="meta-pill">
                    <div class="meta-pill-dot"></div>
                    <span class="meta-pill-text">Categoría:</span>
                    <span class="meta-pill-value">{{ $curso->categoriaLabel() }}</span>
                </div>
            </div>

            <div class="descripcion">
                {{ $curso->descripcion_corta ?? 'Programa de capacitación especializado para el fortalecimiento de organizaciones comunitarias en Colombia.' }}
            </div>
        </div>

        <!-- Columna derecha -->
        <div class="col-side">

            <!-- Firma -->
            <div class="firma-block">
                @if(file_exists(public_path('images/firma-ivan-castillo.png')))
                    <img src="{{ public_path('images/firma-ivan-castillo.png') }}" class="firma-img" alt="Firma">
                @else
                    <div class="firma-placeholder"></div>
                @endif
                <div class="firma-line-under"></div>
                <div class="firma-nombre">Iv&aacute;n Castillo</div>
                <div class="firma-cargo">Director &middot; Comunal Aprende</div>
            </div>

            <!-- Verificación -->
            <div class="verify-block">
                <div class="verify-top">
                    <div class="qr-wrap">
                        <img src="data:image/svg+xml;base64,{{ $qrBase64 }}" class="qr-img" alt="QR">
                    </div>
                    <div class="verify-info">
                        <div class="verify-label">Expedición</div>
                        <div class="verify-fecha">
                            {{ $certificado->fecha_emision->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
                        </div>
                        <div class="verify-label" style="margin-top:1.5mm;">C&oacute;digo</div>
                        <div class="verify-code">{{ $certificado->codigo }}</div>
                    </div>
                </div>
                <div class="verify-bottom">Escanea para verificar autenticidad</div>
            </div>

        </div>
    </div>

</div>
</body>
</html>