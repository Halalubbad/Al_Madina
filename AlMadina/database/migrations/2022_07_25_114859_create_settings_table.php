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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('instagram');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('youtube');
            $table->string('email');
            $table->integer('mobile');
            $table->integer('whatsapp');
            $table->string('sales_manager_mobile');
            $table->integer('customer_followup_mobile');
            $table->integer('disributor_mobile');
            $table->string('location');
            $table->string('site_image');
            $table->string('boss_image');
            $table->text('boss_words');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
