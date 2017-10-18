<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo');
            $table->string('cover');
            $table->string('banner');
            $table->string('title');
            $table->text('description');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('show_has_chef', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('show_id');
            $table->unsignedInteger('chef_id');
            $table->timestamps();

            $table->foreign('show_id')->references('id')->on('shows')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('chef_id')->references('id')->on('users')
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
        Schema::drop('show_has_chef');
        Schema::drop('shows');
    }
}
