@extends('layouts.menu-dashboard')
@section('title', 'Horarios')
@section('content-dashboard')
<div class="container mx-auto p-4 sm:p-2">
    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
            Horarios
        </h1>
        <div class="flex flex-col md:flex-row items-center">
            <form action="{{ route('schedule.table') }}" method="GET">
                <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                    Gestionar Horarios
                </button>
            </form>  
        </div>
    </div>
</div>
<div class="bg-gray-100">
    <div class="container mx-auto py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 ml-7 mr-7">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="loadSchedule('Lunes')">Lunes</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="loadSchedule('Martes')">Martes</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="loadSchedule('Miércoles')">Miércoles</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="loadSchedule('Jueves')">Jueves</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="loadSchedule('Viernes')">Viernes</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="loadSchedule('Sábado')">Sábado</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="loadSchedule('Domingo')">Domingo</button>
        </div>
        <div id="schedule-table" class="mt-6">
            <!-- Aquí se mostrará la tabla de horarios -->
        </div>
    </div>
</div>

<script>
    function loadSchedule(day) {
        fetch(`/schedules/${day}`)
            .then(response => response.json())
            .then(data => {
                const tableContainer = document.getElementById('schedule-table');
                tableContainer.innerHTML = generateTableHTML(day, data);
            })
            .catch(error => console.error('Error:', error));
    }

    function generateTableHTML(day, schedules) {
        let tableHTML = `<h2 class="text-xl font-bold mb-4 ml-7">Horarios para ${day}</h2>`;
        tableHTML += `<div class="mx-7"><table class="min-w-full bg-white"><thead><tr><th class="py-2 px-4">Hora</th>`;

        const times = [];
        for (let h = 8; h < 19; h++) {
            times.push(`${h < 10 ? '0' : ''}${h}:00`);
            times.push(`${h < 10 ? '0' : ''}${h}:30`);
        }
        times.push('19:00'); // Añadir la última hora

        tableHTML += `<th class="py-2 px-4">Dentistas</th></tr></thead><tbody>`;

        times.forEach(time => {
            tableHTML += `<tr><td class="border px-4 py-2">${time}</td>`;
            tableHTML += `<td class="border px-4 py-2">`;

            schedules.forEach(schedule => {
                const start = schedule.start_time.slice(0, 5);
                const end = schedule.end_time.slice(0, 5);
                const startBreak = schedule.start_break ? schedule.start_break.slice(0, 5) : null;
                const endBreak = schedule.end_break ? schedule.end_break.slice(0, 5) : null;

                if (start <= time && time < end) {
                    if (!(startBreak && startBreak <= time && time < endBreak)) {
                        tableHTML += `${schedule.dentist_name}<br>`;
                    }
                }
            });

            tableHTML += `</td></tr>`;
        });

        tableHTML += `</tbody></table></div>`;
        return tableHTML;
    }
</script>
@endsection