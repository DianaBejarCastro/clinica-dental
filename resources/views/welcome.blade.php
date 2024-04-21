<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinica Dental Florentina</title>
    <!-- Fonts -->
    <link rel="icon" href="{{asset('fonts/icono-arriba.png')}}" type="image/png">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

</head>

<!--<body class="antialiased">-->

<div>
    <!-- resources/views/menu.blade.php -->
    @include('layouts.auth.menu')
</div>

<body class="antialiased bg-white font-sans text-gray-900">

    <div id="carrousel">
        <div id="animation-carousel" class="relative w-full mt-16 overflow-hidden flex items-center"
            data-carousel="static">

            <!-- Carousel wrapper -->
            <div class="relative w-full h-full flex-shrink-0">
                <!-- Item 1 -->
                <div class="block duration-200 ease-linear" data-carousel-item>
                    <img src="{{ asset('img/banner/banner1.png') }}" class="block w-full h-full object-cover"
                        alt="...">
                </div>
                <!-- Item 2 -->
                <div class="hidden duration-200 ease-linear" data-carousel-item>
                    <img src="{{ asset('img/banner/banner2.png') }}" class="block w-full h-full object-cover"
                        alt="...">
                </div>
                <!-- Item 3 -->
                <div class="hidden duration-200 ease-linear" data-carousel-item="active">
                    <img src="{{ asset('img/banner/banner3.png') }}" class="block w-full h-full object-cover"
                        alt="...">
                </div>
                <!-- Item 4 -->
                <div class="hidden duration-200 ease-linear" data-carousel-item>
                    <img src="{{ asset('img/banner/banner4.png') }}" class="block w-full h-full object-cover"
                        alt="...">
                </div>
            </div>


            <!-- Slider controls -->
            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <!-- Botón anterior -->
                <img src="{{ asset('fonts/before.png') }}" alt="Icono" class="w-9">
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <img src="{{ asset('fonts/next.png') }}" alt="Icono" class="w-9">
                <!-- Botón siguiente -->
            </button>
        </div>
    </div>
    <div>
        <img src="{{ asset('img/banner/banner-foot.png') }}" class="h-full" alt="...">
    </div>
    <main class="w-full">

        <!-- start about -->
        <section class="relative px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 lg:py-10">
            <div class="flex flex-col lg:flex-row lg:-mx-8">
                <div class="w-full lg:w-1/2 lg:px-8">
                    <h2 class="text-3xl leading-tight font-bold mt-4 text-sky-500">
                        ¿Quiénes somos?
                    </h2>
                    <p class="text-lg mt-4 font-semibold  text-sky-400">
                        Consultorio Odontologico Florentina
                    </p>
                    <p class="mt-2 leading-relaxed">
                        Somos una clínica dental comprometida con tu sonrisa.
                        Buscamos ser líderes en odontología, ofreciendo tratamientos
                        de vanguardia con un enfoque personalizado y humano. Nuestro equipo
                        altamente calificado y nuestra tecnología de última generación están
                        dedicados a brindarte la mejor atención dental para ti y tu familia.
                    </p>
                </div>

                <div class="w-full lg:w-1/2 lg:px-8 mt-12 lg:mt-0">
                    <h2 class="text-3xl leading-tight font-bold mt-4 mb-5  text-sky-500">
                        ¿Dónde estamos?
                    </h2>
                    <div class="md:flex">
                        <div>
                            <div class="w-16 h-16 rounded-full">
                                <img src="{{ asset('fonts/icono-cochabamba.png') }}" class=" mr-2 animate-move"
                                    alt="Icono">
                            </div>

                        </div>
                        <div class="md:ml-8 mt-4 md:mt-0">

                            <h4 class="text-xl font-bold leading-tight  text-sky-600">
                                En Cochabamba
                            </h4>
                            <p class="mt-2 leading-relaxed">
                                Villa Sebastián Pagador. Av. Humberto Asin Rivero.
                            </p>
                            <button
                                onclick="window.location.href='https://www.google.com/maps/place/17%C2%B026\'25.6%22S+66%C2%B007\'00.2%22W/@-17.440455,-66.116719,17z/data=!3m1!4b1!4m4!3m3!8m2!3d-17.440455!4d-66.116719?entry=ttu'"
                                class="border bg-white text-black border-sky-400 hover:bg-sky-400 hover:text-white font-bold py-1 px-4 rounded-full flex items-center ml-2">
                                Ver ubicación
                            </button>


                        </div>
                    </div>

                    <div class="md:flex mt-8">
                        <div>
                            <div class="w-16 h-16 rounded-full">
                                <img src="{{ asset('fonts/icono-santa.png') }}" class=" mr-2 animate-move"
                                    alt="Icono">
                            </div>
                        </div>
                        <div class="md:ml-8 mt-4 md:mt-0">
                            <h4 class="text-xl font-bold leading-tight  text-sky-600">
                                En Santa cruz
                            </h4>
                            <p class="mt-2 leading-relaxed">
                                Zona pampa de la isla km6, Calle 2 calle san Felipe.
                            </p>
                            <button onclick="window.location.href='https://maps.app.goo.gl/dLTpmKiJkwudaRWQ7'"
                                class="border bg-white text-black border-sky-400 hover:bg-sky-400 hover:text-white font-bold py-1 px-4 rounded-full flex items-center ml-2">
                                Ver ubicación
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:flex md:flex-wrap mt-24 text-center md:-mx-4">
                <div class="md:w-1/2 md:px-4 lg:w-1/4 flex flex-col">
                    <div
                        class="bg-sky-100 hover:bg-sky-200 rounded-lg border border-gray-300 p-8 flex-grow transition-transform duration-300 transform hover:-translate-y-1">
                        <img src="{{ asset('img/inicio/limpieza.png') }}" alt="" class="h-20 mx-auto">

                        <h4 class="text-xl font-bold mt-4 italic">Limpieza dental</h4>
                        <p class="mt-1">
                            Procedimiento para eliminar la placa y el sarro de los dientes,
                            manteniendo la salud bucal y previniendo enfermedades.
                        </p>
                        <a href="#" class="block mt-4">Read More</a>
                    </div>
                </div>


                <div class="md:w-1/2 md:px-4 lg:w-1/4 flex flex-col">
                    <div
                        class="bg-sky-100 hover:bg-sky-200 rounded-lg border border-gray-300 p-8 flex-grow transition-transform duration-300 transform hover:-translate-y-1">
                        <img src="{{ asset('img/inicio/empasta.png') }}" alt="" class="h-20 mx-auto">

                        <h4 class="text-xl font-bold mt-4 italic">
                            Empastes dentales
                        </h4>
                        <p class="mt-1">
                            Tratamiento para reparar dientes con caries,
                            restaurando su función y forma normal.
                        </p>
                        <a href="#" class="block mt-4">Read More</a>
                    </div>
                </div>

                <div class="md:w-1/2 md:px-4 lg:w-1/4 flex flex-col ">
                    <div
                        class="bg-sky-100 hover:bg-sky-200 rounded-lg border border-gray-300 p-8 flex-grow transition-transform duration-300 transform hover:-translate-y-1">
                        <img src="{{ asset('img/inicio/blanqueamiento.png') }}" alt="" class="h-20 mx-auto">

                        <h4 class="text-xl font-bold mt-4 italic">
                            Blanqueamiento dental
                        </h4>
                        <p class="mt-1">
                            Procedimiento para aclarar el color de los dientes,
                            eliminando manchas y decoloraciones.
                        </p>
                        <a href="#" class="block mt-4">Read More</a>
                    </div>
                </div>

                <div class="md:w-1/2 md:px-4 lg:w-1/4 flex flex-col">
                    <div
                        class="bg-sky-100 hover:bg-sky-200 rounded-lg border border-gray-300 p-8 flex-grow transition-transform duration-300 transform hover:-translate-y-1">
                        <img src="{{ asset('img/inicio/ortodoncia.png') }}" alt="" class="h-20 mx-auto">

                        <h4 class="text-xl font-bold mt-4 italic">
                            Ortodoncia
                        </h4>
                        <p class="mt-1">
                            Corrección de la alineación de los dientes y la
                            mandíbula mediante el uso de aparatos dentales.
                        </p>
                        <a href="#" class="block mt-4">Read More</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- end about -->
        <div id="animated-tooth" class="w-9 h-10 relative overflow-hidden">
            <img src="{{ asset('fonts/fondo.png') }}" alt="Diente" class="w-full">
        </div>

        <!-- start testimonials -->
        <section class="relativ px-4 sm:px-8 lg:px-4 xl:px-40 2xl:px-64 py-6 lg:py-10 ">
            <div class="flex flex-col lg:flex-row lg:-mx-8">
                <div class="w-full lg:w-1/2 lg:px-8 ">
                    <h2 class="text-3xl leading-tight font-bold mt-4 text-sky-500 italic">
                        ¡Horarios Pensados Para Ti
                    </h2>
                    <div class="md:grid md:grid-cols-2 lg:grid-cols-1">
                        <p class="mt-2 md:mt-7 mr-4 ">
                            En nuestra clínica dental, comprendemos lo ocupada que puede estar tu vida,
                            por eso te ofrecemos horarios flexibles de atención de lunes a sábado.
                            Nuestra prioridad es tu comodidad y bienestar, por eso estamos aquí para
                            atenderte en el momento que más te convenga.
                        </p>
                        <div>
                            <img src="{{ asset('img/inicio/fondo-div-1.jpg') }}" alt="">
                        </div>
                    </div>

                </div>

                <div class="w-full md:max-w-md md:mx-auto lg:w-1/2 lg:px-8 mt-12 mt:md-0">
                    <div class="w-full rounded-lg">
                        <div
                            class="max-w-sm mx-auto bg-gradient-to-r from-sky-300 to-purple-300 rounded-lg p-2 mb-4 text-white">
                            <h4 class="font-bold text-lg">Lunes: 8:00 AM - 7:00 PM</h4>
                        </div>
                        <div
                            class="max-w-sm mx-auto bg-gradient-to-r from-sky-300 to-purple-300 rounded-lg p-2 mb-4 text-white">
                            <h4 class="font-bold text-lg">Martes: 8:00 AM - 7:00 PM</h4>
                        </div>
                        <div
                            class="max-w-sm mx-auto bg-gradient-to-r from-sky-300 to-purple-300 rounded-lg p-2 mb-4 text-white">
                            <h4 class="font-bold text-lg">Miércoles: 8:00 AM - 7:00 PM</h4>
                        </div>
                        <div
                            class="max-w-sm mx-auto bg-gradient-to-r from-sky-300 to-purple-300 rounded-lg p-2 mb-4 text-white">
                            <h4 class="font-bold text-lg">Jueves: 8:00 AM - 7:00 PM</h4>
                        </div>
                        <div
                            class="max-w-sm mx-auto bg-gradient-to-r from-sky-300 to-purple-300 rounded-lg p-2 mb-4 text-white">
                            <h4 class="font-bold text-lg">Viernes: 8:00 AM - 7:00 PM</h4>
                        </div>
                        <div
                            class="max-w-sm mx-auto bg-gradient-to-r from-sky-300 to-purple-300 rounded-lg p-2 mb-4 text-white">
                            <h4 class="font-bold text-lg">Sábado: 9:00 AM - 5:00 PM</h4>
                        </div>
                        <div
                            class="max-w-sm mx-auto bg-gradient-to-r from-sky-300 to-purple-300 rounded-lg p-2 mb-4 text-white">
                            <h4 class="font-bold text-lg">Domingo: CERRADO</h4>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- end testimonials -->

        <!-- start blog -->
        <section class="relative bg-white px-4 sm:px-8 lg:px-16 py-12">
            <div class="">
                <h2 class="text-3xl leading-tight font-bold text-sky-500">Encuentranos</h2>
                <p class="text-gray-600 mt-2 md:max-w-lg">
                    Nuestros especialistas están listos para cuidar de tu sonrisa
                    en cada una de nuestras ubicaciones
                    .</p>
            </div>

            <div class="md:flex mt-6 ">
                <div class="md:w-1/2">
                    <div class="bg-white rounded border border-gray-300 aspect-w-1 aspect-h-1">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3806.4023883450077!2d-66.1167222!3d-17.4404444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTfCsDI2JzI1LjYiUyA2NsKwMDcnMDAuMiJX!5e0!3m2!1ses-419!2sbo!4v1713662520786!5m2!1ses-419!2sbo"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center mt-4">
                            <img src="{{ asset('fonts/icono-ubicacion.png') }}" alt="icono" class="h-6">
                            <div class="ml-4">
                                <span class="text-sky-400 font-semibold">En Cochabamba</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:px-4 md:w-1/2 mt-4 md:mt-0">
                    <div class="bg-white rounded border border-gray-300 aspect-w-1 aspect-h-1">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d949.8737803313123!2d-63.122913!3d-17.7684128!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93f1e8a7b74a00bb%3A0x8155a03a6f3fd324!2sCespedes%20consultorio%20dental!5e0!3m2!1ses-419!2sbo!4v1713662469997!5m2!1ses-419!2sbo"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="p-4">

                        <div class="flex items-center mt-4">
                            <img src="{{ asset('fonts/icono-ubicacion.png') }}" alt="icono" class="h-6">
                            <span class="text-sky-400 font-semibold  ml-4">En Santa Cruz</span>
                        </div>

                    </div>
                </div>
            </div>

        </section>
        <!-- end blog -->

        <!-- start cta -->
        <section
            class="relative bg-gradient-to-b from-sky-600 to-sky-100 px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 py-12 text-center md:text-left">
            <div class="md:flex md:items-center md:justify-center">
                <h2 class="text-xl font-bold text-white">
                    Tu cita en un solo clic, ¡agenda ya!
                    <button onclick="#"
                        class="border bg-white text-black border-sky-400 hover:bg-sky-400 hover:text-white font-bold py-1 px-4 rounded-full items-center ml-2 inline-block">
                        Registrar Cita
                    </button>
            </div>
        </section>
        <!-- end cta -->

        <!-- start footer -->
        <footer class="relative bg-gray-900 text-white px-4 sm:px-8 lg:px-16 xl:px-40 2xl:px-64 py-12 lg:py-24">
            <div class="flex flex-col md:flex-row">
                <div class="w-full lg:w-2/6 lg:mx-4 lg:pr-8">
                    <img src="{{asset('logo/logo-white.png')}}" alt=""  class="h-8">
                    <p class="text-gray-400">
                        nos dedicamos a cuidar de tu sonrisa con profesionalismo y 
                        atención personalizada. ¡Déjanos cuidarte y mostrar al mundo
                         tu mejor sonrisa!
                    </p>

                   <!-- <form class="flex items-center mt-6">
                        <div class="w-full">
                            <label class="block uppercase tracking-wide text-gray-600 text-xs font-bold mb-2"
                                for="grid-last-name">
                                Subscribe for our Newsletter
                            </label>
                            <div class="relative">
                                <input
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-4 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    type="email" placeholder="Enter Your Email Address">

                                <button type="submit"
                                    class="bg-teal-500 hover:bg-teal-400 text-white px-4 py-2 text-sm font-bold rounded absolute top-0 right-0 my-2 mr-2">Subscribe</button>
                            </div>
                        </div>
                    </form>-->
                </div>

                <div class="w-full lg:w-1/6 mt-8 lg:mt-0 lg:mx-4">
                    <h5 class="uppercase tracking-wider font-semibold text-gray-500">especialistas en</h5>
                    <ul class="mt-4">
                        <li class="mt-2"><a href="#" title=""
                                class="opacity-75 hover:opacity-100">Ortodoncia</a></li>
                        <li class="mt-2"><a href="#" title=""
                                class="opacity-75 hover:opacity-100">Endodoncia</a></li>
                        <li class="mt-2"><a href="#" title=""
                                class="opacity-75 hover:opacity-100">Periodoncia</a></li>
                    </ul>
                    <h5 class="uppercase tracking-wider font-semibold text-gray-500">y mas</h5>
                </div>

                <div class="w-full lg:w-2/6 mt-8 lg:mt-0 lg:mx-4 lg:pr-8">
                    <h5 class="uppercase tracking-wider font-semibold text-gray-500">contactanos</h5>
                    <ul class="mt-4">
                    
                        <li class="mt-4">
                            <a href="#" title=""
                                class="block flex items-center opacity-75 hover:opacity-100">
                                <span>
                                    <img src="{{asset('fonts/horario-blanco.png')}}" alt="icono" class="h-6">
                                </span>
                                <span class="ml-3">
                                    Lun - Vie: 8:00 - 19:00 
                                    <br>
                                    Sabados: 9:00 - 17:00
                                    <br>
                                    Cerrado Domingos
                                </span>
                            </a>
                        </li>
                        
                        <li class="mt-4">
                            <a href="#" title=""
                                class="block flex items-center opacity-75 hover:opacity-100">
                                <span>
                                    <img src="{{asset('fonts/telefono-blanco.png')}}" alt="icono" class="h-5">
                                </span>
                                <span class="ml-3">
                                    +591 79369921
                                    <br>
                                    Cochabamba
                                </span>
                            </a>
                        </li>
                        <li class="mt-4">
                            <a href="#" title=""
                                class="block flex items-center opacity-75 hover:opacity-100">
                                <span>
                                    <img src="{{asset('fonts/telefono-blanco.png')}}" alt="icono" class="h-5">
                                </span>
                                <span class="ml-3">
                                    +591 714741920
                                    <br>
                                    Santa Cruz
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="w-full lg:w-1/6 mt-8 lg:mt-0 lg:mx-4">
                    <h5 class="uppercase tracking-wider font-semibold text-gray-500">
                        Redes sociales
                    </h5>
                    <ul class="mt-4 flex">
                        <li>
                            <a href="#" target="_blank" title="">
                                <img src="{{ asset('fonts/whatsapp-logo.png') }}" alt="Icono" class="w-6 h-6">
                            </a>
                            
                        </li>

                        <li class="ml-6">
                            <a href="#" target="_blank" title="">
                                <img src="{{ asset('fonts/facebook-logo-1.png') }}" alt="Icono" class="w-6 h-6">
                            </a>
                        </li>

                        <li class="ml-6">
                            <a href="#" target="_blank" title="">
                                <img src="{{ asset('fonts/insta-logo.png') }}" alt="Icono" class="w-6 h-6">
                            </a>
                        </li>

                    </ul>

                    <p class="text-sm text-gray-400 mt-12">© 2024 Consultorio Odontologico <br class="hidden lg:block">
                        Florentina
                    </p>
                </div>
            </div>
        </footer>
        <!-- end footer -->

    </main>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131505823-4"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener todos los elementos del carrusel
            const items = document.querySelectorAll('[data-carousel-item]');
            const prevButton = document.querySelector('[data-carousel-prev]');
            const nextButton = document.querySelector('[data-carousel-next]');
            let currentIndex = 0;
            let intervalId;

            // Función para mostrar un elemento específico
            function showItem(index) {
                // Ocultar todos los elementos
                items.forEach(item => item.classList.add('hidden'));
                // Mostrar el elemento en el índice dado
                items[index].classList.remove('hidden');
            }

            // Función para avanzar al siguiente elemento
            function nextItem() {
                currentIndex = (currentIndex + 1) % items.length;
                showItem(currentIndex);
            }

            // Función para retroceder al elemento anterior
            function prevItem() {
                currentIndex = (currentIndex - 1 + items.length) % items.length;
                showItem(currentIndex);
            }

            // Mostrar el primer elemento al cargar la página
            showItem(currentIndex);

            // Mostrar el siguiente elemento cada 5 segundos
            intervalId = setInterval(nextItem, 5000);

            // Función para reiniciar el intervalo al hacer clic en las flechas
            function resetInterval() {
                clearInterval(intervalId);
                intervalId = setInterval(nextItem, 5000);
            }

            // Mostrar el siguiente elemento al hacer clic en la flecha siguiente
            nextButton.addEventListener('click', function() {
                nextItem();
                resetInterval();
            });

            // Mostrar el elemento anterior al hacer clic en la flecha anterior
            prevButton.addEventListener('click', function() {
                prevItem();
                resetInterval();
            });
        });
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-131505823-4');


        document.addEventListener('DOMContentLoaded', function() {
            const tooth = document.getElementById('animated-tooth');
            tooth.classList.add('animate-spin');
        });
    </script>

</body>

</html>
