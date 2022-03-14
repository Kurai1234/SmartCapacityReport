<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AccessPointStatisticHelperClass;
use App\Models\Network;
use App\Models\Tower as ModelsTower;

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
        //
        $networks = Network::with('maestro')->get();
        
        foreach ($networks as $key) {
            $collections= array();
            $networks = new AccessPointStatisticHelperClass($key->maestro->url, env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/networks/' . str_replace(' ', '%20', $key->name). '/towers');
            $networks->call_api();
            $complied_data = $networks->get_response_data();
            // dd($complied_data[0]->name);
            foreach ($complied_data as $model) {
                if(!ModelsTower::where('name', $model->name)->exists()){
                    $insertion = new ModelsTower();
                    $insertion->name = $model->name;
                    $insertion->network_id = $key->id;
                    $insertion->save();
                }
            }
        }
        error_log("Insertion Completed");
        return;
    }
}
