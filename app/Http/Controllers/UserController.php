<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/pictures/';
    private $user;

    public function __construct(User $user)
    {
        $this->user= $user;
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);

        return view('users.show')->with('user',$user);
    }

    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        return view('users.edit')->with('user',$user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required|min:1|max:50',
            'username'=>'required|min:1|max:50',
            'email'=>'required|min:1|max:50|unique:users,email,'.Auth::user()->id,
        ]);//unique means no duplicate, unique:TABLE,COLUMN,.(EXCEPT)
        // users table
        // email column
        // except the user who is currently logged in

        // getting the user currently logging in
        $user = $this->user->findOrFail(Auth::user()->id);

        $user->name= $request->name;
        $user->username= $request->username;
        $user->email= $request->email;

        if($request->picture){
            // dd($request->picture);
            $request->validate([
                'picture'=>'mimes:jpg,jpeg,png,gif|max:1048',
            ]);

            if($user->picture)
            {
                $this->deletePicture($user->picture);
                // deletePicture is used defined function
            }

            $user->picture=$this->savePicture($request);
        }

        $user->save();

        return redirect()->route('profile.show',$user->id);
    }

    public function savePicture($request)
    {
        // rename the file to prevent duplication /overwrite
        $picture_name = time().".".$request->picture->extension();

        // saving to storage folder
        $request->picture->storeAs(self::LOCAL_STORAGE_FOLDER, $picture_name);

        // return the picture name to be saved in the db
        return $picture_name;
    }

    public function deletePicture($picture_name)
    {
        // rename the file to prevent duplication /overwrite
        $picture_path = self::LOCAL_STORAGE_FOLDER.$picture_name;

        // checking if the picture exist in the storage
       if(Storage::disk('local')->exists($picture_path)){
            Storage::disk('local')->delete($picture_path);
       }
    }

    public function destroy($id)
    {
        $user=$this->user->findOrFail($id);
        $user->deletePicture($user->picture);

        $all_posts= $user->posts;

        foreach($all_posts as $post)
        {
            $post->deleteMedia($post->media);
            $post->delete();
        }

        $this->user->destroy($id);
        return redirect()->route('index');
    }
}
