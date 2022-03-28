<?php

namespace App\Exports;

use App\Models\AccessPointStatistic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PeakCapacityThroughputExportMapping implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('access_point_statistics')->join('access_points','access_point_statistics.access_point_id','=','access_points.id')
        ->select(DB::raw('access_point_id,MAX(dl_throughput) as max'),'access_points.name','access_point_statistics.created_at')
        // ->select('access_point_statistics.*','access_points.id')
        ->groupBy('access_point_id','access_points.name','access_point_statistics.created_at')
        ->where('access_point_statistics.created_at','>=',Carbon::now()->startOfWeek(Carbon::SUNDAY))
        ->where('access_point_statistics.created_at','<=',Carbon::now()->endOfWeek(Carbon::SATURDAY))
        ->get();
    }
    public function map($data):array{
        return[
            $data->name,
            $data->max,
            $data->created_at
        ];
    }
    public function headings() :array{
        return[
            'Access Point Name',
            'Highest Downlink Throughput'
        ];
    }


}
