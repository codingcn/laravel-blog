<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authentication
{
    use  Notifiable;
    /**
     * 不可被批量赋值的属性。
     * @var array
     */
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * 用户评论列表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }
    public function commentLike()
    {
        return $this->belongsToMany(CommentLike::class, 'comment_likes', 'user_id', 'comment_id');
    }

    public function likeCommentFor(Comment $comment)
    {
        return $this->commentLike()->toggle($comment);
    }
}
