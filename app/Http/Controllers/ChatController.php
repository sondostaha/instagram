<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chatForm($user_id)
    {
        $reciever = User::findOrFail($user_id);
        return view('frontend.chat.index',compact('reciever'));
    }
}
