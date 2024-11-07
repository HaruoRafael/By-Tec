<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-[#2d2d2d] p-8 rounded-lg shadow-lg">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-yellow-500" />
            <x-text-input id="email" class="block mt-1 w-full bg-[#3d3d3d] text-yellow-500 border-gray-700 focus:border-yellow-500 focus:ring focus:ring-yellow-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-yellow-500" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" class="text-yellow-500" />
            <x-text-input id="password" class="block mt-1 w-full bg-[#3d3d3d] text-yellow-500 border-gray-700 focus:border-yellow-500 focus:ring focus:ring-yellow-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-yellow-500" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-yellow-500 shadow-sm focus:ring-yellow-500" name="remember">
                <span class="ml-2 text-sm text-yellow-500">{{ __('Lembrar-me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-yellow-500 hover:text-yellow-400" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif

            <x-primary-button class="ml-3 bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded">
                {{ __('Entrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
