<?php

namespace App\Http\Controllers;

use App\Jobs\Maestro;
use App\Models\Network;
use App\Models\Tower;
use App\Models\AccessPoint;
use Illuminate\Http\Request;
use MaestroApiClass;
use Carbon\Carbon;


class AccesspointController extends Controller
{
    //
    public function index()
    {
        $test = (new MaestroApiClass(1,"/devices/statistics",array('mode' => 'ap')))->call_api();
        dd($test);
        //returns All data
        $data = $this->formData();
        return view('auth.pages.Accesspoints.accesspoint', compact('data'));
    }

    /**
     * Returns page with graph.
     * @return void 
     */
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
        $result = $this->prepareDataForGraph((new MaestroApiClass(
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
    /**
     * Gets Data to allow user to filter Access Points
     * @return array
     */
    public function formData()
    {
        return  [
            'networks' => Network::all('id', 'name'),
            'towers' => Tower::all('id', 'name', 'network_id'),
            'accesspoints' => AccessPoint::all('id', 'name', 'tower_id'),
        ];
    }
    /**
     * @param object $results Acceepts the response data from the maestro api call
     * @return array Returns the data in array format, much easier to process when graphing the data
     */
    public function prepareDataForGraph($results)
    {
        $product = AccessPoint::query()->where('name', $results[0]->name)->where('mac_address', $results[0]->mac)->firstOrFail()->product;
        (array)$date = $frame_utlization = $dl_throughput = $ul_throughput = $dl_retransmission = [];
        foreach ($results as $key) {
            if (isset($key->radio)) {
                array_push($date, translateTimeToEnglish($key->timestamp));
                array_push($frame_utlization, round($key->radio->dl_frame_utilization), 2);
                array_push($dl_retransmission, round($key->radio->dl_retransmits_pct, 2) ?? 0);
                array_push($dl_throughput, round($key->radio->dl_throughput / 1024, 2));
                array_push($ul_throughput, round($key->radio->ul_throughput / 1024, 2));
            }
        }
        return array(
            'name' => $results[0]->name,
            'product' => $product,
            'dates' => $date,
            'frame_utilization' => $frame_utlization,
            'dl_retransmission' => $dl_retransmission,
            'throughput' => ['dl_throughput' => $dl_throughput, 'ul_throughput' => $ul_throughput]

        );
        // return $preparedData;
    }
}
