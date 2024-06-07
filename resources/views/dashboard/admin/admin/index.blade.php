@extends('layouts.menu-dashboard')
@section('title', 'Administradores')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Administradores
            </h1>
            <button
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                Registrar Administrador
            </button>
        </div>

    </div>
    <!-- Empieza tabla -->
    <table id="admins-table" class="min-w-full bg-white max-h-96" width="100%">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                <th class="py-2 px-2 text-left ">C.I.</th>
                <th class="py-2 px-2 text-left">Nombre(s) </th>
                <th class="py-2 px-2 text-left">Apellidos</th>
                <th class="py-2 px-2 text-left w-10">Sucursal</th>
                <th class="py-2 px-2 text-left w-10">Acciones</th> <!-- Espacio para los botones "Editar" y "Eliminar" -->
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($admins as $admin)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="">
                        <button class="" onclick="showInfo(this)" 
                            data-ci="{{ $admin->ci }}"
                            data-is-active="{{ $admin->is_active }}" data-created-at="{{ $admin->created_at }}"
                            data-updated-at="{{ $admin->updated_at }}">
                            <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                        </button>
                    </td>
                    <td class="py-2 px-2">{{ $admin->ci }}</td>
                    <td class="py-2 px-2">{{ $admin->name }}</td>
                    <td class="py-2 px-2">{{ $admin->last_name }}</td>
                    <td class="py-2 px-2">{{ $admin->center_id }}</td>
                    <td class="py-2 px-2">
                        <button onclick="editAdmin({{ $admin->id }})">
                            <img src="{{ asset('img/table/boton-editar.png') }}" alt="editar" class="w-6 h-6">
                        </button>
                        <button class="">
                            <img src="{{ asset('img/table/borrar.png') }}" alt="eliminar" class="w-6 h-6">
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Termina tabla -->
    <script>
        $(document).ready(function() {
            $('#admins-table').DataTable({
                language: spanishLanguageConfig,
            });
            // Ajustar el ancho del <select> después de la inicialización de DataTable
            $('select[name="admins-table_length"]').addClass('w-24');
        });
        // Pasar la ruta y el token CSRF a JavaScript
        var storeRoute = "{{ route('centers.store') }}";
        var csrfToken = '{{ csrf_token() }}';
    </script>
@endsection