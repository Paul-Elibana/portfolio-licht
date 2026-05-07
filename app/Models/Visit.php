<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modèle pour le suivi des visites sur le site.
 */
class Visit extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'user_agent',
    ];

    /**
     * @var bool
     */
    public $timestamps = false; // Géré via useCurrent dans la migration
}
