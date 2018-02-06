<?php


namespace App\Repositories;


use App\Models\Article;

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
        return Article::where('status','2')
            ->withCount('comments')
            ->with('tags')
            ->with('articleCategory')
            ->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(8);
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

    public function showArticle(Article $article)
    {
        //取得当前文章的总评论数
        $article = $article->withCount('comments')
            ->find($article->id)
            ->load('comments', 'tags', 'user');
        $article->comments = $article->comments()->withCount('likes')->get();
        $article->content_html = preg_replace("/<img\s+src=['\"](.+)['\"]\s(.*('|\"))>/", '<img src="' . asset('storage') . '${1}" ${2}>', $article->content_html);
        return $article;
    }

    public function archives()
    {
        return Article::where('status', '=', '2')
            ->orderBy('created_at', 'desc')
            ->filter(request()->only(['year', 'month']))
            ->latest()
            ->paginate(10);
    }

    public function search($keywords = '')
    {
        return Article::where('title', 'like', "%{$keywords}%")
            ->orWhere('summary', 'like', "%{$keywords}%")
            ->orWhere('content_html', 'like', "%{$keywords}%")
            ->paginate(10);
    }
}