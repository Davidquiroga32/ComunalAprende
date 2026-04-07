<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-100 to-blue-200">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <!-- Reemplaza con tu logo -->
                <img src="{{ asset('images/logo.png') }}"
                        alt="Comunal Aprende"
                        style="height:120px;width:auto;object-fit:contain;"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="auth-logo" style="display:none;">CA</div>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-bold text-center text-blue-700 mb-2">
                Recuperar contraseña
            </h2>

            <p class="text-sm text-gray-500 text-center mb-6">
                Ingresa tu correo y te enviaremos un enlace para restablecerla
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Correo electrónico')" class="text-gray-700" />

                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            ✉️
                        </span>

                        <x-text-input
                            id="email"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            class="pl-10 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                            placeholder="ejemplo@gmail.com"
                        />
                    </div>

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Botón -->
                <div>
                    <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg shadow-md">
                        Enviar enlace de recuperación
                    </x-primary-button>
                </div>
            </form>

            <!-- Volver -->
            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">
                    ← Volver al inicio de sesión
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>