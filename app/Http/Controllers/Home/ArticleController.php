<?php

namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\SeoRepository;
use Illuminate\Http\Request;


class ArticleController extends CommonController
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function show(Article $article)
    {
        if ($article->status == 1) {
            return response()->view('errors.404', [], 404);
        }
        $this->articleRepository->addPageViews($article);
        $article = $this->articleRepository->showArticle($article);
        $seoTitle = $article->title . '_' . getSetting('site_title');
        $seoKeywords = '面朝大海，春暖花开';
        $seoDescription = $article->summary;
        $seo = $this->getSeoInfo($seoTitle, $seoKeywords, $seoDescription);
        $data = [
            'article' => $article,
            'seo' => $seo
        ];
        return view('home.article', $data);
    }

    public function archives(Request $request)
    {
        $article = $this->articleRepository->archives();
        $data = [
            'date_title' => $request->input('year') . '-' . $request->input('month'),
            'articles' => $article,
            'seo' => [
                'title' => '归档_' . getSetting('site_title'),
                'keywords' => '面朝大海，春暖花开',
            ]
        ];
        return view('home.archives', $data);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $articles = $this->articleRepository->search($keywords);
        $data = [
            'articles' => $articles,
            'seo' => $this->getSeoInfo(getSetting('site_title'), '面朝大海，春暖花开')
        ];
        return view('home.category', $data);
    }
}
