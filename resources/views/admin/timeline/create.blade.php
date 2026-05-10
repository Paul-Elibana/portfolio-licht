@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-2xl">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.timeline') }}" class="text-slate-500 hover:text-accent-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Nouvelle entrée</h1>
            <p class="text-slate-400 mt-1 text-sm uppercase tracking-widest">Formation ou expérience professionnelle</p>
        </div>
    </div>

    @if($errors->any())
        <div class="glass border border-red-400/20 text-red-400 px-5 py-3 rounded-xl text-sm space-y-1">
            @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
        </div>
    @endif

    <x-glass-card :hover="false">
        <form action="{{ route('admin.timeline.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Icône (emoji) *</label>
                    <input type="text" name="icon" value="{{ old('icon', '🚀') }}"
                           class="contact-input text-2xl" maxlength="20" placeholder="🚀">
                    <p class="text-xs text-slate-600 mt-1">Un emoji représentant cette étape</p>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Type *</label>
                    <select name="type" class="contact-input" required>
                        <option value="exp" {{ old('type') === 'exp' ? 'selected' : '' }}>Expérience professionnelle</option>
                        <option value="edu" {{ old('type') === 'edu' ? 'selected' : '' }}>Formation / Diplôme</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Intitulé du poste / diplôme *</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="contact-input" required maxlength="255"
                       placeholder="Ex : Développeur Full-Stack Freelance">
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Organisation / Établissement *</label>
                <input type="text" name="organization" value="{{ old('organization') }}"
                       class="contact-input" required maxlength="255"
                       placeholder="Ex : Université Omar Bongo — Libreville">
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Période *</label>
                <input type="text" name="date_label" value="{{ old('date_label') }}"
                       class="contact-input" required maxlength="100"
                       placeholder="Ex : 2022 — 2024 ou 2024 — Présent">
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Description</label>
                <textarea name="description" rows="4" class="contact-input resize-none" maxlength="1000"
                          placeholder="Décrivez vos missions, apprentissages ou réalisations...">{{ old('description') }}</textarea>
                <p class="text-xs text-slate-600 mt-1 text-right">
                    <span id="desc-count">{{ strlen(old('description', '')) }}</span>/1000
                </p>
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Ordre d'affichage</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                       class="contact-input w-32" min="0" max="9999" placeholder="0">
                <p class="text-xs text-slate-600 mt-1">Les entrées sont triées par ordre croissant (0 = en premier)</p>
            </div>

            <div class="flex gap-4 pt-2">
                <button type="submit" class="neon-btn text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer
                </button>
                <a href="{{ route('admin.timeline') }}" class="ghost-btn text-sm">Annuler</a>
            </div>
        </form>
    </x-glass-card>
</div>

<script>
const ta = document.querySelector('textarea[name="description"]');
const counter = document.getElementById('desc-count');
if (ta && counter) {
    ta.addEventListener('input', () => { counter.textContent = ta.value.length; });
}
</script>
@endsection
