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
        color: #0A4D8C;
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
        color: #94a3b8;
        pointer-events: none;
        display: flex;
        align-items: center;
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

    .ca-input-noicon {
        width: 100%;
        padding: 11px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
        transition: all 0.2s ease;
        outline: none;
    }

    .ca-input:focus,
    .ca-input-noicon:focus {
        border-color: #0A4D8C;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(10, 77, 140, 0.1);
    }

    .ca-input::placeholder,
    .ca-input-noicon::placeholder { color: #94a3b8; }

    .ca-eye {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        background: none;
        border: none;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: color 0.2s;
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
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

            <div class="ca-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>

            <h1 class="ca-title">Nueva contraseña</h1>
            <p class="ca-desc">Crea una contraseña segura para proteger tu cuenta.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="ca-field">
                    <label for="email" class="ca-label">Correo electrónico</label>
                    <div class="ca-input-wrap">
                        <span class="ca-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <input id="email" type="email" name="email"
                               value="{{ old('email', $request->email) }}"
                               required autofocus autocomplete="username"
                               class="ca-input" />
                    </div>
                    @error('email')
                        <p class="ca-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nueva contraseña -->
                <div class="ca-field">
                    <label for="password" class="ca-label">Nueva contraseña</label>
                    <div class="ca-input-wrap">
                        <span class="ca-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input id="password" type="password" name="password"
                               required autocomplete="new-password"
                               placeholder="Mínimo 8 caracteres"
                               class="ca-input" />
                        <button type="button" class="ca-eye" onclick="togglePass('password', 'icon-eye-1', 'icon-eye-off-1')">
                            <svg id="icon-eye-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="icon-eye-off-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <path d="m14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
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
                        <span class="ca-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <input id="password_confirmation" type="password"
                               name="password_confirmation"
                               required autocomplete="new-password"
                               placeholder="Repite tu contraseña"
                               class="ca-input" />
                        <button type="button" class="ca-eye" onclick="togglePass('password_confirmation', 'icon-eye-2', 'icon-eye-off-2')">
                            <svg id="icon-eye-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg id="icon-eye-off-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 style="display:none">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                                <path d="m14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="ca-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="ca-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Restablecer contraseña
                </button>
            </form>
        </div>

        <div class="ca-footer">© {{ date('Y') }} Comunal Aprende · Colombia</div>
    </div>
</div>

<script>
function togglePass(fieldId, eyeId, eyeOffId) {
    const input = document.getElementById(fieldId);
    const eye = document.getElementById(eyeId);
    const eyeOff = document.getElementById(eyeOffId);
    if (input.type === 'password') {
        input.type = 'text';
        eye.style.display = 'none';
        eyeOff.style.display = 'block';
    } else {
        input.type = 'password';
        eye.style.display = 'block';
        eyeOff.style.display = 'none';
    }
}
</script>
</x-guest-layout>