<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->index('category_id'); // Für schnellere category-basierte Filter
            $table->index('question');    // Für LIKE-basierte Suchen im Backend
            $table->fullText('answer');   // Für bessere Volltextsuche (MySQL 5.6+)
        });

        /* Join performance */
        Schema::table('faq_tag', function (Blueprint $table) {
            $table->index('faq_id');
            $table->index('tag_id');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->index('name'); // often searched with like
        });
    }

    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['question']);
            $table->dropFullText(['answer']);
        });

        Schema::table('faq_tag', function (Blueprint $table) {
            $table->dropIndex(['faq_id']);
            $table->dropIndex(['tag_id']);
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
};
