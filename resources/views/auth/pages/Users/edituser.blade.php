@extends('layouts.auth-layout')

@section('content')
<h4>User Management Control</h4>
<div class="container-fluid manage--dashboard">

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
    {{-- @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif --}}
    <span>User Database</span>
    <form method="POST" action="{{route("admin.updateuser",$user->id)}}">
        @csrf
        @method('patch')
        @include('layouts.partialform')   
    </form>
    <div class="form-group col-md-6 my-4">

        <form method="POST" action="{{route('admin.resetpass')}}" id="submit">
            @csrf
            <input hidden type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}@isset($user){{$user->email}}@endisset">
            <button type="submit" class="btn btn-primary" name="passwordReset">Send Reset Email</button>
            {{-- <a class="btn btn-sm btn-primary">Send Reset email</a> --}}
        </form>
    </div>
</div>


@endsection
