@extends('layouts.menu-dashboard')
@section('title', 'Odontograma')
@section('content-dashboard')
    <div class="container mx-auto p-4 sm:p-2">
        <div class="flex flex-col items-center mb-4 md:flex-row md:justify-between md:items-center">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 leading-tight mb-4 shadow-sm">
                Odontograma
            </h1>
            <button
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4 md:mt-0 md:ml-4 open-modal-button">
                Botón
            </button>
        </div>

        <!-- Odontograma de adulto -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Odontograma Adulto</h2>
            <div class="grid grid-cols-8 gap-2 mb-4">
                @for ($i = 1; $i <= 32; $i++)
                    <button
                        class="bg-white border border-gray-300 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                        <img src={{ asset('img/odontogram/diente-blanco.png') }} alt="Diente {{ $i }}" class="w-8 h-8 mx-auto mb-1">
                        D{{ $i }}
                    </button>
                @endfor
            </div>
        </div>

        <!-- Odontograma de niño -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">Odontograma Niño</h2>
            <div class="grid grid-cols-5 gap-2 mb-4">
                @for ($i = 1; $i <= 20; $i++)
                    <button
                        class="bg-white border border-gray-300 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded shadow">
                        <img src={{ asset('img/odontogram/diente-blanco.png') }} alt="Diente {{ $i }}" class="w-8 h-8 mx-auto mb-1">
                        D{{ $i }}
                    </button>
                @endfor
            </div>
        </div>
    </div>
@endsection
