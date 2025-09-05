<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('location_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->cascadeOnDelete();

            // Open/close as TIME columns with defaults 09:00 / 18:00
            $table->time('mon_open')->default('09:00:00');
            $table->time('mon_close')->default('18:00:00');

            $table->time('tue_open')->default('09:00:00');
            $table->time('tue_close')->default('18:00:00');

            $table->time('wed_open')->default('09:00:00');
            $table->time('wed_close')->default('18:00:00');

            $table->time('thu_open')->default('09:00:00');
            $table->time('thu_close')->default('18:00:00');

            $table->time('fri_open')->default('09:00:00');
            $table->time('fri_close')->default('18:00:00');

            $table->time('sat_open')->default('09:00:00');
            $table->time('sat_close')->default('18:00:00');

            $table->time('sun_open')->default('09:00:00');
            $table->time('sun_close')->default('18:00:00');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('location_hours');
    }
};
