<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AccessPointStatistic;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApStatusController extends Controller
{
    //
    public function index()
    {
        //Most recent data is returned to client side.

        //Cache the latest data to avoid countless database queries
        return  Cache::remember('apstatus', 60 * 10, function () {
            //queries the database through models.
            $collection = AccessPointStatistic::query()
                ->with('accesspoint:id,name,tower_id', 'accesspoint.tower:id,name,network_id', 'accesspoint.tower.network:id,name')
                //takes the latest amount of data.
                ->latest()
                ->take(AccessPoint::active())
                ->get();
            //creates a array to store a brief summary of results.
            $data = array(
                'status' => array(
                    //returns total number of online access points
                    'online' => count($collection->where('status', 'online')),
                    //returns total number of boarding access points
                    'boarding' => count($collection->where('status', 'boarding')),
                    //returns total number of offline access points
                    'offline' => count($collection->where('status', 'offline')),
                ),
                'devices' =>
                $collection->where('status', 'offline')
            );
            return response()->json(['data' => $data]);
        });
    }
}
