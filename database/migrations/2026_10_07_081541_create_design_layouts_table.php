<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fitur 2 Evaluasi Dosen: Katalog Referensi Desain & Pemilihan Tata Letak (Layout Siap Pakai)
     */
    public function up(): void
    {
        Schema::create('design_layouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('minimalis'); // minimalis, tropis_modern, skandinavia, industrial, mediterania
            $table->string('building_type'); // Type 45, Type 70, Type 120, Villa 2-Lantai, Ruko 3-Lantai
            $table->decimal('land_size_sqm', 8, 2);
            $table->decimal('building_size_sqm', 8, 2);
            $table->unsignedTinyInteger('floor_count')->default(1);
            $table->unsignedTinyInteger('bedrooms')->default(2);
            $table->unsignedTinyInteger('bathrooms')->default(1);
            $table->unsignedTinyInteger('carport_capacity')->default(1);
            $table->string('layout_plan_image')->nullable(); // Gambar Denah Arsitektural 2D
            $table->string('render_3d_image')->nullable(); // Visualisasi Render 3D Eksterior
            $table->decimal('estimated_price_idr', 15, 2)->nullable();
            $table->text('specifications_summary')->nullable();
            $table->boolean('is_featured')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_layouts');
    }
};
