<?php

namespace App\Http\Controllers\api\v1;
use App\Models\AccessPoint;
use App\Http\Controllers\Controller;

use App\Models\AccessPointStatistic;
use Illuminate\Http\Request;
use App\Models\User;

class LiveAccessPointsStatistic extends Controller
{
    //
    public function livedata(){
        $total = count(AccessPoint::all());
        $data = AccessPointStatistic::with('accesspoint','accesspoint.tower','accesspoint.tower.network')->latest()->take($total)->get();
        // dd($data);
        return response()->json(['data'=>$data]);
        }
}
