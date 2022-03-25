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
use MaestroApiClass;

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

        foreach (Maestro::all() as $maestro) {
            $call_api = new MaestroApiClass($maestro->id, '/devices', array('type' => 'epmp'));
            $accesspoints = $call_api->call_api();
            $complied_data = array();
            foreach ($accesspoints as $accesspoint) {
                if (str_contains($accesspoint->network, 'ePMP')) {
                    if (str_contains($accesspoint->product, '2000') || str_contains($accesspoint->product, '3000') || str_contains($accesspoint->product, '1000')) {
                        array_push($complied_data, $accesspoint);
                    }
                }
            }

            foreach($complied_data as $insert){
                $towers_info = Tower::with('network')->where('name',$insert->tower)->first();
                ModelsAccessPoint::updateOrCreate([
                    'ip_address'=>$insert->ip,
                ],[
                    'name' => $insert->name,
                    'mac_address' => $insert->mac,
                    'product' => $insert->product,
                    'tower_id' => $towers_info->id,
                    'type' => $insert->type,
                    'ip_address' => $insert->ip,
                ]);
            }
        }
        error_log('Insertion completed');

        return;
    }
}
