<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AccessPointStatisticHelperClass;
use Error;

class AccessPoint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries=5;
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
        $accesspoints = new AccessPointStatisticHelperClass(env('MAESTRO_SECOND_SERVER'), env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/devices');
        $filter = array(
            'type'=> 'epmp',
        );
        $counter=0;
        $accesspoints->set_url_query($filter);
        $accesspoints->call_api();
        $total=$accesspoints->get_response_data();
        $tester=array();
        foreach($total as $key){
            if(str_contains($key->product,'2000')||str_contains($key->product,'3000')||str_contains($key->product,'1000'))
            {
                array_push($tester,$key);
            }
        }
        error_log($total[0]->name);
        error_log($total[1]->name);
        error_log($total[2]->name);
        error_log($total[3]->name);
        error_log($total[4]->name);
        error_log($total[5]->name);
        error_log($total[6]->name);
        error_log($counter);
        error_log(count($tester));
        return;
        //
    }
}
