<?php

// use PhpParser\Builder\Class_;
use App\Jobs\Network;
use App\Jobs\Tower as JobTower;
use App\Models\AccessPoint as ModelsAccessPoint;
use App\Models\Tower;
use Carbon\Carbon;



if (!function_exists('updateAccessPoints')) {
    /**
     * @param object $info_to_test accepts a single API return object
     * @param int $maestroid  accepts a integer
     * @return void
     */
    function updateAccessPoints($info_to_test, $maestroid)
    {
        $acceptableDevices = array('ePMP 3000', 'ePMP 2000', 'ePMP 1000');
        $isAccepted = false;
        $new_access_point = new MaestroApiClass($maestroid, modifyUrl('/devices', $info_to_test->mac), []);
        foreach ($new_access_point->call_api() as $accesspoint) {

            foreach ($acceptableDevices as $device) {
                if (strcmp($accesspoint->product, $device) === 0) $isAccepted = !$isAccepted;
            }
            if ($isAccepted) {
                $tower = Tower::query()->where('name', $accesspoint->tower)->first();
                if ($tower === null) {
                    Network::dispatch();
                    JobTower::dispatch();
                    return;
                }
                $insertOrUpdate = ModelsAccessPoint::updateOrCreate(
                    ['ip_address' => $accesspoint->ip],
                    [
                        'name' => $accesspoint->name,
                        'mac_address' => $accesspoint->mac,
                        'tower_id' => $tower->id,
                        'product' => $accesspoint->product,
                        'type' => $accesspoint->type,

                    ]
                );
                if ($insertOrUpdate) error_log("updated or inserted");
                $isAccepted = false;
            }
        }
        return;
    }
}


if (!function_exists('formatBackupTime')) {
    /**
     * @param string $string accepts backup file name.
     * @return string  returns a Datetime string in Alphabetic Date, 12 hour format.
     * @example 24 April, 2022 12:00am.
     */
    function formatBackupTime($string)
    {
        // return $string;
        $time = array();
        $dateTime = explode('-', explode('.', explode('/', $string)[1])[0]);
        for ($i = 0; $i <= sizeof($dateTime) / 2; $i++) {
            array_push($time, array_pop($dateTime));
        }
        $date = implode('/', $dateTime) . ' ' .  implode(':', array_reverse($time));
        return Carbon::parse($date)->format('d M Y g:i:a');
    }
}



if (!function_exists('modifyUrl')) {
    /**
     * @param string $url Accepts a Url to be used in a API Call to Maestro
     * @param string $mac Accepts the string mac address for a device
     * @return string returns the url encoded with the mac address attached
     */
    function modifyUrl(string $url, string $mac)
    {
        if (substr($url, -1) != '/') $url .= '/';
        return $url . str_replace(':', '%3A', $mac);
    }
}

if (!function_exists('formatTimeToString')) {
    /**
     * @param string $time Transform datetime from the DOM datetime format
     * @return string returns a datetimestring that acceptable to use for api call
     */
    function formatTimeToString($time)
    {
        return implode(" ", explode("T", implode("/", explode("-", $time)))); //formats the time to be acceptable for the api call
    }
}

if (!function_exists('translateTimeToEnglish')) {
    /**
     * @param string $time Accepts a string in time format from the resulting API call to maestro performance api
     * @return string Returns a Alphabetical Date Time for readability
     */
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
    /**
     * @param object $results Acceepts the response data from the maestro api call
     * @return array Returns the data in array format, much easier to process when graphing the data
     */
    function prepareDataForGraph($results)
    {
        $product = ModelsAccessPoint::query()->where('name', $results[0]->name)->where('mac_address', $results[0]->mac)->firstOrFail()->product;
        (array)$date = $frame_utlization = $dl_throughput = $ul_throughput = $dl_retransmission = [];
        foreach ($results as $key) {
            if (isset($key->radio)) {
                array_push($date, translateTimeToEnglish($key->timestamp));
                array_push($frame_utlization, round($key->radio->dl_frame_utilization), 2);
                array_push($dl_retransmission, round($key->radio->dl_retransmits_pct, 2) ?? 0);
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

if (!function_exists('getMpbsCapacity')) {
    /**
     * @param string $product Accepts product name from API response
     * @return int Return Device Mpbs Capacity
     */
    function getMpbsCapacity(string $product)
    {
        if (str_contains($product, '3000')) return 220;
        if (str_contains($product, '1000')) return 120;
        if (str_contains($product, '2000')) return 120;
        return 100;
    }
}

if (!function_exists('convertToMb')) {
    /**
     * @param int $value Accepts Kilobytes
     * @return int Returns data in Megabytes
     *
     */
    function convertToMb( int $value)
    {
        return round(($value / 1024), 2);
    }
}
