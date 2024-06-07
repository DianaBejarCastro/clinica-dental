@extends('layouts.menu-dashboard')
@section('title', 'Sucursales')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Sucursales
            </h1>
            <button
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                Registrar Sucursal
            </button>
        </div>

    </div>
    <!-- Empieza tabla -->
    <table id="centers-table" class="min-w-full bg-white max-h-96" width="100%">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                <th class="py-2 px-2 text-left ">Nombre</th>
                <th class="py-2 px-2 text-left">Ciudad</th>
                <th class="py-2 px-2 text-left">Dirección</th>
                <th class="py-2 px-2 text-left w-10">Activo</th>
                <th class="py-2 px-2 text-left w-10">Acciones</th> <!-- Espacio para los botones "Editar" y "Eliminar" -->
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($centers as $center)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="">
                        <button class="" onclick="showInfo(this)" data-name-branch="{{ $center->name_branch }}"
                            data-city="{{ $center->city }}" data-address="{{ $center->address }}"
                            data-is-active="{{ $center->is_active }}" data-created-at="{{ $center->created_at }}"
                            data-updated-at="{{ $center->updated_at }}">
                            <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                        </button>
                    </td>
                    <td class="py-2 px-2">{{ $center->name_branch }}</td>
                    <td class="py-2 px-2">{{ $center->city }}</td>
                    <td class="py-2 px-2">{{ $center->address }}</td>
                    <td class="py-2 px-2">{{ $center->is_active ? 'Sí' : 'No' }}</td>
                    <td class="py-2 px-2">
                        <button onclick="editCenter({{ $center->id }})">
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
        var storeRoute = "{{ route('centers.store') }}";
        var csrfToken = '{{ csrf_token() }}';

        document.querySelector('.open-modal-button').addEventListener('click', () => {
            Swal.fire({
                title: 'Registrar Sucursal',
                html: `
                <form id="register-form" action="${storeRoute}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div style="margin-bottom: 1rem;">
                        <label for="name_branch" class="form-label" style="display: block; margin-bottom: 0.5rem;">Nombre</label>
                        <input type="text" class="form-control" id="name_branch" name="name_branch" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="city" class="form-label" style="display: block; margin-bottom: 0.5rem;">Ciudad</label>
                        <select class="form-control" id="city" name="city" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
                            <option value="">Seleccione una ciudad</option>
                            <option value="Cochabamba">Cochabamba</option>
                            <option value="Santa Cruz">Santa Cruz</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="address" class="form-label" style="display: block; margin-bottom: 0.5rem;">Dirección</label>
                        <input type="text" class="form-control" id="address" name="address" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
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
            const nameBranch = button.getAttribute('data-name-branch');
            const city = button.getAttribute('data-city');
            const address = button.getAttribute('data-address');
            const isActive = button.getAttribute('data-is-active') == '1' ? 'Sí' : 'No';
            const createdAt = new Date(button.getAttribute('data-created-at')).toLocaleString();
            const updatedAt = new Date(button.getAttribute('data-updated-at')).toLocaleString();

            Swal.fire({
                title: 'Información de la Sucursal',
                html: `
                <div class="text-left">
    <div class="items-center mb-2">
        <strong class="w-28 mr-10">Nombre:</strong>
        <span>${nameBranch}</span>
    </div>
    <div class="items-center mb-2">
        <strong class="w-28 mr-12">Ciudad:</strong>
        <span>${city}</span>
    </div>
    <div class="items-center mb-2">
        <strong class="w-28 mr-6">Dirección:</strong>
        <span>${address}</span>
    </div>
    <div class="flex items-center mb-2">
        <strong class="w-28">Activo:</strong>
        <span>${isActive}</span>
    </div>
    <div class="flex items-center mb-2">
        <strong class="w-28">Creado:</strong>
        <span>${createdAt}</span>
    </div>
    <div class="flex items-center mb-2">
        <strong class="w-28">Actualizado:</strong>
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

        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.innerHTML = `
                .swal-popup-custom .swal2-icon.swal2-info {
                    font-size: 0.7em; /* Ajusta el tamaño del icono aquí */
                    width: 3em; /* Ajusta el tamaño del icono aquí */
                    height: 3em; /* Ajusta el tamaño del icono aquí */
                    margin: 1.5em auto; /* Ajusta el margen del icono aquí */
                }
            `;
            document.head.appendChild(style);
        });


        function editCenter(centerId) {
            // Fetch the center details using AJAX
            fetch(`/centers/${centerId}`)
                .then(response => response.json())
                .then(data => {
                    // Display the modal with the fetched data
                    Swal.fire({
                        title: 'Editar Sucursal',
                        html: `
                    <form id="editCenterForm">
                        <div class="mb-4">
                            <label for="name_branch" class="block text-sm font-medium text-gray-700">Nombre:</label>
                            <input type="text" id="name_branch" name="name_branch" value="${data.name_branch}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="city" class="block text-sm font-medium text-gray-700">Ciudad:</label>
                            <select id="city" name="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="Cochabamba" ${data.city === 'Cochabamba' ? 'selected' : ''}>Cochabamba</option>
                                <option value="Santa Cruz" ${data.city === 'Santa Cruz' ? 'selected' : ''}>Santa Cruz</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">Dirección:</label>
                            <input type="text" id="address" name="address" value="${data.address}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>
                        <input type="hidden" id="is_active" name="is_active" value="${data.is_active}">
                    </form>
                `,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        preConfirm: () => {
                            // Get form data
                            const form = document.getElementById('editCenterForm');
                            if (!form.checkValidity()) {
                                Swal.showValidationMessage(
                                    'Por favor, completa todos los campos obligatorios.');
                                return false;
                            }

                            const formData = new FormData(form);
                            const updatedData = {};
                            formData.forEach((value, key) => updatedData[key] = value);

                            return fetch(`/centers/${centerId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content')
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
                    Swal.fire('Error!', 'No se pudo cargar los datos de la sucursal.', 'error');
                });
        }

        function deleteCenter(centerId) {
            if (confirm('¿Estás seguro de que deseas eliminar el centro con ID: ' + centerId + '?')) {
                alert('Centro con ID: ' + centerId + ' eliminado.');
                // Aquí puedes agregar lógica para eliminar el centro.
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#centers-table').DataTable({

                language: spanishLanguageConfig,
            });
            // Ajustar el ancho del <select> después de la inicialización de DataTable
            $('select[name="centers-table_length"]').addClass('w-24');

        });

        // Pasar la ruta y el token CSRF a JavaScript
        var storeRoute = "{{ route('centers.store') }}";
        var csrfToken = '{{ csrf_token() }}';

        document.querySelector('.open-modal-button').addEventListener('click', () => {
            Swal.fire({
                title: 'Registrar Sucursal',
                html: `
            <form id="register-form" action="${storeRoute}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="name_branch" class="form-label" style="display: block; margin-bottom: 0.5rem;">Nombre</label>
                    <input type="text" class="form-control" id="name_branch" name="name_branch" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
                    <div id="name_branch_error" class="error-message" style="color: red; display: none;">Por favor, ingrese el nombre de la sucursal.</div>
                </div>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="city" class="form-label" style="display: block; margin-bottom: 0.5rem;">Ciudad</label>
                    <select class="form-control" id="city" name="city" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
                        <option value="">Seleccione una ciudad</option>
                        <option value="Cochabamba">Cochabamba</option>
                        <option value="Santa Cruz">Santa Cruz</option>
                    </select>
                    <div id="city_error" class="error-message" style="color: red; display: none;">Por favor, seleccione una ciudad.</div>
                </div>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="address" class="form-label" style="display: block; margin-bottom: 0.5rem;">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" required>
                    <div id="address_error" class="error-message" style="color: red; display: none;">Por favor, ingrese la dirección.</div>
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
                            id: 'name_branch',
                            errorId: 'name_branch_error',
                            message: 'Por favor, ingrese el nombre de la sucursal.'
                        },
                        {
                            id: 'city',
                            errorId: 'city_error',
                            message: 'Por favor, seleccione una ciudad.'
                        },
                        {
                            id: 'address',
                            errorId: 'address_error',
                            message: 'Por favor, ingrese la dirección.'
                        }
                    ];

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

                    return form.submit();
                }
            });
        });
    </script>
@endsection
