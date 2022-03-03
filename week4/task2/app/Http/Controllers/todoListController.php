<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\todoList;

class todoListController extends Controller
{


    function index()
    {
        $user = auth()->user();
        $data =  todoList::get()->where('user_id', $user->id);
        return view('todolist.index', ["data" => $data]);
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
            'enddate'    =>  'required|date|after:stdate',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $user = auth()->user();
        $image = $request->image;
        # generate image name
        $imageName = time() . '_' . $image->getClientOriginalName();
        # move the images into public path 
        $request->image->move(public_path('images'), $imageName);
        $data['image'] = $imageName;
        $data['user_id'] = $user->id;
        $op = todoList::create($data);

        if ($op)
            $message = 'data inserted';
        else
            $message =  'error try again';

        session()->flash('Message', $message);

        return redirect(url('todolist'));
    }

    public function edit($id)
    {
        $data = todoList::find($id);
        return view('todolist.edit', ['data' => $data]);
    }

    public function show()
    {
    }

    public function update(Request $request, $id)
    {
        //
        $data =  $this->validate($request, [
            "title"     => "required|string|max:255",
            "content"   => "required|min:50",
            'stdate'  =>  'required|date',
            'enddate'    =>  'required|date|after:stdate',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        #   Fetch Data
        $objData = todoList::find($id);
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

        $op = todoList::find($id)->update($data);


        if ($op) {
            $message = 'Raw Updated';
        } else {
            $message =  'error try again';
        }

        session()->flash('Message', $message);

        return redirect(url('todolist'));
    }



    public function destroy($id)
    {
        //  $op =  student::where('id',$id)->delete();     // find($id)
        $data =  todoList::find($id);
        $op =  todoList::find($id)->delete();
        if ($op) {
            unlink(public_path('images/' . $data->image));
            $message = "Raw Removed";
        } else {
            $message = 'Error Try Again';
        }
        session()->flash('Message', $message);
        return redirect(url('todolist'));
    }
}
