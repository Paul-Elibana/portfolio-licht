@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Projets</h1>
            <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Gérez vos réalisations affichées sur le portfolio</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="neon-btn text-sm">
            + NOUVEAU PROJET
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-accent-primary/20 border border-accent-primary/30 text-accent-primary rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            <x-glass-card :hover="false" class="group relative">
                <div class="absolute top-4 right-4 flex gap-2 z-10">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="p-2 bg-white/5 rounded-lg hover:text-accent-primary transition-colors">✏️</a>
                    <form action="{{ route('admin.projects.delete', $project) }}" method="POST" onsubmit="return confirm('Supprimer ce projet ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-white/5 rounded-lg hover:text-red-400 transition-colors">🗑️</button>
                    </form>
                </div>

                <div class="aspect-video bg-slate-900 rounded-lg mb-6 overflow-hidden">
                    <div class="w-full h-full flex items-center justify-center text-slate-700 bg-gradient-to-br from-slate-900 to-black uppercase font-mono text-xs">
                        @if($project->image_path)
                            <img src="{{ asset('storage/' . $project->image_path) }}" class="w-full h-full object-cover">
                        @else
                            [IMAGE: {{ $project->title }}]
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-xl font-bold">{{ $project->title }}</h3>
                    <p class="text-sm text-slate-400 line-clamp-2">{{ $project->description }}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->technologies as $tech)
                            <x-badge variant="neutral">{{ $tech }}</x-badge>
                        @endforeach
                    </div>
                </div>
            </x-glass-card>
        @empty
            <x-glass-card :hover="false" class="col-span-full text-center py-20">
                <p class="text-slate-500 italic">Aucun projet pour le moment. Commencez par en ajouter un !</p>
            </x-glass-card>
        @endforelse
    </div>
</div>
@endsection
