<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('用户名');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('email')->unique();
            $table->string('password')->comment('密码');
            $table->string('user_face')->nullable()->comment('用户头像');
            $table->tinyInteger('gender')->default(0)->comment('性别 0：未知 1:男性 2：女性');
            $table->string('desc')->nullable()->comment('描述');
            $table->tinyInteger('state')->default(1)->comment('1:启用 0：禁用');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->comment('角色名称');
        });

        Schema::create('role_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('user_id');
            $table->unique(['role_id', 'user_id'],'role_user_unique_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_users');
    }
}
