<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2017/11/30
 * Time: 下午5:02
 */

namespace App\Repositories;


use App\Article;

class ArticleRepository
{
    use CommonRepository;

    protected $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->with('type')->orderBy($sortColumn, $sort)->paginate($number);
    }


    public function update($id, $input)
    {
       // 暂时不使用事务 后期加上
        $article = $this->model->find($id);
        $article->title = array_get($input,'title');
        $article->content = array_get($input,'content');
        $article->content_md = array_get($input,'content_md');
        $article->type_id = array_get($input,'type_id');
        $article->save();
        if(array_get($input,'tagIds')){
            $tagIds = array_unique(array_get($input,'tagIds'));
            $article->tags()->sync($tagIds);
        }
        return true;
    }
//
//    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
//    {
//        return $this->model->where('is_show', 1)->orderBy($sortColumn, $sort)->paginate($number);
//    }
}