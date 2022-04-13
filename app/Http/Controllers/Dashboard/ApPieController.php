<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AccessPointStatistic;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApPieController extends Controller
{
    //
    public function index()
    {
        //devices that are over 80% capacity throughput
        return Cache::remember('pieinfo', 60 * 10, function () {
            $watchPoint = 80;
            $collection = AccessPointStatistic::query()->latest()->take(AccessPoint::count())->get();
            // (object)$header = array('accesspoint', 'Percentage');
            (object)$header = array('Top-Notch', 'Intense');
            (object) $cool = array(count($collection->where('dl_capacity_throughput', '<', $watchPoint),),count($collection->where('dl_capacity_throughput', '>', $watchPoint)));
            $response[0]= $header;
            $response[1]=$cool;
            //returns the devices in json format for the piecharts
            return  response()->json($response);
        });
    }
}
