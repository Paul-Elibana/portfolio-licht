<?php

namespace App\Services;

use App\Models\Visit;
use Illuminate\Http\Request;

/**
 * Service pour la gestion des statistiques du portfolio.
 * Ce service permet de suivre les visites et de récupérer les données analytiques.
 */
class AnalyticsService
{
    /**
     * Enregistre une nouvelle visite de manière asynchrone (non-bloquante).
     *
     * @param Request $request
     * @return void
     */
    public function recordVisit(Request $request): void
    {
        // On évite d'enregistrer les visites locales si nécessaire, 
        // mais pour le dev on peut tout garder.
        Visit::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Retourne le nombre total de visites uniques (basé sur l'IP).
     *
     * @return int
     */
    public function getTotalUniqueVisits(): int
    {
        return Visit::distinct('ip_address')->count();
    }

    /**
     * Retourne le nombre total de pages vues.
     *
     * @return int
     */
    public function getTotalViews(): int
    {
        return Visit::count();
    }
}
