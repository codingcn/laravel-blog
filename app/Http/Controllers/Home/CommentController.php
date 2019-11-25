<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends CommonController
{
    public function store(Request $request, Article $article)
    {
        $this->validate($request, [
            'content' => 'required|min:1'
        ]);
        $data = [
            'article_id' => $article->id,
            'user_id' => \Auth::guard('home_session')->id(),
            'content' => $request->get('content'),
        ];
        Comment::create($data);
        return back();
    }

    public function like(Comment $comment)
    {
        $user = \Auth::guard('home_token')->user();
        $res = $user->likeCommentFor($comment);
        if (count($res['attached'])) {
            $data['is_like'] = true;
        } else {
            $data['is_like'] = false;
        }
        return $this->responseJson('OK', $data, '赞+1');
    }
}
