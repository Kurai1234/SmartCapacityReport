<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Maestro;
use Illuminate\Support\Facades\DB;
use App\Models\AccessPoint;
use App\Models\Tower;
use MaestroApiClass;

class CleanupAccessPoints implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $counter = 0;
    /**
     * Create a new job instance.
     *
     * @return void
     */
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
        DB::transaction(function ($api_response) {
            AccessPoint::updated(['isActive' => false]);
            // $dbAccessPoints = AccessPoint::all();
            foreach (Maestro::all() as $maestro) {
                $api_response = (new MaestroApiClass($maestro->id, '/devices', array('type' => 'epmp')))->call_api();
                if ($api_response) {
                    foreach ($api_response as $accesspoint) {
                        if (isAcceptableNetwork($accesspoint->network) && isAcceptableDevice($accesspoint->product)) {
                            $this->counter++;
                            Accesspoint::where('name', $accesspoint->name)
                                ->where('product', $accesspoint->product)
                                ->where('mac_address', $accesspoint->mac)
                                ->update(['isActive' => true]);
                        }
                    }
                }
            }
        });
        return error_log($this->counter);
    }
}
