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

        $testing = AccessPoint::all();
        return view('auth.pages.Reports.report');
    }

    public function export(Request $request)
    {
        $request->validate([
            'startTime' => 'required|date',
            'endTime' => 'required|date|after_or_equal:startTime'
        ]);
        switch ($request->action) {
            case 'filter':
                return $this->mySql($request->startTime, $request->endTime);

                break;
            case 'csv':
                return Excel::download(new PeakCapacityThroughputWithDatesExportMapping($request->startTime,$request->endTime), $request->startTime.'_'.$request->endTime.'.csv');
                break;
            case 'xlsx':
                return Excel::download(new PeakCapacityThroughputWithDatesExportMapping($request->startTime,$request->endTime), $request->startTime.'_'.$request->endTime.'.xlsx');
                break;
            case 'html':
                return Excel::download(new PeakCapacityThroughputWithDatesExportMapping($request->startTime,$request->endTime), $request->startTime.'_'.$request->endTime.'.html');
                break;
            default:
                return redirect()->back();
        }
    }
    public function mySql($start, $end)
    {

        $max = DB::table('access_point_statistics')
            ->select(DB::raw('access_point_id,MAX(dl_throughput) as max'))
            ->groupBy('access_point_id')
            ->where('access_point_statistics.created_at', '>=', Carbon::parse($start))
            ->where('access_point_statistics.created_at', '<=', Carbon::parse($end));
        $maxWithRelations = DB::table('access_points')->select('name', 'mac_address', 'product', 'access_point_id', 'max')->joinSub($max, 'max_table', function ($join) {
            $join->on('access_points.id', 'max_table.access_point_id');
        });
        $testing = DB::table('access_point_statistics')->joinSub($maxWithRelations, 'stats', function ($join) {
            $join->on('stats.access_point_id', '=', 'access_point_statistics.access_point_id')
                ->on('stats.max', 'access_point_statistics.dl_throughput');
        })->where('access_point_statistics.created_at', '>=', Carbon::parse($start))
            ->where('access_point_statistics.created_at', '<=', Carbon::parse($end))
            ->orderBy('max', 'desc')->get();
        // dd($testing);
        $time = [
            'start' => $start,
            'end' => $end
        ];
        $testing =  $testing->unique('access_point_id');
        return view('auth.pages.Reports.report', compact('testing'), compact('time'));
    }
}
