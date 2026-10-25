<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Evaluasi Dosen:
     * - Poin 5: Manajemen Alur Negosiasi & Penugasan (rfp_negotiation_logs)
     * - Poin 7: Pemantauan Progres Harian Mandor & Visual Pembanding (construction_progress_logs)
     * - Poin 8: Fitur Komplain / Pengaduan Hasil Lapangan (project_complaints)
     */
    public function up(): void
    {
        // Poin 5: Log Negosiasi Harga & Spesifikasi
        Schema::create('rfp_negotiation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_rfp_id')->constrained('inquiry_rfps')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('stage'); // initial_proposal, spec_clarification, price_negotiation, revised_boq, final_deal, rejected
            $table->decimal('proposed_amount_idr', 15, 2)->nullable();
            $table->text('client_notes')->nullable();
            $table->text('admin_response')->nullable();
            $table->timestamps();
        });

        // Poin 7: Jurnal Laporan Harian/Berkala Mandor & Komparasi Desain vs Nyata
        Schema::create('construction_progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_rfp_id')->constrained('inquiry_rfps')->cascadeOnDelete();
            $table->unsignedSmallInteger('day_number'); // Hari ke-1, 15, 30, dst.
            $table->date('log_date');
            $table->string('stage_name'); // Pondasi, Pengecoran Sloof/Kolom, Rangka Atap, Finishing
            $table->text('description');
            $table->string('promised_render_image')->nullable(); // Desain Render 3D yang dijanjikan
            $table->string('actual_field_photo')->nullable(); // Foto Fisik Nyata di Lapangan
            $table->decimal('progress_percentage', 5, 2)->default(0); // 0 - 100%
            $table->string('logged_by_name')->default('Mandor Lapangan');
            $table->timestamps();
        });

        // Poin 8: Wadah Pengaduan / Komplain Konsumen
        Schema::create('project_complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_rfp_id')->constrained('inquiry_rfps')->cascadeOnDelete();
            $table->string('complaint_ticket')->unique(); // CMP-2610-001
            $table->string('category'); // warna_cat_finishing, posisi_sanitasi_wc, retak_acian, kelistrikan_mep, atap_bocor, lainnya
            $table->string('title');
            $table->text('description');
            $table->string('photo_proof')->nullable(); // Foto bukti ketidaksesuaian
            $table->string('urgency')->default('medium'); // low, medium, high, emergency
            $table->string('status')->default('submitted'); // submitted, in_review, repair_in_progress, resolved
            $table->text('admin_solution_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_complaints');
        Schema::dropIfExists('construction_progress_logs');
        Schema::dropIfExists('rfp_negotiation_logs');
    }
};
