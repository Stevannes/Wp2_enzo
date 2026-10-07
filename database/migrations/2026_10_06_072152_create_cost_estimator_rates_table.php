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
        Schema::create('cost_estimator_rates', function (Blueprint $table) {
            $table->id();
            $table->string('building_type');
            $table->string('finish_grade')->default('standard');
            $table->decimal('base_price_per_sqm', 12, 2);
            $table->decimal('multi_floor_multiplier', 5, 2)->default(1.00);
            $table->text('specification_details')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_estimator_rates');
    }
};
