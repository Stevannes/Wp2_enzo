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
        Schema::create('inquiry_rfps', function (Blueprint $table) {
            $table->id();
            $table->string('rfp_number')->unique();
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('email');
            $table->string('phone_number');
            $table->string('project_category')->nullable();
            $table->string('site_location')->nullable();
            $table->decimal('estimated_budget_idr', 15, 2)->nullable();
            $table->decimal('planned_area_sqm', 10, 2)->nullable();
            $table->text('project_notes')->nullable();
            $table->string('source_channel')->default('web_form');
            $table->string('status')->default('new');
            $table->text('internal_admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_rfps');
    }
};
