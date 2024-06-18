@extends('layouts.menu-dashboard')
@section('title', 'Administradores')
@section('content-dashboard')
<div class="container mx-auto p-4 sm:p-2">
    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
            Administradores
        </h1>
        <div class="flex flex-col md:flex-row items-center">
            <form action="{{ route('admin.register') }}" method="GET">
                <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                    Registrar Administrador
                </button>
            </form>  
        </div>
    </div>
</div>


<div class="container mx-auto sm:p-2">
    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
        <div class="w-full flex justify-center md:justify-end">
            <form action="" method="GET">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ver Horarios
                </button>
            </form>
        </div>
    </div>
</div>


    <!-- Empieza tabla -->
    <table id="admins-table" class="min-w-full bg-white max-h-96" width="100%">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                <th class="py-2 px-2 text-left ">C.I.</th>
                <th class="py-2 px-2 text-left">Nombre</th>
                <th class="py-2 px-2 text-left">Sucursal</th>
                <th class="py-2 px-2 text-left w-10">Acciones</th> <!-- Espacio para los botones "Editar" y "Eliminar" -->
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($admins as $admin)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="">
                        <button class="" onclick="showInfo(this)" data-ci="{{ $admin->ci }}"
                            data-name="{{ $admin->name }}" data-center="{{ $admin->center }}"
                            data-email="{{ $admin->email }}" 
                            data-birthdate="{{ $admin->birthdate }}"
                            data-address="{{ $admin->address }}"
                            data-phone="{{ $admin->phone }}"
                            data-role="{{ $admin->role }}"
                            data-admin_created_at="{{ $admin->admin_created_at }}"
                            data-admin_updated_at="{{ $admin->admin_updated_at }}">
                            <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                        </button>
                    </td>
                    <td class="py-3 px-6">{{ $admin->ci }}</td>
                    <td class="py-3 px-6">{{ $admin->name }}</td>
                    <td class="py-3 px-6">{{ $admin->center }}</td>
                    <td class="py-3 px-6">
                        <button onclick="editAdmin('{{ $admin->id }}')">
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

        function editAdmin(adminId) {
    fetch('{{ route('admin.setEditId') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id: adminId })
    })
    .then(response => response.json())
    .then(data => {
        window.location.href = '{{ route('admin.edit.view') }}';
    })
    .catch(error => console.error('Error:', error));
}

 
        function showInfo(button) {
            var ci = button.getAttribute('data-ci');
            var name = button.getAttribute('data-name');
            var center = button.getAttribute('data-center');
            var email = button.getAttribute('data-email');
            var birthdate = button.getAttribute('data-birthdate');
            var address = button.getAttribute('data-address');
            var phone = button.getAttribute('data-phone');
            var role = button.getAttribute('data-role');
            var admin_created_at = button.getAttribute('data-admin_created_at');
            var admin_updated_at = button.getAttribute('data-admin_updated_at');

            // Mostrar los datos en un modal de SweetAlert
            Swal.fire({
                title: 'Información del Administrador',
                html: `
          <div style="display: grid; grid-template-columns: max-content 1fr; grid-row-gap: 0.5rem; justify-content: start;">
            <strong style="grid-column: 1; text-align: left;">CI:</strong>
            <span style="grid-column: 2; text-align: left;">${ci}</span>

            <strong style="grid-column: 1; text-align: left;">Nombre:</strong>
            <span style="grid-column: 2; text-align: left;">${name}</span>

            <strong style="grid-column: 1; text-align: left;">Centro:</strong>
            <span style="grid-column: 2; text-align: left;">${center}</span>

            <strong style="grid-column: 1; text-align: left;">Email:</strong>
            <span style="grid-column: 2; text-align: left;">${email}</span>

            <strong style="grid-column: 1; text-align: left;">Fecha de <br> nacimiento:</strong>
            <span style="grid-column: 2; text-align: left;">${birthdate}</span>

            <strong style="grid-column: 1; text-align: left;">Dirección:</strong>
            <span style="grid-column: 2; text-align: left;">${address}</span>

            <strong style="grid-column: 1; text-align: left;">Telefono:</strong>
            <span style="grid-column: 2; text-align: left;">${phone}</span>

            <strong style="grid-column: 1; text-align: left;">Rol:</strong>
            <span style="grid-column: 2; text-align: left;">${role}</span>

            <strong style="grid-column: 1; text-align: left;">Creado en:</strong>
            <span style="grid-column: 2; text-align: left;">${admin_created_at}</span>

            <strong style="grid-column: 1; text-align: left;">Actualizado en:</strong>
            <span style="grid-column: 2; text-align: left;">${admin_updated_at}</span>

        </div>
        `,
                confirmButtonText: 'Aceptar'
            });
        }
    </script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Registro exitoso',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Aceptar'
                });
            });
        </script>
    @endif
@endsection
