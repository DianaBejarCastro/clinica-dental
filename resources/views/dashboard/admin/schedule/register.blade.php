@extends('layouts.menu-dashboard')
@section('title', 'Horarios')
@section('content-dashboard')
<style>
    .inline-flex.items-center.cursor-pointer {
  vertical-align: middle;
}

</style>
<div class="container mx-auto p-4 sm:p-2 min-h-screen flex flex-col justify-center">
    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
            Información de Horario
        </h1>
    </div>

    <div class="flex justify-center">
        <div class="bg-white p-6 rounded-lg shadow-md w-full">
            <h2 class="text-base sm:text-lg font-bold text-gray-600 mb-4 mt-4">Datos Personales del Dentista</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-700 mr-4">Nombre:</span>
                        <p class="text-gray-900">{{ old('name', $user->name) }}</p>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-700 mr-7">Cédula:</span>
                        <p class="text-gray-900">{{ old('ci', $dentist->ci) }}</p>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-700 mr-4">Sucursal:</span>
                        <p class="text-gray-900">{{ $dentist->center->name_branch }}</p>
                    </div>
                </div>
                <div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-700 mr-10">Email:</span>
                        <p class="text-gray-900">{{ old('email', $user->email) }}</p>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-700 mr-2">Dirección:</span>
                        <p class="text-gray-900">{{ old('address', $dentist->address) }}</p>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-700 mr-4">Teléfono:</span>
                        <p class="text-gray-900">{{ old('phone', $dentist->phone) }}</p>
                    </div>
                </div>
            </div>
            

            @php
                $daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            @endphp

            <div class="mt-6">
                @foreach ($daysOfWeek as $day)
                    @php
                        $schedule = $schedules->firstWhere('day', $day);
                    @endphp
                    <div class="border-b border-gray-300 my-4"></div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center">
                        <div class="flex items-center w-24">
                            <div class="w-2 h-2 rounded-full bg-sky-400"></div>
                            <h2 class="text-base sm:text-lg font-bold text-gray-600 ml-2">{{ $day }}</h2>
                        </div>
                        @if ($schedule)
                            <div class="ml-2 sm:ml-4 flex flex-col sm:flex-row flex-wrap items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                <p><strong>Hora de Inicio:</strong> {{ $schedule->start_time }}</p>
                                <p><strong>Hora de Fin:</strong> {{ $schedule->end_time }}</p>
                                <p><strong>Descanso:</strong> {{ $schedule->break ? 'Sí' : 'No' }}</p>
                                @if ($schedule->break)
                                    <p><strong>Inicio de Descanso:</strong> {{ $schedule->start_break }}</p>
                                    <p><strong>Fin de Descanso:</strong> {{ $schedule->end_break }}</p>
                                @endif

                                <div class="flex justify-end w-full mt-2">
                                    <button data-schedule-id="{{ $schedule->id }}" data-day="{{ $schedule->day }}"
                                        data-dentist-id="{{ $schedule->dentist_id }}"
                                        data-start-time="{{ $schedule->start_time }}"
                                        data-end-time="{{ $schedule->end_time }}" 
                                        data-break="{{ $schedule->break }}"
                                        data-start-break="{{ $schedule->start_break }}"
                                        data-end-break="{{ $schedule->end_break }}" class="edit-schedule-button">
                                        <img src="{{ asset('img/table/boton-editar.png') }}" alt="editar"
                                            class="w-6 h-6 object-cover">
                                    </button>

                                    <button data-schedule-id="{{ $schedule->id }}" class="delete-schedule-btn">
                                        <img src="{{ asset('img/table/borrar.png') }}" alt="eliminar" class="w-6 h-6 object-cover">
                                    </button>
                                    
                                    <div>
                                        <form method="POST" action="{{ route('schedule.toggle', ['schedule' => $schedule->id]) }}">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                                                {{ $schedule->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    </div>
                                    
                                   
                                </div>
                            </div>
                        @else
                            <div class="ml-0 sm:ml-4 flex items-center">
                                <button
                                    class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 open-modal-button"
                                    data-day="{{ $day }}" data-dentist-id="{{ $dentist->id }}">Registrar
                                    Horario</button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


    <script>
        var storeRoute = "{{ route('schedules.store') }}";
        var csrfToken = '{{ csrf_token() }}';
        

        document.querySelectorAll('.open-modal-button').forEach(button => {
            button.addEventListener('click', function() {
                const day = this.dataset.day;
                const dentistId = this.dataset.dentistId;

                Swal.fire({
                    title: 'Registrar Horario',
                    html: `
                   <form id="register-form" action="${storeRoute}" method="POST" enctype="multipart/form-data" class="text-left space-y-4">
    <input type="hidden" name="_token" value="${csrfToken}">
    <input type="hidden" name="day" value="${day}">
    <input type="hidden" name="dentist_id" value="${dentistId}">
    
    <div class="mb-4 md:flex md:items-center">
        <label for="start_time" class="block text-gray-700 md:w-1/4">Hora de Inicio:</label>
        <div class="md:w-3/4 w-full sm:w-1/2">
            <input type="time" id="start_time" name="start_time" class="swal2-input w-3/4 md:w-1/2" min="08:00" max="18:30">
            <div>
                 <span id="start_time_error" class="text-red-500 text-sm hidden">La hora de inicio es obligatoria y debe estar entre las 8:00 am y las 7:00 pm, en intervalos de 30 minutos.</span> 
            </div>
           
        </div>
    </div>
    
    <div class="mb-4 md:flex md:items-center">
        <label for="end_time" class="block text-gray-700 md:w-1/4">Hora de Fin:</label>
        <div class="md:w-3/4 w-full sm:w-1/2">
            <input type="time" id="end_time" name="end_time" class="swal2-input w-3/4 md:w-1/2" min="08:00" max="18:30">
            <div>
                <span id="end_time_error" class="text-red-500 text-sm hidden">La hora de fin es obligatoria y debe estar entre las 8:00 am y las 7:00 pm, en intervalos de 30 minutos.</span>
            </div>
            
        </div>
    </div>
    
    <div class="mb-4 md:flex md:items-center">
        <label for="break" class="block text-gray-700 md:w-1/4">Descanso:</label>
        <div class="md:w-3/4 w-full sm:w-1/2">
            <select id="break" name="break" class="swal2-input w-3/4 md:w-1/2">
                <option value="no">No</option>
                <option value="si">Sí</option>
            </select>
        </div>
    </div>
    
    <div id="break-times" class="hidden space-y-4">
        <div class="mb-4 md:flex md:items-center">
            <label for="start_break" class="block text-gray-700 md:w-1/4">Inicio de Descanso:</label>
            <div class="md:w-3/4 w-full sm:w-1/2">
                <input type="time" id="start_break" name="start_break" class="swal2-input w-3/4 md:w-1/2" min="11:00" max="15:00">
                <div>
                    <span id="start_break_error" class="text-red-500 text-sm hidden">La hora de inicio del descanso es obligatoria y debe estar entre las 11:00 am y las 3:00 pm, en intervalos de 30 minutos.</span>
                    <span id="start_break_error_extended" class="text-red-500 text-xs hidden">El descanso no puede comenzar antes de las 11:00 am.</span>
                </div>
                
            </div>
        </div>
        <div class="mb-4 md:flex md:items-center">
            <label for="end_break" class="block text-gray-700 md:w-1/4">Fin de Descanso:</label>
            <div class="md:w-3/4 w-full sm:w-1/2">
                <input type="time" id="end_break" name="end_break" class="swal2-input w-3/4 md:w-1/2" min="11:00" max="15:00">
                <div>
                    <span id="end_break_error" class="text-red-500 text-sm hidden">La hora de fin del descanso es obligatoria y debe estar entre las 11:00 am y las 3:00 pm, en intervalos de 30 minutos.</span>
                    <span id="end_break_error_extended" class="text-red-500 text-xs hidden">El descanso no puede terminar después de las 3:00 pm y debe durar máximo 2 horas.</span>
                </div>
            </div>
        </div>
    </div>
</form>

                `,
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Registrar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        const form = document.getElementById('register-form');
                        let valid = true;

                        // Validate start_time
                        const startTime = form.querySelector('#start_time');
                        const startTimeError = form.querySelector('#start_time_error');
                        if (!startTime.value || !validateTime(startTime.value)) {
                            startTimeError.classList.remove('hidden');
                            valid = false;
                        } else {
                            startTimeError.classList.add('hidden');
                        }

                        // Validate end_time
                        const endTime = form.querySelector('#end_time');
                        const endTimeError = form.querySelector('#end_time_error');
                        if (!endTime.value || !validateTime(endTime.value)) {
                            endTimeError.classList.remove('hidden');
                            valid = false;
                        } else {
                            endTimeError.classList.add('hidden');
                        }

                        // Check if start time is not equal to end time
                        if (startTime.value === endTime.value) {
                            startTimeError.textContent =
                                ' La hora de inicio no puede ser igual a la hora de fin. // La hora de inicio es obligatoria y debe estar entre las 8:00 am y las 7:00 pm, en intervalos de 30 minutos.';
                            startTimeError.classList.remove('hidden');
                            valid = false;
                        }

                        // Check if start time is not after end time
                        if (startTime.value > endTime.value) {
                            startTimeError.textContent =
                                'La hora de inicio no puede ser después de la hora de fin.';
                            startTimeError.classList.remove('hidden');
                            valid = false;
                        }

                        // Validate break times if break is "si"
                        const breakSelect = form.querySelector('#break');
                        const startBreak = form.querySelector('#start_break');
                        const endBreak = form.querySelector('#end_break');
                        const startBreakError = form.querySelector('#start_break_error');
                        const endBreakError = form.querySelector('#end_break_error');
                        const startBreakErrorExtended = form.querySelector(
                            '#start_break_error_extended');
                        const endBreakErrorExtended = form.querySelector(
                            '#end_break_error_extended');

                        if (breakSelect.value === 'si') {
                            if (!startBreak.value || !validateTime(startBreak.value)) {
                                startBreakError.classList.remove('hidden');
                                valid = false;
                            } else {
                                startBreakError.classList.add('hidden');
                            }

                            if (!endBreak.value || !validateTime(endBreak.value)) {
                                endBreakError.classList.remove('hidden');
                                valid = false;
                            } else {
                                endBreakError.classList.add('hidden');
                            }

                            // Check if start break 
                            if (startBreak.value < '11:00') {
                                startBreakErrorExtended.classList.remove('hidden');
                                valid = false;
                            } else {
                                startBreakErrorExtended.classList.add('hidden');
                            }

                            // Check if end break 
                            if (endBreak.value > '15:00' || (parseInt(endBreak.value.split(':')[
                                    0]) - parseInt(startBreak.value.split(':')[0])) > 2) {
                                endBreakErrorExtended.classList.remove('hidden');
                                valid = false;
                            } else {
                                endBreakErrorExtended.classList.add('hidden');
                            }

                            // Check if end break is after start break
                            if (endBreak.value <= startBreak.value) {
                                endBreakError.classList.remove('hidden');
                                valid = false;
                            } else {
                                endBreakError.classList.add('hidden');
                            }
                        }

                        return valid ? form : false;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('register-form');
                        const formData = new FormData(form);

                        fetch(storeRoute, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Horario registrado', '', 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Error', 'Hubo un problema al registrar el horario.',
                                    'error');
                            });
                    }
                });

                // Function to validate that time is in 00 or 30 minutes and within clinic hours
                function validateTime(time) {
                    const [hours, minutes] = time.split(':').map(val => parseInt(val));

                    // Check if time is within clinic hours
                    if (hours < 8 || hours > 19 || (hours === 19 && minutes > 0)) {
                        return false;
                    }

                    // Check if minutes are 00 or 30
                    if (minutes !== 0 && minutes !== 30) {
                        return false;
                    }

                    return true;
                }

                // Event listener for break select
                const breakSelect = document.getElementById('break');
                breakSelect.addEventListener('change', function() {
                    const breakTimes = document.getElementById('break-times');
                    if (this.value === 'si') {
                        breakTimes.classList.remove('hidden');
                    } else {
                        breakTimes.classList.add('hidden');
                    }
                });
            });
        });
    </script>

