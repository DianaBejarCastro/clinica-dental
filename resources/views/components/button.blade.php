<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest bg-gradient-to-b from-sky-600 via-blue-600 to-indigo-400 hover:bg-gradient-to-b hover:from-indigo-400 hover:via-blue-600 hover:to-sky-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
