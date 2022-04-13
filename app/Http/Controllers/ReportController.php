<?php

namespace App\Http\Controllers;

use App\Models\AccessPoint;
use Illuminate\Http\Request;
use App\Exports\AccessPointStatisticExport;
use App\Exports\PeakCapacityThroughputExportMapping;
use App\Exports\PeakCapacityThroughputWithDatesExportMapping;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function index()
    {
        //display the report page
        return view('auth.pages.Reports.report');
    }

    public function export(Request $request)
    {
        //validates the request time
        $request->validate([
            'startTime' => 'required|date',
            'endTime' => 'required|date|after_or_equal:startTime'
        ]);
        //switch statement to filter the options of submit types
        switch ($request->action) {

                //calls the filter function
            case 'filter':
                return $this->mySql($request->startTime, $request->endTime);
                break;
                //sends download of file
            case 'csv':
                return Excel::download(new PeakCapacityThroughputWithDatesExportMapping($request->startTime, $request->endTime), $request->startTime . '_' . $request->endTime . '.csv');
                break;
                //sends download of file
            case 'xlsx':
                return Excel::download(new PeakCapacityThroughputWithDatesExportMapping($request->startTime, $request->endTime), $request->startTime . '_' . $request->endTime . '.xlsx');
                break;
                //sends download of file
            case 'html':
                return Excel::download(new PeakCapacityThroughputWithDatesExportMapping($request->startTime, $request->endTime), $request->startTime . '_' . $request->endTime . '.html');
                break;
                //sends download of file

            default:
                return redirect()->back();
        }
    }

    public function mySql($start, $end)
    {

        //select max dl_throughput for each access_point from access_point_statistics table
        $max = DB::table('access_point_statistics')
            ->select(DB::raw('access_point_id,MAX(dl_throughput) as max'))
            ->groupBy('access_point_id')
            ->where('access_point_statistics.created_at', '>=', Carbon::parse($start))
            ->where('access_point_statistics.created_at', '<=', Carbon::parse($end));
        //sub join table max with access_points to display name of access_point and display date
        $maxWithRelations = DB::table('access_points')->select('name', 'mac_address', 'product', 'access_point_id', 'max')->joinSub($max, 'max_table', function ($join) {
            $join->on('access_points.id', 'max_table.access_point_id');
        });
        //sub join table maxWithRelations to request addition data from access_point_statistics such as date.
        $peakData = DB::table('access_point_statistics')->joinSub($maxWithRelations, 'stats', function ($join) {
            $join->on('stats.access_point_id', '=', 'access_point_statistics.access_point_id')
                ->on('stats.max', 'access_point_statistics.dl_throughput');
        })->where('access_point_statistics.created_at', '>=', Carbon::parse($start))
            ->where('access_point_statistics.created_at', '<=', Carbon::parse($end))
            ->select("id","connected_sms","stats.access_point_id","created_at","product","mac_address","name","max","dl_capacity_throughput")
            ->orderBy('max', 'desc')->get();
            // dd($peakData);
            //removes duplicates from peakData collection
            $peakData =  $peakData->unique('access_point_id');
            //stores time entered to filter.
            $time = [
                'start' => $start,
                'end' => $end
            ];
        //returns data to page.
        return view('auth.pages.Reports.report', compact('peakData'), compact('time'));
    }
}
