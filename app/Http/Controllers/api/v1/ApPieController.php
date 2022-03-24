<?php

namespace App\Http\Controllers\api\v1;

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
        return Cache::remember('pieinfo', 60 * 5, function () {
            $collection = AccessPointStatistic::query()->latest()->take(AccessPoint::count())->get();
            (object)$header = array('accesspoint', 'Percentage');
            (object) $cool = array('Top-Notch', count($collection->where('dl_capacity_throughput', '<', 80)));
            (object) $overWork = array('Intense', count($collection->where('dl_capacity_throughput', '>=', 80)));
            $response[0] = $header;
            $response[1] = $overWork;
            $response[2] = $cool;
            //returns the devices in json format for the piecharts
            return  response()->json($response);
        });
    }
}
