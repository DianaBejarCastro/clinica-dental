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
                                data-user_created_at="{{ $patient->user_created_at }}"
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
                                <img src="{{ asset('img/table/cita-cancelar.png') }}" alt="eliminar" class="w-6 h-6">
                            </button>
                            <button class="">
                                <img src="{{ asset('img/table/boton-editar.png') }}" alt="eliminar" class="w-6 h-6">
                            </button>
                        </td>
                    </tr>
                @endforeach

                <!-- Filas de usuarios con rol de paciente que no han completado su registro -->
                @foreach ($incompletePatients as $incomplete)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="">
                            <button class="" onclick="showIncompleteInfo(this)" 
                                data-name="{{ $incomplete->name }}" 
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
                                <img src="{{ asset('img/table/cita-cancelar.png') }}" alt="eliminar" class="w-6 h-6">
                            </button>
                            <button class="">
                                <img src="{{ asset('img/table/boton-editar.png') }}" alt="eliminar" class="w-6 h-6">
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <script>
            $(document).ready(function() {
                $('#patients-table').DataTable({
                    language: spanishLanguageConfig,
                });
                // Ajustar el ancho del <select> después de la inicialización de DataTable
                $('select[name="patients-table_length"]').addClass('w-24');
            });
        </script>
    </div>
@endsection
