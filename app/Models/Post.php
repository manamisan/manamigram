<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    const LOCAL_STORAGE_FOLDER = "public/media/";
    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()//: BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()//: HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     * Get all of the likes for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()//: HasMany
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function isLikedBy($user_id)
    {
        return $this->likes()->where('user_id',$user_id)->exists();
    }

    public function video()
    {
        $ext= File::extension($this->media);

        if($ext=='mp4'){
            return true;
        }else{
            return false;
        }
    }

    public function deleteMedia($media_name)
    {
        $media_path = self::LOCAL_STORAGE_FOLDER.$media_name;

        if(Storage::disk('local')->exists($media_path)){
            Storage::disk('local')->delete($media_path);
        }
    }
}
