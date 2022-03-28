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
        $new_access_point = new MaestroApiClass($maestro, modifyUrl('/devices',$info_to_test->mac) , [] );
        foreach($new_access_point->call_api() as $accesspoint){
            $tower= Tower::query()->where('name',$accesspoint->tower)->first();
            ModelsAccessPoint::updateOrCreate(
                ['ip_address'=>$accesspoint->ip,],
                ['name'=>$accesspoint->name,
                'mac_address'=>$accesspoint->mac,
                'tower_id'=>$tower->id,
                'product'=>$accesspoint->product,
                'type'=>$accesspoint->type]
            );
        }
        return error_log('Updated a device');
    }
}

if (!function_exists('modifyUrl')) {
    function modifyUrl(string $url,string $mac){
        if(substr($url,-1)!='/') $url .='/';
        return $url .str_replace(':','%3A',$mac);
    }

}

if(!function_exists('formatTimeToString')){
    function formatTimeToString($time){
        return implode(" ",explode("T",implode("/",explode("-",$time)))); //formats the time to be acceptable for the api call
    }
}
if(!function_exists('prepareDataForGraph')){
    function prepareDataForGraph($results){
        dd($results);
        dd(isset($results[1]->radio));
        foreach($results as $key=>$result){
            dd($results);
        }

        $array= array($results[0]->radio);
        dd($array,gettype($array));        
    }
}

function hectorDextorBextor()
{
    return "Hectormexkor";
}
