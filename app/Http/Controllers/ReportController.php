<?php

namespace App\Http\Controllers;

use App\Models\AccessPoint;
use Illuminate\Http\Request;
// use App\Exports\AccessPointStatisticExport;
// use App\Exports\PeakCapacityThroughputExportMapping;
use App\Exports\PeakCapacityThroughputWithDatesExportMapping;
use App\Exports\AccessPointStatsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use MaestroApiClass;
use ReportQuery;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function index()
    {
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
                // return Excel::download(new AccessPointStatsExport([$request->startTime, $request->endTime]), $request->startTime . '_' . $request->endTime . '.csv');
                return new AccessPointStatsExport([$request->startTime, $request->endTime],'csv');
                break;
                //sends download of file
            case 'xlsx':
                // return Excel::download(new PeakCapacityThroughputWithDatesExportMapping($request->startTime, $request->endTime), $request->startTime . '_' . $request->endTime . '.xlsx');
                return new AccessPointStatsExport([$request->startTime, $request->endTime],'xlsx');
                break;
                //sends download of file
            case 'html':
                return new AccessPointStatsExport([$request->startTime, $request->endTime],'html');
                break;
                //sends download of file
            default:
                return redirect()->back();
        }
    }

    public function mySql($start, $end)
    {
        $peakData=ReportQuery::perform([Carbon::parse($start),Carbon::parse($end)]);
        $time = [
            'start' => $start,
            'end' => $end
        ];
        //returns data to page.
        return view('auth.pages.Reports.report', compact('peakData'), compact('time'));
    }
}
