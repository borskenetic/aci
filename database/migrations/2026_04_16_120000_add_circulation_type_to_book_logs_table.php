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
            if (! Schema::hasColumn('book_logs', 'circulation_type')) {
                $table->string('circulation_type', 20)->default('checkout')->after('status');
            }
        });

        if (Schema::hasColumn('book_logs', 'circulation_type')) {
            DB::table('book_logs')->whereNull('circulation_type')->update(['circulation_type' => 'checkout']);
        }
    }

    public function down(): void
    {
        Schema::table('book_logs', function (Blueprint $table) {
            if (Schema::hasColumn('book_logs', 'circulation_type')) {
                $table->dropColumn('circulation_type');
            }
        });
    }
};
