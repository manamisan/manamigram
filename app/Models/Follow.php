<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Follow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    /**
     * Get the follower that owns the Follow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function follower()//: BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * Get the followee that owns the Follow
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function followee()//: BelongsTo
    {
        return $this->belongsTo(User::class, 'followee_id');
    }

}
