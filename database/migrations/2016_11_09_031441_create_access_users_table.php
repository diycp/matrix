<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('access_id')->unsigned();
            $table->tinyInteger('access_type')->unsigned()->default(0); // 0为关联权限id，1为关联权限分组
            $table->integer('user_id')->unsigned()->default(0);         // 为0时则使用群组控制
            $table->string('user_group')->nullable()->default(null);   // 用户群组，只在user_id为0时启用
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
        Schema::drop('access_users');
    }
}
