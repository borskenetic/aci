<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('book_logs', 'fine_original')) {
                $table->decimal('fine_original', 8, 2)->nullable()->after('fine_incurred');
            }
            if (! Schema::hasColumn('book_logs', 'fine_balance')) {
                $table->decimal('fine_balance', 8, 2)->nullable()->after('fine_original');
                $table->index('fine_balance');
            }
            if (! Schema::hasColumn('book_logs', 'fine_paid_total')) {
                $table->decimal('fine_paid_total', 8, 2)->nullable()->default(0)->after('fine_balance');
            }
            if (! Schema::hasColumn('book_logs', 'fine_waived_total')) {
                $table->decimal('fine_waived_total', 8, 2)->nullable()->default(0)->after('fine_paid_total');
            }
        });

        // Backfill for existing rows.
        if (Schema::hasColumn('book_logs', 'fine_incurred')) {
            DB::table('book_logs')
                ->whereNotNull('fine_incurred')
                ->whereNull('fine_original')
                ->update(['fine_original' => DB::raw('fine_incurred')]);

            DB::table('book_logs')
                ->whereNotNull('fine_incurred')
                ->whereNull('fine_balance')
                ->update(['fine_balance' => DB::raw('fine_incurred')]);
        }
    }

    public function down(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            if (Schema::hasColumn('book_logs', 'fine_balance')) {
                $table->dropIndex(['fine_balance']);
            }
            $cols = ['fine_original', 'fine_balance', 'fine_paid_total', 'fine_waived_total'];
            $toDrop = array_filter($cols, fn ($c) => Schema::hasColumn('book_logs', $c));
            if ($toDrop !== []) {
                $table->dropColumn($toDrop);
            }
        });
    }
};

