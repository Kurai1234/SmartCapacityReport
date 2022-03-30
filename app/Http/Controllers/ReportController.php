<?php

namespace App\Http\Controllers;

use App\Models\AccessPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
class ReportController extends Controller
{
    //
    public function index(){

        $testing = AccessPoint::all();
        return view('auth.pages.Reports.report');
    }

    public function export(Request $request){
        $request->validate([
            'start_time'=>'required|before:tomorrow',
            'end_time'=>'required|before:tomorrow',
            'action'=>'required'
        ]);

        switch($request->action){
            case 'filter':
                // $testing='chieck';
                // return view('auth.pages.Reports.report',compact(['testing']));
                return $this->mySql($request->start_time,$request->end_time);
                break;
                case 'csv':
                    // $testing='chieck';
                    // return view('auth.pages.Reports.report',compact(['testing']));
                    return $this->mySql($request->start_time,$request->end_time);
                    break;
                default:
                dd($request->action);

        }
    }
    public function mySql($start, $end){
        
        $max= DB::table('access_point_statistics')
        ->select(DB::raw('access_point_id,MAX(dl_throughput) as max'))
        ->groupBy('access_point_id')
        ->where('access_point_statistics.created_at','>=',Carbon::parse($start))
        ->where('access_point_statistics.created_at','<=',Carbon::parse($end))
        ;
        $maxWithRelations = DB::table('access_points')->select('name','mac_address','product','access_point_id','max')->joinSub($max,'max_table',function($join){
            $join->on('access_points.id','max_table.access_point_id');
        });
       $testing= DB::table('access_point_statistics')->joinSub($maxWithRelations,'stats',function($join){
            $join->on('stats.access_point_id','=','access_point_statistics.access_point_id')
            ->on('stats.max','access_point_statistics.dl_throughput');
        })->where('access_point_statistics.created_at','>=',Carbon::parse($start))
        ->where('access_point_statistics.created_at','<=',Carbon::parse($end))
        ->orderBy('max','desc')->get();
        return view('auth.pages.Reports.report',compact('testing'))->with('testing',$start);
    }
}
