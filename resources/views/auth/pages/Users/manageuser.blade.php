@extends('layouts.auth-layout')

@section('content')
<h4>User Management Control</h4>
<div class="container-fluid manage--dashboard">
    <div class="create--user--div mb-3"> 
    <span > Create A User </span>
    
    <a href="{{route('admin.createuser')}}" class="btn btn-success ms-auto">Add User</a>
    </div>
    <hr class="mb-4"/>
    <span>User Database</span>
    
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
                    <th>Name</th>
                    <th>User Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <th>{{$user->id}}</th>
                    <th>{{$user->name}}</th>
                    <th>{{$user->user_name}}</th>
                    <th>{{$user->is_admin?"Admin":"User"}}</th>
                    <th>{{$user->email}}</th>
                    <th><a class="btn btn-sm btn-primary" href="{{route('admin.edituser',$user->id)}}">Edit</a>
                  
                     <a class="btn btn-sm btn-danger"  href="{{ route('admin.deleteuser',$user->id)}}" onclick="event.preventDefault(); document.getElementById('delete-user-{{$user->id}}').submit()">Delete </a>
                        <form method="POST" action="{{ route('admin.deleteuser',$user->id)}}" id="delete-user-{{$user->id}}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </th>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    
</div>
@endsection
