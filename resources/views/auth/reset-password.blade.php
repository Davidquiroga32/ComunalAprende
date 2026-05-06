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

    .ca-body { padding: 28px 32px 24px; }

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

    .ca-field { margin-bottom: 16px; }

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
        padding: 11px 40px 11px 38px;
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

    /* Ojito */
    .ca-eye {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 16px;
        color: #94a3b8;
        background: none;
        border: none;
        padding: 0;
        line-height: 1;
        transition: color 0.2s;
        user-select: none;
    }

    .ca-eye:hover { color: #0A4D8C; }

    .ca-hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 4px;
    }

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
        margin-top: 8px;
        letter-spacing: 0.2px;
    }

    .ca-btn:hover {
        background: linear-gradient(135deg, #073A6B, #0A4D8C);
        box-shadow: 0 6px 18px rgba(10, 77, 140, 0.35);
        transform: translateY(-1px);
    }

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
            <div class="ca-icon">🔑</div>
            <h1 class="ca-title">Nueva contraseña</h1>
            <p class="ca-desc">Crea una contraseña segura para proteger tu cuenta.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="ca-field">
                    <label for="email" class="ca-label">Correo electrónico</label>
                    <div class="ca-input-wrap">
                        <span class="ca-input-icon">✉️</span>
                        <input id="email" type="email" name="email"
                               value="{{ old('email', $request->email) }}"
                               required autofocus autocomplete="username"
                               class="ca-input" style="padding-right:12px;" />
                    </div>
                    @error('email')
                        <p class="ca-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nueva contraseña -->
                <div class="ca-field">
                    <label for="password" class="ca-label">Nueva contraseña</label>
                    <div class="ca-input-wrap">
                        <span class="ca-input-icon">🔒</span>
                        <input id="password" type="password" name="password"
                               required autocomplete="new-password"
                               placeholder="Mínimo 8 caracteres"
                               class="ca-input" />
                        <button type="button" class="ca-eye" onclick="togglePass('password', this)" title="Mostrar/ocultar">
                            👁️
                        </button>
                    </div>
                    <p class="ca-hint">Usa letras, números y símbolos para mayor seguridad.</p>
                    @error('password')
                        <p class="ca-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div class="ca-field">
                    <label for="password_confirmation" class="ca-label">Confirmar contraseña</label>
                    <div class="ca-input-wrap">
                        <span class="ca-input-icon">🔒</span>
                        <input id="password_confirmation" type="password"
                               name="password_confirmation"
                               required autocomplete="new-password"
                               placeholder="Repite tu contraseña"
                               class="ca-input" />
                        <button type="button" class="ca-eye" onclick="togglePass('password_confirmation', this)" title="Mostrar/ocultar">
                            👁️
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="ca-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="ca-btn">
                    ✅ &nbsp; Restablecer contraseña
                </button>
            </form>
        </div>

        <div class="ca-footer">© {{ date('Y') }} Comunal Aprende · Colombia</div>
    </div>
</div>

<script>
function togglePass(fieldId, btn) {
    const input = document.getElementById(fieldId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>
</x-guest-layout>