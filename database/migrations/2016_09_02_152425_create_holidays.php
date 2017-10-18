<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->boolean('is_megamenu')->default(false);
            $table->timestamps();
        });

        Schema::create('holiday_has_preference', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('holiday_id');
            $table->unsignedInteger('preference_id');
            $table->timestamps();

            $table->foreign('holiday_id')->references('id')->on('holidays')
                ->onUpdate('no action')->onDelete('cascade');
            $table->foreign('preference_id')->references('id')->on('preferences')
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
        Schema::drop('holiday_has_preference');
        Schema::drop('holidays');
    }
}
