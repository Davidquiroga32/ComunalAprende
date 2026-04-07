@extends('layouts.auth')

@section('title', 'Iniciar Sesión - Comunal Aprende')

@section('content')

    <div class="auth-container">
        <div class="auth-card">

            <div class="auth-header">
                <a href="{{ route('inicio') }}" style="display:inline-block;margin-bottom:.25rem;">
                    <img src="{{ asset('images/logo.png') }}"
                        alt="Comunal Aprende"
                        style="height:120px;width:auto;object-fit:contain;"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="auth-logo" style="display:none;">CA</div>
                </a>
                <h1 class="auth-title">Bienvenido de nuevo</h1>
                <p class="auth-subtitle">Ingresa a tu cuenta para continuar aprendiendo</p>
            </div>

            {{-- MENSAJES DE ERROR DE SESIÓN --}}
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div class="alert-content">{{ session('error') }}</div>
                </div>
            @endif

            {{-- FORMULARIO DE LOGIN (Laravel Auth) --}}
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">
                        Correo electrónico <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            class="form-input @error('email') error @enderror"
                            id="email"
                            name="email"
                            placeholder="tu@email.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="form-group">
                    <label class="form-label" for="password">
                        Contraseña <span class="required">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            class="form-input @error('password') error @enderror"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

               {{-- Recuérdame y Olvidé mi contraseña --}}
                <div class="flex items-center justify-between my-4">

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="form-checkbox"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <span class="text-sm text-gray-700">
                            Recordarme
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:underline"
                        >
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif

                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary form-submit">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>

            </form>

            {{-- Footer --}}
            <div class="auth-footer">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="form-link">Regístrate aquí</a>
            </div>

        </div>
    </div>

@endsection