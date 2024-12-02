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
        if (Schema::hasTable('attachments')) {
            Schema::table('attachments', function (Blueprint $table) {
                if (!Schema::hasColumn('attachments', 'width')) {
                    $table->unsignedInteger('width')->nullable()->after('size');
                }
                if (!Schema::hasColumn('attachments', 'height')) {
                    $table->unsignedInteger('height')->nullable()->after('width');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('attachments')) {
            Schema::table('attachments', function (Blueprint $table) {
                $table->dropColumn('width');
                $table->dropColumn('height');
            });
        }
    }
};
