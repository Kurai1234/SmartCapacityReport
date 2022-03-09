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
use GuzzleHttp\Exception\BadResponseException;

class RetrieveAccessPointsStatistic implements ShouldQueue
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
        //
        $token_request = new Client(['verify' => false]);

        $raw_response = $token_request->post(env('MAESTRO_SECOND_SERVER') . '/access/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('CLIENT_ID_SECOND'),
                'client_secret' => env('CLIENT_SECRET_SECOND')
            ]

        ]);


        $data = json_decode($raw_response->getBody()->getContents());
        $token = $data->access_token;

        $api_request = new Client(['verify' => false]);
            $api_raw_response = $api_request->get(env('MAESTRO_SECOND_SERVER') . '/devices/statistics?mode=ap', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);
       
        if (!$api_raw_response) return;
        $api_data = json_decode($api_raw_response->getBody()->getContents());
        $api_object_total = $api_data->paging->total;
        $api_objects_limit = $api_data->paging->limit;
        $pagin_necessary = $api_object_total > $api_objects_limit ? true : false;
        if ($pagin_necessary) {
            $api_request = new Client(['verify' => false]);

            for ($counter = $api_objects_limit; $counter < $api_object_total; $counter += $api_objects_limit) {
                $api_url_query = array(
                    'mode' => 'ap',
                    'offset' => $counter,

                );
                $api_new_query = http_build_query($api_url_query);
                try {
                    $api_raw_response = $api_request->get(env('MAESTRO_SECOND_SERVER') . '/devices/statistics?' . $api_new_query, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $token,
                        ]
                    ]);
                    $api_data->data = array_merge($api_data->data, json_decode($api_raw_response->getBody()->getContents())->data);
                } catch (BadResponseException $err) {

                    $api_raw_response = false;

                    //add error handlers
                }
                if (!$api_raw_response) return;
            }
        }

        //insert db
        foreach ($api_data->data as $key) {

            if (strpos($key->network, "ePMP") !== false) {
                $insertion = new AccessPointStatistic();
                //insertion missing
                $insertion->access_point_id = 1;
                $insertion->mode = $key->mode ? $key->mode : "N/A";
                $insertion->dl_retransmit = $key->radio->dl_retransmits? $key->radio->dl_retransmits : 0;

                $insertion->dl_retransmit_pcts = $key->radio->dl_retransmits_pct ? $key->radio->dl_retransmits_pct : 0;
                $insertion->dl_pkts = $key->radio->dl_pkts ? $key->radio->dl_pkts / 1000 : 0;
                $insertion->ul_pkts = $key->radio->ul_pkts ? $key->radio->ul_pkts / 1000 : 0;;
                $insertion->dl_throughput = $key->radio->dl_throughput ? $key->radio->dl_throughput / 1000 : 0;
                $insertion->ul_throughput = $key->radio->ul_throughput ? $key->radio->ul_throughput / 1000 : 0;
                $insertion->status = $key->status;
                $insertion->connected_sms = $key->connected_sms ? $key->connected_sms : 0;
                $insertion->reboot = $key->reboots ? $key->reboots :0;
                $insertion->frame_utilization = 1;
                $insertion->save();


                $chicken = $key->name;

            }
        }

        error_log($chicken);
        return;
    }
}
