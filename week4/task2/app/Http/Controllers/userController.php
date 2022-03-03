<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use  App\Models\User;

class userController extends Controller
{

    function register()
    {
        return view('user.register');
    }


    function doRegister(Request $request)
    {
        $data =  $this->validate($request, [
            "email"     => "required|email|unique:users",
            "name"      => "required|string",
            "password"  => "required|min:8",
            'passwordconfirm' => "required|same:password",
            'date'  =>  'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $data['password'] = Hash::make($data['password']);

        $image = $request->image;
        # generate image name
        $imageName = time() . '_' . $image->getClientOriginalName();
        # move the images into public path 
        $image->move(public_path('images'), $imageName);

        $data['image'] = $imageName;
        $user = User::create($data);
        if (!$user) {
            session()->flash('Message', 'error while create user');
            return redirect(url('/user/login'));
        }
        // dd($user);

        if (auth()->attempt($request->only('email', 'password')))
            return redirect(url('todolist'));
        else {
            session()->flash('Message', 'invalid Data');
            return redirect(url('/user/login'));
        }
    }

    function login()
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
            return redirect(url('todolist'));
        else {
            session()->flash('Message', 'invalid Data');
            return redirect(url('/user/login'));
        }
    }


    public function LogOut()
    {
        // code .....
        auth()->logout();
        return redirect(url('user/login'));
    }

    public function show($id)
    {
        
        $user = User::where('id', $id)->first();

        ## we can make it by policy 
        ## check that only the user can view its profile
        if ($user && $user->id == auth()->user()->id)
            return view('user.profile', ['user' => $user]);
        else {
            return redirect(url('todolist'));
        }
    }


    public function update(Request $request, $id)
    {

        $data =  $this->validate($request, [
            "name"     => "required|string|max:255",
            "email"   => "required|email|max:255",
            'bdate'  =>  'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($id != auth()->user()->id)
            return redirect(url('todolist'));
        #   Fetch Data
        $objData = User::find($id);

        if ($request->hasFile('image')) {
            $FinalName = time() . rand() . '.' . $request->image->extension();
            if ($request->image->move(public_path('images'), $FinalName)) {
                unlink(public_path('images/' . $objData->image));
            }
        } else {
            $FinalName = $objData->image;
        }

        $data['image'] = $FinalName;

        # Update OP ...
        $op = User::find($id)->update($data);

        if ($op) {
            $message = 'data Updated';
        } else {
            $message =  'error try again';
        }

        session()->flash('Message', $message);

        return back();
    }
}
