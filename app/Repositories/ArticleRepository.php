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

//
//    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
//    {
//        return $this->model->where('is_show', 1)->orderBy($sortColumn, $sort)->paginate($number);
//    }
}