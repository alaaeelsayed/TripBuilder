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
        Schema::create('flights', function (Blueprint $table) {
            $table->foreignId('airline')->constrained('airlines', 'code');
            $table->string('number');
            $table->string('departure_airport', 3);
            $table->time('departure_time');
            $table->string('arrival_airport', 3);
            $table->integer('duration');
            $table->decimal('price');

            $table->foreign('departure_airport')->references('code')->on('airports');
            $table->foreign('arrival_airport')->references('code')->on('airports');

            $table->primary(['airline', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
