<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * ArticlePolicy constructor.
     */
    public function __construct()
    {
        //
    }

    public function look(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }
}
