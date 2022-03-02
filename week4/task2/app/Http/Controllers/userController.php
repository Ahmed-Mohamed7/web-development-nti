<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    function login(Request $request)
    {
        return view('user.login');
    }

    function dologin(Request $request)
    {
        $data =  $this->validate($request, [
            "email"     => "required|email",
            "password"  => "required|min:8"
        ]);


        if (auth()->attempt($data))
            return redirect(url('/index'));
        else 
        {
            session()->flash('Message', 'invalid Data');
            return redirect(url('/user/login'));
        }
    }

    
    public function LogOut(){
        // code .....
        auth()->logout();
        return redirect(url('user/login'));
    }

}
