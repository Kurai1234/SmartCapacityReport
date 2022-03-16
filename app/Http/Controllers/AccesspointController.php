<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use AccessPointStatisticHelperClass;
use App\Models\Maestro;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try{
        $testing11 = Maestro::findOrFail(1);
        }
        catch(ModelNotFoundException $e){
              dd(get_class_methods($e));
              dd($e);

        }
        // foreach($testing11 as $test){
//            dd($test->name,$test->url);   
            
        // }
        $info =array('chicken','dog','cat');
        // updateAccessPoints();
        dd(AccessPoint::wherehas('tower',function($query){
            $query->where('tower_id',1);
        })->with('tower')->get());
        // dd(updateAccessPoints(false,));
        dd(hectorDextorBextor());
        dd("yes");



        $testing = AccessPoint::with(['tower:id,name,network_id', 'tower.network:id,name'])->get();
        $encode = json_encode($testing);
        $decode = json_decode($encode);
        // dd($decode);
        return view('auth.pages.accesspoint', ['testing' => $testing]);
    }
}
