<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modèle pour la gestion des compétences techniques.
 */
class Skill extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'icon',
        'category',
    ];
}
