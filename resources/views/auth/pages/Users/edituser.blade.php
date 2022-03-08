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
    {{-- fix --}}
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
