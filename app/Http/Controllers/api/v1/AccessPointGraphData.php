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
        $total = count(ModelsAccessPoint::all());
        $boarding = 0;
        $online = 0;
        $offline = 0;
        $collection = AccessPointStatistic::query()->latest()->take($total)->get();
        // $collection = AccessPointStatistic::all();
        foreach ($collection as $key) {
            if ($key->status === 'online') $online++;
            if ($key->status === 'boarding') $boarding++;
            if ($key->status === 'offline') $offline++;
        }
        $data = array(
            'online' => $online,
            'boarding' => $boarding,
            'offline' => $offline,
        );
        return response()->json(['data' => $data]);
        return "hi";
    }
    public function pieChart(){
        $total = count(ModelsAccessPoint::all());
        $collection = AccessPointStatistic::query()->latest()->take($total)->get();
        $counter =1;
        (object) $dog=[];
        (object)$chicken= array('accesspoint','Percentage');
        (object) $cat=array('online',2);

        (object) $fly=array('offline',10);
        $dog[0]=$chicken;
        $dog[1]=$cat;
        $dog[2]=$fly;
    return  response()->json($dog);
    }
}
