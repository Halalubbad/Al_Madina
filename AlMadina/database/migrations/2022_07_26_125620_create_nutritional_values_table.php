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
        Schema::create('nutritional_values', function (Blueprint $table) {
            $table->id();
            $table->float('energy');
            $table->float('fatty');
            $table->float('proteins');
            $table->float('carbohydrates');
            $table->float('vitaminC');
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
        Schema::dropIfExists('nutritional_values');
    }
};
