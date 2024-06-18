@extends('layouts.menu-dashboard')
@section('title', 'Administradores')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Editar Datos del Administrador
            </h1>
        </div>

        <h2 class="text-sm sm:text-base text-gray-600 mb-4">Editar Contraseña</h2>
        <form class="w-full max-w-6xl bg-white p-8 rounded-lg shadow-md"
        method="POST" action="{{ route('admin.changePassword') }}">
        @csrf

        <div class="mt-4">
            <x-label for="password" value="{{ __('Nueva contraseña') }}" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <p class="text-gray-700 text-xs mt-2 mb-2">
                {{ 'La contraseña debe tener al menos 8 caracteres, que contenga al menos una letra mayúscula, una letra minúscula y un número' }}
            </p>
            @error('password')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="password_confirmation" value="{{ __('Confirmar nueva contraseña') }}" />
            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
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
            <form class="w-full max-w-6xl bg-white p-8 rounded-lg shadow-md" method="POST" action="{{ route('admin.update') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-label for="name" value="{{ __('Nombre') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @error('name')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
                    </div>
            
                    <div class="mb-4">
                        <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @error('email')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
                        </div>
                </div>
            
                <!-- Datos de usuario -->
                <!-- Datos de administrador -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- CI Field -->
                    <div class="mb-4">
                        <x-label for="ci" value="{{ __('C.I.') }}" />
                        <input type="text" id="ci" name="ci" value="{{ old('ci', $admin->ci) }}" placeholder="CI" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('ci')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
        @enderror
                    </div>
            
                    <!-- Day of Birth Field -->
                    <div class="mb-4">
                        <x-label for="day_of_birth" value="{{ __('Fecha de nacimiento') }}" />
                        <input type="date" id="day_of_birth" name="day_of_birth" value="{{ old('day_of_birth', $admin->day_of_birth) }}" placeholder="Fecha de nacimiento" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('day_of_birth')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <!-- Address Field -->
                    <div class="mb-4">
                        <x-label for="address" value="{{ __('Dirección') }}" />
                        <input type="text" id="address" name="address" value="{{ old('address', $admin->address) }}" placeholder="Dirección" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('address')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="phone" value="{{ __('Numero de Telefono') }}" />
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}" placeholder="Numero de Telefono" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        @error('phone')
                        <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
            
                    <!-- Center ID Field -->
                    <div class="mb-4">
                        <x-label for="center_id" value="{{ __('Sucursal') }}" />
                        <select id="center_id" name="center_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Seleccione una sucursal</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ $center->id == old('center_id', $admin->center_id) ? 'selected' : '' }}>{{ $center->name_branch }}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <!-- Role Field -->
                    <div class="mb-4">
                        <x-label for="center_id" value="{{ __('Rol') }}" />
                        <select id="role_id" name="role_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="" disabled selected>Seleccione un rol</option>
                            <option value="1" {{ $user->roles->contains(1) ? 'selected' : '' }}>Super Admin</option>
                            <option value="2" {{ $user->roles->contains(2) ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>
            
                <x-button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-20 rounded mt-6 open-modal-button">
                    {{ __('Guardar Cambios') }}
                </x-button>
            </form>
            >
        </div>
@endsection
