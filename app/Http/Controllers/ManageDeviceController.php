<?php

namespace App\Http\Controllers;

use App\Models\AccessPoint;
use Illuminate\Http\Request;

class ManageDeviceController extends Controller
{
    //
    public function index()
    {
        return view(
            'auth.pages.Devices.managedevice',
            ['collection' => AccessPoint::with('tower:id,name,network_id', 'tower.network:id,name')->get()]
        );
    }

    public function edit($id)
    {
        return view(
            'auth.pages.Devices.editdevice',
            ['device' =>  AccessPoint::with('tower:id,name,network_id', 'tower.network:id,name')->findOrFail($id)]
        );
    }

    public function update(Request $request, $id){
        $request->validate([
            'name'=>'required',
            'product'=>'required',
            'macaddress'=>'required',
            'tag'=>'required',
        ]);
        $accesspoint = AccessPoint::findOrFail($id);
        $accesspoint->name = $request->name;
        $accesspoint->product = $request->product;
        $accesspoint->mac_address = $request->macaddress;
        $accesspoint->tag = $request->tag;
        $accesspoint->save();
        return redirect()->route('devices')->with('message','Updated Successful');


    }
}
