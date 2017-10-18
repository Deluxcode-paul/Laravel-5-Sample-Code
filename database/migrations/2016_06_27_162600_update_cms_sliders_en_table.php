<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCmsSlidersEnTable extends Migration
{
    public function up()
    {
        Schema::table('cms_sliders_en', function (Blueprint $table) {
            $table->string('heading');
        });
    }

    public function down()
    {
        Schema::table('cms_sliders_en', function (Blueprint $table) {
            $table->dropColumn('heading');
        });
    }
}
