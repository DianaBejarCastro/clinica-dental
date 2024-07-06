<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/datatables-net.css') }}">

    @livewireStyles
    <title>@yield('title', 'Florentina')</title>
</head>

<body>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.js') }}"></script>
    <div>
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
                class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

            <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
                class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gradient-to-b from-sky-600 via-blue-600 to-indigo-400 lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <img src="{{ asset('img/dashboard/icono-principal.png') }}" alt="icono" class="h-5 w-auto">
                        <span class="mx-2 text-2xl font-semibold text-white">Florentina</span>
                    </div>
                </div>

                <nav class="mt-10">
                    <a class="flex items-center px-6 py-2 mt-4 text-white  hover:bg-black hover:bg-opacity-10"
                        href="{{ route('profile') }}">
                        <img src="{{ asset('img/dashboard/perfil.png') }}" alt="icono" class="h-7 w-auto">

                        <span class="mx-3">Perfil</span>
                    </a>
                    @if (Auth::user()->hasRole(['patient']))
                        <a class="flex items-center px-6 py-2 mt-4 text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100"
                            href="{{ route('appointment') }}">
                            <img src="{{ asset('img/dashboard/agenda.png') }}" alt="icono" class="h-7 w-auto">

                            <span class="mx-3">Citas</span>
                        </a>
                    @endif
                    @if (Auth::user()->hasRole(['admin', 'super-admin']))
                        <a class="flex items-center px-6 py-2 mt-4 text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100"
                            href="{{ route('appointment-admin') }}">
                            <img src="{{ asset('img/dashboard/agenda.png') }}" alt="icono" class="h-7 w-auto">

                            <span class="mx-3">Citas</span>
                        </a>
                    @endif
                    @if (Auth::user()->hasRole(['dentist', 'doctor']))
                        <a class="flex items-center px-6 py-2 mt-4 text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100"
                            href="{{ route('appointment-dentist') }}">
                            <img src="{{ asset('img/dashboard/agenda.png') }}" alt="icono" class="h-7 w-auto">

                            <span class="mx-3">Citas</span>
                        </a>
                    @endif
                    @if (Auth::user()->hasRole(['admin', 'super-admin', 'dentist', 'doctor']))
                        <div @click.away="personalOpen = false" x-data="{ personalOpen: false }">
                            <a @click="personalOpen = !personalOpen"
                                class="flex items-center px-6 py-2 mt-4 text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100 cursor-pointer">
                                <img src="{{ asset('img/dashboard/personal.png') }}" alt="icono" class="h-7 w-auto">
                                <span class="mx-3">Pacientes</span>
                                <img :src="personalOpen ? '{{ asset('img/dashboard/flecha-arriba.png') }}' :
                                    '{{ asset('img/dashboard/flecha-abajo.png') }}'"
                                    alt="flecha"
                                    class="inline h-4 w-4 mt-1 ml-1 transition-transform duration-200 transform">
                            </a>
                            <div x-show="personalOpen" x-transition class="mt-2 space-y-2 px-7">

                                <a href="{{ route('patient') }}"
                                    class="block px-4 py-2 text-sm text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100">Registrados</a>
                                <a href="{{ route('complete-patient') }}"
                                    class="block px-4 py-2 text-sm text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100">Nuevos</a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::user()->hasRole(['admin', 'super-admin']))
                        <div @click.away="personalOpen = false" x-data="{ personalOpen: false }">
                            <a @click="personalOpen = !personalOpen"
                                class="flex items-center px-6 py-2 mt-4 text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100 cursor-pointer">
                                <img src="{{ asset('img/dashboard/personal.png') }}" alt="icono" class="h-7 w-auto">
                                <span class="mx-3">Personal</span>
                                <img :src="personalOpen ? '{{ asset('img/dashboard/flecha-arriba.png') }}' :
                                    '{{ asset('img/dashboard/flecha-abajo.png') }}'"
                                    alt="flecha"
                                    class="inline h-4 w-4 mt-1 ml-1 transition-transform duration-200 transform">
                            </a>
                            <div x-show="personalOpen" x-transition class="mt-2 space-y-2 px-7">

                                <a href="{{ route('dentist') }}"
                                    class="block px-4 py-2 text-sm text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100">Dentistas</a>
                                <a href="{{ route('admin') }}"
                                    class="block px-4 py-2 text-sm text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100">Administradores</a>
                            </div>
                        </div>

                        <a class="flex items-center px-6 py-2 mt-4  text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100"
                            href="{{ route('center') }}">
                            <img src="{{ asset('img/dashboard/sucursal.png') }}" alt="icono" class="h-7 w-auto">

                            <span class="mx-3">Sucursales</span>
                        </a>

                        <a class="flex items-center px-6 py-2 mt-4  text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100"
                            href="{{ route('specialty') }}">
                            <img src="{{ asset('img/dashboard/especialidad.png') }}" alt="icono" class="h-7 w-auto">

                            <span class="mx-3">Especialidades</span>
                        </a>
                    @endif
                    @if (Auth::user()->hasRole(['dentist', 'doctor']))
                        <a class="flex items-center px-6 py-2 mt-4 text-white hover:bg-black hover:bg-opacity-10 hover:text-gray-100"
                            href="{{ route('appointment-admin-register') }}">
                            <img src="{{ asset('img/dashboard/historial-medico.png') }}" alt="icono" class="h-7 w-auto">

                            <span class="mx-3">Historial Clinico</span>
                        </a>
                    @endif
                </nav>
            </div>
            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-sky-600">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <img src="{{ asset('fonts/menu.png') }}" alt="icono" class="h-7 w-auto">
                        </button>

                    </div>

                    


                    <div class="flex items-center">
                        <div>
                            <img src="{{ asset('logo/logo-color.png') }}" alt="logo" class="h-5 w-auto mr-3">
                        </div>

                        @if (Auth::user()->hasRole(['admin', 'super-admin', 'dentist', 'doctor']))
                        <!-- Contenedor principal del menú desplegable -->
                    <div x-data="{ dropdownOpen: false, notifications: ['Notificación 1', 'Notificación 2', 'Notificación 3'] }" class="relative">
                        <!-- Botón que abre y cierra el menú desplegable -->
                        <button @click="dropdownOpen = ! dropdownOpen"
                            class="relative block w-8 h-8 overflow-hidden focus:outline-none">
                            <!-- Imagen de la campana con la burbuja roja -->
                            <div class="relative ">
                                <img class="object-cover w-full h-full" src="{{ asset('img/dashboard/campana.png') }}"
                                    alt="Notificaciones">
                                <div
                                    class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">
                                    
                                </div>
                            </div>
                        </button>

                        <!-- Fondo oscuro que cubre toda la pantalla cuando el menú está abierto -->
                        <div x-show="dropdownOpen" @click="dropdownOpen = false"
                            class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

                        <!-- Contenido del menú desplegable -->
                        <div x-show="dropdownOpen"
                            class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl"
                            style="display: none;">
                            <!-- Lista de notificaciones -->
                            <div class="px-4 py-2">
                                <h3 class="text-sm font-semibold mb-2">Notificaciones</h3>
                                <ul>
                                    <template x-for="notification in notifications">
                                        <li
                                            class="text-sm text-gray-700 hover:bg-sky-100 px-2 py-1 rounded-md cursor-pointer">
                                            <span x-text="notification"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                        <div x-data="{ dropdownOpen: false }" class="relative">

                            <button @click="dropdownOpen = ! dropdownOpen"
                                class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                                <img class="object-cover w-full h-full"
                                    src="{{ asset('img/dashboard/usuario-sf.png') }}" alt="Your avatar">
                            </button>

                            <div x-show="dropdownOpen" @click="dropdownOpen = false"
                                class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

                            <div x-show="dropdownOpen"
                                class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl"
                                style="display: none;">
                                <div class="flex items-center px-4  text-sm text-gray-70 ml-2">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="flex items-center px-4 py-2 text-xs text-gray-700">
                                    {{ Auth::user()->email }}
                                </div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-sky-100">
                                        <img src="{{ asset('fonts/cerrar-sesion.png') }}" alt="icono"
                                            class="h-3 w-auto mr-1">{{ __('Cerrar sesión') }}
                                    </x-dropdown-link>
                                </form>

                            </div>
                        </div>
                    </div>
                </header>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                    <div class="container px-6 py-8 mx-auto">
                        @yield('content-dashboard')

                    </div>
                </main>
            </div>
        </div>
    </div>

    <x-app-layout>
    </x-app-layout>



    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/lan-Datatable.js') }}"></script>

    @livewireScripts
</body>

</html>
