<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AccessPointStatisticExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
class ReportController extends Controller
{
    //

    public function export(){
        return Excel::download(new AccessPointStatisticExport,'testing.xlsx');
        // Carbon::now()->startOfWeek()->toDateTimeString().Carbon::now()->endOfWeek()->toDateTimeString().
    }
}
