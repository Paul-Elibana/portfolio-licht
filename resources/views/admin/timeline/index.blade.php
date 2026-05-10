@extends('layouts.admin')

@section('content')
<div class="space-y-8">

    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Parcours</h1>
            <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Formations & expériences affichées sur le portfolio</p>
        </div>
        <a href="{{ route('admin.timeline.create') }}" class="neon-btn text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle entrée
        </a>
    </div>

    @if(session('success'))
        <div class="glass border border-green-400/20 text-green-400 px-5 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <x-glass-card :hover="false" class="overflow-hidden p-0">
        @if($entries->isEmpty())
            <div class="text-center py-20 text-slate-500">
                <div class="text-4xl mb-4">📋</div>
                <p class="italic">Aucune entrée pour l'instant.</p>
                <a href="{{ route('admin.timeline.create') }}" class="neon-btn text-sm mt-5 inline-flex">Ajouter la première entrée</a>
            </div>
        @else
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-500 uppercase tracking-widest border-b border-white/10">
                    <tr>
                        <th class="px-5 py-4 w-10">#</th>
                        <th class="px-5 py-4">Titre</th>
                        <th class="px-5 py-4 hidden lg:table-cell">Organisation</th>
                        <th class="px-5 py-4 hidden md:table-cell">Période</th>
                        <th class="px-5 py-4">Type</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($entries as $entry)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-5 py-4 text-xl">{{ $entry->icon }}</td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-sm text-slate-200">{{ $entry->title }}</div>
                                <div class="text-xs text-slate-500 lg:hidden">{{ $entry->organization }}</div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-400 hidden lg:table-cell">{{ $entry->organization }}</td>
                            <td class="px-5 py-4 text-xs font-mono text-slate-500 hidden md:table-cell">{{ $entry->date_label }}</td>
                            <td class="px-5 py-4">
                                @if($entry->type === 'exp')
                                    <span class="px-2.5 py-1 rounded-full text-xs bg-accent-primary/10 text-accent-primary border border-accent-primary/20">Expérience</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs bg-accent-secondary/10 text-accent-secondary border border-accent-secondary/20">Formation</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.timeline.edit', $entry) }}"
                                       class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-slate-400 hover:text-accent-primary hover:border-accent-primary/30 transition-all">
                                        Modifier
                                    </a>
                                    <form action="{{ route('admin.timeline.delete', $entry) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cette entrée ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-xs px-3 py-1.5 rounded-lg border border-white/10 text-slate-500 hover:text-red-400 hover:border-red-400/30 transition-all">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </x-glass-card>

    <p class="text-xs text-slate-600 font-mono">
        Ordre d'affichage : du plus petit numéro d'ordre au plus grand. Modifiez le champ "Ordre" pour réorganiser.
    </p>
</div>
@endsection
