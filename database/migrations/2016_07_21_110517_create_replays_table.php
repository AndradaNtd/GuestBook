<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('replay');
            $table->integer('review_id')->unsigned();
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('replays');
    }
}
