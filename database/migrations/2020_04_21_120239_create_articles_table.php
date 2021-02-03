<?php

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
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
	        $table->string('slug');
            $table->string('image');
            $table->text('content');
	        $table->unsignedBigInteger( 'user_id');
            $table->timestamps();
        });

	    Schema::table('articles', function(Blueprint $table) {
		    $table->foreign( 'user_id')->references( 'id')->on('users');
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
