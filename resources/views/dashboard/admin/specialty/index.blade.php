@extends('layouts.menu-dashboard')
@section('title', 'Especialidades')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Especialidades
            </h1>
            <button
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                Registrar Especialidad
            </button>
        </div>
    </div>
    <!-- Empieza tabla -->
    
        <table id="specialty-table" class="min-w-full bg-white" width="100%">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Descripción</th>
                    <th class="py-3 px-6 text-left">Acciones</th> <!-- Espacio para los botones "Editar" y "Eliminar" -->
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($specialties as $specialty)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="">
                            <button class="" onclick="showInfo(this)" 
                                data-name="{{ $specialty->name }}"
                                data-description="{{ $specialty->description }}" 
                                data-created-at="{{ $specialty->created_at }}"
                                data-updated-at="{{ $specialty->updated_at }}">
                                <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                            </button>
                        </td>
                        <td class="py-3 px-6">{{ $specialty->name }}</td>
                        <td class="py-3 px-6">{{ $specialty->description }}</td>
                        <td class="py-3 px-6">
                            <button onclick="editSpecialty({{ $specialty->id }})">
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
        // Pasar la ruta y el token CSRF a JavaScript
        var storeRoute = "{{ route('specialties.store') }}";
        var csrfToken = '{{ csrf_token() }}';

        document.querySelector('.open-modal-button').addEventListener('click', () => {
            Swal.fire({
                title: 'Registrar Especialidad',
                html: `
            <form id="register-form" action="${storeRoute}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <div style="margin-bottom: 1rem;">
                    <label for="name" class="form-label" style="display: block; margin-bottom: 0.5rem;">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label for="description" class="form-label" style="display: block; margin-bottom: 0.5rem;">Descripción</label>
                    <textarea class="form-control" id="description" name="description" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>
            </form>
        `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Registrar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    document.getElementById('register-form').submit();
                }

            });
        });
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
    <script>
        function showInfo(button) {
    const name = button.getAttribute('data-name');
    const description = button.getAttribute('data-description');
    const createdAt = new Date(button.getAttribute('data-created-at')).toLocaleString();
    const updatedAt = new Date(button.getAttribute('data-updated-at')).toLocaleString();

    Swal.fire({
        title: 'Información de la Especialidad',
        html: `
            <div class="text-left">
                <div class="items-specialty mb-2">
                    <strong style="width: 100px; display: inline-block;">Nombre:</strong>
                    <span>${name}</span>
                </div>
                <div class="items-specialty mb-2">
                    <strong style="width: 100px;">Descripción:</strong>
                    <span>${description}</span>
                </div>

                <div class="items-specialty mb-2">
                    <strong style="width: 100px; display: inline-block;">Creado:</strong>
                    <span>${createdAt}</span>
                </div>
                <div class="items-specialty mb-2">
                    <strong style="width: 100px;">Actualizado:</strong>
                    <span>${updatedAt}</span>
                </div>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Cerrar',
        customClass: {
            title: 'text-lg font-semibold',
            htmlContainer: 'text-left',
            popup: 'swal-popup-custom',
        }
    });
}
        
        function editSpecialty(specialtyId) {
    // Fetch the center details using AJAX
    fetch(`/specialties/${specialtyId}`)
        .then(response => response.json())
        .then(data => {
            // Display the modal with the fetched data
            Swal.fire({
                title: 'Editar Especialidad',
                html: `
                <form id="editSpecialtyForm">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <input type="text" id="name" name="name" value="${data.name.trim()}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción:</label>
                        <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">${(data.description ? data.description.trim() : '')}</textarea>
                    </div>
                </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                preConfirm: () => {
                    // Get form data
                    const form = document.getElementById('editSpecialtyForm');
                    if (!form.checkValidity()) {
                        Swal.showValidationMessage(
                            'Por favor, ingrese el nombre de la especialidad.'
                        );
                        return false;
                    }

                    const formData = new FormData(form);
                    const updatedData = {};
                    formData.forEach((value, key) => updatedData[key] = value);

                    // Remove the description field if it's empty
                    if (!updatedData.description.trim()) {
                        delete updatedData.description;
                    }

                    return fetch(`/specialties/${specialtyId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(updatedData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
                }
            }).then(result => {
                if (result.isConfirmed) {
                    Swal.fire('Guardado!', 'Los cambios han sido guardados.', 'success')
                    .then(() => {
                        location.reload(); // Optional: Reload the page to see the changes
                    });
                }
            });
        })
        .catch(error => {
            Swal.fire('Error!', 'No se pudo cargar los datos de la especialidad.', 'error');
        });
}

    </script>
    <script>
        $(document).ready(function() {
            $('#specialty-table').DataTable({
                language: spanishLanguageConfig,
            });
            // Ajustar el ancho del <select> después de la inicialización de DataTable
            $('select[name="specialty-table_length"]').addClass('w-24');
        });

        // Pasar la ruta y el token CSRF a JavaScript
        var storeRoute = "{{ route('specialties.store') }}";
        var csrfToken = '{{ csrf_token() }}';

        document.querySelector('.open-modal-button').addEventListener('click', () => {
            Swal.fire({
                title: 'Registrar Especialidad',
                html: `
                <form id="register-form" action="${storeRoute}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label for="name" class="form-label" style="display: block; margin-bottom: 0.5rem;">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
                        <div id="name_error" class="error-message" style="color: red; display: none;">Por favor, ingrese el nombre de la especialidad.</div>
                    </div>
                    <div class="form-group" style="margin-bottom: 1rem;">
                        <label for="description" class="form-label" style="display: block; margin-bottom: 0.5rem;">Descripción</label>
                        <textarea class="form-control" id="description" name="description" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                        <div id="description_error" class="error-message" style="color: red; display: none;">Por favor, ingrese una descripción.</div>
                    </div>
                </form>
                `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Registrar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const form = document.getElementById('register-form');
                    const fields = [{
                        id: 'name',
                        errorId: 'name_error',
                        message: 'Por favor, ingrese el nombre de la especialidad.'
                    }, ];

                    let isValid = true;

                    fields.forEach(field => {
                        const input = document.getElementById(field.id);
                        const error = document.getElementById(field.errorId);

                        if (input.value.trim() === '') {
                            error.style.display = 'block';
                            isValid = false;
                        } else {
                            error.style.display = 'none';
                        }
                    });

                    if (!isValid) {
                        return false;
                    }

                    // Si el formulario es válido, enviarlo manualmente.
                    form.submit();
                }
            });
        });
    </script>
@endsection
