<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBmisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bmis', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedBigInteger('user_info_id');
	        $table->float('bmi', 3, 1)->nullable();
	        $table->timestamps();
        });

	    Schema::table('user_bmis', function(Blueprint $table) {
		    $table->foreign('user_info_id')->references('id')->on('user_info');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bmis');
    }
}
