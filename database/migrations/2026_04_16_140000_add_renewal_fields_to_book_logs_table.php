<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('book_logs', 'renew_count')) {
                $table->unsignedTinyInteger('renew_count')->default(0)->after('circulation_type');
            }
            if (! Schema::hasColumn('book_logs', 'last_renewed_at')) {
                $table->dateTime('last_renewed_at')->nullable()->after('renew_count');
            }
        });

        if (Schema::hasColumn('book_logs', 'renew_count')) {
            DB::table('book_logs')->whereNull('renew_count')->update(['renew_count' => 0]);
        }
    }

    public function down(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            if (Schema::hasColumn('book_logs', 'last_renewed_at')) {
                $table->dropColumn('last_renewed_at');
            }
            if (Schema::hasColumn('book_logs', 'renew_count')) {
                $table->dropColumn('renew_count');
            }
        });
    }
};

