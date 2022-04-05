<?php

namespace App\Exports;

use App\Models\AccessPointStatistic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PeakCapacityThroughputWithDatesExportMapping implements FromCollection,WithHeadings,WithMapping,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $startTime;
    protected $endTime;
    public function __construct($startTime,$endTime)
    {
        $this->startTime=$startTime;
        $this->endTime=$endTime;
    }

    public function collection()
    {
        $max= DB::table('access_point_statistics')
        ->select(DB::raw('access_point_id,MAX(dl_throughput) as max'))
        ->groupBy('access_point_id')
        ->where('access_point_statistics.created_at','>=',$this->startTime)
        ->where('access_point_statistics.created_at','<=',$this->endTime)
        ;
        $maxWithRelations = DB::table('access_points')->select('name','mac_address','product','access_point_id','max')->joinSub($max,'max_table',function($join){
            $join->on('access_points.id','max_table.access_point_id');
        });
       $maxWithRelationsAndDates= DB::table('access_point_statistics')->joinSub($maxWithRelations,'stats',function($join){
            $join->on('stats.access_point_id','=','access_point_statistics.access_point_id')
            ->on('stats.max','access_point_statistics.dl_throughput');
        })->where('access_point_statistics.created_at','>=',$this->startTime)
        ->where('access_point_statistics.created_at','<=',$this->endTime)
        ->orderBy('name','asc')
        ->get();
        return $maxWithRelationsAndDates->unique('access_point_id');         
    }
    public function map($maxWithRelationsAndDates):array{
        return [
            $maxWithRelationsAndDates->name,
            $maxWithRelationsAndDates->mac_address,
            $maxWithRelationsAndDates->product,
            round($maxWithRelationsAndDates->max,2),
            round($maxWithRelationsAndDates->dl_capacity_throughput,2),
            $maxWithRelationsAndDates->connected_sms,
            $maxWithRelationsAndDates->created_at
        ];
    }
    public function headings():array{
        return[
            'Access Point Name',
            'Mac Address',
            'Product',
            'Peak Throughput',
            'Capacity Throughput of Device',
            'connected sms',
            'TimeStamp'
        ];
    }
}
