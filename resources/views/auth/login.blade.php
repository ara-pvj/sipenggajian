<x-guest-layout>

    <div class="text-center mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 mx-auto mb-3">

        <h1 class="text-3xl font-bold text-blue-700">
            SIPENGGAJIAN
        </h1>

        <p class="text-gray-600">
            SMP Roudhotul Mardhiyyah
        </p>
    </div>

    <!-- Session Status -->

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
    id="email"
    class="block mt-1 w-full rounded-xl"
    type="email"
    name="email"
    :value="old('email')"
    required
    autofocus
    autocomplete="username"
/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input
    id="password"
    class="block mt-1 w-full rounded-xl"
    type="password"
    name="password"
    required
    autocomplete="current-password"
/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

           <div class="flex justify-end">
    <button
        type="submit"
        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition">
        LOG IN
    </button>
</div>
    </form>
</x-guest-layout>
