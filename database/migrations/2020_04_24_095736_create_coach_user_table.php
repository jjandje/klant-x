<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_user', function (Blueprint $table) {
	        $table->integer('coach_id')->unsigned()->index();
	        $table->integer('user_id')->unsigned()->index();

	        $table->primary(['coach_id', 'user_id']);

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
        Schema::dropIfExists('coach_user');
    }
}
