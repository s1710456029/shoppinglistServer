<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
                $table->bigIncrements('id');
                //$table->string('title');
                $table->string('text');
                $table->bigInteger('user_id')->unsigned();
                $table->integer('shoppinglist_id')->unsigned();

                $table->foreign('shoppinglist_id')->references('id')->on('shoppinglists')->onDelete('cascade');
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
        Schema::dropIfExists('comments');
    }
}
