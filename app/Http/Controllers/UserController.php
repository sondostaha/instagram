<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function unFollowedFriends()
    {
        $follwers  = Follower::select('user_id')->where('follower_id',Auth::id())->pluck('user_id')->toArray();
        // dd()
        $notaddedlist = array_merge([Auth::id()],$follwers);
        $users = User::all()->except($notaddedlist);
        // dd($users);
        return view('forntend.user.index',compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->user_id;
        $user =  User::findOrFail($id);
        Follower::create([
            'follower_id' => Auth::id(),
            'user_id' => $id,
        ]);
        session()->flash('Add','You Followed this user successfully');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function showFriends()
    {
        $follwers  = Follower::select('user_id')->where('follower_id',Auth::id())->pluck('user_id');
        // dd()
        $users = User::whereIn('id',$follwers)->get();
        // dd($users);
        return view('forntend.user.index',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
