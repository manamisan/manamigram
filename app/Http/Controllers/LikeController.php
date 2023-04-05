<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like)
    {
        $this->like=$like;
    }

    public function addLike($user_id,$post_id)
    {
        $this->like->user_id= $user_id;
        $this->like->post_id = $post_id;
        $this->like->save();

        return redirect()->back();
    }

    public function removeLike($user_id,$post_id)
    {
        $like=$this->like->where('user_id',$user_id)->where('post_id',$post_id)->first();
        $this->like->destroy($like->id);

        return redirect()->back();
    }
}
