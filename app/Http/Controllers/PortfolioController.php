<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Visit;
use App\Models\User;
use App\Models\ContactMessage;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Contrôleur principal gérant l'affichage du portfolio.
 */
class PortfolioController extends Controller
{
    /**
     * Affiche la page d'accueil du portfolio.
     *
     * @param Request $request
     * @param AnalyticsService $analytics
     * @return View
     */
    public function index(Request $request, AnalyticsService $analytics): View
    {
        // Enregistrement de la visite
        $analytics->recordVisit($request);

        // Récupération des données
        $projects = Project::latest()->get();
        $skills = Skill::all()->groupBy('category');
        $stats = [
            'views' => $analytics->getTotalViews(),
            'unique' => $analytics->getTotalUniqueVisits(),
        ];
        
        // Récupère l'utilisateur admin par son email pour plus de fiabilité
        $adminUser = User::first();

        return view('welcome', compact('projects', 'skills', 'stats', 'adminUser'));
    }

    public function sendContact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return response()->json(['success' => true, 'message' => 'Message envoyé avec succès !']);
    }
}
