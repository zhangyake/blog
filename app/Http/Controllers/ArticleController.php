<?php

namespace App\Http\Controllers;


use App\Article;
use App\Repositories\TypeRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    protected $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }


    //
    public function index($id)
    {
        $article        = Article::with('type')->where('id', $id)->first();
        $recentArticles = Article::select('id', 'title')->orderBy('id', 'DESC')->limit(5)->get();
        $types          = $this->typeRepository->getTypeArticleNum();

        return view('article', compact('article', 'types', 'recentArticles'));
    }

    public function lists()
    {
        $articles       = Article::with('type')->orderBy('id', 'DESC')->get();
        $recentArticles = Article::select('id', 'title')->orderby('id', 'DESC')->limit(5)->get();
        $types          = $this->typeRepository->getTypeArticleNum();

        $name = '所有文章';
        return view('archives', compact('name', 'articles', 'types', 'recentArticles'));
    }


}
