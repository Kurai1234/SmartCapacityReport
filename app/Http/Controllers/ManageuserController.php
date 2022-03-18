<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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
        if(auth()->user()->id==$id) return redirect()->back()->with('message','Dont delete yourself silly');
       $isLast=User::query()->all();
       if(count($isLast)<1) return redirect()->back()->with('message','Your the last one dude,do not leave us');
        User::destroy($id);
        return redirect()->route('admin.manageuser');
    }

    public function resetPassword(Request $request)
    {
        
        if(auth()->user()->is_admin){
        if($request->has('passwordReset')){
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $credentials = ['email'=>$request->email];
        $status = Password::sendResetLink(
            $credentials
        );

        return $status == Password::RESET_LINK_SENT
            ? redirect()->route('admin.manageuser')->with('message', 'Password Link Has Been Sent')
            : back()->withErrors(['email' => __($status)]);
    }}
    else {
        return redirect()->back()->withErrors("You are Not admin");
    }

    }

    public function updateUser(Request $request,$id){
        if(auth()->user()->is_admin){
            // dd($request->is_admin);
        if($request->has('updateUser')){
            $user = User::findorFail($id);
            $user->is_admin = $request->is_admin===null? false:true;
           $user->save;
           $user->update($request->except(['_token','updateUser','_method']));
           
            return redirect()->route('admin.manageuser')->with('message','User sucessfully updated');

        }
    }
    else
{
    return redirect()->back()->withErrors("You are Not Admin");
}
}


public function createUser(){
    return view('auth.pages.Users.createuser');
}

}

// yes 