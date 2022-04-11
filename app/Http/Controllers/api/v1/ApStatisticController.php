<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApStatisticResource;
use App\Http\Resources\NetworkResource;
use App\Http\Resources\TowerResource;
use App\Http\Resources\AccessPointResource;
use App\Models\AccessPointStatistic;
use App\Models\AccessPoint;
use App\Models\Network;
use App\Models\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApStatisticController extends Controller
{
    //
        public function index(){
        
            //filter data through resource
            return ApStatisticResource::collection(
                //caches the data to avoid multiple queries
                Cache::remember('apstats',60*10,function(){
                    return AccessPointStatistic::query()
                    ->with('accesspoint','accesspoint.tower','accesspoint.tower.network')
                    ->latest()
                    ->take(AccessPoint::count())
                    ->get();
                })
                );
                
        }
}
