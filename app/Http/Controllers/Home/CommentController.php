<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentLike;
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
            'user_id' => \Auth::id(),
            'content' => $request->get('content'),
        ];
        Comment::create($data);
        return back();
    }

    public function like(Comment $comment)
    {
        return $this->responseJson('OK', [\request()->user()], '赞+1');
        if (\Auth::guard('home_session')->check()) {
//            \Auth::guard('home_session')->user()->likeCommentFor($comment);
            return $this->responseJson('OK', [\Auth::guard('home_session')], '赞+1');
        } else {
            return $this->responseJson('OK', [], '请先登录');
        }
    }
}
