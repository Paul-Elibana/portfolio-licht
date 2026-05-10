<?php

namespace App\Http\Controllers;

use App\Mail\NewContactMessage;
use App\Models\Project;
use App\Models\Skill;
use App\Models\TimelineEntry;
use App\Models\User;
use App\Models\ContactMessage;
use App\Models\PublicDocument;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
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
        $projects  = Project::latest()->get();
        $skills    = Skill::all()->groupBy('category');
        $assets    = PublicDocument::all()->groupBy('type');
        $timeline  = TimelineEntry::orderBy('sort_order')->orderBy('id')->get();
        $stats     = [
            'views'  => $analytics->getTotalViews(),
            'unique' => $analytics->getTotalUniqueVisits(),
        ];
        $adminUser = User::first();

        return view('welcome', compact('projects', 'skills', 'stats', 'adminUser', 'assets', 'timeline'));
    }

    public function sendContact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $message = ContactMessage::create($validated);

        // Notification par email si MAIL_MAILER est configuré
        if (config('mail.default') !== 'log' && config('mail.mailers.' . config('mail.default') . '.transport') !== 'log') {
            $adminEmail = User::first()?->email;
            if ($adminEmail) {
                try {
                    Mail::to($adminEmail)->send(new NewContactMessage($message));
                } catch (\Exception) {
                    // L'email échoue silencieusement — le message est déjà sauvegardé en DB
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Message envoyé avec succès !']);
    }

    public function carte(): View
    {
        $adminUser = User::first();
        return view('public.carte', compact('adminUser'));
    }
}
