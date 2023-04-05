<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    private $follow;
    private $user;

    public function __construct(Follow $follow, User $user)
    {
        $this->follow= $follow;
        $this->user = $user; 
    }

    public function follow($followee_id, $follower_id)
    {
        $this->follow->followee_id= $followee_id;
        $this->follow->follower_id= $follower_id;
        $this->follow->save();

        return redirect()->back();
    }

    public function unfollow($followee_id, $follower_id)
    {
        $follow = $this->follow->where('follower_id',$follower_id)->where('followee_id',$followee_id)->first();
        $this->follow->destroy($follow->id);

        return redirect()->back();
    }

    // public function unfollow(Request $request)
    // {
    //     $follow = $this->follow->where('follower_id',$follower_id)->where('followee_id',$followee_id)->first();
    //     $this->follow->destroy($follow->id);

    //     return redirect()->back();
    // }

    public function followers($id)
    {
        $user= $this->user->findOrFail($id);
        $follows = $this->follow->where('followee_id',$id)->get();
        return view('follows.followers',compact(['user','follows']));
    }

    public function following($id)
    {
        $user= $this->user->findOrFail($id);
        $follows = $this->follow->where('follower_id',$id)->get();
        return view('follows.following',compact(['user','follows']));
    }
}
