<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppinglistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppinglists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('due_date');
            $table->float('final_sum')->nullable();
            $table->bigInteger('seeker_id')->unsigned();
            $table->foreign('seeker_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('volunteer_id')->unsigned()->nullable();
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
        Schema::dropIfExists('shoppinglists');
    }
}
