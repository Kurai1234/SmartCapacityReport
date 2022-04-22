<?php

// use PhpParser\Builder\Class_;
use App\Jobs\Network;
use App\Jobs\Tower as JobTower;
use App\Models\AccessPoint as ModelsAccessPoint;
use App\Models\Tower;
use Carbon\Carbon;



if (!function_exists('updateAccessPoints')) {
    /**
     * Updates Access Points
     * @param object $info_to_test 
     * @param int $maestroid 
     * @return void
     */
    function updateAccessPoints($info_to_test, $maestroid)
    {
        $acceptableDevices = array('ePMP 3000', 'ePMP 2000', 'ePMP 1000');
        foreach ((new MaestroApiClass($maestroid, modifyUrl('/devices', $info_to_test->mac), []))->call_api() as $accesspoint) {
            $isAccepted = false;
            if (in_array($accesspoint->product, $acceptableDevices)) $isAccepted = !$isAccepted;
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
        return Carbon::parse(implode('/', $dateTime) . ' ' .  implode(':', array_reverse($time)))->format('d M Y g:i:a');
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
        if (empty($time)) return;
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
        return 120;
    }
}

if (!function_exists('convertToMb')) {
    /**
     * @param int $value Accepts Kilobytes
     * @return int Returns data in Megabytes
     *
     */
    function convertToMb(int $value)
    {
        return round(($value / 1024), 2);
    }
}
