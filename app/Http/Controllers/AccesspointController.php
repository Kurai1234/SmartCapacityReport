<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccesspointController extends Controller
{
    //
    public function index(){
        return view('auth.pages.accesspoint');
    }

}
