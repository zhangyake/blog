<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->comment('回复用户'); //
            $table->string('content', 1024); // 回复内容
            $table->morphs('target');
            $table->unsignedInteger('parent_id')->default(0)->comment('回复父id'); //
            $table->unsignedInteger('like_count')->default(0); // 点赞次数
            $table->timestamp('created_at', 0)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replays');
    }
}
