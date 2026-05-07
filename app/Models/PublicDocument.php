<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modèle pour les documents publics (certifications, diplômes).
 */
class PublicDocument extends Model
{
    protected $fillable = [
        'title',
        'issuer',
        'issue_date',
        'expiry_date',
        'document_path',
        'description',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];
}
