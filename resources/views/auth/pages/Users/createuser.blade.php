@extends('layouts.auth-layout')

@section('content')
<h4>User Management Control</h4>
<div class="container-fluid manage--dashboard">
    <span>Create User</span>
    <form method="POST"action={{ route('register') }}>
    @csrf
    @include('layouts.partialform',['create'=>true])
    </form>
@endsection
