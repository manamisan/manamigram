<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

// use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const LOCAL_STORAGE_FOLDER = "public/pictures/";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()//: HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    /**
     * Get all of the followers for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers()//: HasMany
    {
        return $this->hasMany(Follow::class, 'followee_id');
    }

    public function followings()//: HasMany
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function isFollowedBy($user_id)
    {
        return $this->followers->where('follower_id',$user_id)->count();
    }

    public function deletePicture($picture_name)
    {
        $media_path = self::LOCAL_STORAGE_FOLDER.$picture_name;

        if(Storage::disk('local')->exists($media_path)){
            Storage::disk('local')->delete($media_path);
        }
    }

    /**
    * パスワードリセット通知の送信
    *
    * @param  string  $token
    * @return void
    */
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetPasswordNotification($token));
    // }
}
