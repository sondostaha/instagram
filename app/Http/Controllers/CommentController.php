<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function add(Request $request)
    {
        Comments::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'body' => $request->comment,
        ]);
        session()->flash('Add','Comment Added Successfully');
        return back();
    }
}
