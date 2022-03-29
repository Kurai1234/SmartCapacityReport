<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AccessPointStatisticExport;
use App\Exports\PeakCapacityThroughputExportMapping;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
class ReportController extends Controller
{
    //

    public function export(){
        return Excel::download(new AccessPointStatisticExport,'testing.xlsx');
        // Carbon::now()->startOfWeek()->toDateTimeString().Carbon::now()->endOfWeek()->toDateTimeString().
    }
    public function exportPeakCapacity(){
        return Excel::download(new PeakCapacityThroughputExportMapping,Carbon::now()->startOfWeek()->toDateTimeString().'_'.Carbon::now()->endOfWeek()->toDateTimeString().'.xlsx');
    //    (new PeakCapacityThroughputExportMapping)->store(Carbon::now()->startOfWeek()->toDateTimeString().'_'.Carbon::now()->endOfWeek()->toDateTimeString().'.xlsx');
        // return back()->withSucess('Started');
        // (new PeakCapacityThroughputExportMapping)->queue('ues.xlsx');    
    }
}
