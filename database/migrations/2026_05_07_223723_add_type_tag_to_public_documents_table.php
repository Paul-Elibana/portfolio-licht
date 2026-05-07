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
        Schema::table('public_documents', function (Blueprint $table) {
            $table->string('type')->default('autre')->after('description');
            $table->string('tag')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('public_documents', function (Blueprint $table) {
            $table->dropColumn(['type', 'tag']);
        });
    }
};
