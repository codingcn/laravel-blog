<?php

namespace App\Http\Controllers\Home;


use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class IndexController extends CommonController
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * 首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->session()->has('hello')) {
            $data = [
                'seo' => $this->getSeoInfo(getSetting('site_title'), '边城', '面朝大海，春暖花开'),
                'articles' => $this->articleRepository->indexArticles(),
            ];
            return view('home.index', $data);
        } else {
            return redirect('/welcome');
        }
    }

    public function welcome(Request $request)
    {
        session(['hello' => 'worlds']);
        return view('home.welcome');
    }
}
