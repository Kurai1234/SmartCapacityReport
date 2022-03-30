<?php

namespace App\Http\Controllers;

use App\Models\AccessPoint;
use Illuminate\Http\Request;

use Carbon\Carbon;
class ReportController extends Controller
{
    //
    public function index(){

        $testing = AccessPoint::all();
        return view('auth.pages.Reports.report',compact('testing'));
    }
    
}
