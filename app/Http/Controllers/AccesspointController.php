<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use AccessPointStatisticHelperClass;
use App\Models\Maestro;

class AccesspointController extends Controller
{
    //
    public function index()
    {

        // $towers_info = Tower::with('network','network.maestro')->get();
        // dd($towers_info);

        // $counter=0;
//        // $testing= get_maestro_api_token();
//        $testing3 = new AccessPointStatisticHelperClass(env('MAESTRO_SECOND_SERVER'), env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/networks');
//        // $testing->call_api();
//               $testing3->call_api();
//        $yep = $testing3->get_response_data();
//        // $data=$testing3->get_response_data();
//        // dd($testing3);
//        $dog ='Belize City ePMP';
//        $dog = str_replace(' ','%20',$dog);
//        
//        // dd($dog);
//        $testing = new AccessPointStatisticHelperClass(env('MAESTRO_SECOND_SERVER'), env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/devices/statistics');
//        // $testing2 = new AccessPointStatisticHelperClass(env('MAESTRO_SECOND_SERVER'),env('CLIENT_ID_SECOND'),env('CLIENT_SECRET_SECOND'),'/devices/statistics');
//        $testing->set_url_query(array('mode' => 'ap'));
//        // $testing2->set_url_query(array('mode'=>'ap','offset'=>'100'));
//
//        $testing->call_api();
//        foreach($testing->get_response_data() as $key){
//            if(str_contains($key->network,'ePMP'))
//            {
//                $counter=$counter+1;
//            }
//        }
//

        // dd($counter);
        // dd($testing->get_response_data());
        // dd(Maestro::all());
        
        $testing11 = Maestro::all();
        
        // foreach($testing11 as $test){
//            dd($test->name,$test->url);    
        // }
        $testing = AccessPoint::with(['tower:id,name,network_id', 'tower.network:id,name'])->get();
        $encode = json_encode($testing);
        $decode = json_decode($encode);
        // dd($decode);
        return view('auth.pages.accesspoint', ['testing' => $testing]);
    }
}
