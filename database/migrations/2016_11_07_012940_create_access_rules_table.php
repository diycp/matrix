<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('access_id')->unsigned();
            $table->enum('method', ['get', 'post', 'put', 'patch', 'delete', 'options', 'any']);
            $table->string('path');
            $table->string('query')->nullable()->default(null);
            $table->timestamps();
            $table->index(['access_id', 'method', 'path']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('access_rules');
    }
}
