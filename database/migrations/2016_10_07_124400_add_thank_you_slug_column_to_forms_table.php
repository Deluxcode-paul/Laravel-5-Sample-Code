<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThankYouSlugColumnToFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bfm_forms', function (Blueprint $table) {
            $table->string('thank_you_slug')->nullable()->after('thank_you_message');
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
            $table->dropColumn('thank_you_slug');
        });
    }
}
