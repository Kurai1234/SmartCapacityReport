<div class="form-row">

    <div class="form-group col-md-6">
        <label for="name">Full Name</label>
        <input type="text" required class="form-control" id="name" name="name" placeholder="Name" value="{{old('name')}}@isset($user){{$user->name}}@endisset" required>
    </div>
    <div class="form-group col-md-6">
        <label for="user_name">User</label>
        <input type="text" required class="form-control" id="user_name" name="user_name" placeholder="User Name" value="{{old('user_name')}}@isset($user){{$user->user_name}}@endisset" required>
    </div>
    <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input type="email" required class="form-control" id="email" name="email" placeholder="Email" value=" {{old('email')}}@isset($user){{$user->email}}@endisset" required>
    </div>

    @isset($create)

    <div class="form-group col-md-6">
        <label for="password">Password</label>
        <input type="password" required class="form-control" id="password" name="password" required>
    </div>
    <div class="form-group col-md-6">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" required class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>
    @endisset



</div>
<div class="form-group col-md-6 my-3 ">
    <h4>Roles</h4>
    <hr />
</div>
<div class="form-group col-md-6 my-2    ">
    <input class="form-check-input" type="checkbox" value="1" @isset($user) @if($user->is_admin) checked @endif @endisset id="isAdmin" name="is_admin" >
    <label class="form-check-label" for="isAdmin">
        Admin
    </label>
</div>
<div class="form-group col-md-6 my-4">




    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Save
    </button>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Save Changes?

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-success" name="updateUser">Save</button> </div>
        </div>
    </div>
</div>

{{-- fix --}}
