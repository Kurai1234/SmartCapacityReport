@include('layouts.header')
{{-- <x-guest-layout>
    <x-auth-card>
        {{-- <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot> --}}

<!-- Session Status -->
{{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

<!-- Validation Errors -->
{{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
<div class="login--page">
    <div class="login--container">
        <h4>Smart</h4>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif
        <form method="POST" action="{{ route('login') }}" class="login--form--container" >
            @csrf
            <!-- Email Address -->
            <div>
                {{-- <label for="email">{{ __('Email') }} </label> --}}

                <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{old('email')}}" placeholder="Email" required
                    autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                {{-- <label for="password">{{ __('Password') }} </label> --}}
                <input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Password"required
                    autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            {{-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div> --}}

            <div class="flex items-center justify-end mt-4">
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}

                <button class="btn btn-secondary">
                    {{ __('Log in') }}

                </button>
            </div>
        </form>
    </div>
</div>

{{-- </x-auth-card> --}}
{{-- </x-guest-layout> --}}
