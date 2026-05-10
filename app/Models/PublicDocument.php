<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicDocument extends Model
{
    protected $fillable = [
        'title',
        'description',
        'document_path',
        'type',
        'tag',
        'issuer',
        'issue_date',
        'expiry_date',
    ];

    protected $casts = [
        'issue_date'  => 'date',
        'expiry_date' => 'date',
    ];

    public const TYPES = [
        'hero'          => 'Hero / Bannière',
        'background'    => 'Arrière-plan',
        'illustration'  => 'Illustration',
        'certification' => 'Certification / Diplôme',
        'autre'         => 'Autre',
    ];

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->document_path) . '?v=' . ($this->updated_at?->timestamp ?? time());
    }
}
