<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pending_students', function (Blueprint $table) {
            if (! Schema::hasColumn('pending_students', 'mobile_number')) {
                $table->string('mobile_number', 20)->nullable()->after('year');
            }
            if (! Schema::hasColumn('pending_students', 'address')) {
                $table->text('address')->nullable()->after('mobile_number');
            }
            if (! Schema::hasColumn('pending_students', 'emergency_person')) {
                $table->string('emergency_person')->nullable()->after('address');
            }
            if (! Schema::hasColumn('pending_students', 'emergency_relationship')) {
                $table->string('emergency_relationship')->nullable()->after('emergency_person');
            }
            if (! Schema::hasColumn('pending_students', 'emergency_number')) {
                $table->string('emergency_number', 20)->nullable()->after('emergency_relationship');
            }
            if (! Schema::hasColumn('pending_students', 'emergency_address')) {
                $table->text('emergency_address')->nullable()->after('emergency_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pending_students', function (Blueprint $table) {
            $drop = [];
            foreach ([
                'mobile_number',
                'address',
                'emergency_person',
                'emergency_relationship',
                'emergency_number',
                'emergency_address',
            ] as $col) {
                if (Schema::hasColumn('pending_students', $col)) {
                    $drop[] = $col;
                }
            }
            if ($drop !== []) {
                $table->dropColumn($drop);
            }
        });
    }
};

