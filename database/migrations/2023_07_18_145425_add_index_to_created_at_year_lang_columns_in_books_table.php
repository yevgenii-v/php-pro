<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->index(['created_at']);
            $table->index(['year', 'created_at']);
            $table->index(['lang', 'created_at']);
            $table->index(['year', 'lang', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['year', 'created_at']);
            $table->dropIndex(['lang', 'created_at']);
            $table->dropIndex(['year', 'lang', 'created_at']);
        });
    }
};
