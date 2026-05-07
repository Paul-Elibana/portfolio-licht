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
        Schema::create('public_documents', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Titre du document (ex: Certification AWS)
            $table->string('issuer')->nullable(); // Organisme émetteur (ex: Amazon Web Services)
            $table->date('issue_date')->nullable(); // Date d'émission
            $table->date('expiry_date')->nullable(); // Date d'expiration (optionnel)
            $table->string('document_path'); // Chemin vers le fichier (stocké dans storage/app/public)
            $table->text('description')->nullable(); // Description ou lien (optionnel)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_documents');
    }
};
