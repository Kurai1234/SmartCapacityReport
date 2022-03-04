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
       $users= User::all();
    //    dd($users);
        return view('auth.pages.Users.manageuser',compact('users'));
    }

    public function edit($id){
        dd($id);
    }

    public function delete($id){
        User::destroy($id);
        return redirect()->route('admin.manageuser');
    }

}
