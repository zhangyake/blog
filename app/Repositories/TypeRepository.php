<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2017/11/30
 * Time: 下午5:02
 */

namespace App\Repositories;




use App\Type;

class TypeRepository
{
    use CommonRepository;

    protected $model;

    public function __construct(Type $type)
    {
        $this->model = $type;
    }


    public function  getTypeArticleNum(){

        return $this->model->withCount('articles')->get();
    }

    public function getArticles($id)
    {
        $type =  $this->model->with('articles')->where('id',$id)->first();
        return array_get($type,'articles',[]);
    }

}