<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\User;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MaestroApiClass;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AccesspointController extends Controller
{
    //
    public function index()
    {   
        $data=$this->formData();
        return view('auth.pages.accesspoint',compact('data'));
    }
    public function view(Request $request){

            $request->validate([
                'network'=>'required|max:255|not_in:Default',
                'accesspoint'=>'required|max:255|not_in:Default',
                'tower'=>'required|max:255|not_in:Default',
                'start_time'=>'required|before:now',
                'end_time'=>'required|before:tomorrow|after:start_time'
            ]);
            if(Carbon::now()->format('Y/m/d H:i')<$request->end_time)
            return redirect()->back()->withErrors('Date must be in the present');
            
            $apiCall = new MaestroApiClass(Network::findOrFail($request->network)->maestro_id,
            modifyUrl('/devices',AccessPoint::findOrFail($request->accesspoint)->mac_address).'/performance',
            array(
                'start_time'=>formatTimeToString($request->start_time),
                'stop_time'=>formatTimeToString($request->end_time)
                )
            );
            $results=$apiCall->call_api();
            $result=prepareDataForGraph($results);
            $data= $this->formData();
            return view('auth.pages.accesspoint',compact('result'),compact('data'));
            return "go back, currently working on it";
        }
    
    public function formData(){
        $data=[
            'networks'=>Network::all('id','name'),
            'towers'=>Tower::all('id','name','network_id'),
            'accesspoints'=>AccessPoint::all('id','name','tower_id'),
        ];    
        return $data;
    }

}
