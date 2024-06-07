<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <img src="{{asset('logo/logo-color.png')}}" alt="logo" class="m-5 h-9 w-auto mx-auto">
            </div>
            <div>
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Correo Electronico') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
           

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif
            <x-button 
            class="flex mt-4 justify-center items-center border bg-sky-500 hover:bg-white hover:text-black hover:border-sky-400 text-white font-bold py-2 px-6 rounded-full">
                {{ __('Registrarse') }}
            </x-button>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('¿Ya estás registrado?') }}
                </a>

                
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
