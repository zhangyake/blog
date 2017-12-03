<?php

namespace App\Http\Middleware;

use App\Article;
use App\Repositories\TagRepository;
use App\Repositories\TypeRepository;
use Closure;
use Illuminate\Support\Facades\Cache;
use function PHPSTORM_META\type;

class HomeQueryMiddleware
{

    private $typeRepository;
    private $tagRepository;

    public function __construct(TypeRepository $typeRepository, TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->typeRepository = $typeRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!Cache::has('types')) {
            $types = $this->typeRepository->getTypeArticleNum();
            Cache::forever('types', $types);
        }
        if (!Cache::has('tags')) {
            $types = $this->tagRepository->getTagArticleNum();
            Cache::forever('tags', $types);
        }
        if (!Cache::has('recentArticles')) {
            $recentArticles = Article::select('id', 'title')->orderby('id', 'DESC')->limit(5)->get();
            Cache::forever('recentArticles', $recentArticles);
        }


        return $next($request);
    }
}
