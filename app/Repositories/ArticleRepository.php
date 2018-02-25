<?php


namespace App\Repositories;


use App\Models\Article;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ArticleRepository
{
    public function selectAll()
    {
        return Article::all();
    }

    /**
     * 首页文章列表
     * @return mixed
     */
    public function indexArticles()
    {
        return Article::where('publish_status', '2')
            ->select(['id', 'category_id', 'title', 'summary', 'cover', 'content_length', 'page_views', 'published_at'])
            ->withCount('comments')
            ->with('tags')
            ->with([
                'articleCategory' => function ($query) {
                    $query->select(['id', 'name']);
                }
            ])
            ->orderBy('published_at','DESC')
            ->paginate(10);
    }

    /**
     * 增加浏览量
     * @param Article $article
     */
    public function addPageViews(Article $article)
    {
        $article->page_views += 1;
        $article->save();
    }

    public function showArticle(Article $article, $user)
    {
        //取得当前文章的总评论数
        $article = $article->select(['id', 'user_id', 'category_id', 'title', 'summary', 'content_html', 'publish_status', 'page_views', 'content_length', 'content_length', 'published_at'])
            ->withCount('comments')
            ->with([
                'comments' => function ($comments_query) {
                    $comments_query->with([
                        'user' => function ($query) {
                            $query->select(['id', 'username', 'avatar']);
                        }
                    ])
                        ->select(['id', 'user_id', 'article_id', 'content','created_at'])
                        ->withCount('likes')
                        ->get();
                },
                'tags' => function ($query) {
                    $query->select(['id', 'name']);
                },
                'user' => function ($query) {
                    $query->select(['id', 'username', 'avatar']);
                }
            ])->find($article->id)->toArray();
        // 是否已赞
        if (is_null($user)) {
            foreach ($article['comments'] as $k => $comment) {
                $article['comments'][$k]['is_liked'] = false;
            }
        } else {
            $user_comment_likes = $user->commentLikes->toArray();
            $user_comment_ids = array_column($user_comment_likes, 'comment_id');
            foreach ($article['comments'] as $k => $comment) {
                if (in_array($comment['id'], $user_comment_ids)) {
                    $article['comments'][$k]['is_liked'] = true;
                } else {
                    $article['comments'][$k]['is_liked'] = false;
                }
            }
        }
        $article['content_html'] = preg_replace("/<img\s+src=['\"](.+)['\"]\s(.*('|\"))>/", '<img src="' . asset('storage') . '${1}" ${2}>', $article['content_html']);
        return $article;
    }

    public function archives()
    {
        if (request('year') && request('month')) {
            return Article::where('publish_status', '=', '2')
                ->select(['*'])
                ->orderBy('published_at', 'desc')
                ->filter(request()->only(['year', 'month']))
                ->latest()
                ->paginate(10);
        } else {
            return Article::where('publish_status', '=', '2')
                ->select(['*', DB::raw("DATE_FORMAT( published_at,'%Y-%m') as published_date")])
                ->orderBy('published_at', 'desc')
                ->latest()
                ->get()
                ->groupBy('published_date')
                ->paginate(10);
        }

    }

    public function search($keywords = '')
    {
        return Article::where('title', 'like', "%{$keywords}%")
            ->orWhere('summary', 'like', "%{$keywords}%")
            ->orWhere('content_html', 'like', "%{$keywords}%")
            ->paginate(10);
    }

    /**
     * 删除文章
     * @param Article $article
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        $article_tags = \DB::table('article_tag')->where('article_id', $article->id)->get(['tag_id']);
        if (count($article_tags) > 0) {
            foreach ($article_tags ?? [] as $article_tag) {
                $count = \DB::table('article_tag')->where('tag_id', $article_tag->tag_id)->count();
                if ($count <= 1) {
                    Tag::destroy($article_tag->tag_id);
                }
            }
        }
        $article->tags()->detach();
        Comment::where('article_id',$article->id)->delete();
        CommentLike::where('article_id',$article->id)->delete();
        $article->delete();
    }
}