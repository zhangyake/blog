<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2017/11/30
 * Time: 下午5:02
 */

namespace App\Repositories;


use App\Tag;

class TagRepository
{
    use CommonRepository;

    protected $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }


    public function  getTagArticleNum(){

        return $this->model->withCount('articles')->get();
    }

    public function getArticles($id)
    {
        $tag =  $this->model->with('articles')->where('id',$id)->first();

        return array_get($tag,'articles',[]);
    }

}