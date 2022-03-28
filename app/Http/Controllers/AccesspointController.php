<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\User;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use AccessPointStatisticHelperClass;
use App\Models\AccessPointStatistic;
use App\Models\Maestro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MaestroApiClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AccesspointController extends Controller
{
    //
    public function index()
    {  
        $testing= DB::table('access_point_statistics')->join('access_points','access_point_statistics.access_point_id','=','access_points.id')
        ->select(DB::raw('access_point_id,MAX(dl_throughput) as max'),'access_points.name','access_point_statistics.created_at')
        // ->select('access_point_statistics.*','access_points.id')
        ->groupBy('access_point_id','access_points.name','access_point_statistics.created_at')
        ->where('access_point_statistics.created_at','>=',Carbon::now()->startOfWeek(Carbon::SUNDAY))
        ->where('access_point_statistics.created_at','<=',Carbon::now()->endOfWeek(Carbon::SATURDAY))
        ->get();
        // $testing=DB::table('access_point_statistics')->get();      
        dd($testing);
        $tring='2022-03-04T14:29';
        $data=[
            'networks'=>Network::all('id','name'),
            'towers'=>Tower::all('id','name','network_id'),
            'accesspoints'=>AccessPoint::all('id','name','tower_id'),
        ];    
        return view('auth.pages.accesspoint',compact('data'));
    }
    public function view(Request $request){

            $request->validate([
                'network'=>'required|max:255|not_in:Default',
                'accesspoint'=>'required|max:255|not_in:Default',
                'tower'=>'required|max:255|not_in:Default',
                'start_time'=>'required|before:tomorrow',
                'end_time'=>'required|before:tomorrow'
            ]);
            
            $testing = new MaestroApiClass(Network::findOrFail($request->network)->maestro_id,
            modifyUrl('/devices',AccessPoint::findOrFail($request->accesspoint)->mac_address).'/performance',
            array(
                'start_time'=>formatTimeToString($request->start_time),
                'stop_time'=>formatTimeToString($request->end_time)
                )
            );
            $dog=$testing->call_api();
            prepareDataForGraph($dog);
            // dd("hi");
            // dd($testing->call_api());
                // $tt= AccessPoint::find($request->accesspoint)->mac_address;
            return "go back, currently working on it";
        }
}
