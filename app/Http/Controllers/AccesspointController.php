<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\Tower;
use Illuminate\Http\Request;

class AccesspointController extends Controller
{
    //
    public function index()
    {
        $testing = Tower::with(['network','network.maestro'])->findOrFail(1);

        return view('auth.pages.accesspoint', ['testing' => $testing]);
    }
}
