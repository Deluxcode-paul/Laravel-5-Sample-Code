<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class AddTimestampsForCmsPagesEn extends Migration
{
    public function up()
    {
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable()->default(Carbon::now());
            $table->timestamp('updated_at')->nullable()->default(Carbon::now());
            $table->timestamp('published_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('published_at');
        });
    }
}
