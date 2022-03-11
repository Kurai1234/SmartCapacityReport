<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use AccessPointStatisticHelperClass;

class AccesspointController extends Controller
{
    //
    public function index()
    {
        // $testing= get_maestro_api_token();
        $testing = new AccessPointStatisticHelperClass(env('MAESTRO_SECOND_SERVER'),env('CLIENT_ID_SECOND'),env('CLIENT_SECRET_SECOND'),'/devices/statistics');
        // $testing->get_maestro();
        $testing->call_api();
        dd($testing->get_response_data());
        $testing = AccessPoint::with(['tower','tower.network','tower.network.maestro'])->findOrFail(1);

        return view('auth.pages.accesspoint', ['testing' => $testing]);
    }
}
