@extends('layouts.menu-dashboard')
@section('title', 'Paciente')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Formulario de Registro de Paciente
            </h1>
        </div>

        <div class="flex justify-center">
            <form id="register-form" method="POST" action="{{ route('patient.register.store') }}"
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
                <!-- Datos de paciente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- CI Field -->
                    <div class="mb-4">
                        <x-label for="identification_number" value="{{ __('Numero de identificación') }}" />
                        <input type="text" id="ci" name="identification_number" placeholder="" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('identification_number')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Tipo de Identificación -->
                    <div class="mb-4">
                        <x-label for="identification_type" value="{{ __('Tipo de Identificación') }}" />
                        <select id="identification_type" name="identification_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="Cedula de Identidad">Cedula de Identidad</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                        @error('identification_type')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Género -->
                    <div class="mb-4">
                        <x-label for="gender" value="{{ __('Género') }}" />
                        <select id="gender" name="gender" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="Femenino">Femenino</option>
                            <option value="Masculino">Masculino</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="mb-4">
                        <x-label for="date_of_birth" value="{{ __('Fecha de Nacimiento') }}" />
                        <input type="date" id="date_of_birth" name="date_of_birth" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('date_of_birth')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                        <div class="">
                            <span class="text-xs text-gray-500" id="age"></span>
                         </div>
                    </div>

                    <!-- Edad (Calculada) -->
                   
                    <!-- Address Field -->
                    <div class="mb-4">
                        <x-label for="password" value="{{ __('Dirección') }}" />
                        <input type="text" id="address" name="address" placeholder="Dirección" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('address')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Teléfono -->
                    <div class="mb-4">
                        <x-label for="phone" value="{{ __('Teléfono') }}" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                            required />
                        @error('phone')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <x-label for="center_id" value="{{ __('Sucursal') }}" />
                        <select id="center_id" name="center_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Seleccione una sucursal</option>
                            @foreach ($centers as $center)
                                <option value="{{ $center->id }}">{{ $center->name_branch }}</option>
                            @endforeach
                        </select>
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

            document.getElementById('date_of_birth').addEventListener('change', function() {
                var dob = new Date(this.value);
                var ageDifMs = Date.now() - dob.getTime();
                var ageDate = new Date(ageDifMs); // miliseconds from epoch
                var age = Math.abs(ageDate.getUTCFullYear() - 1970);
                document.getElementById('age').textContent = age;
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
