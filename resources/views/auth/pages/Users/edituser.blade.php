@extends('layouts.auth-layout')

@section('content')
<h4>User Management Control</h4>
<div class="container-fluid manage--dashboard">
    <span>User Database</span>

    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name"placeholder="Name" value="{{old('name')}}@isset($user){{$user->name}}@endisset">
            </div>
            <div class="form-group col-md-6">
                <label for="user_name">User</label>
                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" value="{{old('user_name')}}@isset($user){{$user->user_name}}@endisset">
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"placeholder="Email" value="{{old('email')}}@isset($user){{$user->email}}@endisset">
            </div>
        </div>
        <div class="form-group col-md-6 my-4">
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="submit" class="btn btn-sm btn-primary">Send Reset email</button>

            </div>
    </form>
    @endsection
