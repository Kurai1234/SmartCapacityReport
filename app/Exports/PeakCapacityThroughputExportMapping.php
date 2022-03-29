<?php

namespace App\Exports;

use App\Models\AccessPointStatistic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PeakCapacityThroughputExportMapping implements FromCollection,WithMapping,WithHeadings,ShouldQueue
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $testing= DB::table('access_point_statistics')
        ->select(DB::raw('access_point_id,MAX(dl_throughput) as max'))
        ->groupBy('access_point_id')
        ->where('access_point_statistics.created_at','>=',Carbon::now()->startOfWeek(Carbon::SUNDAY))
        ->where('access_point_statistics.created_at','<=',Carbon::now()->endOfWeek(Carbon::SATURDAY))
        ;
        return DB::table('access_points')->joinSub($testing,'access_point_statistics',function($join){
            $join->on('access_points.id','=','access_point_statistics.access_point_id');
        })->orderBy('max','desc')->get();
    }
    public function map($data):array{
        return[
            $data->name,
            $data->mac_address,
            $data->product,
            $data->max,
            // $data->created_at
        ];
    }
    public function headings() :array{
        return[
            'Access Point Name',
            'MAC Address',
            'Product',
            'Highest Downlink Throughput'
        ];
    }


}
