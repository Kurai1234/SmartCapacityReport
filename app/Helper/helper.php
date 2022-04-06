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
        $test = 'ePMP 1000';
        $acceptableDevices = array('ePMP 3000', 'ePMP 2000', 'ePMP 1000');
        $isAccepted = false;

        $new_access_point = new MaestroApiClass($maestro, modifyUrl('/devices', $info_to_test->mac), []);

        foreach ($new_access_point->call_api() as $accesspoint) {

            foreach ($acceptableDevices as $device) {
                if (strcmp($accesspoint->product, $device) === 0) $isAccepted = true;
            }

            if ($isAccepted) {

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

if (!function_exists('translateTimeToEnglish')) {
    function translateTimeToEnglish($time)
    {
        // return $time;
        $date = explode("T", $time);
        if (str_contains($date[1], '-')) {
            $prepare = explode("-", $date[1]);
            $date[1] = Carbon::parse(date('H:i:s', strtotime($prepare[0]) + (strtotime($prepare[1]) - strtotime('00:00:00'))))->format('g:i A');
            $date[0] = Carbon::parse($date[0])->format('M d Y');
            return implode(" ", $date);
        }
        if (str_contains($date[1], '+')) {
            $prepare = explode("+", $date[1]);
            $date[1] = Carbon::parse(date('H:i:s', strtotime($prepare[0]) - (strtotime($prepare[1]) - strtotime('00:00:00'))))->format('g:i A');
            $date[0] = Carbon::parse($date[0])->format('M d Y');
            return implode(" ", $date);
        }

        return $time;
    }
}


if (!function_exists('prepareDataForGraph')) {
    function prepareDataForGraph($results)
    {
        $product = ModelsAccessPoint::query()->where('name', $results[0]->name)->where('mac_address', $results[0]->mac)->firstOrFail()->product;
        (array)$date = $frame_utlization = $dl_throughput = $ul_throughput = $dl_retransmission = [];
        foreach ($results as $key) {
            if (isset($key->radio)) {
                array_push($date, translateTimeToEnglish($key->timestamp));
                array_push($frame_utlization, round($key->radio->dl_frame_utilization), 2);
                array_push($dl_retransmission, isset($key->radio->dl_retransmits_pct) ?  round($key->radio->dl_retransmits_pct, 2) : 0);
                array_push($dl_throughput, round($key->radio->dl_throughput / 1024, 2));
                array_push($ul_throughput, round($key->radio->ul_throughput / 1024, 2));
            }
        }
        $preparedData = array(

            'name' => $results[0]->name,
            'product' => $product,
            'dates' => $date,
            'frame_utilization' => $frame_utlization,
            'dl_retransmission' => $dl_retransmission,
            'throughput' => ['dl_throughput' => $dl_throughput, 'ul_throughput' => $ul_throughput]

        );
        return $preparedData;
    }
}

function hectorDextorBextor()
{
    return "Hectormexkor";
}
