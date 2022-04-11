<?php

namespace App\Http\Controllers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\User;

class FirstLoginController extends Controller
{
    //
    public function create(){
        return view('Authentication.firstuser');
    }

    public function store(Request $request){
        //Validates the request inputted 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_name'=>['required','string','max:255','unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        //creates a user account as admin
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_name'=>$request->user_name,
            'is_admin'=>true,
            'password' => Hash::make($request->password),
        ]);

        //fires a event that user is created.
        event(new Registered($user));
        //if users is successfully created, then return to login page
        if($user)
        {
            return redirect()->route('login');

        }
        else
        {
            //user is redirected back with errors.
            return redirect()->back()->withErrors("Input valid Information");
        }
    }
}
