<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_tags', function (Blueprint $table) {
            //
            $table->foreignId('tag_id')->after('id');
            $table->foreign('tag_id')->on('tags')->references('id')->cascadeOnDelete();

            $table->foreignId('product_id')->after('id');
            $table->foreign('product_id')->on('products')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_tags', function (Blueprint $table) {
            //
            $table->dropForeign('product_tags_tag_id_foreign');
            $table->dropColumn('tag_id');

            $table->dropForeign('product_tags_product_id_foreign');
            $table->dropColumn('product_id');
        });
    }
};
