<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AccessPointStatisticHelperClass;
use App\Models\AccessPoint as ModelsAccessPoint;
use App\Models\Maestro;
use App\Models\Tower;
use Error;

class AccessPoint implements ShouldQueue
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
        $maestro_ip = Maestro::all();
        $towers_info = Tower::with('network', 'network.maestro')->get();
        // dd($towers_info[0]->network->maestro->url);
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
                }
            }

            error_log('hi');
        }
        // $accesspoints = new AccessPointStatisticHelperClass(env('MAESTRO_SECOND_SERVER'), env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/devices');
        // $filter = array(
        //     'type' => 'epmp',
        // );
        // $counter = 0;
        // $accesspoints->set_url_query($filter);
        // $accesspoints->call_api();
        // $total = $accesspoints->get_response_data();
        // $tester = array();
        // foreach ($total as $key) {
        //     if (str_contains($key->network, 'ePMP')) {
        //         if (str_contains($key->product, '2000') || str_contains($key->product, '3000') || str_contains($key->product, '1000')) {
        //             array_push($tester, $key);
        //         }
        //     }
        // }
        // error_log($tester[0]->name);
        // error_log($tester[1]->name);
        // error_log($tester[2]->name);
        // error_log($tester[3]->name);
        // error_log($tester[4]->name);
        // error_log($tester[5]->name);
        // error_log($tester[6]->name);
        // error_log($counter);
        // error_log(count($tester));
        return;
        //
    }
}
