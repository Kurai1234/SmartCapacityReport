@include('layouts.header')

<div class="hero">
 
    <div class="card">
    @if ($errors->any())
    <div class="alert alert-danger">
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        <span class="card-title m-auto f--title">Smart</span>
        <h6 class="card-subtitle m-auto my-2 text-muted">Card subtitle</h6>


        <div class="card-body">
            <form method="POST" action="{{route('firstsignup')}}">
                @csrf
                <input type="text" name="name"placeholder="Full Name" />
                <input type="text" name="user_name"placeholder="User Name"/>

                <input type="text" name="email"placeholder="Email"/>

                <input type="text" name="password"placeholder="Password"/>

                <input type="text" name="password_confirmation" placeholder="ConfirmPassword"/>

                <button type="submit" class="btn btn-secondary">Sign Up</button>
            </form>

        </div>
    </div>

</div>
