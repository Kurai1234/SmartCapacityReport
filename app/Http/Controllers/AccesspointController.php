<?php

namespace App\Http\Controllers;

use App\Exports\AccessPointStatisticsExportView;
use App\Mail\WeeklyReport;
use App\Models\Network;
use App\Models\User;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use MaestroApiClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AccesspointController extends Controller
{
    //
    public function index()
    {
        //returns All data
        $data = $this->formData();
        return view('auth.pages.Accesspoints.accesspoint', compact('data'));
    }
    public function view(Request $request)
    {
        //validates the request
        $request->validate([
            'network' => 'required|max:255|not_in:Default',
            'accesspoint' => 'required|max:255|not_in:Default',
            'tower' => 'required|max:255|not_in:Default',
            'start_time' => 'required|before:now',
            'end_time' => 'required|before:tomorrow|after:start_time'
        ]);
        //second validation to above errors in the api
        if (Carbon::now()->format('Y/m/d H:i') < $request->end_time) return redirect()->back()->withErrors('Date must be in the present');
        //creates a api instance

        //prepares the data for graphing
        $result = prepareDataForGraph((new MaestroApiClass(
            Network::findOrFail($request->network)->maestro_id,
            modifyUrl('/devices', AccessPoint::findOrFail($request->accesspoint)->mac_address) . '/performance',
            array(
                'start_time' => formatTimeToString($request->start_time),
                'stop_time' => formatTimeToString($request->end_time)
            )
        ))->call_api());
        //gets all data
        $data = $this->formData();
        //returns data for graphs and also data for option dom element.
        return view('auth.pages.Accesspoints.accesspoint', compact('result'), compact('data'));
    }

    public function formData()
    {
        return  [
            'networks' => Network::all('id', 'name'),
            'towers' => Tower::all('id', 'name', 'network_id'),
            'accesspoints' => AccessPoint::all('id', 'name', 'tower_id'),
        ];
    }
}
