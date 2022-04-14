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
        $response[0] = (object)array('Top-Notch', 'Intense');
        $response[1] = (object)array(count($collection->where('dl_capacity_throughput', '<', $watchPoint),), count($collection->where('dl_capacity_throughput', '>', $watchPoint)));
        return  response()->json($response);
        });
    }
}
