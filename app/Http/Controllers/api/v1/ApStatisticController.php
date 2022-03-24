<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\AccessPointStatistic;
use App\Models\AccessPoint;
use Illuminate\Http\Request;

class ApStatisticController extends Controller
{
    //
    public function index(){
        $data = AccessPointStatistic::with('accesspoint','accesspoint.tower','accesspoint.tower.network')->latest()->take(AccessPoint::count())->get();
        return response()->json(['data'=>$data]);
    }
}
