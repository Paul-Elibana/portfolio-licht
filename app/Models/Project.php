<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modèle pour la gestion des projets du portfolio.
 * Un projet contient les informations de réalisation, technologies et liens.
 */
class Project extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'technologies',
        'image_path',
        'github_url',
        'live_url',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'technologies' => 'array',
    ];
}
