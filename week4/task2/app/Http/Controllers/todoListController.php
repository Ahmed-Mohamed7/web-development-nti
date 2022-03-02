<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\todoList;

class todoListController extends Controller
{
    function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $data =  todoList::get()->where('user_id', $user->id);
            return view('todolist.index', ["data" => $data]);
        } else {
            return redirect(url('/user/login'));
        }
    }

    function create()
    {
        return view('todolist.create');
    }

    function store(Request $request)
    {
        $data =  $this->validate($request, [
            "title"     => "required|string|max:255",
            "content"   => "required|min:50",
            'stdate'  =>  'required|date',
            'enddate'    =>  'required|date|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if (auth()->check()) {
            $user = auth()->user();
            $image = $request->image;
            # generate image name
            $imageName = time() . '_' . $image->getClientOriginalName();
            # move the images into public path 
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
            $data['user_id'] = $user->id;
            $op = todoList::create($data);
            if ($op) {
                $message = 'data inserted';
            } else {
                $message =  'error try again';
            }
        } else
            $message =  'error try again';


        session()->flash('Message', $message);

        return redirect(url('index/'));
    }

    public function delete($id)
    {

        //  $op =  student::where('id',$id)->delete();     // find($id)
        $op =  todoList::find($id)->delete();
        if ($op) {
            $message = "Raw Removed";
        } else {
            $message = 'Error Try Again';
        }

        session()->flash('Message', $message);

        return redirect(url('/index'));
    }
}
