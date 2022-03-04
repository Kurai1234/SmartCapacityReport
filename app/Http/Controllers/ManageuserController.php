<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ManageuserController extends Controller
{
    //

    public function index(){
        // dd(User::with('roles')->find(auth::id()));
        // dd(auth()->user());
    //    $users= User::all();
    //    dd($users);
        return view('auth.pages.Users.manageuser',['users'=>User::all()]);
    }

    public function edit($id){
        // $user= User::find($id);
        // dd($user);
        return view('auth.pages.Users.edituser',['user'=>User::find($id)]);
    }

    public function delete($id){
        User::destroy($id);
        return redirect()->route('admin.manageuser');
    }

}
