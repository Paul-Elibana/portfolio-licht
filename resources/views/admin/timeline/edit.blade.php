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
            <h1 class="text-4xl font-bold tracking-tight">Modifier l'entrée</h1>
            <p class="text-slate-400 mt-1 text-sm uppercase tracking-widest">{{ $entry->title }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="glass border border-red-400/20 text-red-400 px-5 py-3 rounded-xl text-sm space-y-1">
            @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
        </div>
    @endif

    @if(session('success'))
        <div class="glass border border-green-400/20 text-green-400 px-5 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <x-glass-card :hover="false">
        <form action="{{ route('admin.timeline.update', $entry) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Icône (emoji) *</label>
                    <input type="text" name="icon" value="{{ old('icon', $entry->icon) }}"
                           class="contact-input text-2xl" maxlength="20" placeholder="🚀">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Type *</label>
                    <select name="type" class="contact-input" required>
                        <option value="exp" {{ old('type', $entry->type) === 'exp' ? 'selected' : '' }}>Expérience professionnelle</option>
                        <option value="edu" {{ old('type', $entry->type) === 'edu' ? 'selected' : '' }}>Formation / Diplôme</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Intitulé *</label>
                <input type="text" name="title" value="{{ old('title', $entry->title) }}"
                       class="contact-input" required maxlength="255">
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Organisation / Établissement *</label>
                <input type="text" name="organization" value="{{ old('organization', $entry->organization) }}"
                       class="contact-input" required maxlength="255">
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Période *</label>
                <input type="text" name="date_label" value="{{ old('date_label', $entry->date_label) }}"
                       class="contact-input" required maxlength="100">
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Description</label>
                <textarea name="description" rows="4" class="contact-input resize-none" maxlength="1000"
                          id="desc-ta">{{ old('description', $entry->description) }}</textarea>
                <p class="text-xs text-slate-600 mt-1 text-right">
                    <span id="desc-count">{{ strlen(old('description', $entry->description ?? '')) }}</span>/1000
                </p>
            </div>

            <div>
                <label class="block text-xs text-slate-400 uppercase tracking-wide mb-2">Ordre d'affichage</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $entry->sort_order) }}"
                       class="contact-input w-32" min="0" max="9999">
            </div>

            <div class="flex gap-4 pt-2">
                <button type="submit" class="neon-btn text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.timeline') }}" class="ghost-btn text-sm">Annuler</a>
            </div>
        </form>
    </x-glass-card>

    {{-- Danger zone --}}
    <x-glass-card :hover="false" class="border border-red-400/10">
        <h3 class="text-sm font-bold text-red-400 mb-4">Zone dangereuse</h3>
        <form action="{{ route('admin.timeline.delete', $entry) }}" method="POST"
              onsubmit="return confirm('Supprimer définitivement cette entrée ?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="text-sm px-4 py-2 rounded-xl border border-red-400/20 text-red-400 hover:bg-red-400/10 transition-all">
                Supprimer cette entrée
            </button>
        </form>
    </x-glass-card>
</div>

<script>
const ta = document.getElementById('desc-ta');
const counter = document.getElementById('desc-count');
if (ta && counter) {
    ta.addEventListener('input', () => { counter.textContent = ta.value.length; });
}
</script>
@endsection
