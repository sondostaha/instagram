<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followers =  Follower::select('user_id')->where('follower_id',Auth::id())->get()->pluck('user_id');

        $posts =  Post::with('comments')->whereIn('user_id',$followers)->get();
        return view('layouts.home',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('forntend.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $file_name =  uniqid().'.'.$extention ;
            $file->move(public_path('images/posts/'),"$file_name");
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'image' => $file_name ,
            'body' => $request->body,
        ]);

        return redirect()->route('home')->with('success','post added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id , User $user)
    {
        $post =  Post::with('user')->findOrFail($id);
        // dd(Auth::id());
        return view('forntend.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::whereId($id)->first();
        return view('forntend.post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post =  Post::findOrFail($id);
        if($request->hasFile('image'))
        {
            if($post->image !==  null)
            {
                if(File::exists('image/posts'.$post->image))
                {
                    unlink(public_path('image/posts'.$post->image));
                }
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $file_name =  uniqid().'.'.$extention ;
            $file->move(public_path('images/posts/'),"$file_name");
        }
        $post->update([
            'image' => $file_name ,
            'body' => $request->body,
        ]);
        if ($post) {
            return redirect()->route('home')->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post =  Post::findOrFail($id);
        if($post->image !==  null)
        {
            if(File::exists('image/posts'.$post->image))
            {
                unlink(public_path('image/posts'.$post->image));
            }
        }
        $post->delete() ;
    }
}
