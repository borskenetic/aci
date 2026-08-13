<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('marc_fields', function (Blueprint $table) {
            $table->id();
            $table->string('tag', 3);
            $table->string('subfield', 1)->nullable();
            $table->string('label')->nullable();
            $table->boolean('repeatable')->default(false);
            $table->string('input_type')->default('text'); // text|textarea|select|date
            $table->json('options')->nullable(); // for selects / authorized values
            $table->timestamps();

            $table->unique(['tag', 'subfield']);
            $table->index(['tag', 'subfield']);
        });

        Schema::create('catalog_frameworks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('catalog_framework_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('framework_id');
            $table->unsignedBigInteger('marc_field_id');

            $table->boolean('visible')->default(true);
            $table->boolean('required')->default(false);
            $table->unsignedInteger('sort_order')->default(0);

            // Optional mapping back to a concrete books column (keeps your current schema working)
            $table->string('book_column')->nullable();

            $table->string('default_value')->nullable();
            $table->timestamps();

            $table->foreign('framework_id')
                ->references('id')->on('catalog_frameworks')
                ->onDelete('cascade');

            $table->foreign('marc_field_id')
                ->references('id')->on('marc_fields')
                ->onDelete('cascade');

            $table->unique(['framework_id', 'marc_field_id']);
            $table->index(['framework_id', 'visible', 'sort_order']);
        });

        Schema::create('book_marc_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->string('tag', 3);
            $table->string('subfield', 1)->nullable();
            $table->string('indicator1', 1)->nullable();
            $table->string('indicator2', 1)->nullable();
            $table->unsignedInteger('occurrence')->default(0);
            $table->text('value')->nullable();
            $table->timestamps();

            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('cascade');

            $table->index(['book_id', 'tag', 'subfield']);
            $table->index(['book_id', 'tag', 'subfield', 'occurrence']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_marc_fields');
        Schema::dropIfExists('catalog_framework_fields');
        Schema::dropIfExists('catalog_frameworks');
        Schema::dropIfExists('marc_fields');
    }
};

