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
        $largeNetwork="Large network";
        $smallNetwork="Small network";
        // $towers_info = Tower::with('network')->get();
        foreach ($maestro_ip as $key) {
            if($key->name==$smallNetwork)$accesspoints = new AccessPointStatisticHelperClass($key->url, env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/devices');
            if($key->name==$largeNetwork)$accesspoints = new AccessPointStatisticHelperClass($key->url, env('CLIENT_ID_FIRST'), env('CLIENT_SECRET_FIRST'), '/devices');
           
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
                    $towers_info= Tower::with('network')->where('name','=',$model->tower)->first();
                    // dd($towers_info->id);
                    $insertion = new ModelsAccessPoint();
                    $insertion->name=$model->name;
                    $insertion->mac_address=$model->mac;
                    $insertion->product=$model->product;
                    $insertion->tower_id=$towers_info->id;
                    $insertion->type=$model->type;
                    $insertion->ip_address=$model->ip;
                    $insertion->save();
                }
            }

        }
        error_log('Insertion completed');

        return;
       
    }
}
