@extends('layouts.auth-layout')

@section('content')
    <h2>Edit Device Information </h2>
    <h6 class="text-muted">{{ $device->name }}</h6>
    <div class="managedevice--container">
        <div class="">
            {{-- {{old('name')? old('name'):isset($user->name)? $user->name:''}} --}}
            {{-- {{old('name')? old('name'):isset($user->name)? $user->name:''}} --}}

            <form method="POST" action="{{route('devices.update',$device->id)}}"class="row g-3">
                @csrf
                @method('patch')
                <div class="col-md-6">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{old('name')? old('name'):isset($device->name)? $device->name:''}}" required>
                </div>
                <div class="col-md-6">
                    <label for="product" class="form-label">Product:</label>
                    <input type="text" class="form-control" name="product" id="product" value="{{old('product')? old('product'):isset($device->product)? $device->product:''}}" required>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-label">Type:</label>
                    <input type="text" class="form-control" name="type" id="type" value="{{old('type')? old('type'):isset($device->type)? $device->type:''}}"readonly>
                </div>
                <div class="col-md-6">
                    <label for="macaddress" class="form-label">Mac Address:</label>
                    <input type="text" class="form-control" name="macaddress" id="macaddress" value="{{old('macaddress')? old('macaddress'):isset($device->mac_address)? $device->mac_address:''}}"required>
                </div>
                <div class="col-md-6">
                    <label for="ipaddress" class="form-label">IP Address:</label>
                    <input type="text" class="form-control" name="ipaddress" id="ipaddress" value="{{old('ipaddress')? old('ipaddress'):isset($device->ip_address)? $device->ip_address:''}}"readonly>
                </div>
                <div class="col-md-6">
                    <label for="tag" class="form-label">Tag:</label>
                    <input type="text" class="form-control" name="tag" id="tag" value="{{old('tag')? old('tag'):isset($device->tag)? $device->tag:''}}" required>
                </div>
                <div class="col-md-6">
                    <label for="tower" class="form-label">Tower:</label>
                    <input type="text" class="form-control" name="tower" id="tower" value="{{old('tower')? old('tower'):isset($device->tower->name)? $device->tower->name:''}}" readonly>
                </div>
                <div class="col-md-6">
                    <label for="network" class="form-label">Network:</label>
                    <input type="text" class="form-control" name="network" id="network" value="{{old('network')? old('network'):isset($device->tower->network->name)? $device->tower->network->name:''}}"readonly>
                </div>
                {{-- <div class="col-md-12">
                    <label for="status" class="form-check-label">Online:</label>
                    <input type="checkbox" class="form-check-input" id="status">
                </div> --}}
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
