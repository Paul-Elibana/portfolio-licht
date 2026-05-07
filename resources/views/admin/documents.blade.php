@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Coffre-fort Numérique</h1>
            <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Stockage sécurisé pour vos documents personnels sensibles</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-accent-primary/20 border border-accent-primary/30 text-accent-primary rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-10">
        <!-- Upload Form -->
        <div class="lg:col-span-1">
            <x-glass-card :hover="false">
                <h3 class="text-lg font-bold mb-6">Ajouter un document</h3>
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-accent-primary transition-colors cursor-pointer relative">
                        <input type="file" name="document" required class="absolute inset-0 opacity-0 cursor-pointer">
                        <div class="text-4xl mb-2">📁</div>
                        <p class="text-xs text-slate-500 uppercase font-mono">Glisser-déposer ou cliquer pour choisir</p>
                    </div>
                    <p class="text-[10px] text-slate-500 italic">Formats acceptés : PDF, JPG, PNG (Max 5Mo)</p>
                    <button type="submit" class="w-full neon-btn">TÉLÉVERSER</button>
                </form>
            </x-glass-card>
        </div>

        <!-- Document List -->
        <div class="lg:col-span-2">
            <x-glass-card :hover="false" class="overflow-hidden p-0">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-xs text-slate-500 uppercase tracking-widest border-b border-white/10">
                        <tr>
                            <th class="px-6 py-4">Nom du fichier</th>
                            <th class="px-6 py-4">Taille</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xl">📄</span>
                                        <span class="text-sm font-medium">{{ $doc['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 font-mono">{{ $doc['size'] }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500 font-mono">{{ $doc['date'] }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.documents.download', $doc['name']) }}" class="inline-block p-2 bg-white/5 rounded-lg hover:text-accent-primary transition-all">⬇️</a>
                                    <form action="{{ route('admin.documents.delete', $doc['name']) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer définitivement ce document ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white/5 rounded-lg hover:text-red-400 transition-all">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500 italic">Le coffre-fort est vide.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-glass-card>
        </div>
    </div>
</div>
@endsection
