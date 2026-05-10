<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\TimelineEntry;
use App\Models\Visit;
use App\Models\PublicDocument;
use App\Models\ContactMessage;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /* ─── AUTH ─────────────────────────────────────────────── */

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
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.'])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /* ─── DASHBOARD ─────────────────────────────────────────── */

    public function dashboard(AnalyticsService $analytics): View
    {
        $stats = [
            'total_views'     => $analytics->getTotalViews(),
            'unique_visitors' => $analytics->getTotalUniqueVisits(),
            'projects_count'  => Project::count(),
            'skills_count'    => Skill::count(),
            'assets_count'    => PublicDocument::count(),
            'timeline_count'  => TimelineEntry::count(),
            'messages_count'  => ContactMessage::count(),
            'unread_messages' => ContactMessage::whereNull('read_at')->count(),
            'recent_messages' => ContactMessage::latest()->take(20)->get(),
            'recent_visits'   => Visit::orderBy('created_at', 'desc')->take(50)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function resetVisits(Request $request): RedirectResponse
    {
        Visit::truncate();
        return back()->with('success', 'Historique des visites réinitialisé.');
    }

    public function resetMessages(Request $request): RedirectResponse
    {
        ContactMessage::truncate();
        return back()->with('success', 'Messages de contact supprimés.');
    }

    public function markMessageRead(ContactMessage $message): JsonResponse
    {
        $message->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    /* ─── PROFIL ────────────────────────────────────────────── */

    public function profile(): View
    {
        return view('admin.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'          => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_photo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'public_email'      => ['nullable', 'email', 'max:255'],
            'phone'             => ['nullable', 'string', 'max:50'],
            'github_url'        => ['nullable', 'url', 'max:255'],
            'linkedin_url'      => ['nullable', 'url', 'max:255'],
            'location'          => ['nullable', 'string', 'max:100'],
            'is_available'      => ['nullable', 'boolean'],
            'availability_text' => ['nullable', 'string', 'max:100'],
        ]);

        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->public_email     = $request->public_email;
        $user->phone            = $request->phone;
        $user->github_url       = $request->github_url;
        $user->linkedin_url     = $request->linkedin_url;
        $user->location         = $request->location;
        $user->is_available     = $request->boolean('is_available');
        $user->availability_text = $request->availability_text;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    /* ─── PROJETS ───────────────────────────────────────────── */

    public function projects(): View
    {
        return view('admin.projects', ['projects' => Project::latest()->get()]);
    }

    public function createProject(): View
    {
        return view('admin.projects.create');
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'technologies'=> ['required', 'string'],
            'image_path'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:3072'],
            'github_url'  => ['nullable', 'url'],
            'live_url'    => ['nullable', 'url'],
        ]);

        $project = new Project([
            'title'        => $request->title,
            'description'  => $request->description,
            'technologies' => array_map('trim', explode(',', $request->technologies)),
            'github_url'   => $request->github_url,
            'live_url'     => $request->live_url,
        ]);

        if ($request->hasFile('image_path')) {
            $project->image_path = $request->file('image_path')->store('projects', 'public');
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
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'technologies'=> ['required', 'string'],
            'image_path'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:3072'],
            'github_url'  => ['nullable', 'url'],
            'live_url'    => ['nullable', 'url'],
        ]);

        $project->title        = $request->title;
        $project->description  = $request->description;
        $project->technologies = array_map('trim', explode(',', $request->technologies));
        $project->github_url   = $request->github_url;
        $project->live_url     = $request->live_url;

        if ($request->hasFile('image_path')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $project->image_path = $request->file('image_path')->store('projects', 'public');
        }

        $project->save();

        return redirect()->route('admin.projects')->with('success', 'Projet mis à jour.');
    }

    public function deleteProject(Project $project): RedirectResponse
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }
        $project->delete();
        return back()->with('success', 'Projet supprimé.');
    }

    /* ─── COMPÉTENCES ───────────────────────────────────────── */

    public function skills(): View
    {
        return view('admin.skills', ['skills' => Skill::all()->groupBy('category')]);
    }

    public function storeSkill(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        Skill::create($request->only('name', 'category'));

        return back()->with('success', 'Compétence ajoutée.');
    }

    public function updateSkill(Request $request, Skill $skill): RedirectResponse
    {
        $request->validate(['level' => ['required', 'integer', 'min:10', 'max:100']]);
        $skill->update(['level' => $request->level]);
        return back()->with('success', 'Niveau mis à jour.');
    }

    public function deleteSkill(Skill $skill): RedirectResponse
    {
        $skill->delete();
        return back()->with('success', 'Compétence supprimée.');
    }

    /* ─── ASSETS DU SITE ────────────────────────────────────── */

    public function documents(): View
    {
        $assets = PublicDocument::latest()->get();
        return view('admin.documents', compact('assets'));
    }

    public function storeDocument(Request $request): RedirectResponse
    {
        $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'type'          => ['required', 'string', 'in:' . implode(',', array_keys(PublicDocument::TYPES))],
            'tag'           => ['nullable', 'string', 'max:100'],
            'document_path' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg,pdf', 'max:5120'],
        ]);

        $file     = $request->file('document_path');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('assets', $filename, 'public');

        PublicDocument::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'type'          => $request->type,
            'tag'           => $request->tag,
            'document_path' => 'assets/' . $filename,
        ]);

        return back()->with('success', 'Asset ajouté avec succès.');
    }

    public function editDocument(PublicDocument $document): View
    {
        return view('admin.documents_edit', compact('document'));
    }

    public function updateDocument(Request $request, PublicDocument $document): RedirectResponse
    {
        $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'type'          => ['required', 'string', 'in:' . implode(',', array_keys(PublicDocument::TYPES))],
            'tag'           => ['nullable', 'string', 'max:100'],
            'document_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg,pdf', 'max:5120'],
        ]);

        $document->title       = $request->title;
        $document->description = $request->description;
        $document->type        = $request->type;
        $document->tag         = $request->tag;

        if ($request->hasFile('document_path')) {
            Storage::disk('public')->delete($document->document_path);
            $file     = $request->file('document_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('assets', $filename, 'public');
            $document->document_path = 'assets/' . $filename;
        }

        $document->save();

        return redirect()->route('admin.documents')->with('success', 'Asset mis à jour.');
    }

    public function deleteDocument(PublicDocument $document): RedirectResponse
    {
        Storage::disk('public')->delete($document->document_path);
        $document->delete();
        return back()->with('success', 'Asset supprimé.');
    }

    /* ─── PARCOURS / TIMELINE ───────────────────────────────── */

    public function timeline(): View
    {
        return view('admin.timeline.index', [
            'entries' => TimelineEntry::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function reorderTimeline(Request $request): JsonResponse
    {
        $request->validate(['order' => ['required', 'array'], 'order.*' => ['integer']]);
        foreach ($request->order as $position => $id) {
            TimelineEntry::where('id', $id)->update(['sort_order' => $position]);
        }
        return response()->json(['success' => true]);
    }

    public function createTimeline(): View
    {
        return view('admin.timeline.create');
    }

    public function storeTimeline(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date_label'   => ['required', 'string', 'max:100'],
            'title'        => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'type'         => ['required', 'in:exp,edu'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'icon'         => ['nullable', 'string', 'max:20'],
            'sort_order'   => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $validated['icon']       = $validated['icon'] ?? '🚀';
        $validated['sort_order'] = $validated['sort_order'] ?? TimelineEntry::max('sort_order') + 1;

        TimelineEntry::create($validated);
        return redirect()->route('admin.timeline')->with('success', 'Entrée ajoutée au parcours.');
    }

    public function editTimeline(TimelineEntry $entry): View
    {
        return view('admin.timeline.edit', compact('entry'));
    }

    public function updateTimeline(Request $request, TimelineEntry $entry): RedirectResponse
    {
        $validated = $request->validate([
            'date_label'   => ['required', 'string', 'max:100'],
            'title'        => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'type'         => ['required', 'in:exp,edu'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'icon'         => ['nullable', 'string', 'max:20'],
            'sort_order'   => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $entry->update($validated);
        return redirect()->route('admin.timeline')->with('success', 'Entrée mise à jour.');
    }

    public function deleteTimeline(TimelineEntry $entry): RedirectResponse
    {
        $entry->delete();
        return back()->with('success', 'Entrée supprimée du parcours.');
    }
}