<script>
    document.querySelectorAll('.edit-schedule-button').forEach(button => {
    button.addEventListener('click', function() {
        const scheduleId = this.dataset.scheduleId;
        const day = this.dataset.day;
        const dentistId = this.dataset.dentistId;
        const startTime = this.dataset.startTime;
        const endTime = this.dataset.endTime;
        const breakTime = this.dataset.break;
        const startBreak = this.dataset.startBreak;
        const endBreak = this.dataset.endBreak;

        Swal.fire({
            title: 'Editar Horario',
            html: `
                <form id="edit-form" action="/schedules/${scheduleId}" method="POST" enctype="multipart/form-data" class="text-left space-y-4">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="day" value="${day}">
                    <input type="hidden" name="dentist_id" value="${dentistId}">

                    <div class="mb-4 md:flex md:items-center">
                        <label for="start_time" class="block text-gray-700 md:w-1/4">Hora de Inicio:</label>
                        <div class="md:w-3/4 w-full sm:w-1/2">
                            <input type="time" id="start_time" name="start_time" class="swal2-input w-3/4 md:w-1/2" value="${startTime}" min="08:00" max="19:00">
                            <div>
                                <span id="start_time_error" class="text-red-500 text-sm hidden">La hora de inicio es obligatoria y debe estar entre las 8:00 am y las 7:00 pm, en intervalos de 30 minutos.</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 md:flex md:items-center">
                        <label for="end_time" class="block text-gray-700 md:w-1/4">Hora de Fin:</label>
                        <div class="md:w-3/4 w-full sm:w-1/2">
                            <input type="time" id="end_time" name="end_time" class="swal2-input w-3/4 md:w-1/2" value="${endTime}" min="08:00" max="19:00">
                            <div>
                                <span id="end_time_error" class="text-red-500 text-sm hidden">La hora de fin es obligatoria y debe estar entre las 8:00 am y las 7:00 pm, en intervalos de 30 minutos.</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 md:flex md:items-center">
                        <label for="break" class="block text-gray-700 md:w-1/4">Descanso:</label>
                        <div class="md:w-3/4 w-full sm:w-1/2">
                            <select id="break" name="break" class="swal2-input w-3/4 md:w-1/2">
                                <option value="no" ${breakTime === 'no' ? 'selected' : ''}>No</option>
                                <option value="si" ${breakTime === '1' ? 'selected' : ''}>Sí</option>
                            </select>
                        </div>
                    </div>

                    <div id="break-times" class="space-y-4 ${breakTime === '1' ? '' : 'hidden'}">
                        <div class="mb-4 md:flex md:items-center">
                            <label for="start_break" class="block text-gray-700 md:w-1/4">Inicio de Descanso:</label>
                            <div class="md:w-3/4 w-full sm:w-1/2">
                                <input type="time" id="start_break" name="start_break" class="swal2-input w-3/4 md:w-1/2" value="${startBreak}" min="11:00" max="15:00">
                                <div>
                                    <span id="start_break_error" class="text-red-500 text-sm hidden">La hora de inicio del descanso es obligatoria y debe estar entre las 11:00 am y las 3:00 pm, en intervalos de 30 minutos.</span>
                                    <span id="start_break_error_extended" class="text-red-500 text-xs hidden">El descanso no puede comenzar antes de las 11:00 am.</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 md:flex md:items-center">
                            <label for="end_break" class="block text-gray-700 md:w-1/4">Fin de Descanso:</label>
                            <div class="md:w-3/4 w-full sm:w-1/2">
                                <input type="time" id="end_break" name="end_break" class="swal2-input w-3/4 md:w-1/2" value="${endBreak}" min="11:00" max="15:00">
                                <div>
                                    <span id="end_break_error" class="text-red-500 text-sm hidden">La hora de fin del descanso es obligatoria y debe estar entre las 11:00 am y las 3:00 pm, en intervalos de 30 minutos.</span>
                                    <span id="end_break_error_extended" class="text-red-500 text-xs hidden">El descanso no puede terminar después de las 3:00 pm y debe durar máximo 2 horas.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            `,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Guardar Cambios',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const form = document.getElementById('edit-form');
                    let valid = true;

                    // Validate start_time
                    const startTime = form.querySelector('#start_time');
                    const startTimeError = form.querySelector('#start_time_error');
                    if (!startTime.value || !validateTime(startTime.value)) {
                        startTimeError.classList.remove('hidden');
                        valid = false;
                    } else {
                        startTimeError.classList.add('hidden');
                    }

                    // Validate end_time
                    const endTime = form.querySelector('#end_time');
                    const endTimeError = form.querySelector('#end_time_error');
                    if (!endTime.value || !validateTime(endTime.value)) {
                        endTimeError.classList.remove('hidden');
                        valid = false;
                    } else {
                        endTimeError.classList.add('hidden');
                    }

                    // Check if start time is not equal to end time
                    if (startTime.value === endTime.value) {
                        startTimeError.textContent =
                            'La hora de inicio no puede ser igual a la hora de fin.';
                        startTimeError.classList.remove('hidden');
                        valid = false;
                    }

                    // Check if start time is not after end time
                    if (startTime.value > endTime.value) {
                        startTimeError.textContent =
                            'La hora de inicio no puede ser después de la hora de fin.';
                        startTimeError.classList.remove('hidden');
                        valid = false;
                    }

                    // Validate break times if break is "si"
                    const breakSelect = form.querySelector('#break');
                    const startBreak = form.querySelector('#start_break');
                    const endBreak = form.querySelector('#end_break');
                    const startBreakError = form.querySelector('#start_break_error');
                    const endBreakError = form.querySelector('#end_break_error');
                    const startBreakErrorExtended = form.querySelector(
                        '#start_break_error_extended');
                    const endBreakErrorExtended = form.querySelector(
                        '#end_break_error_extended');

                    if (breakSelect.value === 'si') {
                        if (!startBreak.value || !validateTime(startBreak.value)) {
                            startBreakError.classList.remove('hidden');
                            valid = false;
                        } else {
                            startBreakError.classList.add('hidden');
                        }

                        if (!endBreak.value || !validateTime(endBreak.value)) {
                            endBreakError.classList.remove('hidden');
                            valid = false;
                        } else {
                            endBreakError.classList.add('hidden');
                        }

                        // Check if start break 
                        if (startBreak.value < '11:00') {
                            startBreakErrorExtended.classList.remove('hidden');
                            valid = false;
                        } else {
                            startBreakErrorExtended.classList.add('hidden');
                        }

                        // Check if end break is not after 15:00
                        if (endBreak.value > '15:00') {
                            endBreakErrorExtended.classList.remove('hidden');
                            valid = false;
                        } else {
                            endBreakErrorExtended.classList.add('hidden');
                        }

                        // Check if break duration is not more than 2 hours
                        const breakDuration =
                            (new Date('1970-01-01T' + endBreak.value) - new Date('1970-01-01T' + startBreak.value)) / 1000 / 60 / 60;
                        if (breakDuration > 2) {
                            endBreakErrorExtended.classList.remove('hidden');
                            valid = false;
                        } else {
                            endBreakErrorExtended.classList.add('hidden');
                        }
                    }

                    return valid ? form : false;
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('edit-form');
                    form.submit();
                }
            });

            // Event listener for select change
            const breakSelect = document.getElementById('break');
            const breakTimes = document.getElementById('break-times');
            breakSelect.addEventListener('change', function() {
                if (this.value === 'si') {
                    breakTimes.classList.remove('hidden');
                } else {
                    breakTimes.classList.add('hidden');
                }
            });

            // Function to validate that time is in 00 or 30 minutes and within clinic hours
            function validateTime(time) {
                    const [hours, minutes] = time.split(':').map(val => parseInt(val));

                    // Check if time is within clinic hours
                    if (hours < 8 || hours > 19 || (hours === 19 && minutes > 0)) {
                        return false;
                    }

                    // Check if minutes are 00 or 30
                    if (minutes !== 0 && minutes !== 30) {
                        return false;
                    }

                    return true;
                }
        });
    });


</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-schedule-btn').forEach(button => {
            button.addEventListener('click', function() {
                const scheduleId = this.getAttribute('data-schedule-id');
                
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
                        fetch(`/schedules/${scheduleId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    '¡Eliminado!',
                                    'El horario ha sido eliminado.',
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
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const scheduleId = this.id.split('-')[1];
                const isActive = this.checked;
                updateScheduleState(scheduleId, isActive);
            });
        });

        function updateScheduleState(scheduleId, isActive) {
            fetch(`/update-schedule/${scheduleId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
        }
    });
</script>


@endsection
