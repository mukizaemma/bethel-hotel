<x-guest-layout>
    @php
        $setting = \App\Models\Setting::first();
        $logo = $setting?->logo ? asset('storage/images/' . ltrim($setting->logo, '/')) : null;
    @endphp
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="w-full max-w-md bg-white shadow-xl rounded-lg p-8">
            <div class="text-center mb-6">
                @if($logo)
                    <img src="{{ $logo }}" alt="Hotel Logo" class="mx-auto h-16 w-auto object-contain mb-2">
                @endif
                <p class="text-sm text-gray-500 mt-1">Sign in to continue to your dashboard</p>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <x-button class="w-full justify-center">
                    {{ __('Log in') }}
                </x-button>
            </form>
        </div>
    </div>
</x-guest-layout>
