<x-guest-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .ca-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #071D36 0%, #0A4D8C 60%, #1E6DB8 100%);
        padding: 20px 16px;
        font-family: 'Inter', sans-serif;
    }

    .ca-card {
        width: 100%;
        max-width: 400px;
        background: #ffffff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(7, 29, 54, 0.45);
    }

    /* HEADER */
    .ca-header {
        background: linear-gradient(135deg, #071D36 0%, #0A4D8C 100%);
        padding: 24px 32px 20px;
        text-align: center;
        border-bottom: 3px solid #C9A84C;
    }

    .ca-logo {
        height: 70px;
        width: auto;
        object-fit: contain;
        margin-bottom: 10px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .ca-brand {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #ffffff;
    }

    .ca-tagline {
        font-size: 10px;
        color: rgba(255,255,255,0.45);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-top: 3px;
    }

    /* BODY */
    .ca-body {
        padding: 28px 32px 24px;
    }

    .ca-icon {
        width: 54px;
        height: 54px;
        background: #EBF3FF;
        border: 2px solid #c5d9f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 22px;
    }

    .ca-title {
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: #071D36;
        text-align: center;
        margin-bottom: 6px;
    }

    .ca-desc {
        font-size: 13px;
        color: #64748b;
        text-align: center;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    .ca-status {
        background: #f0fdf4;
        border: 1px solid #86efac;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        color: #166534;
        margin-bottom: 18px;
        text-align: center;
    }

    .ca-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 5px;
    }

    .ca-input-wrap { position: relative; }

    .ca-input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        pointer-events: none;
    }

    .ca-input {
        width: 100%;
        padding: 11px 12px 11px 38px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s ease;
        outline: none;
    }

    .ca-input:focus {
        border-color: #0A4D8C;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(10, 77, 140, 0.1);
    }

    .ca-input::placeholder { color: #94a3b8; }

    .ca-error {
        font-size: 11px;
        color: #dc2626;
        margin-top: 4px;
    }

    .ca-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #0A4D8C, #1E6DB8);
        color: #ffffff;
        border: none;
        border-radius: 9px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 20px;
        letter-spacing: 0.2px;
    }

    .ca-btn:hover {
        background: linear-gradient(135deg, #073A6B, #0A4D8C);
        box-shadow: 0 6px 18px rgba(10, 77, 140, 0.35);
        transform: translateY(-1px);
    }

    .ca-back {
        display: block;
        text-align: center;
        margin-top: 16px;
        font-size: 13px;
        color: #0A4D8C;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .ca-back:hover { color: #C9A84C; }

    .ca-footer {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 12px 32px;
        text-align: center;
        font-size: 11px;
        color: #94a3b8;
    }
</style>

<div class="ca-page">
    <div class="ca-card">

        <div class="ca-header">
            <img src="{{ asset('images/logo.png') }}" alt="Comunal Aprende" class="ca-logo"
                 onerror="this.style.display='none'">
            <div class="ca-brand">Comunal Aprende</div>
            <div class="ca-tagline">Colombia · Formación Comunitaria</div>
        </div>

        <div class="ca-body">
            <div class="ca-icon">🔐</div>
            <h1 class="ca-title">Recuperar contraseña</h1>
            <p class="ca-desc">Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>

            @if (session('status'))
                <div class="ca-status">
                    ✅ Te hemos enviado el enlace de recuperación. Revisa tu correo.
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label for="email" class="ca-label">Correo electrónico</label>
                    <div class="ca-input-wrap">
                        <span class="ca-input-icon">✉️</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus placeholder="ejemplo@correo.com" class="ca-input" />
                    </div>
                    @error('email')
                        <p class="ca-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="ca-btn">
                    📨 &nbsp; Enviar enlace de recuperación
                </button>
            </form>

            <a href="{{ route('login') }}" class="ca-back">← Volver al inicio de sesión</a>
        </div>

        <div class="ca-footer">© {{ date('Y') }} Comunal Aprende · Colombia</div>
    </div>
</div>
</x-guest-layout>