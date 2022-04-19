<?php

namespace App\Exports;

use App\Models\AccessPointStatistic;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithCustomQuerySize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AccessPointStatisticExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return AccessPointStatistic::with('accesspoint')->where('created_at','>=',Carbon::now()->startOfWeek()->toDateTimeString())->where('created_at','<=',Carbon::now()->endOfWeek())->get();

    }

    public function map($accesspointstatistic): array{

        return[
            $accesspointstatistic->id,
            $accesspointstatistic->accesspoint->name,
            $accesspointstatistic->mode,
            $accesspointstatistic->dl_retransmit,
            $accesspointstatistic->dl_retransmit_pcts,
            $accesspointstatistic->dl_pkts,
            $accesspointstatistic->ul_pkts,
            $accesspointstatistic->dl_throughput,
            $accesspointstatistic->ul_throughput,
            $accesspointstatistic->status,
            $accesspointstatistic->connected_sms,
            $accesspointstatistic->reboot,
            $accesspointstatistic->dl_capacity_throughput

        ];

    }

    public function headings() :array{
        return[
            'id',
            'Access Point Name',
            'mode',
            'Downlink retransmit',
            'Downlink Retransmit Percentage',
            'Downlink Per Kilobits',
            'Uplink per Kilobits',
            'Downlink throughput',
            'Uplink throughput',
            'status',
            'Connected sms',
            'Reboots',
            'Downlink capacity throughput',

        ];
    }

}
