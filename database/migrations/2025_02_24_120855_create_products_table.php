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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('color');
            $table->string('filtration_stage');  // Number of filtration stages (4, 5, etc.)
            $table->string('cold_water_tank_capacity');  // Cold water tank capacity (e.g., '80L')
            $table->string('hot_water_tank_capacity');  // Hot water tank capacity (e.g., '8L')
            $table->string('heating_capacity');  // Minimum heating capacity (e.g., '80C')
            $table->string('cold_power_consumption');  // Power consumption for cold mode (e.g., '100W')
            $table->string('hot_power_consumption');  // Power consumption for hot mode (e.g., '300W')
            $table->integer('quantity')->default(0);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('products');
    }
};
