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
        Schema::table('album_images', function (Blueprint $table) {
            //
            $table->foreignId('album_id')->after('id');
            $table->foreign('album_id')->on('albums')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('album_images', function (Blueprint $table) {
            //
            $table->dropForeign('album_images_album_id_foreign');
            $table->dropColumn('album_id');
        });
    }
};
