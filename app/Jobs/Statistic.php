<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AccessPointStatistic;
use App\Models\AccessPoint;
use App\Models\Maestro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MaestroApiClass;

class Statistic implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 1;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //set ignore to false
        foreach (Maestro::all() as $maestro) {
            $api_call = new MaestroApiClass($maestro->id, '/devices/statistics', array('mode' => 'ap'));
            foreach ($api_call->call_api() as $statistic_data) {
                $ignore = false;
                if (str_contains($statistic_data->network, "ePMP")) {
                    try {
                        $access_point_info = AccessPoint::query()->where('name', '=', $statistic_data->name)->where('mac_address', '=', $statistic_data->mac)->firstOrFail();
                    } catch (ModelNotFoundException $e) {
                        // error_log($statistic_data->name . $statistic_data->mac);
                        updateAccessPoints($statistic_data, $maestro->id);
                    }
                    try {
                        $access_point_info = AccessPoint::query()->where('name', '=', $statistic_data->name)->where('mac_address', $statistic_data->mac)->firstOrFail();
                    } catch (ModelNotFoundException $e) {
                        // error_log($statistic_data->name . "hi");
                        $ignore = true;
                    }
                    if (!$ignore) {
                        AccessPointStatistic::create([
                            'access_point_id' => $access_point_info->id,
                            'mode' => $statistic_data->mode ?? '',
                            'dl_retransmit' => $statistic_data->radio->dl_retransmits ?? 0,
                            'dl_retransmit_pcts' => $statistic_data->radio->dl_retransmits_pct ?? 0,
                            'dl_pkts' => convertToMb($statistic_data->radio->dl_pkts) ?? 0,
                            'ul_pkts' => convertToMb($statistic_data->radio->ul_pkts) ?? 0,
                            'dl_throughput' => convertToMb($statistic_data->radio->dl_throughput) ?? 0,
                            'ul_throughput' => convertToMb($statistic_data->radio->ul_throughput) ?? 0,
                            'status' => $statistic_data->status ?? "offline",
                            'connected_sms' => $statistic_data->connected_sms ?? 0,
                            'reboot' => $statistic_data->reboots ?? 0,
                            'dl_capacity_throughput' => round(((convertToMb($statistic_data->radio->dl_throughput) * 100) / getMpbsCapacity($access_point_info->product)), 2) ?? 0,
                        ]);
                    }
                }
            }
        }
        error_log("New Batch of information");
        return;
        //
    }
}
