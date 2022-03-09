<?php

namespace App\Http\Controllers;

use App\Models\AccessPointStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class DashboardController extends Controller
{
    //

    public function index(){
        $testing = AccessPointStatistic::all();
        // dd(User::with('roles')->find(auth::id()));
        // dd(auth()->user());
        return view('auth.pages.dashboard',['testing'=>$testing]);
    }
}
