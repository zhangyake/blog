<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->comment('用户名');
            $table->string('password')->nullable()->comment('密码');
            $table->string('github_user_id')->unique()->comment('github_user_id');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('avatar')->nullable()->comment('github头像url');
            $table->string('gender')->nullable()->comment('性别');
            $table->boolean('is_frozen')->default(false)->comment('是否冻结');
            $table->dateTime('last_login')->nullable()->comment('最后一次登录时间');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
