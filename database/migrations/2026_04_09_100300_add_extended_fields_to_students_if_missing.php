<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            foreach ([
                'mobile_number' => fn (Blueprint $t) => $t->string('mobile_number')->nullable()->after('student_signature'),
                'address' => fn (Blueprint $t) => $t->text('address')->nullable()->after('mobile_number'),
                'emergency_person' => fn (Blueprint $t) => $t->string('emergency_person')->nullable()->after('address'),
                'emergency_relationship' => fn (Blueprint $t) => $t->string('emergency_relationship')->nullable()->after('emergency_person'),
                'emergency_number' => fn (Blueprint $t) => $t->string('emergency_number')->nullable()->after('emergency_relationship'),
                'emergency_address' => fn (Blueprint $t) => $t->text('emergency_address')->nullable()->after('emergency_number'),
            ] as $col => $callback) {
                if (! Schema::hasColumn('students', $col)) {
                    $callback($table);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $cols = ['mobile_number', 'address', 'emergency_person', 'emergency_relationship', 'emergency_number', 'emergency_address'];
            $toDrop = array_filter($cols, fn ($c) => Schema::hasColumn('students', $c));
            if ($toDrop !== []) {
                $table->dropColumn($toDrop);
            }
        });
    }
};
