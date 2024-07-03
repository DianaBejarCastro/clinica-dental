@extends('layouts.menu-dashboard')
@section('title', 'Dentista')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Editar Datos del Paciente
            </h1>
        </div>

        <h2 class="text-sm sm:text-base text-gray-600 mb-4">Editar Contraseña</h2>
        <form class="w-full max-w-6xl bg-white p-8 rounded-lg shadow-md" method="POST"
            action="{{ route('patient.changePassword') }}">
            @csrf
            <div class="mt-4">
                <x-label for="password" value="{{ __('Nueva contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <p class="text-gray-700 text-xs mt-2 mb-2">
                    {{ 'La contraseña debe tener al menos 8 caracteres, que contenga al menos una letra mayúscula, una letra minúscula y un número' }}
                </p>
                @error('password')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar nueva contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                    required autocomplete="new-password" />
                @if ($errors->has('password'))
                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div>
                <x-button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-20 rounded mt-6">
                    {{ __('Cambiar Contraseña') }}
                </x-button>
            </div>
        </form>

        <h2 class="text-sm sm:text-base text-gray-600 mb-4 mt-4">Editar datos personales</h2>

        <div class="flex justify-center">
            <form id="register-form" method="POST" action="{{ route('patient.update') }}"
                class="w-full max-w-6xl bg-white p-8 rounded-lg shadow-md">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-label for="name" value="{{ __('Nombre') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name"
                            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        @error('name')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                            value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        @error('email')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Datos de usuario -->
                <!-- Datos de paciente -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- CI Field -->
                    <div class="mb-4">
                        <x-label for="identification_number" value="{{ __('Numero de identificación') }}" />
                        <input type="text" id="ci" name="identification_number"
                            value="{{ old('identification_number', $patient->identification_number) }}" placeholder=""
                            required
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
                            <option value="Cedula de Identidad"
                                {{ old('identification_type', $patient->identification_type) == 'Cedula de Identidad' ? 'selected' : '' }}>
                                Cedula de Identidad</option>
                            <option value="Pasaporte"
                                {{ old('identification_type', $patient->identification_type) == 'Pasaporte' ? 'selected' : '' }}>
                                Pasaporte</option>
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
                            <option value="Femenino" {{ old('gender', $patient->gender) == 'Femenino' ? 'selected' : '' }}>
                                Femenino</option>
                            <option value="Masculino"
                                {{ old('gender', $patient->gender) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="mb-4">
                        <x-label for="date_of_birth" value="{{ __('Fecha de Nacimiento') }}" />
                        <input type="date" id="date_of_birth" name="date_of_birth"
                            value="{{ old('date_of_birth', $patient->date_of_birth) }}" required
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
                        <x-label for="address" value="{{ __('Dirección') }}" />
                        <input type="text" id="address" name="address" value="{{ old('address', $patient->address) }}"
                            placeholder="Dirección" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('address')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Teléfono -->
                    <div class="mb-4">
                        <x-label for="phone" value="{{ __('Teléfono') }}" />
                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                            value="{{ old('phone', $patient->phone) }}" required />
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
                                <option value="{{ $center->id }}"
                                    {{ old('center_id', $patient->center_id) == $center->id ? 'selected' : '' }}>
                                    {{ $center->name_branch }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <x-button
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-20 rounded mt-6 md:ml-4 open-modal-button">
                    {{ __('Editar Datos') }}
                </x-button>
            </form>
        </div>
        <!-- contacto de emergencia-->
        <h2 class="text-sm sm:text-base text-gray-600 mb-4 mt-4">Editar Contacto(s) de emergencia</h2>


        <div class="flex justify-center">
            <form id="emergency-contact-form" method="POST" action="{{ route('emergency-contacts.update', $patient->id) }}"
                  class="w-full max-w-6xl bg-white p-8 rounded-lg shadow-md">
                @csrf
                @method('PUT')
        
                <div class="mb-4">
                    <h2 class="text-lg font-semibold">Contacto de emergencia 1 (Obligatorio)</h2>
                    
                </div>
                
                <!-- Contacto de Emergencia 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-label for="emergency_name_1" value="{{ __('Nombre Contacto de Emergencia 1') }}" />
                        <x-input id="emergency_name_1" class="block mt-1 w-full" type="text" name="emergency_name_1"
                                 :value="$emergencyContacts[0]->name ?? old('emergency_name_1')" required />
                        @error('emergency_name_1')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-label for="emergency_relationship_1" value="{{ __('Relación Contacto de Emergencia 1') }}" />
                        <select id="emergency_relationship_1" name="emergency_relationship_1"
                                class="block mt-1 w-full border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="Padre" {{ old('emergency_relationship_1', $emergencyContacts[0]->relationship ?? '') == 'Padre' ? 'selected' : '' }}>Padre</option>
                            <option value="Madre" {{ old('emergency_relationship_1', $emergencyContacts[0]->relationship ?? '') == 'Madre' ? 'selected' : '' }}>Madre</option>
                            <option value="Hermano/a" {{ old('emergency_relationship_1', $emergencyContacts[0]->relationship ?? '') == 'Hermano/a' ? 'selected' : '' }}>Hermano/a</option>
                            <option value="Tío/a" {{ old('emergency_relationship_1', $emergencyContacts[0]->relationship ?? '') == 'Tío/a' ? 'selected' : '' }}>Tío/a</option>
                            <option value="Primo/a" {{ old('emergency_relationship_1', $emergencyContacts[0]->relationship ?? '') == 'Primo/a' ? 'selected' : '' }}>Primo/a</option>
                            <option value="Amigo/a" {{ old('emergency_relationship_1', $emergencyContacts[0]->relationship ?? '') == 'Amigo/a' ? 'selected' : '' }}>Amigo/a</option>
                            <option value="Otro/a" {{ old('emergency_relationship_1', $emergencyContacts[0]->relationship ?? '') == 'Otro/a' ? 'selected' : '' }}>Otro/a</option>
                        </select>
                        @error('emergency_relationship_1')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-label for="emergency_address_1" value="{{ __('Dirección de Contacto de Emergencia 1') }}" />
                        <input type="text" id="emergency_address_1" name="emergency_address_1"
                               value="{{ old('emergency_address_1', $emergencyContacts[0]->address ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('emergency_address_1')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-label for="emergency_phone_1" value="{{ __('Teléfono Contacto de Emergencia 1') }}" />
                        <x-input id="emergency_phone_1" class="block mt-1 w-full" type="text" name="emergency_phone_1"
                                 :value="old('emergency_phone_1', $emergencyContacts[0]->phone ?? '')" required />
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
                            <x-label for="emergency_name_2" value="{{ __('Nombre de Contacto de Emergencia 2') }}" />
                            <input type="text" id="emergency_name_2" name="emergency_name_2"
                                   value="{{ old('emergency_name_2', $emergencyContacts[1]->name ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('emergency_name_2')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-label for="emergency_relationship_2" value="{{ __('Relación Contacto de Emergencia 2') }}" />
                            <select id="emergency_relationship_2" name="emergency_relationship_2"
                                    class="block mt-1 w-full border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="Padre" {{ old('emergency_relationship_2', $emergencyContacts[1]->relationship ?? '') == 'Padre' ? 'selected' : '' }}>Padre</option>
                                <option value="Madre" {{ old('emergency_relationship_2', $emergencyContacts[1]->relationship ?? '') == 'Madre' ? 'selected' : '' }}>Madre</option>
                                <option value="Hermano/a" {{ old('emergency_relationship_2', $emergencyContacts[1]->relationship ?? '') == 'Hermano/a' ? 'selected' : '' }}>Hermano/a</option>
                                <option value="Tío/a" {{ old('emergency_relationship_2', $emergencyContacts[1]->relationship ?? '') == 'Tío/a' ? 'selected' : '' }}>Tío/a</option>
                                <option value="Primo/a" {{ old('emergency_relationship_2', $emergencyContacts[1]->relationship ?? '') == 'Primo/a' ? 'selected' : '' }}>Primo/a</option>
                                <option value="Amigo/a" {{ old('emergency_relationship_2', $emergencyContacts[1]->relationship ?? '') == 'Amigo/a' ? 'selected' : '' }}>Amigo/a</option>
                                <option value="Otro/a" {{ old('emergency_relationship_2', $emergencyContacts[1]->relationship ?? '') == 'Otro/a' ? 'selected' : '' }}>Otro/a</option>
                            </select>
                            @error('emergency_relationship_2')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-label for="emergency_address_2" value="{{ __('Dirección Contacto de Emergencia 2') }}" />
                            <input type="text" id="emergency_address_2" name="emergency_address_2"
                                   value="{{ old('emergency_address_2', $emergencyContacts[1]->address ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('emergency_address_2')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <x-label for="emergency_phone_2" value="{{ __('Teléfono Contacto de Emergencia 2') }}" />
                            <input type="text" id="emergency_phone_2" name="emergency_phone_2"
                                   value="{{ old('emergency_phone_2', $emergencyContacts[1]->phone ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            @error('emergency_phone_2')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
                <x-button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-20 rounded mt-6 md:ml-4 open-modal-button">
                {{ __('Editar Datos') }}
                </x-button>
            </form>
        </div>
        
        
    </div>
    <script>
        document.getElementById('date_of_birth').addEventListener('change', function() {
            var dob = new Date(this.value);
            var ageDifMs = Date.now() - dob.getTime();
            var ageDate = new Date(ageDifMs); // miliseconds from epoch
            var age = Math.abs(ageDate.getUTCFullYear() - 1970);
            document.getElementById('age').textContent = age;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar u ocultar el segundo contacto de emergencia al cargar la página
            const addSecondEmergencyContact = document.getElementById('add_second_emergency_contact');
            const secondEmergencyContact = document.getElementById('second_emergency_contact');

            addSecondEmergencyContact.addEventListener('change', function() {
                secondEmergencyContact.style.display = this.checked ? 'block' : 'none';
            });
        });
    </script>
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
