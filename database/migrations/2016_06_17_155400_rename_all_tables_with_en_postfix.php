<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAllTablesWithEnPostfix extends Migration
{
    /**
     * php artisan migrate --path=packages/Bfm/flex-cms/src/migrations
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        // indexes removing
        Schema::table('cms_faq_items', function (Blueprint $table) {
            $table->dropForeign('cms_faq_items_faq_id_foreign');
            $table->dropIndex('cms_faq_items_faq_id_foreign');
        });
        Schema::table('cms_gallery_images', function (Blueprint $table) {
            $table->dropForeign('cms_gallery_images_gallery_id_foreign');
            $table->dropIndex('cms_gallery_images_gallery_id_foreign');
        });
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->dropForeign('cms_pages_parent_id_foreign');
            $table->dropIndex('cms_pages_parent_id_foreign');
        });
        Schema::table('cms_page_template', function (Blueprint $table) {
            $table->dropForeign('cms_page_template_page_id_foreign');
            $table->dropIndex('cms_page_template_page_id_foreign');
        });
        Schema::table('cms_slider_items', function (Blueprint $table) {
            $table->dropForeign('cms_slider_items_slider_id_foreign');
            $table->dropIndex('cms_slider_items_slider_id_foreign');
        });
        Schema::table('cms_tabs_item', function (Blueprint $table) {
            $table->dropForeign('cms_tabs_item_tabs_id_foreign');
            $table->dropIndex('cms_tabs_item_tabs_id_foreign');
        });

        // rename tables
        // rename page
        Schema::rename('cms_pages', 'cms_pages_en');
        // rename relations table
        Schema::rename('cms_page_template', 'cms_page_has_templates');
        // rename faqs tables group
        Schema::rename('cms_faqs', 'cms_faqs_en');
        Schema::rename('cms_faq_items', 'cms_faq_items_en');
        // rename wysiwyg tables group
        Schema::rename('cms_wysiwyg', 'cms_wysiwygs_en');
        Schema::rename('cms_two_column_wysiwyg', 'cms_two_column_wysiwygs_en');
        // rename gallery tables
        Schema::rename('cms_galleries', 'cms_galleries_en');
        Schema::rename('cms_gallery_images', 'cms_gallery_items_en');
        // rename slider tables
        Schema::rename('cms_sliders', 'cms_sliders_en');
        Schema::rename('cms_slider_items', 'cms_slider_items_en');
        // rename tab tables
        Schema::rename('cms_tabs', 'cms_tabs_en');
        Schema::rename('cms_tabs_item', 'cms_tab_items_en');


        // add foreign indexes
        Schema::table('cms_faq_items_en', function (Blueprint $table) {
            $table->foreign('faq_id')
                ->references('id')
                ->on('cms_faqs_en')
                ->onDelete('cascade');
        });
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->foreign('gallery_id')
                ->references('id')
                ->on('cms_galleries_en')
                ->onDelete('cascade');
        });
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('cms_pages_en')
                ->onDelete('cascade');
        });
        Schema::table('cms_page_has_templates', function (Blueprint $table) {
            $table->foreign('page_id')
                ->references('id')
                ->on('cms_pages_en')
                ->onDelete('cascade');
        });
        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->foreign('slider_id')
                ->references('id')
                ->on('cms_sliders_en')
                ->onDelete('cascade');
        });
        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->foreign('tabs_id')
                ->references('id')
                ->on('cms_tabs_en')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        // indexes removing
        Schema::table('cms_faq_items_en', function (Blueprint $table) {
            $table->dropForeign('cms_faq_items_en_faq_id_foreign');
            $table->dropIndex('cms_faq_items_en_faq_id_foreign');
        });
        Schema::table('cms_gallery_items_en', function (Blueprint $table) {
            $table->dropForeign('cms_gallery_items_en_gallery_id_foreign');
            $table->dropIndex('cms_gallery_items_en_gallery_id_foreign');
        });
        Schema::table('cms_pages_en', function (Blueprint $table) {
            $table->dropForeign('cms_pages_en_parent_id_foreign');
            $table->dropIndex('cms_pages_en_parent_id_foreign');
        });
        Schema::table('cms_page_has_templates', function (Blueprint $table) {
            $table->dropForeign('cms_page_has_templates_page_id_foreign');
            $table->dropIndex('cms_page_has_templates_page_id_foreign');
        });
        Schema::table('cms_slider_items_en', function (Blueprint $table) {
            $table->dropForeign('cms_slider_items_en_slider_id_foreign');
            $table->dropIndex('cms_slider_items_en_slider_id_foreign');
        });
        Schema::table('cms_tab_items_en', function (Blueprint $table) {
            $table->dropForeign('cms_tab_items_en_tabs_id_foreign');
            $table->dropIndex('cms_tab_items_en_tabs_id_foreign');
        });


        // rename tables
        // rename page
        Schema::rename('cms_pages_en', 'cms_pages');
        // rename relations table
        Schema::rename('cms_page_has_templates', 'cms_page_template');
        // rename faqs tables group
        Schema::rename('cms_faqs_en', 'cms_faqs');
        Schema::rename('cms_faq_items_en', 'cms_faq_items');
        // rename wysiwyg tables group
        Schema::rename('cms_wysiwygs_en', 'cms_wysiwyg');
        Schema::rename('cms_two_column_wysiwygs_en', 'cms_two_column_wysiwyg');
        // rename gallery tables
        Schema::rename('cms_galleries_en', 'cms_galleries');
        Schema::rename('cms_gallery_items_en', 'cms_gallery_images');
        // rename slider tables
        Schema::rename('cms_sliders_en', 'cms_sliders');
        Schema::rename('cms_slider_items_en', 'cms_slider_items');
        // rename tab tables
        Schema::rename('cms_tabs_en', 'cms_tabs');
        Schema::rename('cms_tab_items_en', 'cms_tabs_item');


        // add foreign indexes
        Schema::table('cms_faq_items', function (Blueprint $table) {
            $table->foreign('faq_id')
                ->references('id')
                ->on('cms_faqs')
                ->onDelete('cascade');
        });
        Schema::table('cms_gallery_images', function (Blueprint $table) {
            $table->foreign('gallery_id')
                ->references('id')
                ->on('cms_galleries')
                ->onDelete('cascade');
        });
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('cms_pages')
                ->onDelete('cascade');
        });
        Schema::table('cms_page_template', function (Blueprint $table) {
            $table->foreign('page_id')
                ->references('id')
                ->on('cms_pages')
                ->onDelete('cascade');
        });
        Schema::table('cms_slider_items', function (Blueprint $table) {
            $table->foreign('slider_id')
                ->references('id')
                ->on('cms_sliders')
                ->onDelete('cascade');
        });
        Schema::table('cms_tabs_item', function (Blueprint $table) {
            $table->foreign('tabs_id')
                ->references('id')
                ->on('cms_tabs')
                ->onDelete('cascade');
        });
    }
}
