<?php

use App\Jobs\AccessPoint;
use App\Models;
use App\Models\AccessPoint as ModelsAccessPoint;
use App\Models\Maestro;
use App\Models\Tower;
// use App\Models\AccessPoint;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

if (!function_exists('updateAccessPoints')) {
    function updateAccessPoints()
    {
        
        $maestro_ip = Maestro::all();
        // $towers_info = Tower::with('network')->get();
        foreach ($maestro_ip as $key) {
            $accesspoints = new AccessPointStatisticHelperClass($key->url, env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/devices');
            $filter = array(
                'type' => 'epmp',
            );
            $accesspoints->set_url_query($filter);
            $accesspoints->call_api();
            $reponse_data = $accesspoints->get_response_data();
            $complied_data = array();
            foreach ($reponse_data as $key) {
                if (str_contains($key->network, 'ePMP')) {
                    if (str_contains($key->product, '2000') || str_contains($key->product, '3000') || str_contains($key->product, '1000')) {
                        array_push($complied_data, $key);
                    }
                }
            }
            foreach ($complied_data as $model) {
                if (!ModelsAccessPoint::where('mac_address', $model->mac)->exists()) {
                    $towers_info= Tower::with('network')->where('name','=',$model->tower)->first();
                    // dd($towers_info->id);
                    $insertion = new ModelsAccessPoint();
                    $insertion->name=$model->name;
                    $insertion->mac_address=$model->mac;
                    $insertion->product=$model->product;
                    $insertion->tower_id=$towers_info->id;
                    $insertion->type=$model->type;
                    $insertion->save();
                }
            }

            error_log('Insertiong completed');
        }
       
        return true;
    }
}





function hectorDextorBextor()
{
    return "Hectormexkor";
}
