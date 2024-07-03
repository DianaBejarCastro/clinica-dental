@extends('layouts.menu-dashboard')
@section('title', 'Citas')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Citas Medicas
            </h1>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4"
                onclick="window.location.href='{{ route('appointment-admin-register') }}'">
                Reservar Cita
            </button>
        </div>
        <div class="mb-4 flex justify-between items-center">
            <input type="date" id="appointment_date" class="border rounded p-2"
                min="{{ \Carbon\Carbon::today()->toDateString() }}"
                max="{{ \Carbon\Carbon::today()->addMonths(2)->toDateString() }}">
            <button id="toggle-past-appointments"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
                Ver Citas Pasadas
            </button>
        </div>
        <h2 class="text-ml font-bold mb-2 text-red-900">Selecciona una fecha</h2>

        <h2 class="text-xl font-bold mb-2">Citas Según el día seleccionado</h2>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold">CITAS</h3>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Hora</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="appointments-table-body">
                    <!-- Contenido generado por JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appointmentDateInput = document.getElementById('appointment_date');
            const appointmentsTableBody = document.getElementById('appointments-table-body');
            const togglePastAppointmentsButton = document.getElementById('toggle-past-appointments');
            let showPastAppointments = false;

            const urlParams = new URLSearchParams(window.location.search);
            const urlDate = urlParams.get('date') || new Date().toISOString().split('T')[0];
            appointmentDateInput.value = urlDate;

            appointmentDateInput.addEventListener('change', function() {
                actualizar();
            });

            togglePastAppointmentsButton.addEventListener('click', function() {
                showPastAppointments = !showPastAppointments;
                if (showPastAppointments) {
                    appointmentDateInput.min = '';
                    togglePastAppointmentsButton.textContent = 'Ocultar Citas Pasadas';
                } else {
                    appointmentDateInput.min = new Date().toISOString().split('T')[0];
                    togglePastAppointmentsButton.textContent = 'Ver Citas Pasadas';
                }
                actualizar();
            });

            fetchAppointments(urlDate);

            function fetchAppointments(date) {
                fetch(`/appointments/${date}`)
                    .then(response => response.json())
                    .then(data => {
                        appointmentsTableBody.innerHTML = '';

                        for (let hour = 8; hour < 20; hour++) {
                            ['00', '30'].forEach(minute => {
                                const time = `${hour.toString().padStart(2, '0')}:${minute}:00`;
                                const appointmentsForTime = data.appointments.filter(app => app
                                    .start_time === time);

                                appointmentsForTime.forEach(appointment => {
                                    const row = document.createElement('tr');

                                    const timeCell = document.createElement('td');
                                    timeCell.className = 'border px-4 py-2';
                                    timeCell.textContent = time;
                                    row.appendChild(timeCell);

                                    const nameCell = document.createElement('td');
                                    nameCell.className = 'border px-4 py-2';
                                    const statusColor = appointment.status === 'atendido' ?
                                        'text-yellow-600' :
                                        appointment.status === 'reservado' ? 'text-green-600' :
                                        'text-red-600';
                                    const statusText = appointment.status.charAt(0)
                                        .toUpperCase() + appointment.status.slice(1);
                                    nameCell.innerHTML =
                                        `${appointment.user.name}<br>(Dr.(a). ${appointment.dentist.user.name})<br><span class="${statusColor}">${statusText}</span>`;
                                    row.appendChild(nameCell);

                                    const actionCell = document.createElement('td');
                                    actionCell.className = 'border px-4 py-2';

                                    if (appointment.status === 'reservado' || appointment
                                        .status === 'modificado') {
                                        const cancelButton = document.createElement('button');
                                        cancelButton.setAttribute('data-appointment-id',
                                            appointment.id);
                                        cancelButton.className = 'cancel-appointment-btn';
                                        cancelButton.onclick = function() {
                                            cancelAppointment(appointment.id);
                                        };
                                        cancelButton.innerHTML = `
                                        <img src="{{ asset('img/table/cita-cancelar.png') }}" alt="cancelar" class="w-6 h-6">
                                    `;

                                        const editButton = document.createElement('button');
                                        editButton.setAttribute('data-appointment-id',
                                            appointment.id);
                                        editButton.setAttribute('data-start-time', appointment
                                            .date, appointment.start_time); // Añadir start_time
                                        editButton.className = 'edit-appointment-btn';
                                        editButton.onclick = function() {
                                            editAppointment(appointment.id, appointment
                                                .date, appointment.start_time
                                            ); // Pasar start_time a la función
                                        };
                                        editButton.innerHTML = `
    <img src="{{ asset('img/table/boton-editar.png') }}" alt="editar" class="w-6 h-6">
`;

                                        actionCell.appendChild(cancelButton);
                                        actionCell.appendChild(editButton);


                                    } else if (appointment.status === 'cancelado') {
                                        const cancelButton = document.createElement('button');
                                        cancelButton.className =
                                            'open-modal-button'; // Add a class to open the modal
                                        cancelButton.setAttribute('data-user-id', appointment
                                            .user_id); // Add user_id
                                        cancelButton.onclick = function() {
                                            openAppointmentModal(appointment
                                                .user_id
                                            ); // Call the function to open the modal
                                        };
                                        cancelButton.innerHTML = `
                                    <img src="{{ asset('img/table/cita.png') }}" alt="cancelado" class="w-6 h-6">
                                `;

                                        actionCell.appendChild(cancelButton);
                                    }
                                    row.appendChild(actionCell);

                                    appointmentsTableBody.appendChild(row);
                                });
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            function actualizar() {
                const selectedDate = appointmentDateInput.value;
                const newUrl = `${window.location.pathname}?date=${selectedDate}`;
                window.history.pushState({
                    path: newUrl
                }, '', newUrl);
                fetchAppointments(selectedDate);
            }

            var storeRoute = "{{ route('appointments.store.admin') }}";
            var csrfToken = '{{ csrf_token() }}';

            function openAppointmentModal(userId) {
                Swal.fire({
                    title: 'Reservar Cita',
                    html: `
            <form id="appointmentForm" action="${storeRoute}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="user_id" value="${userId}">

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="date">Fecha</label>
                    <input type="date" id="date" name="date" class="swal2-input" style="width: 80%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    <div id="date-error" class="error-message text-red-800"></div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="center_id">Sucursal</label>
                    <select id="center_id" name="center_id" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">Selecciona una sucursal</option>
                        @foreach ($centers as $center)
                            <option value="{{ $center->id }}">{{ $center->name_branch }}</option>
                        @endforeach
                    </select>
                    <div id="center_id-error" class="error-message text-red-800"></div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="dentist_id">Dentista</label>
                    <select id="dentist_id" name="dentist_id" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">Selecciona un dentista</option>
                    </select>
                    <div id="dentist_id-error" class="error-message text-red-800"></div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="start_time">Hora de Inicio</label>
                    <select id="start_time" name="start_time" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
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
                    preConfirm: handleFormSubmit
                });

                document.getElementById('center_id').addEventListener('change', fetchDentists);
                document.getElementById('dentist_id').addEventListener('change', updateAvailableTimes);
                document.getElementById('date').addEventListener('change', updateAvailableTimes);
            }

            function handleFormSubmit() {
                let isValid = true;
                let formData = new FormData(document.getElementById('appointmentForm'));

                document.querySelectorAll('.error-message').forEach(element => {
                    element.textContent = '';
                });

                if (!formData.get('date')) {
                    document.getElementById('date-error').textContent = 'La fecha es requerida.';
                    isValid = false;
                }
                if (!formData.get('center_id')) {
                    document.getElementById('center_id-error').textContent = 'La sucursal es requerida.';
                    isValid = false;
                }
                if (!formData.get('dentist_id')) {
                    document.getElementById('dentist_id-error').textContent = 'El dentista es requerido.';
                    isValid = false;
                }
                if (!formData.get('start_time')) {
                    document.getElementById('start_time-error').textContent = 'La hora de inicio es requerida.';
                    isValid = false;
                }

                if (!isValid) {
                    return false;
                }

                return fetch(storeRoute, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                }).then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text);
                        });
                    }
                    return response.json();
                }).then(data => {
                    if (data && data.success) {
                        Swal.fire('¡Éxito!', data.success, 'success').then(() => {
                            window.location.reload();
                        });
                    }
                }).catch(error => {
                    Swal.fire('Error', error.message, 'error');
                });
            }

            function fetchDentists() {
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
            }

            function updateAvailableTimes() {
                let dentistSelect = document.getElementById('dentist_id');
                let dateInput = document.getElementById('date');

                if (dentistSelect.value && dateInput.value) {
                    let selectedDate = new Date(dateInput.value + "T00:00:00");
                    let dayOfWeek = selectedDate.getDay();
                    dayOfWeek = (dayOfWeek === 0) ? 6 : dayOfWeek - 1;

                    let timeSelect = document.getElementById('start_time');
                    timeSelect.innerHTML = '<option value="">Selecciona un horario</option>';
                    let noTimesMessage = document.getElementById('no-times-message');

                    fetch(
                            `/appointments/available-times/${dentistSelect.value}?day_of_week=${dayOfWeek}&date=${dateInput.value}`
                        )
                        .then(response => response.json())
                        .then(data => {
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




        });
    </script>

    <script>
        var updatecsrfToken = "{{ csrf_token() }}";
        var updateRoute = "{{ route('appointments.update', ['id' => ':id']) }}";

        function editAppointment(appointmentId, date, startTime) {
            let formattedTime = startTime.substring(0, 5);
            Swal.fire({
                title: 'Editar Cita',
                html: `
            <form id="editAppointmentForm" action="${updateRoute.replace(':id', appointmentId)}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                <input type="hidden" name="_token" value="${updatecsrfToken}">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="appointment_id" value="${appointmentId}">

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="edit_date">Fecha</label>
                    <input type="date" id="edit_date" name="date" class="swal2-input" style="width: 80%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;" value="${date}">
                    <div id="edit_date-error" class="error-message" style="color: red;"></div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="edit_center_id">Sucursal</label>
                    <select id="edit_center_id" name="center_id" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">Selecciona una sucursal</option>
                        @foreach ($centers as $center)
                            <option value="{{ $center->id }}">{{ $center->name_branch }}</option>
                        @endforeach
                    </select>
                    <div id="edit_center_id-error" class="error-message" style="color: red;"></div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="edit_dentist_id">Dentista</label>
                    <select id="edit_dentist_id" name="dentist_id" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">Selecciona un dentista</option>
                    </select>
                    <div id="edit_dentist_id-error" class="error-message" style="color: red;"></div>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="edit_start_time">Hora de inicio</label>
                    <select id="edit_start_time" name="start_time" class="swal2-input" style="width: 90%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="${formattedTime}">${formattedTime}</option>
                        <option value="">Selecciona un horario</option>
                    </select>
                    <div id="edit_start_time-error" class="error-message" style="color: red;"></div>
                </div>

                <div id="edit-no-times-message" style="color: red;"></div>
            </form>
        `,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Guardar Cambios',
                cancelButtonText: 'Cerrar',
                didOpen: () => {
                    const editCenterSelect = document.getElementById('edit_center_id');
                    const editDentistSelect = document.getElementById('edit_dentist_id');
                    const editStartTimeSelect = document.getElementById('edit_start_time');
                    const editDateInput = document.getElementById('edit_date');
                    const noTimesMessage = document.getElementById('edit-no-times-message');

                    editCenterSelect.addEventListener('change', function() {
                        const centerId = editCenterSelect.value;
                        fetchDentistsEdit(centerId, true);
                        editStartTimeSelect.innerHTML =
                            '<option value="">Selecciona la hora de inicio</option>';
                    });

                    editDentistSelect.addEventListener('change', function() {
                        const dentistId = editDentistSelect.value;
                        updateAvailableTimesEdit(dentistId, editDateInput.value, true);
                    });

                    editDateInput.addEventListener('change', function() {
                        const dentistId = editDentistSelect.value;
                        updateAvailableTimesEdit(dentistId, editDateInput.value, true);
                    });
                },
                preConfirm: () => {
                    let isValid = true;
                    let formData = new FormData(document.getElementById('editAppointmentForm'));

                    if (isValid) {
                        updateAppointment(formData.get(
                        'appointment_id')); // Llama a la función para actualizar la cita
                    } else {
                        return false;
                    }

                    document.querySelectorAll('.error-message').forEach(element => {
                        element.textContent = '';
                    });

                    if (!formData.get('date')) {
                        document.getElementById('edit_date-error').textContent = 'La fecha es requerida.';
                        isValid = false;
                    }
                    if (!formData.get('center_id')) {
                        document.getElementById('edit_center_id-error').textContent =
                            'La sucursal es requerida.';
                        isValid = false;
                    }
                    if (!formData.get('dentist_id')) {
                        document.getElementById('edit_dentist_id-error').textContent =
                            'El dentista es requerido.';
                        isValid = false;
                    }
                    if (!formData.get('start_time')) {
                        document.getElementById('edit_start_time-error').textContent =
                            'La hora de inicio es requerida.';
                        isValid = false;
                    }

                    if (isValid) {
                        document.getElementById('editAppointmentForm').submit();
                    } else {
                        return false;
                    }
                }
            });

            function fetchDentistsEdit(centerId, isEdit = false) {
                fetch(`/appointments/dentists/${centerId}`)
                    .then(response => response.json())
                    .then(data => {
                        let dentistSelect = document.getElementById(isEdit ? 'edit_dentist_id' : 'dentist_id');
                        dentistSelect.innerHTML = '<option value="">Selecciona un dentista</option>';
                        data.forEach(dentist => {
                            dentistSelect.innerHTML +=
                                `<option value="${dentist.id}">${dentist.user.name}</option>`;
                        });
                    });
            }

            function updateAvailableTimesEdit(dentistId, date, isEdit = false) {
                if (dentistId && date) {
                    let selectedDate = new Date(date + "T00:00:00");
                    let dayOfWeek = selectedDate.getDay();
                    dayOfWeek = (dayOfWeek === 0) ? 6 : dayOfWeek - 1;

                    let timeSelect = document.getElementById(isEdit ? 'edit_start_time' : 'start_time');
                    timeSelect.innerHTML = '<option value="">Selecciona un horario</option>';
                    let noTimesMessage = document.getElementById(isEdit ? 'edit-no-times-message' : 'no-times-message');

                    fetch(`/appointments/available-times/${dentistId}?day_of_week=${dayOfWeek}&date=${date}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                noTimesMessage.textContent = 'No hay horarios disponibles. Por favor, escoge otro día.';
                            } else {
                                noTimesMessage.textContent = '';
                                data.forEach(time => {
                                    timeSelect.innerHTML += `<option value="${time}">${time}</option>`;
                                });
                            }
                        });
                }
            }
        }
        function updateAppointment(appointmentId) {
    let formData = new FormData(document.getElementById('editAppointmentForm'));

    $.ajax({
        url: updateRoute.replace(':id', appointmentId),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Cita Actualizada',
                text: 'La cita ha sido actualizada correctamente.',
            }).then(() => {
                location.reload();
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al actualizar la cita.',
            });
        }
    });
}

    </script>


    <script>
        function cancelAppointment(appointmentId) {
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
        }
    </script>

@endsection
