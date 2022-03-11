<?php

namespace Database\Factories;
use App\Models\AccessPointStatistic;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessPointStatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = AccessPointStatistic::class;
    public function definition()
    {
        return [
            //
            'access_point_id',
    //         'mode',
    //         'dl_retransmit',
    //         'dl_retransmit_pcts',
    //         'dl_pkts',
    //         'ul_pkts',
    //         'dl_throughput',
    //         'ul_throughput',
    //         'status',
    //         'connected_sms',
    //         'reboot',
    //         'frame_utilization',
        ];
    }
}
