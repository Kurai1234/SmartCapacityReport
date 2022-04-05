@extends('layouts.auth-layout')

@section('content')
<h2>User Management Control</h2>
<h6 class="text-muted">Manage User Accounts</h6>
<div class="container-fluid manage--dashboard">
    <div class="create--user--div mb-3"> 
    <span > Create A User </span>
    
    <a href="{{route('admin.createuser')}}" class="btn btn-success ms-auto">Add User</a>
    </div>
    <hr class="mb-4"/>
    <span>User Database</span>
        @if($errors->any())
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
        @endif

      @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    <div class="manage--user--list table-responsive">
        <table class="table  user--table" id="sortTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="table--hide--column">Name</th>
                    <th>User Name</th>
                    <th class="table--hide--column">Role</th>
                    <th class="table--hide--column">Email</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td >{{$user->name}}</td>
                    <td class="table--hide--column">{{$user->user_name}}</td>
                    <td class="table--hide--column">{{$user->is_admin?"Admin":"User"}}</td>
                    <td class="table--hide--column">{{$user->email}}</td>
                    <td><a class="btn btn-sm btn-primary" href="{{route('admin.edituser',$user->id)}}">Edit</a>
                  
                     <a class="btn btn-sm btn-danger"  href="{{ route('admin.deleteuser',$user->id)}}" onclick="event.preventDefault(); document.getElementById('delete-user-{{$user->id}}').submit()">Delete </a>
                        <form method="POST" action="{{ route('admin.deleteuser',$user->id)}}" id="delete-user-{{$user->id}}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    
</div>
<script defer type="text/javascript" src="{{ asset('js/manageuser.js') }}"> </script>

@endsection
