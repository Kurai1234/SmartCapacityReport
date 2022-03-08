@extends('layouts.auth-layout')

@section('content')
<h4>User Management Control</h4>
<div class="container-fluid manage--dashboard">

    @if ($errors->any())
    <div class="alert alert-danger">
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

<<<<<<< HEAD
        <ul class="list-disc list-inside text-sm text-red-600">
=======
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
>>>>>>> working
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<<<<<<< HEAD
    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    <span>User Database</span>
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{old('name')}}@isset($user){{$user->name}}@endisset">
            </div>
            <div class="form-group col-md-6">
                <label for="user_name">User</label>
                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" value="{{old('user_name')}}@isset($user){{$user->user_name}}@endisset">
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="@isset($user){{$user->email}}@endisset">
            </div>
        </div>
        <div class="form-group col-md-6 my-4">

            <button type="submit" class="btn btn-sm btn-success">Save</button>
        </div>
    </form>
    <div class="form-group col-md-6">

        <form class="my-4" method="POST" action="{{route('admin.resetpass')}}" id="submit">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary">Send Reset Email</button>
            <input hidden type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}@isset($user){{$user->email}}@endisset">

=======
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
>>>>>>> working
        </form>
        

    </div>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" iddata-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


@endsection
