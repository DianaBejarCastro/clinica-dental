@extends('layouts.menu-dashboard')
@section('title', 'Dentistas')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Dentistas
            </h1>
            <form action="{{ route('dentist.register') }}" method="GET">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                    Registrar Dentista
                </button>
            </form>

        </div>

    </div>
    <div class="container mx-auto sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <div class="w-full flex justify-center md:justify-end">
                <form action="{{ route('schedule') }}" method="GET">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Ver Horarios
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Empieza tabla -->
    <table id="dentists-table" class="min-w-full bg-white max-h-96" width="100%">
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
            @foreach ($dentists as $dentist)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="">
                        <button class="" onclick="showInfo(this)" 
                            data-ci="{{ $dentist->ci }}"
                            data-name="{{ $dentist->name }}" 
                            data-center="{{ $dentist->center }}"
                            data-email="{{ $dentist->email }}" 
                            data-birthdate="{{ $dentist->birthdate }}"
                            data-address="{{ $dentist->address }}" 
                            data-phone="{{ $dentist->phone }}"
                            data-role="{{ $dentist->role }}" 
                            data-dentist_created_at="{{ $dentist->dentist_created_at }}"
                            data-dentist_updated_at="{{ $dentist->dentist_updated_at }}"
                            data-specialties="{{ $dentist->specialties }}">
                            <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                        </button>
                    </td>
                    
                    <td class="py-2 px-2">{{ $dentist->ci }}</td>
                    <td class="py-2 px-2">{{ $dentist->name }}</td>
                    <td class="py-2 px-2">{{ $dentist->center }}</td>
                    <td class="py-2 px-2">
                        <button onclick="editDentist('{{ $dentist->id }}')">
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
            $('#dentists-table').DataTable({
                language: spanishLanguageConfig,
            });
            // Ajustar el ancho del <select> después de la inicialización de DataTable
            $('select[name="dentists-table_length"]').addClass('w-24');
        });
        // Pasar la ruta y el token CSRF a JavaScript
        var storeRoute = "{{ route('centers.store') }}";
        var csrfToken = '{{ csrf_token() }}';

        function editDentist(dentistId) {
    fetch('{{ route('dentist.setEditId') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id: dentistId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.href = '{{ route('dentist.edit.view') }}';
        } else {
            console.error('Error setting session ID');
        }
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
    var dentist_created_at = button.getAttribute('data-dentist_created_at');
    var dentist_updated_at = button.getAttribute('data-dentist_updated_at');
    var specialties = button.getAttribute('data-specialties');

    // Mostrar los datos en un modal de SweetAlert
    Swal.fire({
        title: 'Información del Dentista',
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

        <strong style="grid-column: 1; text-align: left;">Especialidades:</strong>
        <span style="grid-column: 2; text-align: left;">${specialties}</span>

        <strong style="grid-column: 1; text-align: left;">Creado en:</strong>
        <span style="grid-column: 2; text-align: left;">${dentist_created_at}</span>

        <strong style="grid-column: 1; text-align: left;">Actualizado en:</strong>
        <span style="grid-column: 2; text-align: left;">${dentist_updated_at}</span>
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
