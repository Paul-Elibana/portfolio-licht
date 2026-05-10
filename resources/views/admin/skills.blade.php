@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Compétences</h1>
            <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Gérez vos domaines d'expertise technique</p>
        </div>
    </div>

    @if(session('success'))
        <div class="glass border border-green-400/20 text-green-400 px-5 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-10">

        {{-- Formulaire d'ajout --}}
        <div class="lg:col-span-1">
            <x-glass-card :hover="false">
                <h3 class="text-sm font-bold text-accent-primary uppercase tracking-widest mb-6">Ajouter une compétence</h3>
                <form action="{{ route('admin.skills.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Nom *</label>
                        <input type="text" name="name" placeholder="Ex: React, Docker..." required class="contact-input">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Catégorie *</label>
                        <select name="category" required class="contact-input">
                            @foreach(['Backend','Frontend','DevOps','Design','Tools','Outils'] as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 uppercase tracking-wide mb-1.5">Niveau (%) *</label>
                        <div class="flex items-center gap-3">
                            <input type="range" name="level" min="10" max="100" step="5" value="75"
                                   id="level-range" class="flex-1 accent-cyan-400">
                            <span id="level-display" class="text-sm font-mono text-accent-primary w-10 text-right">75%</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full neon-btn text-sm">Ajouter</button>
                </form>
            </x-glass-card>
        </div>

        {{-- Liste des compétences --}}
        <div class="lg:col-span-2 space-y-6">
            @forelse($skills as $category => $items)
                <x-glass-card :hover="false">
                    <h3 class="text-xs font-bold text-accent-secondary uppercase tracking-widest mb-5">{{ $category }}</h3>
                    <div class="space-y-3">
                        @foreach($items as $skill)
                            <div class="flex items-center gap-4 group p-3 rounded-xl hover:bg-white/5 transition-colors">
                                <span class="text-sm font-medium text-slate-200 w-28 shrink-0">{{ $skill->name }}</span>
                                {{-- Barre de niveau éditable --}}
                                <form action="{{ route('admin.skills.update', $skill) }}" method="POST"
                                      class="flex-1 flex items-center gap-3" id="skill-form-{{ $skill->id }}">
                                    @csrf @method('PUT')
                                    <input type="range" name="level" min="10" max="100" step="5"
                                           value="{{ $skill->level ?? 75 }}"
                                           class="flex-1 accent-cyan-400 skill-range"
                                           data-id="{{ $skill->id }}"
                                           oninput="document.getElementById('lv-{{ $skill->id }}').textContent=this.value+'%'">
                                    <span id="lv-{{ $skill->id }}" class="text-xs font-mono text-accent-primary w-10 text-right">{{ $skill->level ?? 75 }}%</span>
                                    <button type="submit"
                                            class="text-xs px-3 py-1 rounded-lg border border-white/10 text-slate-500 hover:text-accent-primary hover:border-accent-primary/30 transition-all opacity-0 group-hover:opacity-100">
                                        ✓
                                    </button>
                                </form>
                                {{-- Supprimer --}}
                                <form action="{{ route('admin.skills.delete', $skill) }}" method="POST"
                                      onsubmit="return confirm('Supprimer {{ $skill->name }} ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="text-slate-600 hover:text-red-400 transition-colors opacity-0 group-hover:opacity-100 text-sm">🗑</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </x-glass-card>
            @empty
                <x-glass-card :hover="false" class="text-center py-20">
                    <p class="text-slate-500 italic">Aucune compétence enregistrée.</p>
                </x-glass-card>
            @endforelse
        </div>
    </div>
</div>

<script>
const range = document.getElementById('level-range');
const display = document.getElementById('level-display');
if (range) range.addEventListener('input', () => { display.textContent = range.value + '%'; });
</script>
@endsection
