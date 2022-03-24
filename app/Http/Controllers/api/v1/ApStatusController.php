<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\AccessPointStatistic;
use App\Models\AccessPoint;
use Illuminate\Http\Request;

class ApStatusController extends Controller
{
    //
    public function index()
    {
        //devices thare are offline and online
        $collection = AccessPointStatistic::query()->with('accesspoint:id,name,tower_id','accesspoint.tower:id,name,network_id','accesspoint.tower.network:id,name')->latest()->take(AccessPoint::count())->get();
        $data = array( 
            'status'=>array(
            'online' => count($collection->where('status','online')),
            'boarding' => count($collection->where('status','boarding')),
            'offline' => count($collection->where('status','offline')),
        ),
        'devices'=>
            $collection->where('status','offline')
        
    );
        //returns the devices in json format
        return response()->json(['data' => $data]);
    }
}
