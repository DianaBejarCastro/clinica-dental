@extends('layouts.menu-dashboard')
@section('title', 'Citas')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-2 shadow-sm">
                Datos Médicos
            </h1>
            <button onclick="Odontogram('{{ $patient->id }}')"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                Ir a Odontograma
            </button>
        </div>
    </div>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Datos medicos de {{ $patient->user->name }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-500 text-white p-2 rounded-full mr-4">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Información del Paciente</h2>
                </div>
                <div class="space-y-2">
                    <p><strong>Nombre:</strong> {{ $patient->user->name }}</p>
                    <p><strong>Identificación:</strong> {{ $patient->identification_number }}</p>
                    <p><strong>Correo Electrónico:</strong> {{ $patient->user->email }}</p>
                    <p><strong>Centro:</strong> {{ $patient->center->name_branch ?? 'N/A' }}</p>
                    <p><strong>Género:</strong> {{ $patient->gender }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ $patient->date_of_birth }}</p>
                    <p><strong>Dirección:</strong> {{ $patient->address }}</p>
                    <p><strong>Teléfono:</strong> {{ $patient->phone }}</p>
                    <!-- Añade más campos según sea necesario -->
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="bg-green-500 text-white p-2 rounded-full mr-4">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Contactos de Emergencia</h2>
                </div>
                <div class="space-y-2">
                    @if ($patient->emergencyContacts->isEmpty())
                        <p class="text-red-500">Completar información</p>
                    @else
                        @foreach ($patient->emergencyContacts as $contact)
                            <p><strong>Nombre:</strong> {{ $contact->name ?? 'Sin información' }}</p>
                            <p><strong>Relación:</strong> {{ $contact->relationship ?? 'Sin información' }}</p>
                            <p><strong>Dirección:</strong> {{ $contact->address ?? 'Sin información' }}</p>
                            <p><strong>Teléfono:</strong> {{ $contact->phone ?? 'Sin información' }}</p>
                            <hr class="my-2">
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!--Tabla de enfermedades-->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full">
            <div class="flex items-center mb-4">
                <div class="bg-red-500 text-white p-2 rounded-full mr-4">
                    <i class="fas fa-briefcase-medical"></i>
                </div>
                <div class="container mx-auto p-4 sm:p-2">
                    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
                        <h2 class="text-2xl font-bold">Enfermedades</h2>
                        <button
                            class="bg-red-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button"
                            onclick="openDiseaseModal('{{ $patient->id }}', '{{ $patient->user->name }}')">
                            Registrar Enfermedad
                        </button>
                    </div>
                </div>
            </div>

            @if ($diseases->isEmpty())
                <div class="text-red-500">
                    El paciente no tiene ninguna enfermedad registrada.
                </div>
            @else
                <!-- Tabla de enfermedades -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                    <div class="space-y-2">
                        <table id="disease-table" class="min-w-full bg-white max-h-96" width="100%">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                                    <th class="py-2 px-2 text-left">Nombre</th>
                                    <th class="py-2 px-2 text-left w-10">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($diseases as $disease)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td>
                                            <button class="" onclick="showInfo(this)"
                                                data-name="{{ $disease->name }}"
                                                data-description="{{ $disease->description }}"
                                                data-created-at="{{ $disease->created_at }}"
                                                data-updated-at="{{ $disease->updated_at }}">
                                                <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info"
                                                    class="w-5 h-5">
                                            </button>
                                        </td>
                                        <td class="py-2 px-2">{{ $disease->name }}</td>
                                        <td class="py-2 px-2">
                                            <button
                                                onclick="openEditDiseaseModal('{{ $disease->id }}', '{{ $disease->name }}', '{{ $disease->description }}')">
                                                <img src="{{ asset('img/table/boton-editar.png') }}" alt="editar"
                                                    class="w-6 h-6">
                                            </button>
                                            <button data-disease-id="{{ $disease->id }}" class="delete-disease-btn">
                                                <img src="{{ asset('img/table/borrar.png') }}" alt="eliminar"
                                                    class="w-6 h-6">
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- Termina enfermedades -->





    <!--Tabla de Alergias-->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full">
            <div class="flex items-center mb-4">
                <div class="bg-red-500 text-white p-2 rounded-full mr-4">
                    <i class="fas fa-briefcase-medical"></i>
                </div>

                <div class="container mx-auto p-4 sm:p-2">
                    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
                        <h2 class="text-2xl font-bold">Alergias</h2>
                        <button
                            class="bg-red-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button"
                            onclick="openAllergyModal('{{ $patient->id }}', '{{ $patient->user->name }}')">
                            Registrar Alergia
                        </button>
                    </div>
                </div>
            </div>


            @if ($allergies->isEmpty())
                <div class="text-red-500">
                    El paciente no tiene ninguna alergia registrada.
                </div>
            @else
                <!-- Tabla de enfermedades -->
                <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                    <div class="space-y-2">
                        <table id="alerrgy-table" class="min-w-full bg-white max-h-96" width="100%">
                            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-2 px-2 text-left w-10"></th> <!-- Espacio para el botón "ver más info" -->
                                    <th class="py-2 px-2 text-left">Nombre</th>
                                    <th class="py-2 px-2 text-left w-10">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($allergies as $allergy)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td>
                                            <button class="" onclick="showInfoAllergy(this)"
                                                data-name="{{ $allergy->name }}"
                                                data-description="{{ $allergy->description }}"
                                                data-created-at="{{ $allergy->created_at }}"
                                                data-updated-at="{{ $allergy->updated_at }}">
                                                <img src="{{ asset('img/table/circulo-plus.png') }}" alt="Ver más info"
                                                    class="w-5 h-5">
                                            </button>
                                        </td>
                                        <td class="py-2 px-2">{{ $allergy->name }}</td>
                                        <td class="py-2 px-2">
                                            <button
                                                onclick="openEditAllergyModal('{{ $allergy->id }}', '{{ $allergy->name }}', '{{ $allergy->description }}')">
                                                <img src="{{ asset('img/table/boton-editar.png') }}" alt="editar"
                                                    class="w-6 h-6">
                                            </button>

                                            <button data-allergy-id="{{ $allergy->id }}" class="delete-allergy-btn">
                                                <img src="{{ asset('img/table/borrar.png') }}" alt="eliminar"
                                                    class="w-6 h-6">
                                            </button>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Termina Alergias -->

    <!--Tabla de Medicamentos -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full">
            <div class="flex items-center mb-4">
                <div class="bg-red-500 text-white p-2 rounded-full mr-4">
                    <i class="fas fa-briefcase-medical"></i>
                </div>

                <div class="container mx-auto p-4 sm:p-2">
                    <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
                        <h2 class="text-2xl font-bold">Medicamentos</h2>
                        <button
                            class="bg-red-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button"
                            onclick="openMedicationModal('{{ $patient->id }}', '{{ $patient->user->name }}')">
                            Registrar Medicamento
                        </button>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <!-- Empieza tabla -->
                @if ($medications->isEmpty())
                    <div class="text-red-500">
                        El paciente no tiene ninguna medicación registrada.
                    </div>
                @else
                    <!-- Tabla de enfermedades -->
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
                        <div class="space-y-2">
                            <table id="medication-table" class="min-w-full bg-white max-h-96" width="100%">
                                <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <tr>
                                        <th class="py-2 px-2 text-left w-10"></th>
                                        <!-- Espacio para el botón "ver más info" -->
                                        <th class="py-2 px-2 text-left">Nombre</th>
                                        <th class="py-2 px-2 text-left">es acivo</th>
                                        <th class="py-2 px-2 text-left w-10">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach ($medications as $medication)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td>
                                                <button class="" onclick="showInfoMedication(this)"
                                                    data-name="{{ $medication->name }}"
                                                    data-description="{{ $medication->description }}"
                                                    data-created-at="{{ $medication->is_active }}"
                                                    data-created-at="{{ $medication->created_at }}"
                                                    data-updated-at="{{ $medication->updated_at }}">
                                                    <img src="{{ asset('img/table/circulo-plus.png') }}"
                                                        alt="Ver más info" class="w-5 h-5">
                                                </button>
                                            </td>
                                            <td class="py-2 px-2">{{ $medication->name }}</td>
                                           
                                            <td class="py-2 px-2">
                                              {{ $medication->is_active ? 'Sí' : 'No' }}
                                          </td>
                                          
                                            <td class="py-2 px-2">
                                                <button
                                                    onclick="openEditMedicationModal('{{ $medication->id }}', '{{ $medication->name }}', '{{ $medication->description }}', '{{ $medication->is_active }}')">
                                                    <img src="{{ asset('img/table/boton-editar.png') }}" alt="editar"
                                                        class="w-6 h-6">
                                                </button>

                                                <button data-medication-id="{{ $medication->id }}"
                                                    class="delete-medication-btn">
                                                    <img src="{{ asset('img/table/borrar.png') }}" alt="eliminar"
                                                        class="w-6 h-6">
                                                </button>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Termina Alergias -->

            <script>
                function openDiseaseModal(patientId, patientName) {
                    Swal.fire({
                        title: 'Registrar Enfermedad',
                        html: `
                  <form id="diseaseForm" method="POST" action="{{ route('diseases.store') }}">
                    @csrf
                    <input type="hidden" name="patient_id" value="${patientId}">
                    <div class="flex flex-col mb-4">
                        <label class="mb-1">Nombre del Paciente: ${patientName}</label>
                    </div>
                    <div class="flex flex-col mb-4">
                        <label for="name" class="mb-1">Nombre:</label>
                        <input type="text" id="name" name="name" class="swal2-input h-10 px-4 border border-gray-300 rounded-md" required>
                        <div id="name-error" class="text-red-500 mt-1"></div> <!-- Div para mostrar mensaje de error -->
                    </div>
                    <div class="flex flex-col mb-4">
                        <label for="description" class="mb-1">Descripción:</label>
                        <textarea id="description" name="description" class="swal2-input h-24 px-4 py-2 border border-gray-300 rounded-md"></textarea>
                    </div>
                </form>

              `,
                        showCancelButton: true,
                        confirmButtonText: 'Registrar',
                        preConfirm: () => {
                            const name = document.getElementById('name').value;
                            if (!name) {
                                document.getElementById('name-error').textContent = 'Este campo es obligatorio.';
                                return false;
                            } else {
                                document.getElementById('diseaseForm').submit();
                            }
                        }
                    });
                }
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

            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: '{{ session('error') }}',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                </script>
            @endif

            <script>
                function openEditDiseaseModal(diseaseId, diseaseName, diseaseDescription) {
                    Swal.fire({
                        title: 'Editar Enfermedad',
                        html: `
                  <form id="editDiseaseForm" method="POST" action="{{ route('diseases.update') }}">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="disease_id" value="${diseaseId}">
                      <div class="flex flex-col mb-4">
                          <label class="mb-1">Nombre:</label>
                          <input type="text" id="name" name="name" class="swal2-input h-10 px-4 border border-gray-300 rounded-md" value="${diseaseName}" required>
                          <div id="name-error" class="text-red-500 mt-1"></div> <!-- Div para mostrar mensaje de error -->
                      </div>
                      <div class="flex flex-col mb-4">
                          <label class="mb-1">Descripción:</label>
                          <textarea id="description" name="description" class="swal2-input h-24 px-4 py-2 border border-gray-300 rounded-md">${diseaseDescription}</textarea>
                      </div>
                  </form>
              `,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar cambios',
                        preConfirm: () => {
                            const name = document.getElementById('name').value;
                            if (!name) {
                                document.getElementById('name-error').textContent = 'Este campo es obligatorio.';
                                return false;
                            } else {
                                document.getElementById('editDiseaseForm').submit();
                            }
                        }
                    });
                }
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-disease-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const diseaseId = this.getAttribute('data-disease-id');

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
                                    fetch(`/diseases/delete/${diseaseId}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        })
                                        .then(response => {
                                            if (response.ok) {
                                                Swal.fire(
                                                    '¡Eliminado!',
                                                    'La enfermedad ha sido eliminada.',
                                                    'success'
                                                ).then(() => {
                                                    window.location.reload();
                                                });
                                            } else {
                                                Swal.fire(
                                                    'Error',
                                                    'Hubo un problema al eliminar la enfermedad.',
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
                function showInfo(button) {
                    const name = button.getAttribute('data-name');
                    const description = button.getAttribute('data-description');
                    const createdAt = new Date(button.getAttribute('data-created-at')).toLocaleString();
                    const updatedAt = new Date(button.getAttribute('data-updated-at')).toLocaleString();

                    Swal.fire({
                        title: 'Información de la Enfermedad',
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
            </script>


            <!-- Alergias -->
            <script>
                function openAllergyModal(patientId, patientName) {
                    Swal.fire({
                        title: 'Registrar Alergia',
                        html: `
        <form id="AllergyForm" method="POST" action="{{ route('allergies.store') }}">
            @csrf
            <input type="hidden" name="patient_id" value="${patientId}">
              <div class="flex flex-col mb-4">
                <label class="mb-1">Nombre del Paciente: ${patientName}</label>
              </div>
              <div class="flex flex-col mb-4">
                <label for="name" class="mb-1">Nombre:</label>
                <input type="text" id="name" name="name" class="swal2-input h-10 px-4 border border-gray-300 rounded-md" required>
              <div id="name-error" class="text-red-500 mt-1"></div> <!-- Div para mostrar mensaje de error -->
              </div>
              <div class="flex flex-col mb-4">
              <label for="description" class="mb-1">Descripción:</label>
              <textarea id="description" name="description" class="swal2-input h-24 px-4 py-2 border border-gray-300 rounded-md"></textarea>
              </div>
        </form>

    `,
                        showCancelButton: true,
                        confirmButtonText: 'Registrar',
                        preConfirm: () => {
                            const name = document.getElementById('name').value;
                            if (!name) {
                                document.getElementById('name-error').textContent = 'Este campo es obligatorio.';
                                return false;
                            } else {
                                document.getElementById('AllergyForm').submit();
                            }
                        }
                    });
                }
            </script>
            <script>
                function openEditAllergyModal(allergyId, allergyName, allergyDescription) {
                    Swal.fire({
                        title: 'Editar Alergia',
                        html: `
                  <form id="editAllergyForm" method="POST" action="{{ route('allergies.update') }}">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="allergy_id" value="${allergyId}">
                      <div class="flex flex-col mb-4">
                          <label class="mb-1">Nombre:</label>
                          <input type="text" id="name" name="name" class="swal2-input h-10 px-4 border border-gray-300 rounded-md" value="${allergyName}" required>
                          <div id="name-error" class="text-red-500 mt-1"></div>
                      </div>
                      <div class="flex flex-col mb-4">
                          <label class="mb-1">Descripción:</label>
                          <textarea id="description" name="description" class="swal2-input h-24 px-4 py-2 border border-gray-300 rounded-md">${allergyDescription}</textarea>
                      </div>
                  </form>
                  `,
                        showCancelButton: true,
                        confirmButtonText: 'Guardar cambios',
                        preConfirm: () => {
                            const name = document.getElementById('name').value;
                            if (!name) {
                                document.getElementById('name-error').textContent = 'Este campo es obligatorio.';
                                return false;
                            } else {
                                document.getElementById('editAllergyForm').submit();
                            }
                        }
                    });
                }
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-allergy-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const allergyId = this.getAttribute('data-allergy-id');

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
                                    fetch(`/allergies/delete/${allergyId}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        })
                                        .then(response => {
                                            if (response.ok) {
                                                Swal.fire(
                                                    '¡Eliminado!',
                                                    'La alergia ha sido eliminada.',
                                                    'success'
                                                ).then(() => {
                                                    window.location.reload();
                                                });
                                            } else {
                                                Swal.fire(
                                                    'Error',
                                                    'Hubo un problema al eliminar la alergia.',
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
                function showInfoAllergy(button) {
                    const name = button.getAttribute('data-name');
                    const description = button.getAttribute('data-description');
                    const createdAt = new Date(button.getAttribute('data-created-at')).toLocaleString();
                    const updatedAt = new Date(button.getAttribute('data-updated-at')).toLocaleString();

                    Swal.fire({
                        title: 'Información de la Alergia',
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
            </script>


            <!-- Medicamentos -->


            <script>
                function openMedicationModal(patientId, patientName) {
                    Swal.fire({
                        title: 'Registrar Medicación',
                        html: `
    <form id="medicationForm" method="POST" action="{{ route('medications.store') }}">
    @csrf
    <input type="hidden" name="patient_id" value="${patientId}">
    <div class="flex flex-col mb-4">
        <label class="mb-1">Nombre del Paciente: ${patientName}</label>
    </div>
    <div class="flex flex-col mb-4">
        <label for="name" class="mb-1">Nombre:</label>
        <input type="text" id="name" name="name" class="swal2-input h-10 px-4 border border-gray-300 rounded-md" required>
        <div id="name-error" class="text-red-500 mt-1"></div> <!-- Div para mostrar mensaje de error -->
    </div>
    <div class="flex flex-col mb-4">
        <label for="description" class="mb-1">Descripción:</label>
        <textarea id="description" name="description" class="swal2-input h-24 px-4 py-2 border border-gray-300 rounded-md"></textarea>
    </div>
    <div class="flex flex-col mb-4">
        <label for="is_active" class="mb-1">¿Actualmente está tomando este medicamento?</label>
        <select id="is_active" name="is_active" class="swal2-input h-10 px-4 border border-gray-300 rounded-md">
            <option value="1">Sí</option>
            <option value="0">No</option>
        </select>
    </div>
</form>

`,
                        showCancelButton: true,
                        confirmButtonText: 'Registrar',
                        preConfirm: () => {
                            const name = document.getElementById('name').value;
                            if (!name) {
                                document.getElementById('name-error').textContent = 'Este campo es obligatorio.';
                                return false;
                            } else {
                                document.getElementById('medicationForm').submit();
                            }
                        }
                    });
                }
            </script>

            
            <script>
              function openEditMedicationModal(medicationId, medicationName, medicationDescription, medicationIsActive) {
    Swal.fire({
        title: 'Editar Medicación',
        html: `
            <form id="editMedicationForm" method="POST" action="{{ route('medications.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="medication_id" value="${medicationId}">
                <div class="flex flex-col mb-4">
                    <label class="mb-1">Nombre:</label>
                    <input type="text" id="name" name="name" class="swal2-input h-10 px-4 border border-gray-300 rounded-md" value="${medicationName}" required>
                    <div id="name-error" class="text-red-500 mt-1"></div>
                </div>
                <div class="flex flex-col mb-4">
                    <label class="mb-1">Descripción:</label>
                    <textarea id="description" name="description" class="swal2-input h-24 px-4 py-2 border border-gray-300 rounded-md">${medicationDescription}</textarea>
                </div>
                <div class="flex flex-col mb-4">
                    <label for="is_active" class="mb-1">Actualmente tomando:</label>
                    <select id="is_active" name="is_active" class="swal2-input h-10 px-4 border border-gray-300 rounded-md">
                        <option value="1" ${medicationIsActive == 1 ? 'selected' : ''}>Sí</option>
                        <option value="0" ${medicationIsActive == 0 ? 'selected' : ''}>No</option>
                    </select>
                </div>
            </form>
            `,
                      showCancelButton: true,
                      confirmButtonText: 'Guardar cambios',
                      preConfirm: () => {
                          const name = document.getElementById('name').value;
                          if (!name) {
                              document.getElementById('name-error').textContent = 'Este campo es obligatorio.';
                              return false;
                          } else {
                              document.getElementById('editMedicationForm').submit();
                          }
                      }
                  });
              }
          </script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-medication-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const medicationId = this.getAttribute('data-medication-id');

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
                                fetch(`/medications/delete/${medicationId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(response => {
                                        if (response.ok) {
                                            Swal.fire(
                                                '¡Eliminado!',
                                                'La enfermedad ha sido eliminada.',
                                                'success'
                                            ).then(() => {
                                                window.location.reload();
                                            });
                                        } else {
                                            Swal.fire(
                                                'Error',
                                                'Hubo un problema al eliminar la enfermedad.',
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
  function showInfoMedication(button) {
    const name = button.getAttribute('data-name');
    const description = button.getAttribute('data-description');
    const isActive = button.getAttribute('data-is_active') == 1 ? 'Sí' : 'No';
    const createdAt = new Date(button.getAttribute('data-created-at')).toLocaleString();
    const updatedAt = new Date(button.getAttribute('data-updated-at')).toLocaleString();

    Swal.fire({
        title: 'Información de la medicación',
        html: `
            <div class="text-left">
                <div class="items-specialty mb-2">
                    <strong style="width: 120px; display: inline-block;">Nombre:</strong>
                    <span>${name}</span>
                </div>
                <div class="items-specialty mb-2">
                    <strong style="width: 120px; display: inline-block;">Descripción:</strong>
                    <span>${description}</span>
                </div>
                <div class="items-specialty mb-2">
                    <strong style="width: 120px; display: inline-block;">Tomando actualmente:</strong>
                    <span>${isActive}</span>
                </div>
                <div class="items-specialty mb-2">
                    <strong style="width: 120px; display: inline-block;">Creado:</strong>
                    <span>${createdAt}</span>
                </div>
                <div class="items-specialty mb-2">
                    <strong style="width: 120px;">Actualizado:</strong>
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
</script>
<script>
    function Odontogram(patientId) {
        fetch('{{ route('history.setEditId') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: patientId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = '{{ route('odontogram.edit.view') }}';
                } else {
                    console.error('Error setting session ID');
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

@endsection
