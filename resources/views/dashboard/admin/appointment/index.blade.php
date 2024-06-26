@extends('layouts.menu-dashboard')
@section('title', 'Citas')
@section('content-dashboard')
<div class="container mx-auto p-4 sm:p-2">
    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
            Citas Medicas
        </h1>
        <button
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4"
            onclick="window.location.href='{{ route('appointment-admin-register') }}'">
            Reservar Cita
        </button>
    </div>
    <div class="mb-4">
        <input type="date" id="appointment_date" class="border rounded p-2"
            min="{{ \Carbon\Carbon::today()->toDateString() }}"
            max="{{ \Carbon\Carbon::today()->addMonths(2)->toDateString() }}">
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
    document.addEventListener('DOMContentLoaded', function () {
        const appointmentDateInput = document.getElementById('appointment_date');
        const appointmentsTableBody = document.getElementById('appointments-table-body');

        // Set the date from the URL or default to today
        const urlParams = new URLSearchParams(window.location.search);
        const urlDate = urlParams.get('date') || new Date().toISOString().split('T')[0];
        appointmentDateInput.value = urlDate;

        appointmentDateInput.addEventListener('change', function () {
            actualizar();
        });

        // Fetch appointments for the initial date
        fetchAppointments(urlDate);

        function fetchAppointments(date) {
            fetch(`/appointments/${date}`)
                .then(response => response.json())
                .then(data => {
                    appointmentsTableBody.innerHTML = '';

                    for (let hour = 8; hour < 20; hour++) {
                        ['00', '30'].forEach(minute => {
                            const time = `${hour.toString().padStart(2, '0')}:${minute}:00`;
                            const appointment = data.appointments.find(app => app.start_time === time);

                            const row = document.createElement('tr');

                            const timeCell = document.createElement('td');
                            timeCell.className = 'border px-4 py-2';
                            timeCell.textContent = time;
                            row.appendChild(timeCell);

                            const nameCell = document.createElement('td');
                            nameCell.className = 'border px-4 py-2';
                            if (appointment) {
                                const statusColor = appointment.status === 'atendido' ? 'text-yellow-600' :
                                    appointment.status === 'reservado' ? 'text-green-600' :
                                        'text-red-600';
                                const statusText = appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1);

                                nameCell.innerHTML = `${appointment.user.name}<br>(Dr.(a). ${appointment.dentist.user.name})<br><span class="${statusColor}">${statusText}</span>`;
                            } else {
                                nameCell.textContent = '-';
                            }
                            row.appendChild(nameCell);

                            const actionCell = document.createElement('td');
                            actionCell.className = 'border px-4 py-2';

                            if (appointment && (appointment.status === 'reservado' || appointment.status === 'modificado')) {
                                const registerButton = document.createElement('button');
                                registerButton.onclick = function () {
                                    register(appointment.user_id);
                                };
                                registerButton.innerHTML = `
                                    <img src="{{ asset('img/table/cita-cancelar.png') }}" alt="editar" class="w-6 h-6">
                                `;

                                const editButton = document.createElement('button');
                                editButton.className = '';
                                editButton.innerHTML = `
                                    <img src="{{ asset('img/table/boton-editar.png') }}" alt="eliminar" class="w-6 h-6">
                                `;

                                actionCell.appendChild(registerButton);
                                actionCell.appendChild(editButton);
                            } else if (appointment && appointment.status === 'cancelado') {
                                const cancelButton = document.createElement('button');
                                cancelButton.className = '';
                                cancelButton.innerHTML = `
                                    <img src="{{ asset('img/table/cita.png') }}" alt="eliminar" class="w-6 h-6">
                                `;

                                actionCell.appendChild(cancelButton);
                            }
                            row.appendChild(actionCell);

                            appointmentsTableBody.appendChild(row);
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
            window.history.pushState({ path: newUrl }, '', newUrl);
            fetchAppointments(selectedDate);
        }
    });
</script>
@endsection
