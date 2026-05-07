<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Visit;
use App\Models\PublicDocument;
use App\Models\ContactMessage;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function loginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard(AnalyticsService $analytics): View
    {
        $stats = [
            'total_views'     => $analytics->getTotalViews(),
            'unique_visitors' => $analytics->getTotalUniqueVisits(),
            'projects_count'  => Project::count(),
            'skills_count'    => Skill::count(),
            'messages_count'  => ContactMessage::count(),
            'unread_messages' => ContactMessage::whereNull('read_at')->count(),
            'recent_messages' => ContactMessage::latest()->take(20)->get(),
            'recent_visits'   => Visit::orderBy('created_at', 'desc')->take(50)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function profile(): View
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function projects(): View
    {
        $projects = Project::latest()->get();
        return view('admin.projects', compact('projects'));
    }

    public function createProject(): View
    {
        return view('admin.projects.create');
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'technologies' => ['required', 'string'], // Sera converti en array
            'image_path' => ['nullable', 'image', 'max:2048'],
            'github_url' => ['nullable', 'url'],
            'live_url' => ['nullable', 'url'],
        ]);

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->technologies = array_map('trim', explode(',', $request->technologies));
        $project->github_url = $request->github_url;
        $project->live_url = $request->live_url;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('projects', 'public');
            $project->image_path = $path;
        }

        $project->save();

        return redirect()->route('admin.projects')->with('success', 'Projet ajouté avec succès.');
    }

    public function editProject(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'technologies' => ['required', 'string'],
            'image_path' => ['nullable', 'image', 'max:2048'],
            'github_url' => ['nullable', 'url'],
            'live_url' => ['nullable', 'url'],
        ]);

        $project->title = $request->title;
        $project->description = $request->description;
        $project->technologies = array_map('trim', explode(',', $request->technologies));
        $project->github_url = $request->github_url;
        $project->live_url = $request->live_url;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('projects', 'public');
            $project->image_path = $path;
        }

        $project->save();

        return redirect()->route('admin.projects')->with('success', 'Projet mis à jour.');
    }

    public function deleteProject(Project $project): RedirectResponse
    {
        $project->delete();
        return back()->with('success', 'Projet supprimé.');
    }

    public function skills(): View
    {
        $skills = Skill::all()->groupBy('category');
        return view('admin.skills', compact('skills'));
    }

    public function storeSkill(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        Skill::create($request->only('name', 'category'));

        return back()->with('success', 'Compétence ajoutée.');
    }

    public function deleteSkill(Skill $skill): RedirectResponse
    {
        $skill->delete();
        return back()->with('success', 'Compétence supprimée.');
    }

    public function documents(): View
    {
        $documents = PublicDocument::orderBy('issue_date', 'desc')->get();
        return view('admin.documents', compact('documents'));
    }

    public function createDocument(): View
    {
        return view('admin.public-documents.create');
    }

    public function storeDocument(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'issue_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'document_path' => ['required', 'file', 'mimes:pdf,jpg,png,jpeg,gif,svg', 'max:5120'], // Max 5MB
            'description' => ['nullable', 'string'],
        ]);

        $file = $request->file('document_path');
        $filename = $file->getClientOriginalName();
        
        // Gérer les doublons avec un timestamp
        $path_to_save = 'documents/' . $filename;
        if (Storage::disk('public')->exists($path_to_save)) {
            $filename = time() . '_' . $filename;
            $path_to_save = 'documents/' . $filename;
        }

        // Stocker dans le disque 'public'
        $file->storeAs('documents', $filename, 'public');

        PublicDocument::create([
            'title' => $request->title,
            'issuer' => $request->issuer,
            'issue_date' => $request->issue_date,
            'expiry_date' => $request->expiry_date,
            'document_path' => $path_to_save,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.documents')->with('success', 'Document public ajouté avec succès.');
    }

    public function editDocument(PublicDocument $document): View
    {
        return view('admin.public-documents.edit', compact('document'));
    }

    public function updateDocument(Request $request, PublicDocument $document): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'issue_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'document_path' => ['nullable', 'file', 'mimes:pdf,jpg,png,jpeg,gif,svg', 'max:5120'], // Max 5MB
            'description' => ['nullable', 'string'],
        ]);

        $document->title = $request->title;
        $document->issuer = $request->issuer;
        $document->issue_date = $request->issue_date;
        $document->expiry_date = $request->expiry_date;
        $document->description = $request->description;

        if ($request->hasFile('document_path')) {
            // Supprimer l'ancien fichier si une nouvelle image est uploadée
            if ($document->document_path) {
                Storage::disk('public')->delete($document->document_path);
            }
            $file = $request->file('document_path');
            $filename = $file->getClientOriginalName();
            $path_to_save = 'documents/' . $filename;
            if (Storage::disk('public')->exists($path_to_save)) {
                $filename = time() . '_' . $filename;
                $path_to_save = 'documents/' . $filename;
            }
            $file->storeAs('documents', $filename, 'public');
            $document->document_path = $path_to_save;
        }

        $document->save();

        return redirect()->route('admin.documents')->with('success', 'Document public mis à jour.');
    }

    public function deleteDocument($document_id): RedirectResponse
    {
        $document = PublicDocument::findOrFail($document_id);
        // Supprimer le fichier du disque public
        if ($document->document_path) {
            Storage::disk('public')->delete($document->document_path);
        }
        $document->delete();
        return back()->with('success', 'Document public supprimé.');
    }
}
