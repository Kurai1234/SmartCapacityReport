<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AccessPointStatisticHelperClass;
use MaestroApiClass;
use App\Models\Maestro;
use App\Models\Network as ModelsNetwork;
use Illuminate\Validation\Rules\Exists;

class Network implements ShouldQueue
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

        //loops through all maestro urls
        foreach (Maestro::all() as $key) {
            foreach ((new MaestroApiClass($key->id, '/networks', []))->call_api() as $network) { //loops through all return data
                if (isAcceptableNetwork($network->name)) { //filters data by name
                    ModelsNetwork::updateOrCreate([  //check if exits
                        'name' => $network->name
                    ], [
                        'maestro_id' => $key->id
                    ]);
                }
            }
        }
        return error_log("Network Inserted");  // returns after completed 
    }
}
