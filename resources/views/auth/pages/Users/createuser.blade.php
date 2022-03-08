@extends('layouts.auth-layout')

@section('content')
<h4>User Management Control</h4>
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
<div class="container-fluid manage--dashboard">
    <span>Create User</span>
    <form method="POST"action={{ route('register') }}>
    @csrf
    @include('layouts.partialform',['create'=>true])
    </form>
@endsection

{{-- fix --}}
