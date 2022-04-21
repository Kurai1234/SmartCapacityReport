@include('layouts.header')

<body class="reset--page">


    <div class="card" style="width: 25rem;">
        <h1 class="text-center"> Reset Password </h1>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">

                        @foreach ($errors->all() as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </div>

                @endif

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb3">
                    <label for="email" class="form-label">Email</label>
                    
                    <input  id="email" class="form-control" type="email" name="email"
                        value="{{ old('email', $request->email) }}" required readonly/>
                        
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>

                    <input id="password" class="form-control" type="password" name="password" required autofocus />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>

                    <input id="password_confirmation" class="form-control" type="password"
                        name="password_confirmation" placeholder="" required />
                </div>

                <div class="flex items-center justify-end mt-4 text-center">
                    <button class="btn btn-success" type="submit">Reset Password </button>
                </div>
            </form>
        </div>
    </div>
</body>



</html>

{{-- <x-guest-layout>
    <x-auth-card>

    <h1>Reset Password</h1>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}
