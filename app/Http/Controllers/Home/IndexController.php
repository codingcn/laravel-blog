<?php

namespace App\Http\Controllers\Home;


use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\SeoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends CommonController
{
    private $articleRepository;
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    public function index(Request $request)
    {
        if ($request->session()->has('hello')) {
            $articles = new Article();
            $data = [
                'seo' => $this->getSeoInfo(getSetting('site_title'),'生活家','面朝大海，春暖花开'),
                'articles' => $articles->indexArticles(),
            ];
            return view('home/index', $data);
        } else {
            return redirect('/welcome');
        }
    }

    public function welcome(Request $request)
    {
        session(['hello' => 'worlds']);
        return view('home/welcome');
    }

}
