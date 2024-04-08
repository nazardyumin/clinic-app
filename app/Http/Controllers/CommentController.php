<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function show()
    {
        $comments = Comment::all();
        return view('comments.comments', compact('comments'));
    }

    public function add(Request $request)
    {
        $now = Carbon::now()->toDateTimeString();
        Comment::create([
            'user_id' => $request->user_id,
            'comment' =>  $request->comment,
            'rate' => $request->rate,
            'date' => $now
        ]);

        return redirect(route('comments'));
    }
}
