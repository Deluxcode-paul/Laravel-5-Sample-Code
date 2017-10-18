<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('user_id');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('cook_time');
            $table->integer('serving');
            $table->unsignedInteger('preference_id');
            $table->tinyInteger('difficulty')->nullable();
            $table->unsignedInteger('blessing_type_id')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_banner')->default(false);
            $table->boolean('is_archive')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('preference_id')->references('id')->on('preferences')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('blessing_type_id')->references('id')->on('blessing_types')
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
        Schema::drop('recipes');
    }
}
