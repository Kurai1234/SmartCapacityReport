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
        $maestros_ip = Maestro::all();
        //

        foreach ($maestros_ip as $ip) {
            $networks = new AccessPointStatisticHelperClass($ip->url, env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/networks');
            $networks->call_api();
            $total = $networks->get_response_data();
            $complied_data = array();
            foreach ($total as $key) {
                if (str_contains($key->name, 'ePMP')) {
                    array_push($complied_data, $key);
                    // error_log($key->name);
                }
                // $complied_data->name;
            }

            foreach ($complied_data as $model) {
                if(!ModelsNetwork::where('name', $model->name)->exists()){
                    $insertion = new ModelsNetwork();
                    $insertion->name = $model->name;
                    $insertion->maestro_id=$ip->id;
                    $insertion->save();
                }
            }
        }
       // $maestros =Maestro::all();
        // error_log(count($complied_data));
        error_log('Insertion Completed');
        return;
    }
}
