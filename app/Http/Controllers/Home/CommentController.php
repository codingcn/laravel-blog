<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;
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
        if (\Auth::check()) {
            $param = [
                'user_id' => \Auth::id(),
                'comment_id' => $comment->id
            ];
            Like::firstOrCreate($param);
            return json_encode([
                'code'=>'0',
                'result'=>[
                    'msg'=>'赞+1'
                ]
            ]);
        }else{
            return json_encode([
                'code'=>'0',
                'result'=>[
                    'msg'=>'请先登录'
                ]
            ]);
        }
    }

    public function dislike(Comment $comment)
    {
        $comment->like(\Auth::id())->delete();
        return back();
    }
}
