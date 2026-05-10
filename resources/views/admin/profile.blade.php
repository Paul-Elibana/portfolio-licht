@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-10">
    <div>
        <h1 class="text-4xl font-bold tracking-tight">Mon Profil</h1>
        <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Informations affichées sur le portfolio public</p>
    </div>

    @if(session('success'))
        <div class="glass border border-green-400/20 text-green-400 px-5 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="glass border border-red-400/20 text-red-400 px-5 py-3 rounded-xl text-sm space-y-1">
            @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- ── Section : Identité & Photo ──────────────────────── --}}
        <x-glass-card :hover="false">
            <h2 class="text-sm font-bold text-accent-primary uppercase tracking-widest mb-6">Identité & Photo</h2>

            <div class="flex flex-col sm:flex-row gap-8 items-start">
                {{-- Photo de profil --}}
                <div class="space-y-3 shrink-0">
                    <label class="block text-xs text-slate-400 uppercase tracking-widest">Photo de profil</label>
                    <div class="relative group w-36 h-36">
                        <div class="w-36 h-36 rounded-2xl overflow-hidden bg-slate-900 border border-white/10">
                            <img id="profile-preview"
                                 src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo).'?v='.($user->updated_at?->timestamp ?? time()) : '' }}"
                                 alt="Photo"
                                 class="{{ $user->profile_photo ? 'block' : 'hidden' }} w-full h-full object-cover">
                            <div id="profile-placeholder"
                                 class="{{ $user->profile_photo ? 'hidden' : 'flex' }} w-full h-full items-center justify-center bg-slate-900">
                                <svg viewBox="0 0 80 80" width="64" height="64" fill="none">
                                    <circle cx="40" cy="30" r="16" fill="#1e293b" stroke="#334155" stroke-width="2"/>
                                    <circle cx="40" cy="30" r="10" fill="#334155"/>
                                    <path d="M12 72c0-15.464 12.536-28 28-28s28 12.536 28 28" stroke="#334155" stroke-width="2" stroke-linecap="round" fill="#1e293b"/>
                                    <circle cx="40" cy="30" r="5" fill="#06b6d4" opacity="0.6"/>
                                </svg>
                            </div>
                        </div>
                        <label for="profile_photo"
                               class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-2xl gap-1">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-[10px] text-white">Changer</span>
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" class="hidden" accept="image/*"
               data-cropper-preview="profile-preview"
               data-cropper-placeholder="profile-placeholder"
               data-cropper-ratio="1">
                    </div>
                    <p class="text-[10px] text-slate-600 leading-relaxed">JPG, PNG, WEBP · Max 3 Mo</p>
                    @if($user->profile_photo)
                        <button type="button"
                                onclick="if(confirm('Supprimer la photo de profil ?')) document.getElementById('delete-photo-form').submit()"
                                class="text-[10px] text-red-400 hover:text-red-300 transition-colors underline">
                            Supprimer la photo
                        </button>
                    @endif
                    @error('profile_photo') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                </div>

                {{-- Nom + email connexion + mdp --}}
                <div class="flex-1 space-y-5 w-full">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Nom complet *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="contact-input">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Email de connexion *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="contact-input">
                            <p class="text-[10px] text-slate-600 mt-1">Utilisé pour vous connecter à l'admin</p>
                        </div>
                    </div>

                    <div class="border-t border-white/5 pt-5">
                        <p class="text-xs text-slate-500 mb-4 uppercase tracking-wide">Mot de passe (laisser vide = inchangé)</p>
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Nouveau mot de passe</label>
                                <input type="password" name="password" class="contact-input">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Confirmer</label>
                                <input type="password" name="password_confirmation" class="contact-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-glass-card>

        {{-- ── Section : Coordonnées publiques ─────────────────── --}}
        <x-glass-card :hover="false">
            <h2 class="text-sm font-bold text-accent-primary uppercase tracking-widest mb-6">Coordonnées publiques</h2>
            <p class="text-xs text-slate-500 mb-6 -mt-3">Ces informations apparaissent dans la section Contact du portfolio.</p>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Email affiché publiquement</label>
                    <input type="email" name="public_email" value="{{ old('public_email', $user->public_email) }}"
                           class="contact-input" placeholder="{{ $user->email }}">
                    <p class="text-[10px] text-slate-600 mt-1">Si vide, l'email de connexion est utilisé</p>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Téléphone / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="contact-input" placeholder="+241 77 519 644">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">URL GitHub</label>
                    <input type="url" name="github_url" value="{{ old('github_url', $user->github_url) }}"
                           class="contact-input" placeholder="https://github.com/votre-profil">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">URL LinkedIn</label>
                    <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}"
                           class="contact-input" placeholder="https://linkedin.com/in/votre-profil">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Localisation</label>
                    <input type="text" name="location" value="{{ old('location', $user->location) }}"
                           class="contact-input" placeholder="Libreville, Gabon">
                </div>
            </div>
        </x-glass-card>

        {{-- ── Section : Statut de disponibilité ───────────────── --}}
        <x-glass-card :hover="false">
            <h2 class="text-sm font-bold text-accent-primary uppercase tracking-widest mb-6">Statut de disponibilité</h2>
            <p class="text-xs text-slate-500 mb-6 -mt-3">Affiché dans le hero, la section Contact et le footer du portfolio.</p>

            <div class="space-y-5">
                <div class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10">
                    <div>
                        <p class="text-sm font-medium text-slate-200">Disponible pour de nouvelles missions</p>
                        <p class="text-xs text-slate-500 mt-0.5">Active le badge vert sur le portfolio</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1" class="sr-only peer"
                               {{ old('is_available', $user->is_available ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                                    peer-checked:bg-accent-primary"></div>
                    </label>
                </div>

                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Message de statut personnalisé</label>
                    <input type="text" name="availability_text" value="{{ old('availability_text', $user->availability_text) }}"
                           class="contact-input" maxlength="100"
                           placeholder="Disponible pour de nouveaux projets">
                    <p class="text-[10px] text-slate-600 mt-1">Texte affiché sous le badge de disponibilité</p>
                </div>
            </div>
        </x-glass-card>

        <div class="flex justify-end">
            <button type="submit" class="neon-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer toutes les modifications
            </button>
        </div>
    </form>

    {{-- Standalone form for photo deletion (outside main form to avoid nesting) --}}
    <form id="delete-photo-form" action="{{ route('admin.profile.photo.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    initCropperInput('profile_photo', 'profile-preview', 'profile-placeholder', 1);
});
</script>
@endsection
