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

    /**
     * @param Request $request
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->session()->has('hello')) {
            $data = [
                'seo' => $this->getSeoInfo(getSetting('site_title'),'边城','面朝大海，春暖花开'),
                'articles' => $this->articleRepository->indexArticles(),
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
