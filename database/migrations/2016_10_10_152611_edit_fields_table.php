<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bfm_forms_fields', function (Blueprint $table) {
            $table->string('value')->nullable()->after('name');
            $table->boolean('is_get_param')->default(false)->after('is_multiple');
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
            $table->dropColumn('value', 'is_get_param');
        });
    }
}
