@extends('layouts.menu-dashboard')
@section('title', 'Citas')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Citas Medicas
            </h1>
            <button
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                Reservar Cita
            </button>
        </div>
    </div>
    <h2 class="text-lg font-semibold mb-2">Cita Reservada</h2>
    <!-- Tabla para citas con estado "reservado" -->
    <table id="appointments-table-reservado" class="min-w-full bg-white max-h-96" width="100%">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                <th class="py-2 px-2 text-left ">Fecha:</th>
                <th class="py-2 px-2 text-left">Hora:</th>
                <th class="py-2 px-2 text-left w-10">Acciones</th> <!-- Espacio para los botones "Editar" y "Eliminar" -->
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($appointments as $appointment)
                @if ($appointment->status == 'reservado')
                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                        <td class="">
                            <button class="" onclick="showInfo(this)" data-date="{{ $appointment->date }}"
                                data-start_time="{{ $appointment->start_time }}" data-status="{{ $appointment->status }}"
                                data-dentist_id="{{ $appointment->dentist->user->name }}"
                                data-created-at="{{ $appointment->created_at }}">

                                <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                            </button>
                        </td>
                        </td>
                        <td class="py-2 px-2">{{ $appointment->date }}</td>
                        <td class="py-2 px-2">{{ $appointment->start_time }}</td>
                        <td class="py-2 px-2">
                            <button data-appointment-id="{{ $appointment->id }}" class="cancel-appointment-btn">
                                <img src="{{ asset('img/table/cita-cancelar.png') }}" alt="eliminar" class="w-6 h-6">
                            </button>
                        </td>

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>



    <div class="border-b border-gray-300 border-2 my-4"></div>
    <h2 class="text-lg font-semibold mb-2 mt-4"> Historial de Citas Atendidas/ Canceladas</h2>
    <!-- Tabla para citas con otros estados -->
    <table id="appointments-table" class="min-w-full bg-white max-h-96" width="100%">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                <th class="py-2 px-2 text-left ">Fecha:</th>
                <th class="py-2 px-2 text-left">Hora:</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach ($appointments as $appointment)
                @if ($appointment->status != 'reservado')
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="">
                            <button class="" onclick="showInfo(this)" data-date="{{ $appointment->date }}"
                                data-start_time="{{ $appointment->start_time }}" data-status="{{ $appointment->status }}"
                                data-dentist_id="{{ $appointment->dentist->user->name }}"
                                data-created-at="{{ $appointment->created_at }}">
                                <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                            </button>
                        </td>
                        <td class="py-2 px-2">{{ $appointment->date }}</td>
                        <td class="py-2 px-2">{{ $appointment->start_time }}</td>

                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#appointments-table').DataTable({

                language: spanishLanguageConfig,
            });
            // Ajustar el ancho del <select> después de la inicialización de DataTable
            $('select[name="appointments-table_length"]').addClass('w-24');

        });

        var storeRoute = "{{ route('appointments.store') }}";
        var csrfToken = '{{ csrf_token() }}';

        document.querySelector('.open-modal-button').addEventListener('click', function() {
            Swal.fire({
                title: 'Reservar Cita',
                html: `
                    <form id="appointmentForm" action="${storeRoute}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="date" >Fecha</label>
                            <input type="date" id="date" name="date" class="swal2-input" style="width: 80%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                            <div id="date-error" class="error-message text-red-800"></div>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="center_id">Sucursal</label>
                            <select id="center_id" name="center_id" class="swal2-input" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="">Selecciona una sucursal</option>
                                @foreach ($centers as $center)
                                    <option value="{{ $center->id }}">{{ $center->name_branch }}</option>
                                @endforeach
                            </select>
                            <div id="center_id-error" class="error-message text-red-800"></div>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="dentist_id">Dentista</label>
                            <select id="dentist_id" name="dentist_id" class="swal2-input" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="">Selecciona un dentista</option>
                            </select>
                            <div id="dentist_id-error" class="error-message text-red-800"></div>
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 1rem;">
                            <label for="start_time">Hora de Inicio</label>
                            <select id="start_time" name="start_time" class="swal2-input" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="">Selecciona un horario</option>
                            </select>
                            <div id="start_time-error" class="error-message text-red-800"></div>
                        </div>
                        
                        <div id="no-times-message" style="color: red; font-size: small;" class="text-red-800"></div>
                    </form>
                `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Registrar',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    let isValid = true;
                    let formData = new FormData(document.getElementById('appointmentForm'));

                    // Clear previous errors
                    document.querySelectorAll('.error-message').forEach(element => {
                        element.textContent = '';
                    });

                    // Validation
                    const dateInput = document.getElementById('date');
                    const selectedDate = new Date(dateInput.value + "T00:00:00");
                    const currentDate = new Date();
                    const maxDate = new Date();
                    maxDate.setMonth(currentDate.getMonth() + 2);

                    selectedDate.setHours(0, 0, 0, 0);
                    currentDate.setHours(0, 0, 0, 0);
                    maxDate.setHours(0, 0, 0, 0);
                    console.log("cu" + currentDate + "se" + selectedDate);
                    if (!formData.get('date')) {
                        document.getElementById('date-error').textContent = 'La fecha es requerida.';
                        isValid = false;
                    } else if (selectedDate < currentDate || selectedDate > maxDate) {
                        document.getElementById('date-error').textContent =
                            'La fecha debe estar entre hoy y dos meses adelante.';
                        isValid = false;
                    }
                    if (!formData.get('center_id')) {
                        document.getElementById('center_id-error').textContent =
                            'La sucursal es requerida.';
                        isValid = false;
                    }
                    if (!formData.get('dentist_id')) {
                        document.getElementById('dentist_id-error').textContent =
                            'El dentista es requerido.';
                        isValid = false;
                    }
                    if (!formData.get('start_time')) {
                        document.getElementById('start_time-error').textContent =
                            'La hora de inicio es requerida.';
                        isValid = false;
                    }

                    if (!isValid) {
                        return false;
                    }

                    return fetch(storeRoute, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,

                        },
                        body: formData
                    }).then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                let errorMessages = Object.values(data.errors).flat();
                                let errorMessage = errorMessages.join('<br>');
                                throw new Error(errorMessage);
                            });
                        }
                        return response.json();
                    }).then(data => {
                        if (data && data.success) {
                            return Swal.fire('¡Éxito!', data.success, 'success');
                        }
                    }).catch(error => {
                        Swal.fire('Error', error.message, 'error');
                    });
                }
            });

            document.getElementById('center_id').addEventListener('change', function() {
                fetch(`/appointments/dentists/${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        let dentistSelect = document.getElementById('dentist_id');
                        dentistSelect.innerHTML = '<option value="">Selecciona un dentista</option>';
                        data.forEach(dentist => {
                            dentistSelect.innerHTML +=
                                `<option value="${dentist.id}">${dentist.user.name}</option>`;
                        });
                    });
            });

            document.getElementById('dentist_id').addEventListener('change', updateAvailableTimes);
            document.getElementById('date').addEventListener('change', updateAvailableTimes);

            function updateAvailableTimes() {
                let dentistSelect = document.getElementById('dentist_id');
                let dateInput = document.getElementById('date');
                if (dentistSelect.value && dateInput.value) {
                    let date = new Date(dateInput.value);
                    let dayOfWeek = date.getDay();

                    fetch(
                            `/appointments/available-times/${dentistSelect.value}?day_of_week=${dayOfWeek}&date=${dateInput.value}`
                        )
                        .then(response => response.json())
                        .then(data => {
                            let timeSelect = document.getElementById('start_time');
                            timeSelect.innerHTML = '<option value="">Selecciona un horario</option>';
                            let noTimesMessage = document.getElementById('no-times-message');
                            if (data.length === 0) {
                                noTimesMessage.textContent =
                                    'No hay horarios disponibles. Por favor, escoge otro día.';
                            } else {
                                noTimesMessage.textContent = '';
                                data.forEach(time => {
                                    timeSelect.innerHTML += `<option value="${time}">${time}</option>`;
                                });
                            }
                        });
                }
            }

            // Set min and max dates for the date input
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            const maxDate = new Date();
            maxDate.setMonth(maxDate.getMonth() + 2);
            dateInput.min = today;
            dateInput.max = maxDate.toISOString().split('T')[0];
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

    <!-- Script para la función showInfo -->
    <script>
        function showInfo(button) {
            const date = button.getAttribute('data-date');
            const start_time = button.getAttribute('data-start_time');
            const status = button.getAttribute('data-status');
            const dentist_id = button.getAttribute('data-dentist_id');
            const createdAt = new Date(button.getAttribute('data-created-at')).toLocaleString();

            Swal.fire({
                title: 'Información de la Cita',
                html: `
                <div class="text-left">
                    <div class="items-center mb-2">
                        <strong class="w-28 mr-10">Fecha:</strong>
                        <span>${date}</span>
                    </div>
                    <div class="items-center mb-2">
                        <strong class="w-28 mr-12">Hora:</strong>
                        <span>${start_time}</span>
                    </div>
                    <div class="items-center mb-2">
                        <strong class="w-28 mr-6">Estado:</strong>
                        <span>${status}</span>
                    </div>
                     <div class="items-center mb-2">
                        <strong class="w-28 mr-6">Dentista:</strong>
                        <span>${dentist_id}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <strong class="w-28">Creado:</strong>
                        <span>${createdAt}</span>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-appointment-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const appointmentId = this.getAttribute('data-appointment-id');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/appointments/${appointmentId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        Swal.fire(
                                            '¡Eliminado!',
                                            'La cita ha sido cancelada.',
                                            'success'
                                        ).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error',
                                            'Hubo un problema al eliminar el horario.',
                                            'error'
                                        );
                                    }
                                });
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.cancel-appointment-btn').on('click', function() {
                var appointmentId = $(this).data('appointment-id');

                Swal.fire({
                    title: 'Cancelar Cita',
                    html: `
                   <form id="cancel-appointment-form">
                    <div class="form-group" style="margin-bottom: 1rem; text-align: center;">
                    <label for="description" style="display: block; margin-bottom: 0.5rem;">Descripción:</label>
                    <textarea id="description" name="description" class="swal2-input" style="height: 100px; display: block; width: 80%; margin: 0 auto;"></textarea>
                     </div>
                    </form>

                `,
                    showCancelButton: true,
                    confirmButtonText: 'Cancelar Cita',
                    preConfirm: () => {
                        const description = Swal.getPopup().querySelector('#description').value;
                        if (!description) {
                            Swal.showValidationMessage(`Por favor, escribe una descripción.`);
                        }
                        return {
                            description: description
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar la solicitud AJAX para cancelar la cita
                        $.ajax({
                            url: '{{ route('appointments.cancel') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                appointment_id: appointmentId,
                                description: result.value.description
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cita Cancelada',
                                    text: 'La cita ha sido cancelada correctamente.',
                                }).then(() => {
                                    // Opcional: recargar la página o actualizar la tabla
                                    location.reload();
                                });
                            },
                            error: function(response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Hubo un error al cancelar la cita.',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
