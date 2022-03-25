<?php

namespace App\Observers;

use App\Models\AccessPointStatistic;
use Illuminate\Support\Facades\Cache;

class AccessPointStatisticObserver
{
    /**
     * Handle the AccessPointStatistic "created" event.
     *
     * @param  \App\Models\AccessPointStatistic  $accessPointStatistic
     * @return void
     */
    public function created(AccessPointStatistic $accessPointStatistic)
    {
        //
        Cache::forget('apstats');
        Cache::forget('apstatus');
        Cache::forget('pieinfo');
    }

    /**
     * Handle the AccessPointStatistic "updated" event.
     *
     * @param  \App\Models\AccessPointStatistic  $accessPointStatistic
     * @return void
     */
    public function updated(AccessPointStatistic $accessPointStatistic)
    {
        //
    }

    /**
     * Handle the AccessPointStatistic "deleted" event.
     *
     * @param  \App\Models\AccessPointStatistic  $accessPointStatistic
     * @return void
     */
    public function deleted(AccessPointStatistic $accessPointStatistic)
    {
        //
    }

    /**
     * Handle the AccessPointStatistic "restored" event.
     *
     * @param  \App\Models\AccessPointStatistic  $accessPointStatistic
     * @return void
     */
    public function restored(AccessPointStatistic $accessPointStatistic)
    {
        //
    }

    /**
     * Handle the AccessPointStatistic "force deleted" event.
     *
     * @param  \App\Models\AccessPointStatistic  $accessPointStatistic
     * @return void
     */
    public function forceDeleted(AccessPointStatistic $accessPointStatistic)
    {
        //
    }
}
