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
            $towers = $api_call->call_api(); //gets the data from the api
            foreach($towers as $tower){ //loops through the data and checks if needs to update or create a tower
                ModelsTower::updateOrCreate([
                    'name'=>$tower->name //compares its tower name
                ],
                [
                    'network_id'=>$network->id //if tower need to update, assigns its network id
                ]);
            }
       }
       error_log("Towers Populated");
       return;  // ends task








       //old code

        // $networks = Network::with('maestro')->get();
        
        // foreach ($networks as $key) {
        //     $number1=1;
        //     $number2=2;
        //    if($key->maestro_id==1) $networks = new AccessPointStatisticHelperClass($key->maestro->url, env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/networks/' . str_replace(' ', '%20', $key->name). '/towers');
        //    if($key->maestro_id==2) $networks = new AccessPointStatisticHelperClass($key->maestro->url, env('CLIENT_ID_FIRST'), env('CLIENT_SECRET_FIRST'), '/networks/' . str_replace(' ', '%20', $key->name). '/towers');
        //     $networks->call_api();
        //     $complied_data = $networks->get_response_data();
        //     // dd($complied_data[0]->name);
        //     foreach ($complied_data as $model) {
        //         if(!ModelsTower::where('name', $model->name)->exists()){
        //             $insertion = new ModelsTower();
        //             $insertion->name = $model->name;
        //             $insertion->network_id = $key->id;
        //             $insertion->save();
        //         }
        //     }
        // }
        // error_log("Insertion Completed");
        // return;
    }
}
