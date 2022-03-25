<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AccessPointStatisticHelperClass;
use App\Models\Maestro;
use App\Models\Network;
use App\Models\Tower as ModelsTower;
use Error;
use MaestroApiClass;

class Tower implements ShouldQueue
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
           
       foreach(Network::all() as $network){ //gets all networks in the database
            $api_call = new MaestroApiClass($network->maestro_id,'/networks/' . str_replace(' ', '%20', $network->name). '/towers',[]); //calls the api
            foreach($api_call->call_api() as $tower){ //loops through the data and checks if needs to update or create a tower
                ModelsTower::updateOrCreate([
                    'name'=>$tower->name //compares its tower name
                ],
                [
                    'network_id'=>$network->id //if tower need to update, assigns its network id
                ]);
            }
       }
      return error_log("Towers Populated");
         // ends task
    }
}
