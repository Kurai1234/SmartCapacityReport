<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageuserController extends Controller
{
    //

    public function index(){
        // dd(User::with('roles')->find(auth::id()));
        // dd(auth()->user());
        return view('auth.pages.manageuser');
    }

}
