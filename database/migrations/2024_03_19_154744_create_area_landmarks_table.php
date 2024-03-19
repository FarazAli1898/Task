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
        Schema::create('area_landmarks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coordinates');
            $table->unsignedBigInteger('city_id');
            $table->timestamps();
        
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_landmarks');
    }
};
