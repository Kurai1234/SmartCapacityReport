<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BackupdatabaseController extends Controller
{
    //
    public function index()
    {   //Creates a list of all backed up files

        $backUpList = array();
        //Loops through all the files in storage
        foreach (Storage::files(config('app.name')) as $key => $item) {
            //creates a object for each file
            $tempArray = array(
                'id' => $key + 1,
                'name' => explode('/', $item)[1],
                'size' => round(Storage::disk('local')->size($item) / 1000000, 2),
                'date' => formatBackupTime($item)
            );
            //pushes that object into backupList array
            array_push($backUpList, (object)$tempArray);
        }
        //returns backUpList to view
        return view('auth.pages.BackupViews.backupdb', compact('backUpList'));
    }
    public function download($name)
    {
        //gets file path
        $file = config('app.name') . '/' . $name;
        //check if file exist
        if (!Storage::disk('local')->exists($file)) return redirect()->back()->withErrors(["msg" => "Backup " . $name . " doesn't Exist"]);
        //returns if file is found
        return Storage::download($file);
    }
}
