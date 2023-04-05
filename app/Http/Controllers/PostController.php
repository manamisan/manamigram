<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    const LOCAL_STORAGE_FOLDER = "public/media/";
    private $post;

    public function __construct(Post $post)
    {
        $this->post= $post;
    }

    public function index()
    {
        // getting all the posts from the db - with pagination
        $all_posts= $this->post->latest()->paginate(5);

        // send the all_posts to the index
        return view('index')->with('all_posts',$all_posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title'=>'max:50',
            'body'=>'required|min:1|max:1000',
        ]); // mime = multipurpose internet mail extensions

        if($request->media){

            $mime = $request->media->getClientMimeType();

            if(strpos($mime,'image') !== false){

                $request->validate([
                    'media'=>'required|mimes:jpg,jpeg,png,gif|max:1048',
                ]);

            }elseif(strpos($mime,'video') !== false || strpos($mime,'application') !== false){

                $request->validate([
                    'media'=>'required|mimes:mp4|max:8000',
                ]);
            }

            $this->post->media = $this->saveMedia($request);
        }

        // save inputs to database
        $this->post->user_id = Auth::user()->id;
        // will get the id of currently logged-in user
        $this->post->title = $request->title ?? null;
        $this->post->body = $request->body;
        $this->post->save();

        return redirect()->route('index'); // go back to homepage
    }

    public function saveMedia($request)
    {
        // changing name of the media to prevent duplicate/overtime
        $media_name= time().".".$request->media->extension();

        // saving the media to storage folder
        $request->media->storeAs(self::LOCAL_STORAGE_FOLDER,$media_name);

        // return the media name to be saved in the database
        return $media_name;
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return view('posts.show')
            ->with('post',$post);
    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        return view('posts.edit')
            ->with('post',$post);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'body'=>'required|min:1|max:1000',
        ]); // mime = multipurpose internet mail extensions

        $post = $this->post->findOrFail($id);

        $post->body = $request->body;

        if($request->title){
            $request->validate([
                'title'=>'required|min:1|max:50',
            ]);

            $post->title = $request->title;
        }

        if($request->media){

            $request->validate([
                'media'=>'required|mimes:jpg,jpeg,png,gif|max:1048',
            ]);
            //delete the old media from storage
            $post->deleteMedia($post->media);
            
            // save the new media to storage and save to db
            $post->media = $this->saveMedia($request);
        }

        // save everything to the db
        $post->save();

        // going to show post page together with the id as parameter
        return redirect()->route('post.show',$id);
    }

    public function destroy($id)
    {
        $post=$this->post->findOrFail($id);
        $post->deleteMedia($post->media);
        // $this->deleteMedia($this->post->findOrFail($id)->media);

        $this->post->destroy($id);
        return redirect()->route('index');
    }

}
