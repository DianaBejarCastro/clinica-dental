@extends('layouts.menu-dashboard')
@section('title', 'Citas')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Pacientes
            </h1>
        </div>
        <!-- Empieza tabla -->
        <table id="patients-table" class="min-w-full bg-white max-h-96" width="100%">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                    <th class="py-2 px-2 text-left">Identificación</th>
                    <th class="py-2 px-2 text-left">Nombre</th>
                    <th class="py-2 px-2 text-left">Correo electronico</th>
                    <th class="py-2 px-2 text-left w-10">Acciones</th>
                    <!-- Espacio para los botones "Editar" y "Eliminar" -->
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($patients as $patient)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="">
                            <button class="" onclick="showInfo(this)"
                                data-identification_number="{{ $patient->identification_number }}"
                                data-identification_type="{{ $patient->identification_type }}"
                                data-name="{{ $patient->name }}" data-center="{{ $patient->center }}"
                                data-email="{{ $patient->email }}" data-gender="{{ $patient->gender }}"
                                data-date_of_birth="{{ $patient->date_of_birth }}" data-address="{{ $patient->address }}"
                                data-phone="{{ $patient->phone }}" data-user_created_at="{{ $patient->user_created_at }}"
                                data-patient_updated_at="{{ $patient->patient_updated_at }}">
                                <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                            </button>
                        </td>
                        <td class="py-3 px-6">{{ $patient->identification_number ?? 'N/A' }}</td>
                        <td class="py-3 px-6">{{ $patient->name }}</td>
                        <td class="py-3 px-6">{{ $patient->email ?? 'N/A' }}</td>
                        <td class="py-3 px-6">
                            <button onclick="register('{{ $patient->user_id }}')">
                                <img src="{{ asset('img/table/cita.png') }}" alt="editar" class="w-6 h-6">
                            </button>
                            <button class="">
                                <img src="{{ asset('img/table/dientes.png') }}" alt="eliminar" class="w-6 h-6">
                            </button>
                        </td>
                    </tr>
                @endforeach

                <!-- Filas de usuarios con rol de paciente que no han completado su registro -->
                @foreach ($incompletePatients as $incomplete)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="">
                            <button class="" onclick="showIncompleteInfo(this)" data-name="{{ $incomplete->name }}"
                                data-email="{{ $incomplete->email }}">
                                <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                            </button>
                        </td>
                        <td class="py-3 px-6">N/A</td>
                        <td class="py-3 px-6">{{ $incomplete->name }}</td>
                        <td class="py-3 px-6">{{ $incomplete->email }}</td>
                        <td class="py-3 px-6">
                            <button onclick="register('{{ $incomplete->id }}')">
                                <img src="{{ asset('img/table/cita.png') }}" alt="editar" class="w-6 h-6">
                            </button>
                            <button class="">
                                <img src="{{ asset('img/table/dientes.png') }}" alt="eliminar" class="w-6 h-6">
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#patients-table').DataTable({
                language: spanishLanguageConfig,
            });
            // Ajustar el ancho del <select> después de la inicialización de DataTable
            $('select[name="patients-table_length"]').addClass('w-24');
        });

        function showInfo(button) {
            var identification_number = button.getAttribute('data-identification_number');
            var identification_type = button.getAttribute('data-identification_type');
            var name = button.getAttribute('data-name');
            var center = button.getAttribute('data-center');
            var email = button.getAttribute('data-email');
            var gender = button.getAttribute('data-gender');
            var date_of_birth = button.getAttribute('data-date_of_birth');
            var address = button.getAttribute('data-address');
            var phone = button.getAttribute('data-phone');
            var user_created_at = button.getAttribute('data-user_created_at');
            var patient_updated_at = button.getAttribute('data-patient_updated_at');

            // Mostrar los datos en un modal de SweetAlert
            Swal.fire({
                title: 'Información del Paciente',
                html: `
        <div style="display: grid; grid-template-columns: max-content 1fr; grid-row-gap: 0.5rem; justify-content: start;">
            <strong style="text-align: left;">Numero de Identificación:</strong>
            <span style="text-align: left;">${identification_number}</span>

            <strong style="text-align: left;">Tipo de Identificación:</strong>
            <span style="text-align: left;">${identification_type}</span>

            <strong style="text-align: left;">Nombre:</strong>
            <span style="text-align: left;">${name}</span>

            <strong style="text-align: left;">Centro:</strong>
            <span style="text-align: left;">${center}</span>

            <strong style="text-align: left;">Email:</strong>
            <span style="text-align: left;">${email}</span>

            <strong style="text-align: left;">Género:</strong>
            <span style="text-align: left;">${gender}</span>

            <strong style="text-align: left;">Fecha de Nacimiento:</strong>
            <span style="text-align: left;">${date_of_birth}</span>

            <strong style="text-align: left;">Dirección:</strong>
            <span style="text-align: left;">${address}</span>

            <strong style="text-align: left;">Teléfono:</strong>
            <span style="text-align: left;">${phone}</span>

            <strong style="text-align: left;">Creado en:</strong>
            <span style="text-align: left;">${user_created_at}</span>

            <strong style="text-align: left;">Actualizado en:</strong>
            <span style="text-align: left;">${patient_updated_at}</span>
        </div>
    `,
                confirmButtonText: 'Aceptar'
            });
        }



        function showIncompleteInfo(button) {
            var name = button.getAttribute('data-name');
            var email = button.getAttribute('data-email');

            // Mostrar los datos en un modal de SweetAlert
            Swal.fire({
                title: 'Información Incompleta',
                html: `
        <div>
            <strong>Nombre:</strong> ${name}<br>
            <strong>Email:</strong> ${email}
        </div>
    `,
                confirmButtonText: 'Aceptar'
            });
        }
    </script>
    <script>
        var storeRoute = "{{ route('appointments.store.admin') }}";
        var csrfToken = '{{ csrf_token() }}';

        function register(userId) {
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
                        `/appointments/available-times/${dentistSelect.value}?day_of_week=${dayOfWeek}&date=${dateInput.value}`)
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
    </script>
@endsection
