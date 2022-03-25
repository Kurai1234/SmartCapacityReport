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
use SebastianBergmann\Environment\Console;

class RetrieveAccessPointsStatistic implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 5;
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
        return error_log('hi');
        foreach(Maestro::all() as $maestro){
            $api_call = new MaestroApiClass($maestro->id,'/devices/statistics',array('mode'=>'ap'));
            foreach($api_call->call_api() as $statistic_data){
                if(str_contains($statistic_data->network,"ePMP")){
                    $maximum_mbps = 0;
                    try {

                        $access_point_info = AccessPoint::query()->where('name', '=', $statistic_data->name)->where('mac_address','=',$statistic_data->mac)->firstOrFail();
                    } catch (ModelNotFoundException $e) {
                        error_log($statistic_data->name);
                        updateAccessPoints($statistic_data,$maestro->ip);
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
                    $insertion->dl_pkts = $statistic_data->radio->dl_pkts ? $statistic_data->radio->dl_pkts / 1024 : 0;
                    $insertion->ul_pkts = $statistic_data->radio->ul_pkts ? $statistic_data->radio->ul_pkts / 1024 : 0;
                    $insertion->dl_throughput = $statistic_data->radio->dl_throughput ? $statistic_data->radio->dl_throughput / 1024 : 0;
                    $insertion->ul_throughput = $statistic_data->radio->ul_throughput ? $statistic_data->radio->ul_throughput / 1024 : 0;
                    $insertion->status = $statistic_data->status;
                    $insertion->connected_sms = $statistic_data->connected_sms ? $statistic_data->connected_sms : 0;
                    $insertion->reboot = $statistic_data->reboots ? $statistic_data->reboots : 0;
                    $insertion->dl_capacity_throughput = (($statistic_data->radio->dl_throughput / 1000) * 100) / $maximum_mbps;
                    $insertion->save();
                }
            }
        }
        error_log("New Batch of information");
        return;
        // $maestros_ip = Maestro::all();
        // $largeNetwork="Large network";
        // $smallNetwork="Small network";
        // foreach ($maestros_ip as $ip) {

        //     if($ip->name==$smallNetwork) $statistic_data = new AccessPointStatisticHelperClass($ip->url, env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/devices/statistics');
        //     if($ip->name==$largeNetwork) $statistic_data = new AccessPointStatisticHelperClass($ip->url, env('CLIENT_ID_FIRST'), env('CLIENT_SECRET_FIRST'), '/devices/statistics');

        //     $statistic_data->set_url_query(array('mode' => 'ap'));
        //     $statistic_data->call_api();
            
        //     $data = $statistic_data->get_response_data();
        //     foreach ($data as $key) {
            

        //         if (str_contains($key->network, "ePMP")) {
        //             $maximum_mbps = 0;
        //             try {

        //                 $access_point_info = AccessPoint::query()->where('name', '=', $key->name)->where('mac_address','=',$key->mac)->firstOrFail();
        //             } catch (ModelNotFoundException $e) {
        //                 error_log($key->name);
        //                 updateAccessPoints($key,$ip->url);
        //                 $access_point_info = AccessPoint::query()->where('name', '=', $key->name)->where('mac_address',$key->mac)->firstOrFail();

        //             }
        //             if (str_contains($access_point_info->product, '3000')) $maximum_mbps = 220;
        //             if (str_contains($access_point_info->product, '1000')) $maximum_mbps = 120;
        //             if (str_contains($access_point_info->product, '2000')) $maximum_mbps = 120;
        //             $insertion = new AccessPointStatistic();
        //             $insertion->access_point_id = $access_point_info->id;
        //             $insertion->mode = $key->mode ? $key->mode : "N/A";
        //             $insertion->dl_retransmit = $key->radio->dl_retransmits ? $key->radio->dl_retransmits : 0;
        //             $insertion->dl_retransmit_pcts = $key->radio->dl_retransmits_pct ? $key->radio->dl_retransmits_pct : 0;
        //             $insertion->dl_pkts = $key->radio->dl_pkts ? $key->radio->dl_pkts / 1000 : 0;
        //             $insertion->ul_pkts = $key->radio->ul_pkts ? $key->radio->ul_pkts / 1000 : 0;
        //             $insertion->dl_throughput = $key->radio->dl_throughput ? $key->radio->dl_throughput / 1000 : 0;
        //             $insertion->ul_throughput = $key->radio->ul_throughput ? $key->radio->ul_throughput / 1000 : 0;
        //             $insertion->status = $key->status;
        //             $insertion->connected_sms = $key->connected_sms ? $key->connected_sms : 0;
        //             $insertion->reboot = $key->reboots ? $key->reboots : 0;
        //             $insertion->dl_capacity_throughput = (($key->radio->dl_throughput / 1000) * 100) / $maximum_mbps;
        //             $insertion->save();
        //             // error_log("6");



        //             // $chicken = $key->name;
        //         }
        //     }
        // }


        //insert db

       
    }
}
