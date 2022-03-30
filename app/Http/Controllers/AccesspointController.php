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
        $tring='2022-03-04T14:29';
        dd(Carbon::parse($tring));
        dd(Carbon::now()->endOfWeek(Carbon::THURSDAY));

        dd(Carbon::now()->subWeek()->endOfWeek(Carbon::FRIDAY));

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
