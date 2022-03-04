<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class DashboardController extends Controller
{
    //

    public function index(){
        // dd(User::with('roles')->find(auth::id()));
        // dd(auth()->user());
        return view('auth.pages.dashboard');
    }
}
