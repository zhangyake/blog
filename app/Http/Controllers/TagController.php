<?php

namespace App\Http\Controllers;


use App\Article;

use App\Repositories\TagRepository;
use App\Repositories\TypeRepository;
use App\Tag;


class TagController extends Controller
{
    protected $tagRepository;
    protected $typeRepository;

    public function __construct(TagRepository $tagRepository,TypeRepository $typeRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->typeRepository = $typeRepository;
    }

    public function listArticles($id)
    {
        $tag = Tag::select('name')->find($id);
        $name = array_get($tag,'name') . ' 相关文章';
        $articles = $this->tagRepository->getArticles($id);
//        $recentArticles = Article::select('id','title')->orderby('id','DESC')->limit(5)->get();
//        $types   = $this->typeRepository->getTypeArticleNum();
//        $tags = Tag::select('id','name')->get();
        return view('archives', compact('name','articles'));
    }

}
