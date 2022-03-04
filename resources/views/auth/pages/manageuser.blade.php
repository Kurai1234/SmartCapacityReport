@extends('layouts.auth-layout')

@section('content')
<h4>User Management Control</h4>
<div class="container-fluid manage--dashboard">
<span>User Database</span>

    <div class="manage--user--list">
        <table class="table table-responsive user--table" id="sortTable">
            <thead>
                <tr>
                <th>ID</th>
                <th >User Name</th>
                <th>Role</th>
                <th>Status</th>
                <th>Email</th>
                <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th>1</th>
                <th>hector </th>
                <th>user</th>
                <th>online</th>
                <th>hect@asmda</th>
                <th><span class="delete"> <a href="#">Delete</a> </span><span class="modify"><a href="#">Modify </a></span></th>
                </tr>
                 <tr>
                <th>2</th>
                <th>vector </th>
                <th>zheck</th>
                <th>online</th>
                <th>hect@asmda</th>
                <th><span class="delete"> <a href="#">Delete</a> </span><span class="modify"><a href="#">Modify </a></span></th>
                </tr>
                 <tr>
                <th>3</th>
                <th>aector </th>
                <th> admin </th>
                <th>online</th>
                <th>hect@asmda</th>
                <th><span class="delete"> <a href="#">Delete</a> </span><span class="modify"><a href="#">Modify </a></span></th>
                </tr>
            </tbody>

        </table>
    </div>
</div>
@endsection
