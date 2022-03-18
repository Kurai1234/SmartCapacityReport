<?php
use PhpParser\Builder\Class_;

use App\Jobs\AccessPoint;
use App\Models\AccessPoint as ModelsAccessPoint;
use App\Models\Maestro;
use App\Models\Tower;
// use AccessPointStatisticHelperClass;

// use App\Models\AccessPoint;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

if (!function_exists('updateAccessPoints')) {
    function updateAccessPoints( $info_to_test,$maestro)
    {   
        error_log($maestro);
        $device_mac_address= str_replace(':','%3A',$info_to_test->mac);
        $device_mac_address='/devices'.'/'.$device_mac_address;
        $new_access_point = new AccessPointStatisticHelperClass($maestro,env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'),$device_mac_address); 
        $new_access_point->set_url_query(array());
        $datas=$new_access_point->call_api();
        $datas2=$new_access_point->get_response_data();
        // dd($datas2[0]->name);
        // error_log('hi');
        foreach($datas2 as $data){
        $tower= Tower::query()->where('name','=',$data->tower)->first();
            error_log('bye');
        $update_or_create = ModelsAccessPoint::updateOrCreate(
            ['ip_address'=>$data->ip,],
            ['name'=>$data->name,
            'mac_address'=>$data->mac,
            'tower_id'=>$tower->id,
            'product'=>$data->product,
            'type'=>$data->type]
        );
        // $update_or_create->save();
    }

        
        return;    
    }
}





function hectorDextorBextor()
{
    return "Hectormexkor";
}
