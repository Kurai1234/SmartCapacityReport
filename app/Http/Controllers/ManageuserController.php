<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class ManageuserController extends Controller
{
    //

    public function index()
    {
        // dd(User::with('roles')->find(auth::id()));
        // dd(auth()->user());
        //    $users= User::all();
        //    dd($users);
        return view('auth.pages.Users.manageuser', ['users' => User::all()]);
    }

    public function edit($id)
    {
        // $user= User::find($id);
        // dd($user);
        return view('auth.pages.Users.edituser', ['user' => User::find($id)]);
    }

    public function delete($id)
    {
        User::destroy($id);
        return redirect()->route('admin.manageuser');
    }

    public function resetPassword(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        // dd($request->email);
        $credentials = ['email'=>$request->email];
        // Password::sendResetLink($request->only(['email']));
        $status = Password::sendResetLink(
            $credentials
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('message', 'Password Link Has Been Sent')
            : back()->withErrors(['email' => __($status)]);

        // return redirect()->route('admin.manageuser');
    }

    public function updateUser(Request $request){
        dd($request);
    }
}
