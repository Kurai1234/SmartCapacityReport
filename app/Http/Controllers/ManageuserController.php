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
        $this->authorize('edit-accounts');
        return view('auth.pages.Users.edituser', ['user' => User::find($id)]);
    }

    public function delete($id)
    {   
        $this->authorize('delete-accounts');
        if (auth()->user()->id == $id) return redirect()->back()->withErrors(['message'=> 'Dont delete yourself silly']);
        if (User::count() < 4) return redirect()->back()->withErrors(['message' => 'Your the last one dude, do not leave us']);
        User::destroy($id);
        return redirect()->route('admin.manageuser');
    }

    public function resetPassword(Request $request)
    {

        $this->authorize('resetpassword');
            if ($request->has('passwordReset')) {
                $request->validate([
                    'email' => ['required', 'email'],
                ]);
                $credentials = ['email' => $request->email];
                $status = Password::sendResetLink(
                    $credentials
                );
                return $status == Password::RESET_LINK_SENT
                    ? redirect()->route('admin.manageuser')->with('message', 'Password Link Has Been Sent')
                    : back()->withErrors(['email' => __($status)]);
            }
        }

    public function updateUser(Request $request, $id)
    {
        $this->authorize('edit-accounts');
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
