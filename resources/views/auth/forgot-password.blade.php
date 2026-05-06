<x-guest-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500&display=swap');

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #071D36 0%, #0A4D8C 60%, #1E6DB8 100%);
        padding: 24px 16px;
        font-family: 'Inter', sans-serif;
    }

    .auth-card {
        width: 100%;
        max-width: 440px;
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 24px 64px rgba(7, 29, 54, 0.4);
    }

    .auth-header {
        background: linear-gradient(135deg, #071D36 0%, #0A4D8C 100%);
        padding: 36px 40px 28px;
        text-align: center;
        border-bottom: 3px solid #C9A84C;
    }

    .auth-logo {
        height: 80px;
        width: auto;
        object-fit: contain;
        margin-bottom: 16px;
        filter: brightness(0) invert(1);
    }

    .auth-logo-fallback {
        width: 64px;
        height: 64px;
        background: rgba(201, 168, 76, 0.15);
        border: 2px solid #C9A84C;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 28px;
    }

    .auth-brand {
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.3px;
    }

    .auth-tagline {
        font-size: 11px;
        color: rgba(255,255,255,0.45);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-top: 4px;
    }

    .auth-body {
        padding: 36px 40px 40px;
    }

    .auth-icon-wrap {
        width: 64px;
        height: 64px;
        background: #EBF3FF;
        border: 2px solid #c5d9f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 26px;
    }

    .auth-title {
        font-family: 'Poppins', sans-serif;
        font-size: 22px;
        font-weight: 700;
        color: #071D36;
        text-align: center;
        margin: 0 0 8px;
    }

    .auth-subtitle {
        font-size: 14px;
        color: #64748b;
        text-align: center;
        line-height: 1.6;
        margin: 0 0 28px;
    }

    .status-msg {
        background: #f0fdf4;
        border: 1px solid #86efac;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        color: #166534;
        margin-bottom: 20px;
        text-align: center;
    }

    .field-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .input-wrap {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 16px;
        pointer-events: none;
    }

    .auth-input {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 15px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s ease;
        outline: none;
        box-sizing: border-box;
    }

    .auth-input:focus {
        border-color: #0A4D8C;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(10, 77, 140, 0.1);
    }

    .auth-input::placeholder { color: #94a3b8; }

    .field-error {
        font-size: 12px;
        color: #dc2626;
        margin-top: 6px;
    }

    .auth-btn {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #0A4D8C, #1E6DB8);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 24px;
        letter-spacing: 0.3px;
    }

    .auth-btn:hover {
        background: linear-gradient(135deg, #073A6B, #0A4D8C);
        box-shadow: 0 6px 20px rgba(10, 77, 140, 0.35);
        transform: translateY(-1px);
    }

    .auth-btn:active { transform: translateY(0); }

    .auth-back {
        display: block;
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: #0A4D8C;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .auth-back:hover { color: #C9A84C; }

    .auth-footer {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 14px 40px;
        text-align: center;
        font-size: 11px;
        color: #94a3b8;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-header">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Comunal Aprende"
                 class="auth-logo"
                 onerror="this.style.display='none';document.getElementById('logo-fallback').style.display='flex';">
            <div id="logo-fallback" class="auth-logo-fallback" style="display:none;">🏛️</div>
            <div class="auth-brand">Comunal Aprende</div>
            <div class="auth-tagline">Colombia · Formación Comunitaria</div>
        </div>

        <div class="auth-body">
            <div class="auth-icon-wrap">🔐</div>
            <h1 class="auth-title">Recuperar contraseña</h1>
            <p class="auth-subtitle">
                Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            @if (session('status'))
                <div class="status-msg">✅ {{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label for="email" class="field-label">Correo electrónico</label>
                    <div class="input-wrap">
                        <span class="input-icon">✉️</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            required autofocus placeholder="ejemplo@correo.com" class="auth-input" />
                    </div>
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="auth-btn">
                    📨 &nbsp; Enviar enlace de recuperación
                </button>
            </form>

            <a href="{{ route('login') }}" class="auth-back">← Volver al inicio de sesión</a>
        </div>

        <div class="auth-footer">© {{ date('Y') }} Comunal Aprende · Colombia</div>
    </div>
</div>
</x-guest-layout>