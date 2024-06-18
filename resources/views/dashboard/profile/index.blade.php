@extends('layouts.menu-dashboard')
@section('title', 'Perfil')
@section('content-dashboard')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gradient-to-b from-sky-600 via-blue-600 to-indigo-400 py-4 px-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Perfil de Usuario</h1>
            <a href="{{ route('profile.edit') }}">
                <img src="{{ asset('img/profile/config.png') }}" alt="icono" class="w-8 h-auto">
            </a>
        </div>
        
        
        
        
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-2">Información de usuario</h2>
            <div class="mb-6 lg:flex lg:items-center">
                <div class="lg:w-1/3 mr-6">
                    <div class="rounded-full overflow-hidden w-24 h-24 ">
                        <img src="{{ asset('img/profile/id.png') }}" alt="icono" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="lg:w-2/3">
                    
                    <p><strong class="mr-24">Nombre:</strong> {{ $user->name }}</p>
                    <p><strong class="mr-4">Correo Electrónico:</strong> {{ $user->email }}</p>
                </div>
                
            </div>
            <div class="border-b border-gray-300 border-2 my-4"></div>


            @if($role == 1 || $role == 2)
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Datos de Administrador</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <p><strong>CI:</strong> {{ $relatedData['ci'] ?? 'N/A' }}</p>
                    <p><strong>Fecha de nacimiento:</strong> {{ $relatedData['day_of_birth'] ?? 'N/A' }}</p>
                    @if (isset($relatedData['day_of_birth']))
                @php
                    $birthDate = \Carbon\Carbon::parse($relatedData['day_of_birth']);
                    $currentDate = \Carbon\Carbon::now();
                    $age = $birthDate->diffInYears($currentDate);
                @endphp
                <p><strong>Edad:</strong> {{ $age }} años</p>
            @else
                <p><strong>Edad:</strong> N/A</p>
            @endif
                    <p><strong>Dirección:</strong> {{ $relatedData['address'] ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $relatedData['phone'] ?? 'N/A' }}</p>
                    <p><strong>Estado:</strong> {{ $relatedData['is_active'] ? 'Activo' : 'No activo' }}</p>
                    <p><strong>Sucursal:</strong> {{ $relatedData['center_name'] ?? 'N/A' }}</p>
                    <p><strong>Creado en:</strong> {{ $relatedData['created_at'] ?? 'N/A' }}</p>
                </div>
            </div>
            @elseif($role == 3)
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Datos de Dentista</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <p><strong>CI:</strong> {{ $relatedData['ci'] ?? 'N/A' }}</p>
                    <p><strong>Fecha de nacimiento:</strong> {{ $relatedData['day_of_birth'] ?? 'N/A' }}</p>
                    @if (isset($relatedData['day_of_birth']))
                @php
                    $birthDate = \Carbon\Carbon::parse($relatedData['day_of_birth']);
                    $currentDate = \Carbon\Carbon::now();
                    $age = $birthDate->diffInYears($currentDate);
                @endphp
                <p><strong>Edad:</strong> {{ $age }} años</p>
            @else
                <p><strong>Edad:</strong> N/A</p>
            @endif
                    <p><strong>Dirección:</strong> {{ $relatedData['address'] ?? 'N/A' }}</p>
                    <p><strong>Teléfono:</strong> {{ $relatedData['phone'] ?? 'N/A' }}</p>
                    <p><strong>Estado:</strong> {{ $relatedData['is_active'] ? 'Activo' : 'No activo' }}</p>
                    <p><strong>Sucursal:</strong> {{ $relatedData['center_name'] ?? 'N/A' }}</p>
                    <p><strong>Creado en:</strong> {{ $relatedData['updated_at'] ?? 'N/A' }}</p>
                </div>
            </div>
            @elseif($role == 4)
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Datos de Paciente</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <p><strong>Número de identificación:</strong> {{ $relatedData['identification_number'] ?? 'N/A' }}</p>
                <p><strong>Tipo de identificación:</strong> {{ $relatedData['identification_type'] ?? 'N/A' }}</p>
                <p><strong>Género:</strong> {{ $relatedData['gender'] ?? 'N/A' }}</p>
                <p><strong>Fecha de nacimiento:</strong> {{ $relatedData['day_of_birth'] ?? 'N/A' }}</p>
                @if (isset($relatedData['day_of_birth']))
                @php
                    $birthDate = \Carbon\Carbon::parse($relatedData['day_of_birth']);
                    $currentDate = \Carbon\Carbon::now();
                    $age = $birthDate->diffInYears($currentDate);
                @endphp
                <p><strong>Edad:</strong> {{ $age }} años</p>
            @else
                <p><strong>Edad:</strong> N/A</p>
            @endif
                <p><strong>Dirección:</strong> {{ $relatedData['address'] ?? 'N/A' }}</p>
                <p><strong>Teléfono:</strong> {{ $relatedData['phone'] ?? 'N/A' }}</p>
                <p><strong>Sucursal:</strong> {{ $relatedData['center_name'] ?? 'N/A' }}</p>
                <p><strong>Creado en:</strong> {{ $relatedData['updated_at'] ?? 'N/A' }}</p>
            </div>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection

