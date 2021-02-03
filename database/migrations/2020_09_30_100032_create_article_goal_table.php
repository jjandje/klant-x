<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleGoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_goal', function (Blueprint $table) {
        	$table->integer('article_id')->unsigned()->index();
        	$table->integer('goal_id')->unsigned()->index();

        	$table->primary(['article_id', 'goal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_goal');
    }
}
