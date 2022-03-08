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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_name'=>['required','string','max:255','unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_name'=>$request->user_name,
            'is_admin'=>true,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        if($user)
        {
            return redirect()->route('login');

        }
        else
        {
            return redirect()->back()->withErrors("Input valid Information");
        }
        // Auth::login($user);
    }
}
