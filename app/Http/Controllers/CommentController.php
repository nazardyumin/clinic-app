<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show()
    {
        $comments = Comment::all();
        return view('comments.comments', compact('comments'));
    }

    public function add(Request $request)
    {

        $timeZone = Auth::user()->timezone;
        date_default_timezone_set($timeZone);
        $now = strtotime('now');

        Comment::create([
            'user_id' => $request->user_id,
            'comment' =>  $request->comment,
            'date' => $now
        ]);

        return redirect(route('comments'));
    }
}
