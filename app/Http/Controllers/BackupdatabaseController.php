<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Tower;
use Illuminate\Support\Facades\Artisan;

class BackupdatabaseController extends Controller
{
    //

    public function index()
    {
        $backUpList = array();
        $file_name = 'SmartMonitor/2022-04-07-13-19-36.zip';
        foreach (Storage::files('SmartMonitor') as $key => $item) {
            $tempArray = array(
                'id' => $key + 1,
                'name' => explode('/', $item)[1],
                'size' => round(Storage::disk('local')->size($file_name) / 1000000, 2),
                'date' => formatBackupTime($item)
            );
            array_push($backUpList, (object)$tempArray);
        }
        return view('auth.pages.BackupViews.backupdb', compact('backUpList'));
    }

    public function forceBackUp()
    {
        // thinking about doing this
        // Artisan::call('backup:run');
        return redirect()->back()->with('message', 'Backup in Process');
    }
    public function download($name)
    {
        $file = 'SmartMonitor/' . $name;
        if (!Storage::disk('local')->exists($file)) return redirect()->back()->withErrors(["msg" => "Backup " . $name . " doesn't Exist"]);
        return Storage::download($file);
    }
}
