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
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')"
                            required autocomplete="new-password" />
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

                    <!-- Tipo de Identificación -->
                    <div class="mb-4">
                        <x-label for="identification_number" value="{{ __('Numero de identificación') }}" />
                        <input type="text" id="ci" name="identification_number" placeholder=""
                            value="{{ old('identification_number') }}" required
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
                            <option value="Cedula de Identidad" @if (old('identification_type') == 'Cedula de Identidad') selected @endif>Cedula de
                                Identidad</option>
                            <option value="Pasaporte" @if (old('identification_type') == 'Pasaporte') selected @endif>Pasaporte</option>
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
                            <option value="Femenino" @if (old('gender') == 'Femenino') selected @endif>Femenino</option>
                            <option value="Masculino" @if (old('gender') == 'Masculino') selected @endif>Masculino</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="mb-4">
                        <x-label for="date_of_birth" value="{{ __('Fecha de Nacimiento') }}" />
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('date_of_birth')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                        <div class="">
                            <span class="text-xs text-gray-500" id="age"></span>
                        </div>
                    </div>

                    <!-- Edad (Calculada) -->

                    <!-- Dirección -->
                    <div class="mb-4">
                        <x-label for="address" value="{{ __('Dirección') }}" />
                        <input type="text" id="address" name="address" placeholder="Dirección"
                            value="{{ old('address') }}" required
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
                    <!-- Sucursal -->
                    <div class="mb-4">
                        <x-label for="center_id" value="{{ __('Sucursal') }}" />
                        <select id="center_id" name="center_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Seleccione una sucursal</option>
                            @foreach ($centers as $center)
                                <option value="{{ $center->id }}" @if (old('center_id') == $center->id) selected @endif>
                                    {{ $center->name_branch }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="border-b border-gray-300 border-2 my-4"></div>
                <h2 class="text-lg font-semibold mb-2">Datos Contacto de emergencia </h2>
                <!-- Datos de contacto de emergencia 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-2 mt-2">
                        <h2 class="text-lg font-semibold ">Contacto de emergencia 1 (Obligatorio)</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

                    <div>
                        <x-label for="emergency_name_1" value="{{ __('Nombre Contacto de Emergencia 1') }}" />
                        <x-input id="emergency_name_1" class="block mt-1 w-full" type="text" name="emergency_name_1"
                            :value="old('emergency_name_1')" required />
                        @error('emergency_name_1')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="emergency_relationship_1" value="{{ __('Relación Contacto de Emergencia 1') }}" />
                        <select id="emergency_relationship_1" name="emergency_relationship_1"
                            class="block mt-1 w-full border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                            required>
                            <option value="" disabled selected>Selecciona una relación</option>
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                            <option value="Hermano/a">Hermano/a</option>
                            <option value="Tío/a">Tío/a</option>
                            <option value="Primo/a">Primo/a</option>
                            <option value="Amigo/a">Amigo/a</option>
                            <option value="Otro/a">Otro/a</option>
                        </select>
                        @error('emergency_relationship_1')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="emergency_address_1" value="{{ __('Dirección de Contacto de Emergencia 1') }}" />
                        <input type="text" id="emergency_address_1" name="emergency_address_1"
                            placeholder="Dirección de Contacto de Emergencia 1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('emergency_address_1')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="emergency_phone_1" value="{{ __('Teléfono Contacto de Emergencia 1') }}" />
                        <x-input id="emergency_phone_1" class="block mt-1 w-full" type="text"
                            name="emergency_phone_1" :value="old('emergency_phone_1')" required />
                        @error('emergency_phone_1')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <h2 class="text-lg font-semibold mb-3 mt-2 ">Contacto de emergencia 2 (Opcional)</h2>
                <!-- Botón para añadir segundo contacto de emergencia -->
                <div class="mb-4">
                    <label for="add_second_emergency_contact" class="inline-flex items-center">
                        <input type="checkbox" id="add_second_emergency_contact" name="add_second_emergency_contact"
                            class="form-checkbox h-5 w-5 text-blue-600" @if (old('add_second_emergency_contact')) checked @endif>
                        <span class="ml-2 text-gray-700">Añadir Segundo Contacto de Emergencia</span>
                    </label>
                </div>



                <!-- Contacto de Emergencia 2 -->
                <div id="second_emergency_contact" style="display: none;">
                    <h2 class="text-lg font-semibold mb-2">Datos Contacto de Emergencia 2</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label for="emergency_name_2" value="{{ __('Nombre Contacto de Emergencia 2') }}" />
                            <x-input id="emergency_name_2" class="block mt-1 w-full" type="text"
                                name="emergency_name_2" :value="old('emergency_name_2')" />
                            @error('emergency_name_2')
                                <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-label for="emergency_relationship_2"
                                value="{{ __('Relación Contacto de Emergencia 2') }}" />
                            <select id="emergency_relationship_2" name="emergency_relationship_2"
                                class="block mt-1 w-full border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="" disabled selected>Selecciona una relación</option>
                                <option value="Padre">Padre</option>
                                <option value="Madre">Madre</option>
                                <option value="Hermano/a">Hermano/a</option>
                                <option value="Tío/a">Tío/a</option>
                                <option value="Primo/a">Primo/a</option>
                                <option value="Amigo/a">Amigo/a</option>
                                <option value="Otro/a">Otro/a</option>
                            </select>
                            @error('emergency_relationship_2')
                                <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-label for="emergency_address_2"
                                value="{{ __('Dirección de Contacto de Emergencia 2') }}" />
                            <input type="text" id="emergency_address_2" name="emergency_address_2"
                                placeholder="Dirección de Contacto de Emergencia 2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('emergency_address_2')
                                <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-label for="emergency_phone_2" value="{{ __('Teléfono Contacto de Emergencia 2') }}" />
                            <x-input id="emergency_phone_2" class="block mt-1 w-full" type="text"
                                name="emergency_phone_2" :value="old('emergency_phone_2')" />
                            @error('emergency_phone_2')
                                <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <x-button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Registrar') }}
                    </x-button>
                </div>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('add_second_emergency_contact');
                const secondContactForm = document.getElementById('second_emergency_contact');

                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        secondContactForm.style.display = 'block';
                    } else {
                        secondContactForm.style.display = 'none';
                    }
                });

                const dateOfBirthInput = document.getElementById('date_of_birth');
                const ageSpan = document.getElementById('age');

                dateOfBirthInput.addEventListener('change', function() {
                    const birthDate = new Date(dateOfBirthInput.value);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDifference = today.getMonth() - birthDate.getMonth();

                    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate
                            .getDate())) {
                        age--;
                    }

                    ageSpan.textContent = `Edad: ${age} años`;
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const checkbox = document.getElementById('add_second_emergency_contact');
                const secondContactForm = document.getElementById('second_emergency_contact');

                // Al cargar la página, verificar si el checkbox está marcado y mostrar el formulario correspondientemente
                if (checkbox.checked) {
                    secondContactForm.style.display = 'block';
                } else {
                    secondContactForm.style.display = 'none';
                }

                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        secondContactForm.style.display = 'block';
                    } else {
                        secondContactForm.style.display = 'none';
                    }
                });
            });
        </script>
    @endsection
