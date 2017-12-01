<?php

namespace App\Http\Controllers;


use App\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\TypeRepository;
use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    protected $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function listArticles($id)
    {
        $type = Type::select('name')->find($id);
        $name = array_get($type,'name') . ' 相关文章';
        $articles = $this->typeRepository->getArticles($id);
        $recentArticles = Article::select('id','title')->orderby('id','DESC')->limit(5)->get();
        $types   = $this->typeRepository->getTypeArticleNum();

        return view('archives', compact('name','articles', 'types','recentArticles'));
    }

}
