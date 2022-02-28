<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        ## validation of inputs
        $validated = $request->validate([
            'title' => 'required|max:255|string',
            'content' => 'required|string|min:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $title = $request->title;
        $content = $request->content;
        $image = $request->image;

        # generate image name
        $imageName = time().'_'.$image->getClientOriginalName();  
        # move the images into public path 
        $request->image->move(public_path('images'), $imageName);

        
        # share the data to profile view
        return view('profile',compact('title','content','imageName'));
    
    }
}
