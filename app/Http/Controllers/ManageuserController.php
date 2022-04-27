<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Access\Gate;

class ManageuserController extends Controller
{

    private int $superadmin;

    public function __construct()
    {
        $this->superadmin = Role::superadmin();
        // $this->admin = Role::admin();
    }

    public function index()
    {
        // dd(auth()->user()->role->hasAuthority());
        // dd(User::find(1)->role);
        // $dat = Role::higherAuthority(3, 2);
        // dd($dat);
        // dd(auth()->user()->role_id);

        $this->authorize('manage-accounts');
        if (auth()->user()->role_id == $this->superadmin)
            return view('auth.pages.Users.manageuser', ['users' => User::with('role')->superAdminCreate()]);
        return view('auth.pages.Users.manageuser', ['users' => User::with('role')->adminCreate()]);
    }
    public function edit($id)
    {

        $this->authorize('edit-accounts');
        if (auth()->user()->role_id == $this->superadmin)
            return view('auth.pages.Users.edituser', ['user' => User::findOrFail($id), 'roles' => Role::all()]);

        return view('auth.pages.Users.edituser', ['user' => User::findOrFail($id), 'roles' => Role::admincreate()]);
    }

    public function delete($id)
    {
        //checks if the user is authorized to delete accounts
        $this->authorize('delete-accounts');
        //check if the user is attempting to delete their self
        if (auth()->user()->id == $id) return redirect()->back()->withErrors(['message' => 'Dont delete yourself silly']);
        //user register count cannot go below 2 users
        if (User::count() < 2) return redirect()->back()->withErrors(['message' => 'Your the last one dude, do not leave us']);
        //after validation, deletes it
        if (Role::higherAuthority(auth()->user()->id, $id))
            return redirect()->back()->withErrors(['message' => 'You dont have authority']);
        User::destroy($id);
        //redirect back
        return redirect()->route('admin.manageuser');
    }

    public function resetPassword(Request $request)
    {
        //checks if user can reset passwords
        $this->authorize('resetpassword');

        //validates email.
        if ($request->has('passwordReset')) {
            $request->validate([
                'email' => ['required', 'email'],
            ]);

            //set email
            $credentials = ['email' => $request->email];
            $status = Password::sendResetLink(
                $credentials
            );
            //send password reset.
            return $status == Password::RESET_LINK_SENT
                ? redirect()->route('admin.manageuser')->with('message', 'Password Link Has Been Sent')
                : back()->withErrors(['email' => __($status)]);
        }
    }

    public function updateUser(Request $request, $id)
    {
        //checks if users has permission to edit account
        $this->authorize('edit-accounts');
        //set counter.
        $user = User::findorFail($id);
        // dd($user->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'user_name' => 'required|unique:users,user_name,' . $user->id,
            'roles' => 'required|exists:App\Models\Role,id'

        ]);
        //updates user info
        if ($request->has('updateUser')) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_name = $request->user_name;
            $user->role_id = intval($request->roles);
            $user->save();
            // $user->update($request->except(['_token', 'updateUser', '_method']));
            return redirect()->route('admin.manageuser')->with('message', 'User sucessfully updated');
        }
    }


    public function createUser()
    {
        $this->authorize('create-accounts');
        if (auth()->user()->role_id == $this->superadmin)
            return view('auth.pages.Users.createuser', ['roles' => Role::all()]);
        return view('auth.pages.Users.createuser', ['roles' => Role::admincreate()]);
    }
}
