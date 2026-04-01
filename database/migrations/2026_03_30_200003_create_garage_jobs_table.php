<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garage_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->unique();
            $table->foreignId('garage_client_id')->constrained('garage_clients')->onDelete('cascade');
            $table->foreignId('garage_vehicle_id')->constrained('garage_vehicles')->onDelete('cascade');
            $table->text('description');
            $table->string('assigned_mechanic')->nullable();
            $table->enum('status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garage_jobs');
    }
};
