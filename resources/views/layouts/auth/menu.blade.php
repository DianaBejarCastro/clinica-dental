<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>

    <div>
        <nav
            class="z-50 bg-white bg-opacity-80 hover:bg-opacity-100 dark:bg-gray-900 fixed w-full top-0 start-0 border-b border-gray-200 dark:border-gray-600">

            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('logo/logo-color.png') }}" class="h-7" alt="Logo">
                </a>
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <div class="navbar-inicio">
                        <button type="button" onclick="window.location.href='{{ route('login') }}'"
                            class="border bg-sky-400 hover:bg-white hover:text-black hover:border-sky-400 text-white font-bold py-2 px-4 rounded-full flex items-center">
                            <img src="{{ asset('fonts/brillante.png') }}" class="w-4 h-4 mr-2" alt="Icono">
                            Iniciar Sesión
                        </button>
                    </div>
                    <div id="navbar-button">
                        <button type="button" onclick="window.location.href='{{ route('register') }}'"
                        class="border bg-sky-400 hover:bg-white hover:text-black hover:border-sky-400 text-white font-bold py-2 px-4 rounded-full flex items-center ml-2">
                            Registrate</button>
                    </div>

                    <button id="toggle-menu" type="button"
                        class="hidden items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-sticky" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>

                        <img src="{{ asset('fonts/menu.png') }}" alt="Menu Icon">
                    </button>



                </div>
                <div class="items-center justify-between w-full md:w-auto md:order-1" id="navbar-sticky">
                    <ul
                        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-white bg-sky-400 rounded md:bg-transparent md:text-sky-400 md:p-0 md:dark:text-sky-400"
                                aria-current="page">INICIO</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-sky-400 md:p-0 md:dark:hover:text-sky-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">TRATAMIENTOS</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-sky-400 md:p-0 md:dark:hover:text-sky-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">CONTACTO</a>
                        </li>
                        <li class="hidden" id="navbar-option-inicio">
                            <a href="#"
                                class=" md:block  block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-sky-400 md:p-0 md:dark:hover:text-sky-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Iniciar
                                Sesión</a>
                        </li>
                        <li class="hidden" id="navbar-option">
                            <a href="#"
                                class=" md:block  block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-sky-400 md:p-0 md:dark:hover:text-sky-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Registrate</a>
                        </li>

                    </ul>
                </div>


            </div>
        </nav>
    </div>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Función para mostrar u ocultar el menú y el botón de menú según el tamaño de la pantalla
            function checkWidth() {
                if ($(window).width() <= 860) {
                    $('#toggle-menu').removeClass('hidden');
                    $('#navbar-sticky').addClass('hidden');
                    $('#navbar-button').addClass('hidden');
                    $('#navbar-option').removeClass('hidden');
                } else {
                    $('#toggle-menu').addClass('hidden');
                    $('#navbar-sticky').removeClass('hidden');
                    $('#navbar-button').removeClass('hidden');
                    $('#navbar-option').addClass('hidden');
                }
            }

            // Ejecutar al cargar la página
            checkWidth();

            // Ejecutar al cambiar el tamaño de la ventana
            $(window).resize(checkWidth);

            $('#toggle-menu').click(function() {
                $('#navbar-sticky').toggleClass('hidden');
            });

            $('#navbar-button').click(function() {
                $('#navbar-sticky').toggleClass('hidden');
            });
        });
    </script>

    @livewireScripts
</body>

</html>
