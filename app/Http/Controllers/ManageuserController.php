<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Access\Gate;

class ManageuserController extends Controller
{

    public function index()
    {
        $this->authorize('manage-accounts');
        return view('auth.pages.Users.manageuser', ['users' => User::all()]);
    }
    public function edit($id)
    {
        //checks if user are allowed to edit accounts
        $this->authorize('edit-accounts');
        //returns request user information
        return view('auth.pages.Users.edituser', ['user' => User::find($id)]);
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
        $counter=$email=0;


        //checks if email is already taken
        foreach(User::where('email', $request->email)->get() as $user){
            if($user->id !=$id){
                ++$email;
            }
        }
        //checks if user_name is already taken
        foreach(User::where('user_name', $request->user_name)->get() as $user){
            if($user->id !=$id){
                ++$counter;
            }
        }
        //if counter is above 0, then users are redirected back
        if ($counter)   return redirect()->back()->withInput()->withErrors(['message' => 'username taken']);
        if ($email)   return redirect()->back()->withInput()->withErrors(['message' => 'Email Taken']);

        //updates user info
        if ($request->has('updateUser')) {
            $user = User::findorFail($id);
            $user->is_admin = $request->is_admin === null ? false : true;
            $user->save;
            $user->update($request->except(['_token', 'updateUser', '_method']));
            return redirect()->route('admin.manageuser')->with('message', 'User sucessfully updated');
        }
    }


    public function createUser()
    {
        $this->authorize('create-accounts');
        return view('auth.pages.Users.createuser');
    }
}
