<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('public_email')->nullable()->after('email');
            $table->string('phone')->nullable()->after('public_email');
            $table->string('github_url')->nullable()->after('phone');
            $table->string('linkedin_url')->nullable()->after('github_url');
            $table->string('location')->nullable()->after('linkedin_url');
            $table->boolean('is_available')->default(true)->after('location');
            $table->string('availability_text')->nullable()->after('is_available');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'public_email', 'phone', 'github_url', 'linkedin_url',
                'location', 'is_available', 'availability_text',
            ]);
        });
    }
};
