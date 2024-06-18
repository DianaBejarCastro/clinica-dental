@extends('layouts.menu-dashboard')
@section('title', 'Administradores')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Formulario de Registro de Administradores
            </h1>
        </div>

        <div class="flex justify-center">
            <form id="register-form" method="POST" action="{{ route('admin.register.store') }}"
                class="w-full max-w-6xl bg-white p-8 rounded-lg shadow-md">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-label for="name" value="{{ __('Nombre') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                        @error('name')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                        </div>

                    <div>
                        <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                            required autocomplete="username" />
                        @error('email')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                        <p class="text-gray-700 text-xs mt-2 mb-2">
                            {{ 'La contraseña debe tener al menos 8 caracteres, que contenga al menos una letra mayúscula, una letra minúscula y un número' }}
                        </p>
                        @error('password')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <p id="password-error" class="text-red-500 mt-2 hidden">Las contraseñas no coinciden. Por favor,
                            verifica.</p>
                    </div>
                </div>
                <!-- Datos de usuario -->
                <!-- Datos de administrador -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- CI Field -->
                    <div class="mb-4">
                        <x-label for="password" value="{{ __('C.I.') }}" />
                        <input type="text" id="ci" name="ci" placeholder="CI" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('ci')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                        </div>

                    <!-- Day of Birth Field -->
                    <div class="mb-4">
                        <x-label for="password" value="{{ __('Fecha de nacimiento') }}" />
                        <input type="date" id="day_of_birth" name="day_of_birth" placeholder="Fecha de nacimiento"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('day_of_birth')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                        </div>

                    <!-- Address Field -->
                    <div class="mb-4">
                        <x-label for="password" value="{{ __('Dirección') }}" />
                        <input type="text" id="address" name="address" placeholder="Dirección" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('address')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="password" value="{{ __('Numero de Telefono') }}" />
                        <input type="text" id="phone" name="phone" placeholder="Numero de Telefono" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('phone')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Center ID Field -->
                    <div class="mb-4">
                        <x-label for="password" value="{{ __('Sucursal') }}" />
                        <select id="center_id" name="center_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Seleccione una sucursal</option>
                            @foreach ($centers as $center)
                                <option value="{{ $center->id }}">{{ $center->name_branch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <x-label for="password" value="{{ __('Rol') }}" />
                        <select id="role_id" name="role_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Seleccione un rol</option>
                            <option value="1">Super Admin</option>
                            <option value="2">Admin</option>
                        </select>
                    </div>

                </div>
        </div>

        <x-button
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-20 rounded mt-6 md:ml-4 open-modal-button">
            {{ __('Registrarse') }}
        </x-button>
        </form>
    </div>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var passwordConfirmation = document.getElementById('password_confirmation').value;
            var passwordError = document.getElementById('password-error');

            if (password !== passwordConfirmation) {
                event.preventDefault();
                passwordError.classList.remove('hidden');
            } else {
                passwordError.classList.add('hidden');
            }
        });
    </script>
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Errores de validación',
                html: '<ul>' +
                    @foreach ($errors->all() as $error)
                        '<li>{{ $error }}</li>' +
                    @endforeach
                '</ul>'
            });
        </script>
    @endif
@endsection
