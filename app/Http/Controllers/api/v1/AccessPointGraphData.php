<?php

namespace App\Http\Controllers\api\v1;

use App\Models;
use App\Http\Controllers\Controller;
use App\Jobs\AccessPoint;
use App\Models\AccessPoint as ModelsAccessPoint;
use App\Models\AccessPointStatistic;
use Illuminate\Http\Request;

class AccessPointGraphData extends Controller
{
    //
    public function index()
    {
        //devices thare are offline and online
        $collection = AccessPointStatistic::query()->with('accesspoint:id,name,tower_id','accesspoint.tower:id,name,network_id','accesspoint.tower.network:id,name')->latest()->take(ModelsAccessPoint::count())->get();
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
    public function pieChart(){

        //devices that are over 80% capacity throughput
        $collection = AccessPointStatistic::query()->latest()->take(ModelsAccessPoint::count())->get();
        (object)$header= array('accesspoint','Percentage');
        (object) $cool=array('Top-Notch',count($collection->where('dl_capacity_throughput','<',80)));
        (object) $overWork=array('Intense',count($collection->where('dl_capacity_throughput','>=',80)));
        $response[0]=$header;
        $response[1]=$overWork;
        $response[2]=$cool;
        //returns the devices in json format for the piecharts
    return  response()->json($response);
    }
}
