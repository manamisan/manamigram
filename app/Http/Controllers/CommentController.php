<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function store($post_id, Request $request)
    {
        $request->validate([
            'comment'=>'required|min:1|max:150',
        ]);

        // save to db
        $this->comment->user_id = Auth::user()->id; //currently logged in user
        $this->comment->post_id = $post_id;//post that a user commented
        $this->comment->body = $request->comment; // comment from input
        $this->comment->save();

        return redirect()->back();

    }

    public function destroy($id)
    {
        $this->comment->destroy($id);

        return redirect()->back();
    }

    public function update($id, Request $request)
    {
        $comment= $this->comment->findOrFail($id);
        $comment->body= $request->comment;
        $comment->save();

        return redirect()->back();
    }
}
