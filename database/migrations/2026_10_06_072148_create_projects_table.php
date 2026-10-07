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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client_name')->nullable();
            $table->string('project_type')->default('residential');
            $table->string('location')->nullable();
            $table->decimal('building_area_sqm', 10, 2)->nullable();
            $table->decimal('land_area_sqm', 10, 2)->nullable();
            $table->integer('completion_year')->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->default('completed');
            $table->text('challenge_description')->nullable();
            $table->text('solution_description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
