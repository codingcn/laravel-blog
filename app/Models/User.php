<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authentication
{
    use HasApiTokens, Notifiable;
    /**
     * 不可被批量赋值的属性。
     * @var array
     */
    protected $guarded = [];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes()
    {
        return $this->belongsToMany(CommentLike::class, 'comment_likes')->withTimestamps();
    }
    public function likeCommentFor(Comment $comment)
    {
        return $this->commentLikes()->toggle($comment);
    }
}
