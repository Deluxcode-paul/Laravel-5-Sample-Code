<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsEditableToFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bfm_forms_fields', function (Blueprint $table) {
            $table->boolean('is_editable')->default(false)->after('is_shown_in_grid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bfm_forms_fields', function (Blueprint $table) {
            $table->dropColumn('is_editable');
        });
    }
}
