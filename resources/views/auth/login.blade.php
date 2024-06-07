<x-guest-layout>
    <x-authentication-card>
        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <img src="{{asset('logo/logo-color.png')}}" alt="logo" class="m-5 h-9 w-auto mx-auto">
            </div>
            <div>
                <x-label for="email" value="{{ __('Correo Electronico') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                </label>
            </div>
            <x-button 
            class="flex mt-4 justify-center items-center border bg-sky-500 hover:bg-white hover:text-black hover:border-sky-400 text-white font-bold py-2 px-6 rounded-full">
                {{ __('Iniciar sesión') }}
            </x-button>
            <div class="flex items-center justify-end mt-4">
               
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                
            </div>
        </form>
        <div class="mb-4 mt-4 ">
            <a href="{{ url('login/google') }}" class="ml-2 mr-2 border border-gray-400 hover:bg-gray-300 text-black font-thin py-2 px-4 mb-4 rounded flex items-center justify-center">
                <img src="{{ asset('fonts/google.png') }}" alt="Icono" class="w-5 h-5 mr-4">
                Iniciar sesión con Google
            </a>
        </div>
        <div class="mb-4 mt-4">
            <a href="{{ url('login/facebook') }}" class="ml-2 mr-2 bg-blue-600 hover:bg-blue-700 text-white font-thin py-2 px-4 mb-4 rounded flex items-center justify-center">
                <img src="{{ asset('fonts/facebook-logo.png') }}" alt="Icono" class="w-5 h-5 mr-4">
                Iniciar sesión con Facebook
            </a>
        </div>
    </x-authentication-card>
</x-guest-layout>
