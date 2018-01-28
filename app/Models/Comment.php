<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function articles()
    {
        return $this->belongsTo('App\Models\Article');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * 和用户关联
     * @param $user_id
     * @return $this
     */
    public function like($user_id)
    {
        return $this->hasOne(Like::class)->where('user_id', $user_id);
    }

    /**
     * 文章所有赞
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
