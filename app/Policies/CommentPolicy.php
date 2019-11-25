<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * CommentPolicy constructor.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, Comment $comment)
    {
        //已登录可评论
        return !empty($user->id);
    }
}
