<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS desde CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Fondo con degradado y desenfoque */
        body {
            background: url('https://source.unsplash.com/1920x1080/?technology,business') no-repeat center center/cover;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center bg-gray-900">

    <div class="relative w-full max-w-md p-8 rounded-lg shadow-2xl bg-white/10 backdrop-blur-lg border border-white/20 text-white">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <x-application-logo class="w-16 h-16 text-white" />
        </div>

        <!-- Título -->
        <h2 class="text-2xl font-semibold text-center mb-4">INICIAR SESION</span></h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Usuario -->
            <div>
                <x-input-label for="username" class="text-gray-200" :value="__('Usuario')" />
                <x-text-input id="username" class="block mt-1 w-full bg-gray-800 text-white border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm" name="username" :value="old('username')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-400" />
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" class="text-gray-200" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full bg-gray-800 text-white border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Recordar sesión y Ver contraseña -->
            <div class="flex items-center justify-between mt-4">
                <label for="show_password" class="inline-flex items-center text-sm text-gray-300">
                    <input id="show_password" type="checkbox" class="rounded border-gray-500 text-indigo-500 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2">Ver contraseña</span>
                </label>
                <a href="#" class="text-sm text-indigo-400 hover:text-indigo-300">¿Olvidaste tu contraseña?</a>
            </div>

            <!-- Botón de acceso -->
            <div class="mt-6">
                <button type="submit" class="w-full px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg shadow-lg transition duration-300">
                    {{ __('Ingresar') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('show_password').addEventListener('change', function() {
            var passwordField = document.getElementById('password');
            passwordField.type = this.checked ? 'text' : 'password';
        });
    </script>

</body>
</html>
