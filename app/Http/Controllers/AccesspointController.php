<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use AccessPointStatisticHelperClass;
use App\Models\Maestro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MaestroApiClass;

class AccesspointController extends Controller
{
    //
    public function index()
    {  
        $tring='2022-03-04T14:29';
       dd(formatTimeToString($tring));
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
            // dd($request);
            
            // $tt= AccessPoint::find($request->accesspoint)->mac_address;
            dd($request->start_time);
            dd(http_build_query(array('start_time'=>'2022/03/04 00:00')));
            dd(modifyUrl('/devices',AccessPoint::find($request->accesspoint)->mac_address));
            return "go back, currently working on it";
            dd(AccessPoint::query()->where('tower_id',$request->tower)->where('id',$request->accesspoint)->firstOrFail());
        }
}
