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
        $testing = AccessPointStatistic::orderby('dl_throughput','desc')->get();
        // dd(User::with('roles')->find(auth::id()));
        // dd(auth()->user());
        return view('auth.pages.dashboard',['testing'=>$testing]);
    }

    // public function livedata(){
    //     $total = count(AccessPoint::all());
    //     $data = AccessPointStatistic::with('accesspoint','accesspoint.tower','accesspoint.tower.network')->orderby('id','desc')->take($total)->get();

    //     // dd($data);

    //     return response()->json(['data'=>$data]);
    //     }
}
