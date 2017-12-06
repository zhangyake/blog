<?php

namespace App\Http\Controllers;


use App\Article;
use App\Repositories\TypeRepository;
use App\Tag;
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
        $article        = Article::with('type','tags')->where('id', $id)->first();
//        $recentArticles = Article::select('id', 'title')->orderBy('id', 'DESC')->limit(5)->get();
//        $types          = $this->typeRepository->getTypeArticleNum();
//        $tags = Tag::select('id','name')->get();
        return view('article', compact('article'));
    }

    public function lists()
    {
        $articles       = Article::with('type')->orderBy('id', 'DESC')->get();
//        $recentArticles = Article::select('id', 'title')->orderby('id', 'DESC')->limit(5)->get();
//        $types          = $this->typeRepository->getTypeArticleNum();
//        $tags = Tag::select('id','name')->get();
        $name = '所有文章';
        return view('archives', compact('name', 'articles'));
    }

    public function allArticles(){
        $articles       = Article::with('type')->orderBy('id', 'DESC')->get();

        return view('welcome', compact( 'articles'));
    }


}
