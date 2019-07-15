<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('文章标题');
            $table->longText('content_md')->comment('文章内容');
            $table->longText('content')->comment('文章内容');
            $table->text('summary')->comment('总结');
            $table->integer('user_id')->comment('作者id user表id');
            $table->integer('category_id')->comment('文章分类id');
            $table->tinyInteger('state')->default('0')->comment('0表示草稿箱，1表示已发表，2表示已删除');
            $table->integer('page_view')->default('0')->comment('浏览次数');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
