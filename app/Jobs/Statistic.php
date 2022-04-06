<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Models\AccessPointStatistic;
use function PHPUnit\Framework\returnSelf;
use AccessPointStatisticHelperClass;
use App\Models\AccessPoint;
use App\Models\Maestro;
use GuzzleHttp\Exception\BadResponseException;
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
        foreach(Maestro::all() as $maestro){
            $api_call = new MaestroApiClass($maestro->id,'/devices/statistics',array('mode'=>'ap'));
            foreach($api_call->call_api() as $statistic_data){
                if(str_contains($statistic_data->network,"ePMP")){
                    $maximum_mbps = 0;
                    try {
                        $access_point_info = AccessPoint::query()->where('name', '=', $statistic_data->name)->where('mac_address','=',$statistic_data->mac)->firstOrFail();
                    } catch (ModelNotFoundException $e) {
                        error_log($statistic_data->name);
                        updateAccessPoints($statistic_data,$maestro->id);
                        $access_point_info = AccessPoint::query()->where('name', '=', $statistic_data->name)->where('mac_address',$statistic_data->mac)->firstOrFail();
                    }
                    if (str_contains($access_point_info->product, '3000')) $maximum_mbps = 220;
                    if (str_contains($access_point_info->product, '1000')) $maximum_mbps = 120;
                    if (str_contains($access_point_info->product, '2000')) $maximum_mbps = 120;
                    $insertion = new AccessPointStatistic();
                    $insertion->access_point_id = $access_point_info->id;
                    $insertion->mode = $statistic_data->mode ? $statistic_data->mode : "N/A";
                    $insertion->dl_retransmit = $statistic_data->radio->dl_retransmits ? $statistic_data->radio->dl_retransmits : 0;
                    $insertion->dl_retransmit_pcts = $statistic_data->radio->dl_retransmits_pct ? $statistic_data->radio->dl_retransmits_pct : 0;
                    $insertion->dl_pkts = $statistic_data->radio->dl_pkts ? round($statistic_data->radio->dl_pkts / 1024,2) : 0;
                    $insertion->ul_pkts = $statistic_data->radio->ul_pkts ? round($statistic_data->radio->ul_pkts / 1024,2) : 0;
                    $insertion->dl_throughput = $statistic_data->radio->dl_throughput ? round($statistic_data->radio->dl_throughput / 1024,2) : 0;
                    $insertion->ul_throughput = $statistic_data->radio->ul_throughput ? round($statistic_data->radio->ul_throughput / 1024,2) : 0;
                    $insertion->status = $statistic_data->status;
                    $insertion->connected_sms = $statistic_data->connected_sms ? $statistic_data->connected_sms : 0;
                    $insertion->reboot = $statistic_data->reboots ? $statistic_data->reboots : 0;
                    $insertion->dl_capacity_throughput = round(
                        ((($statistic_data->radio->dl_throughput / 1024) * 100) / $maximum_mbps)
                        ,2);
                    $insertion->save();
                }
            }
        }
        error_log("New Batch of information");
        return;
        //
    }
}
