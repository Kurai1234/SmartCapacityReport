<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use AccessPointStatisticHelperClass;

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
        //
        $networks = new AccessPointStatisticHelperClass(env('MAESTRO_SECOND_SERVER'), env('CLIENT_ID_SECOND'), env('CLIENT_SECRET_SECOND'), '/networks');

        $networks->call_api();

        $total = $networks->get_response_data();
        error_log($total[0]->name);
        error_log($total[1]->name);
        error_log($total[2]->name);
        error_log($total[3]->name);
        error_log($total[4]->name);
        error_log($total[5]->name);
        error_log($total[6]->name);
        error_log(count($total));

        return;
    }
}
