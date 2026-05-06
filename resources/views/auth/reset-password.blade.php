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

    .auth-body { padding: 36px 40px 40px; }

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

    .field-group { margin-bottom: 20px; }

    .field-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .input-wrap { position: relative; }

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

    .password-hint {
        font-size: 12px;
        color: #94a3b8;
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
        margin-top: 8px;
        letter-spacing: 0.3px;
    }

    .auth-btn:hover {
        background: linear-gradient(135deg, #073A6B, #0A4D8C);
        box-shadow: 0 6px 20px rgba(10, 77, 140, 0.35);
        transform: translateY(-1px);
    }

    .auth-btn:active { transform: translateY(0); }

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
                 onerror="this.style.display='none';document.getElementById('logo-fallback-r').style.display='flex';">
            <div id="logo-fallback-r" class="auth-logo-fallback" style="display:none;">🏛️</div>
            <div class="auth-brand">Comunal Aprende</div>
            <div class="auth-tagline">Colombia · Formación Comunitaria</div>
        </div>

        <div class="auth-body">
            <div class="auth-icon-wrap">🔑</div>
            <h1 class="auth-title">Nueva contraseña</h1>
            <p class="auth-subtitle">Crea una contraseña segura para proteger tu cuenta.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="field-group">
                    <label for="email" class="field-label">Correo electrónico</label>
                    <div class="input-wrap">
                        <span class="input-icon">✉️</span>
                        <input id="email" type="email" name="email"
                               value="{{ old('email', $request->email) }}"
                               required autofocus autocomplete="username"
                               class="auth-input" />
                    </div>
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nueva contraseña -->
                <div class="field-group">
                    <label for="password" class="field-label">Nueva contraseña</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input id="password" type="password" name="password"
                               required autocomplete="new-password"
                               placeholder="Mínimo 8 caracteres"
                               class="auth-input" />
                    </div>
                    <p class="password-hint">Usa letras, números y símbolos para mayor seguridad.</p>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div class="field-group">
                    <label for="password_confirmation" class="field-label">Confirmar contraseña</label>
                    <div class="input-wrap">
                        <span class="input-icon">🔒</span>
                        <input id="password_confirmation" type="password"
                               name="password_confirmation"
                               required autocomplete="new-password"
                               placeholder="Repite tu contraseña"
                               class="auth-input" />
                    </div>
                    @error('password_confirmation')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="auth-btn">
                    ✅ &nbsp; Restablecer contraseña
                </button>
            </form>
        </div>

        <div class="auth-footer">© {{ date('Y') }} Comunal Aprende · Colombia</div>
    </div>
</div>
</x-guest-layout>