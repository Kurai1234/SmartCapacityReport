<?php

namespace App\Http\Controllers;
use App\Exports\AccessPointStatisticExport;
use App\Exports\PeakCapacityThroughputExportMapping;
use App\Exports\PeakCapacityThroughputWithDatesExportMapping;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportFilesController extends Controller
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
    public function exportPeaksCapacityWithDates(){
        return Excel::download(new PeakCapacityThroughputWithDatesExportMapping,'testing.xlsx');
    }
}
