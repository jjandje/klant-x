<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_user', function (Blueprint $table) {
            $table->integer('goal_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->boolean( 'active')->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('finish_date')->nullable();
            $table->boolean('finished')->default(0);

            $table->primary(['goal_id', 'user_id']);

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
        Schema::dropIfExists('goal_user');
    }
}
