<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use AccessPointStatisticHelperClass;
use App\Models\Maestro;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccesspointController extends Controller
{
    //
    public function index()
    {
        $network = Network::all();
        return view('auth.pages.accesspoint',compact('network'));
    }
    
    public function view(Request $request){
            // $validator=$request->validate([
            //     'accesspoint'=>'required|max:255',
            //     'tower'=>'required|max:255',
            // ]);
            // $tower_id= Tower::query()->where('tower','=',$request->tower)->firstOrFail('id');
            // AccessPoint::query()->where('name','=',$request->ap)->firstOrFail();
            
            dd($request->network);
    }
}
