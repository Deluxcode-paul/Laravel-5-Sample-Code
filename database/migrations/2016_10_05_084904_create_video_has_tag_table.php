<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_has_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('video_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->foreign('video_id')->references('id')->on('videos')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_has_tag');
    }
}
