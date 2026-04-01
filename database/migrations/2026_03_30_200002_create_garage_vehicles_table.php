<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garage_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garage_client_id')->constrained('garage_clients')->onDelete('cascade');
            $table->string('car_model');
            $table->string('number_plate')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garage_vehicles');
    }
};
