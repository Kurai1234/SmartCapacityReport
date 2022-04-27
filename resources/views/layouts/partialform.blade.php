<div class="form-row">

    <div class="form-group col-md-6">
        <label for="name">Full Name</label>
        <input type="text" required class="form-control" id="name" name="name" placeholder="Name"
            value="{{ (old('name') ? old('name') : isset($user->name)) ? $user->name : '' }}" required>
    </div>

    <div class="form-group col-md-6">
        <label for="user_name">User</label>
        <input type="text" required class="form-control" id="user_name" name="user_name" placeholder="User Name"
            value="{{ (old('user_name') ? old('user_name') : isset($user->user_name)) ? $user->user_name : '' }}"
            required>
    </div>
    <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input type="email" required class="form-control" id="email" name="email" placeholder="Email"
            value=" {{ (old('email') ? old('email') : isset($user->email)) ? $user->email : '' }}" required>
    </div>

    @isset($create)
        <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input type="password" required class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group col-md-6">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" required class="form-control" id="password_confirmation" name="password_confirmation"
                required>
        </div>
    @endisset

</div>
<div class="form-group col-md-6 my-3 ">
    <h4>Roles</h4>
    <hr />
</div>
<div class="form-group col-md-6">
    <select id="roles" class="form-control form-control-sm form-select" name="roles" required>
        <option></option>

        @foreach ($roles as $key)
            @if ($user->role_id == $key->id)
                <option value="{{ $key->id }}" selected> {{ $key->name }}</option>
            @else
                <option value="{{ $key->id }}"> {{ $key->name }}</option>
            @endif
        @endforeach
    </select>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Save Changes?

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-success" name="updateUser">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- fix --}}
