<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->string('code', 3)->primary();
            $table->string('name');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('city_code', 3);
            $table->string('city');
            $table->string('country_code', 2);
            $table->string('timezone');        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
