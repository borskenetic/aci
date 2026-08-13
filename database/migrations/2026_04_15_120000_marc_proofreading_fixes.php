<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('marc_fields')) {
            return;
        }

        // --- 541: move date from ‡a to ‡d before vendor claims ‡a (avoids unique clash) ---
        $dateMarcId = DB::table('marc_fields as mf')
            ->join('catalog_framework_fields as cff', 'cff.marc_field_id', '=', 'mf.id')
            ->where('mf.tag', '541')
            ->where('mf.subfield', 'a')
            ->where('cff.book_column', 'source_date')
            ->value('mf.id');

        if ($dateMarcId) {
            DB::table('marc_fields')->where('id', $dateMarcId)->update([
                'subfield' => 'd',
                'label' => 'Date of acquisition',
            ]);
        }

        if (Schema::hasTable('book_marc_fields')) {
            DB::table('book_marc_fields')
                ->where('tag', '541')
                ->where('subfield', 'a')
                ->update(['subfield' => 'd']);
        }

        $vendorMarcId = DB::table('marc_fields as mf')
            ->join('catalog_framework_fields as cff', 'cff.marc_field_id', '=', 'mf.id')
            ->where('mf.tag', '541')
            ->whereNull('mf.subfield')
            ->where('cff.book_column', 'source_vendor')
            ->value('mf.id');

        if ($vendorMarcId) {
            DB::table('marc_fields')->where('id', $vendorMarcId)->update([
                'subfield' => 'a',
                'label' => 'Immediate source of acquisition',
            ]);
        }

        if (Schema::hasTable('book_marc_fields')) {
            DB::table('book_marc_fields')
                ->where('tag', '541')
                ->whereNull('subfield')
                ->update(['subfield' => 'a']);
        }

        // --- 250 ‡a (edition), 504 ‡a (bibliography) ---
        DB::table('marc_fields')->where('tag', '250')->whereNull('subfield')->update(['subfield' => 'a']);

        if (Schema::hasTable('book_marc_fields')) {
            DB::table('book_marc_fields')->where('tag', '250')->whereNull('subfield')->update(['subfield' => 'a']);
        }

        DB::table('marc_fields')->where('tag', '504')->whereNull('subfield')->update(['subfield' => 'a']);

        if (Schema::hasTable('book_marc_fields')) {
            DB::table('book_marc_fields')->where('tag', '504')->whereNull('subfield')->update(['subfield' => 'a']);
        }

        // --- Labels / options ---
        DB::table('marc_fields')
            ->where('tag', '300')
            ->where('subfield', 'f')
            ->update(['label' => 'Type of unit (e.g. volumes, pages)']);

        DB::table('marc_fields')
            ->where('tag', '852')
            ->where('subfield', 'c')
            ->update(['label' => 'Sublocation / shelving (local)']);

        $rows336 = DB::table('marc_fields')
            ->where('tag', '336')
            ->where('subfield', 'a')
            ->whereNotNull('options')
            ->get(['id', 'options']);

        foreach ($rows336 as $row) {
            $opts = json_decode($row->options, true);
            if (! is_array($opts)) {
                continue;
            }
            $changed = false;
            foreach ($opts as $i => $v) {
                if ($v === 'Gazetter') {
                    $opts[$i] = 'Gazetteer';
                    $changed = true;
                }
            }
            if ($changed) {
                DB::table('marc_fields')->where('id', $row->id)->update([
                    'options' => json_encode(array_values($opts)),
                ]);
            }
        }
    }

    public function down(): void
    {
        // Non-reversible data normalization; leave empty.
    }
};
