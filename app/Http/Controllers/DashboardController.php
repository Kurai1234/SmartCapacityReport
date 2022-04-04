<?php

namespace App\Http\Controllers;

use App\Models\AccessPoint;
use App\Models\AccessPointStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Database\Factories\AccessPointFactory;

class DashboardController extends Controller
{
    //

    public function index(){
        return view('auth.pages.dashboard.dashboard');
    }

    
}
