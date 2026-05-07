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
        <div class="p-4 bg-accent-primary/20 border border-accent-primary/30 text-accent-primary rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-10">
        <!-- Formulaire d'ajout rapide -->
        <div class="lg:col-span-1">
            <x-glass-card :hover="false">
                <h3 class="text-lg font-bold mb-6">Ajouter une compétence</h3>
                <form action="{{ route('admin.skills.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nom</label>
                        <input type="text" name="name" placeholder="Ex: React, Docker..." required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Catégorie</label>
                        <select name="category" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                            <option value="Frontend">Frontend</option>
                            <option value="Backend">Backend</option>
                            <option value="DevOps">DevOps</option>
                            <option value="Design">Design</option>
                            <option value="Outils">Outils</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full neon-btn">AJOUTER</button>
                </form>
            </x-glass-card>
        </div>

        <!-- Liste des compétences -->
        <div class="lg:col-span-2 space-y-6">
            @forelse($skills as $category => $items)
                <x-glass-card :hover="false">
                    <h3 class="text-xs font-bold text-accent-secondary uppercase tracking-widest mb-4">{{ $category }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($items as $skill)
                            <div class="flex justify-between items-center p-3 bg-white/5 rounded-xl group">
                                <span class="text-sm font-medium">{{ $skill->name }}</span>
                                <form action="{{ route('admin.skills.delete', $skill) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-600 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-all">🗑️</button>
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
@endsection
