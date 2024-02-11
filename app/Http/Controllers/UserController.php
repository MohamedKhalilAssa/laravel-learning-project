<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create(){
        return view('Users.register');
    }
    public function store(Request $request){

        $formFields = $request->validate([
            "name" => ['required',"min:3","string"],
            "email" => ['required',"email",Rule::unique('users','email')],
            'password' => ['required','confirmed','min:6'],
        ]);

        // Hashing password
        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('success','User created and logged in');
    }
// logout
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success','You have been Logged out');
    }
    // loads login
    public function login(){
        return view('Users/login');
    }

    // authenticate
    public function authenticate(Request $request){
        $formFields = $request->validate([
            "email" => ['required',"email"],
            'password' => ['required'],
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('success','You are now logged in');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }
}
