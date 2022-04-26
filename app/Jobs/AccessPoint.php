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
        foreach (Maestro::all() as $maestro) { // retrieves all maestro to loop
            //creates a class instance of the api call
            foreach ((new MaestroApiClass($maestro->id, '/devices', array('type' => 'epmp')))->call_api() as $accesspoint) { //loops through the response
                if (isAcceptableNetwork($accesspoint->network) && isAcceptableDevice($accesspoint->product)) {  //checks if the network is a epmp type
                    //checks if the product is a ap by the type of product
                    $towers_info = Tower::with('network')->where('name', $accesspoint->tower)->first(); // finds its tower id
                    ModelsAccessPoint::updateOrCreate([ //creates or update a accesspoint depending if the ip address exist
                        'ip_address' => $accesspoint->ip,
                    ], [
                        'name' => $accesspoint->name,
                        'mac_address' => $accesspoint->mac,
                        'product' => $accesspoint->product,
                        'tower_id' => $towers_info->id,
                        'type' => $accesspoint->type,
                        'ip_address' => $accesspoint->ip,
                        'isActive'=>true
                    ]);
                }
            }
        }
        return error_log('Insertion completed'); // ends and return message         
    }
}
