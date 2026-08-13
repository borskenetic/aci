<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('book_logs', 'fine_cleared_at')) {
                $table->timestamp('fine_cleared_at')->nullable()->after('fine_incurred');
            }
            if (! Schema::hasColumn('book_logs', 'fine_clearance_type')) {
                $table->string('fine_clearance_type', 32)->nullable()->after('fine_cleared_at');
            }
            if (! Schema::hasColumn('book_logs', 'fine_clearance_note')) {
                $table->text('fine_clearance_note')->nullable()->after('fine_clearance_type');
            }
            if (! Schema::hasColumn('book_logs', 'fine_cleared_by')) {
                $table->foreignId('fine_cleared_by')->nullable()->after('fine_clearance_note')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            if (Schema::hasColumn('book_logs', 'fine_cleared_by')) {
                $table->dropForeign(['fine_cleared_by']);
            }
            $cols = ['fine_cleared_at', 'fine_clearance_type', 'fine_clearance_note', 'fine_cleared_by'];
            $toDrop = array_filter($cols, fn ($c) => Schema::hasColumn('book_logs', $c));
            if ($toDrop !== []) {
                $table->dropColumn($toDrop);
            }
        });
    }
};
