<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Evaluasi Dosen:
     * - Poin 2: Referensi Layout Pilihan (design_layout_id)
     * - Poin 4: Notifikasi & Pengingat Admin (admin_last_viewed_at, reminder_count, last_reminder_at)
     * - Poin 5: Manajemen Penugasan Staf (assigned_to_user_id, deal_amount_idr, deal_date)
     * - Poin 6: Skema Opsi Pembayaran (payment_scheme: cash, cash_tempo, kpr_bank)
     * - Poin 10: Kebijakan Privasi Data Hunian (is_residential, client_privacy_consented)
     */
    public function up(): void
    {
        Schema::table('inquiry_rfps', function (Blueprint $table) {
            $table->foreignId('design_layout_id')->nullable()->after('project_category')->constrained('design_layouts')->nullOnDelete();
            $table->string('payment_scheme')->default('cash_tempo')->after('estimated_budget_idr'); // cash, cash_tempo, kpr_bank
            $table->foreignId('assigned_to_user_id')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->timestamp('admin_last_viewed_at')->nullable()->after('assigned_to_user_id');
            $table->unsignedSmallInteger('reminder_count')->default(0)->after('admin_last_viewed_at');
            $table->timestamp('last_reminder_at')->nullable()->after('reminder_count');
            $table->decimal('deal_amount_idr', 15, 2)->nullable()->after('estimated_budget_idr');
            $table->date('deal_date')->nullable()->after('deal_amount_idr');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('is_residential')->default(false)->after('project_type');
            $table->boolean('client_privacy_consented')->default(false)->after('is_residential');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiry_rfps', function (Blueprint $table) {
            $table->dropForeign(['design_layout_id']);
            $table->dropForeign(['assigned_to_user_id']);
            $table->dropColumn([
                'design_layout_id',
                'payment_scheme',
                'assigned_to_user_id',
                'admin_last_viewed_at',
                'reminder_count',
                'last_reminder_at',
                'deal_amount_idr',
                'deal_date',
            ]);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['is_residential', 'client_privacy_consented']);
        });
    }
};
