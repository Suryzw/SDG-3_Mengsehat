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
        Schema::create('weather_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('weather_name'); // contoh: clear sky, rain
            $table->text('recommendation'); // contoh: "Bersepeda santai" atau "Membaca buku di rumah"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_recommendations');
    }
};
