<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeoTagsToBfmFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bfm_forms', function (Blueprint $table) {
            $table->text('meta_description')->nullable()->after('slug');
            $table->text('meta_keywords')->nullable()->after('slug');
            $table->string('meta_title')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bfm_forms', function (Blueprint $table) {
            $table->dropColumn('meta_title', 'meta_keywords', 'meta_description');
        });
    }
}
