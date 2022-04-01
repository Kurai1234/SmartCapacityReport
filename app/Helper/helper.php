<?php

use PhpParser\Builder\Class_;

use App\Jobs\AccessPoint;
use App\Models\AccessPoint as ModelsAccessPoint;
use App\Models\Maestro;
use App\Models\Tower;
use Carbon\Carbon;
// use AccessPointStatisticHelperClass;

// use App\Models\AccessPoint;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

if (!function_exists('updateAccessPoints')) {
    function updateAccessPoints($info_to_test, $maestro)
    {
        $new_access_point = new MaestroApiClass($maestro, modifyUrl('/devices', $info_to_test->mac), []);
        foreach ($new_access_point->call_api() as $accesspoint) {
            $tower = Tower::query()->where('name', $accesspoint->tower)->first();
            ModelsAccessPoint::updateOrCreate(
                ['ip_address' => $accesspoint->ip,],
                [
                    'name' => $accesspoint->name,
                    'mac_address' => $accesspoint->mac,
                    'tower_id' => $tower->id,
                    'product' => $accesspoint->product,
                    'type' => $accesspoint->type
                ]
            );
        }
        return error_log('Updated a device');
    }
}

if (!function_exists('modifyUrl')) {
    function modifyUrl(string $url, string $mac)
    {
        if (substr($url, -1) != '/') $url .= '/';
        return $url . str_replace(':', '%3A', $mac);
    }
}

if (!function_exists('formatTimeToString')) {
    function formatTimeToString($time)
    {
        return implode(" ", explode("T", implode("/", explode("-", $time)))); //formats the time to be acceptable for the api call
    }
}


if (!function_exists('prepareDataForGraph')) {
    function prepareDataForGraph($results)
    {   
        // dd($results[5]);
        // $tdate='2022-04-01T02:32:22-06:00';
        // $testing = Carbon::parse($tdate)->format('Y-m-d H:i:s');
        // dd($testing);
        (array)$date = $frame_utlization = $dl_throughput = $ul_throughput = $dl_retransmission = [];
        // dd($results);
        foreach ($results as $key) {
            if (isset($key->radio)) {
                array_push($date, $key->timestamp);
                array_push($frame_utlization, $key->radio->dl_frame_utilization);
                array_push($dl_retransmission,isset($key->radio->dl_retransmits_pct) ?  $key->radio->dl_retransmits_pct :0);
                array_push($dl_throughput, round($key->radio->dl_throughput/1024,2));
                array_push($ul_throughput, round($key->radio->ul_throughput/1024,2));
            }
        }
        $preparedData = array(
            'data' => array(
                'dates' => $date,
                'frame_utilization' => $frame_utlization,
                'dl_retransmission' => $dl_retransmission,
                'throughput'=>['dl_throughput'=>$dl_throughput,'ul_throughput'=>$ul_throughput]
            )
        );
      return $preparedData;
    }
}

function hectorDextorBextor()
{
    return "Hectormexkor";
}
