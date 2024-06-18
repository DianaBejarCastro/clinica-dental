@extends('layouts.menu-dashboard')
@section('title', 'Pacientes')
@section('content-dashboard')
<div class="container mx-auto p-4 sm:p-2">
    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
            Pacientes
        </h1>
        <div class="flex flex-col md:flex-row items-center">
            <form action="{{ route('patient.register') }}" method="GET">
                <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                    Registrar Paciente
                </button>
            </form>  
        </div>
    </div>
</div>

<!-- Empieza tabla -->
<table id="patients-table" class="min-w-full bg-white max-h-96" width="100%">
    <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
        <tr>
            <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
            <th class="py-2 px-2 text-left">Identificación</th>
            <th class="py-2 px-2 text-left">Nombre</th>
            <th class="py-2 px-2 text-left">Sucursal</th>
            <th class="py-2 px-2 text-left w-10">Acciones</th> <!-- Espacio para los botones "Editar" y "Eliminar" -->
        </tr>
    </thead>
    <tbody class="text-gray-600 text-sm font-light">
        @foreach ($patients as $patient)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="">
                    <button class="" onclick="showInfo(this)" 
                        data-identification_number="{{ $patient->identification_number }}"
                        data-identification_type="{{ $patient->identification_type }}"
                        data-name="{{ $patient->name }}" 
                        data-center="{{ $patient->center }}"
                        data-email="{{ $patient->email }}" 
                        data-gender="{{ $patient->gender }}"
                        data-date_of_birth="{{ $patient->date_of_birth }}"
                        data-address="{{ $patient->address }}" 
                        data-phone="{{ $patient->phone }}"
                        data-user_created_at="{{ $patient->user_created_at}}"
                        data-patient_updated_at="{{ $patient->patient_updated_at }}">
                        <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info" class="w-5 h-5">
                    </button>
                </td>
                <td class="py-3 px-6">{{ $patient->identification_number ?? 'N/A' }}</td>
                <td class="py-3 px-6">{{ $patient->name }}</td>
                <td class="py-3 px-6">{{ $patient->center ?? 'N/A' }}</td>
                <td class="py-3 px-6">
                    <button onclick="editPatient('{{ $patient->id }}')">
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
        $('#patients-table').DataTable({
            language: spanishLanguageConfig,
        });
        // Ajustar el ancho del <select> después de la inicialización de DataTable
        $('select[name="patients-table_length"]').addClass('w-24');
    });
    // Pasar la ruta y el token CSRF a JavaScript
    var storeRoute = "{{ route('centers.store') }}";
    var csrfToken = '{{ csrf_token() }}';


    function editPatient(patientId) {
    fetch('{{ route('patient.setEditId') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id: patientId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.href = '{{ route('patient.edit.view') }}';
        } else {
            console.error('Error setting session ID');
        }
    })
    .catch(error => console.error('Error:', error));
}



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
        <strong style="grid-column: 1; text-align: left;">Numero de Identificación:</strong>
        <span style="grid-column: 2; text-align: left;">${identification_number}</span>

        <strong style="grid-column: 1; text-align: left;">Tipo de Identificación:</strong>
        <span style="grid-column: 2; text-align: left;">${identification_type}</span>

        <strong style="grid-column: 1; text-align: left;">Nombre:</strong>
        <span style="grid-column: 2; text-align: left;">${name}</span>

        <strong style="grid-column: 1; text-align: left;">Centro:</strong>
        <span style="grid-column: 2; text-align: left;">${center}</span>

        <strong style="grid-column: 1; text-align: left;">Email:</strong>
        <span style="grid-column: 2; text-align: left;">${email}</span>

        <strong style="grid-column: 1; text-align: left;">Genero:</strong>
        <span style="grid-column: 2; text-align: left;">${gender}</span>

        <strong style="grid-column: 1; text-align: left;">Fecha de <br> nacimiento:</strong>
        <span style="grid-column: 2; text-align: left;">${date_of_birth}</span>

        <strong style="grid-column: 1; text-align: left;">Dirección:</strong>
        <span style="grid-column: 2; text-align: left;">${address}</span>

        <strong style="grid-column: 1; text-align: left;">Telefono:</strong>
        <span style="grid-column: 2; text-align: left;">${phone}</span>


        <strong style="grid-column: 1; text-align: left;">Creado en:</strong>
        <span style="grid-column: 2; text-align: left;">${user_created_at}</span>

        <strong style="grid-column: 1; text-align: left;">Actualizado en:</strong>
        <span style="grid-column: 2; text-align: left;">${patient_updated_at}</span>
      </div>
      `,
        confirmButtonText: 'Aceptar'
    });
}



</script>
@if (session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Registro exitoso',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar'
            }).then(function() {
                @php
                    session()->forget('success');
                @endphp
            });
        });
    </script>
@endif



@endsection
