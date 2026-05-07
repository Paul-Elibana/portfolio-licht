@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <div>
        <h1 class="text-4xl font-bold tracking-tight">Nouveau Projet</h1>
        <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Ajoutez une nouvelle réalisation à votre portfolio</p>
    </div>

    <x-glass-card :hover="false">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Titre du projet</label>
                    <input type="text" name="title" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Image (Format image)</label>
                    <input type="file" name="image_path" class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-2.5 text-white">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Description</label>
                <textarea name="description" rows="4" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Technologies (séparées par des virgules)</label>
                <input type="text" name="technologies" placeholder="Ex: Laravel, Tailwind CSS, React" required class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Lien GitHub (URL)</label>
                    <input type="url" name="github_url" class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Lien Live / Démo (URL)</label>
                    <input type="url" name="live_url" class="w-full bg-slate-900/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-accent-primary transition-colors">
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-white/5 gap-4">
                <a href="{{ route('admin.projects') }}" class="px-8 py-3 rounded-xl font-bold border border-white/10 hover:bg-white/5 transition-all">ANNULER</a>
                <button type="submit" class="neon-btn">CRÉER LE PROJET</button>
            </div>
        </form>
    </x-glass-card>
</div>
@endsection
