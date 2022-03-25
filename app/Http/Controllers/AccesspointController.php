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
       
        foreach(Network::all() as $network){
            $api_call = new MaestroApiClass($network->maestro_id,'/networks/' . str_replace(' ', '%20', $network->name). '/towers',[]);
            $towers = $api_call->call_api();
            dd($towers);
            // foreach($towers as $tower){
            //     ModelsTower::updateOrCreate([
            //         'name'=>$tower->name
            //     ],
            //     [
            //         'network_id'=>$network->id
            //     ]);
            // }
       }
        
        
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
                'start_time'=>'required',
                'end_time'=>'required'
            ]);
            $url=Network::query()->with('maestro:id,url')->where('id',$request->network)->firstOrFail();
            dd($url->maestro->url);
            
            // return "go back, currently working on it";
            dd(AccessPoint::query()->where('tower_id',$request->tower)->where('id',$request->accesspoint)->firstOrFail());
        }
}
