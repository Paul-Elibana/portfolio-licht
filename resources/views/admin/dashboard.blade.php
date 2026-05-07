@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-bold tracking-tight">Tableau de bord</h1>
            <p class="text-slate-400 mt-2 text-sm uppercase tracking-widest">Statistiques globales de HubFolio</p>
        </div>
        <div class="text-xs font-mono text-slate-600">
            {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <x-glass-card :hover="false">
            <div class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-mono">Total Vues</div>
            <div class="text-3xl font-bold text-accent-primary">{{ number_format($stats['total_views']) }}</div>
        </x-glass-card>

        <x-glass-card :hover="false">
            <div class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-mono">Visiteurs Uniques</div>
            <div class="text-3xl font-bold text-accent-secondary">{{ number_format($stats['unique_visitors']) }}</div>
        </x-glass-card>

        <x-glass-card :hover="false">
            <div class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-mono">Projets</div>
            <div class="text-3xl font-bold">{{ $stats['projects_count'] }}</div>
        </x-glass-card>

        <x-glass-card :hover="false">
            <div class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-mono">Compétences</div>
            <div class="text-3xl font-bold">{{ $stats['skills_count'] }}</div>
        </x-glass-card>

        <x-glass-card :hover="false">
            <div class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-mono">Messages</div>
            <div class="flex items-center gap-2">
                <div class="text-3xl font-bold">{{ $stats['messages_count'] }}</div>
                @if($stats['unread_messages'] > 0)
                    <span class="px-2 py-0.5 rounded-full bg-accent-primary/20 text-accent-primary text-xs font-bold border border-accent-primary/30">
                        {{ $stats['unread_messages'] }} non lus
                    </span>
                @endif
            </div>
        </x-glass-card>
    </div>

    {{-- Messages de contact --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold flex items-center gap-3">
                Messages reçus
                @if($stats['unread_messages'] > 0)
                    <span class="w-2.5 h-2.5 rounded-full bg-accent-primary animate-pulse inline-block"></span>
                @endif
            </h2>
            <span class="text-xs text-slate-500 font-mono">{{ $stats['messages_count'] }} au total</span>
        </div>

        <x-glass-card :hover="false" class="overflow-hidden p-0">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-500 uppercase tracking-widest border-b border-white/10">
                    <tr>
                        <th class="px-5 py-4">Expéditeur</th>
                        <th class="px-5 py-4">Sujet</th>
                        <th class="px-5 py-4 hidden md:table-cell">Message</th>
                        <th class="px-5 py-4">Date</th>
                        <th class="px-5 py-4">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($stats['recent_messages'] as $msg)
                        <tr class="hover:bg-white/5 transition-colors {{ $msg->read_at ? '' : 'bg-accent-primary/3' }}">
                            <td class="px-5 py-4">
                                <div class="font-medium text-sm text-slate-200">{{ $msg->name }}</div>
                                <div class="text-xs text-slate-500">{{ $msg->email }}</div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-300 max-w-[160px] truncate">{{ $msg->subject }}</td>
                            <td class="px-5 py-4 text-xs text-slate-400 max-w-[220px] truncate hidden md:table-cell">{{ $msg->message }}</td>
                            <td class="px-5 py-4 text-xs text-slate-500 font-mono whitespace-nowrap">
                                {{ $msg->created_at?->format('d/m/y H:i') ?? '—' }}
                            </td>
                            <td class="px-5 py-4">
                                @if($msg->read_at)
                                    <span class="px-2 py-0.5 rounded-full bg-white/5 text-slate-500 text-xs border border-white/10">Lu</span>
                                @else
                                    <form action="{{ route('messages.read', $msg) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-2 py-0.5 rounded-full bg-accent-primary/15 text-accent-primary text-xs border border-accent-primary/30 font-medium hover:bg-accent-primary/25 transition-colors">
                                            Nouveau
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">
                                Aucun message reçu pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-glass-card>
    </div>

    {{-- Zone de maintenance --}}
    <div class="space-y-4">
        <h2 class="text-2xl font-bold">Maintenance</h2>
        <x-glass-card :hover="false">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 p-4 rounded-xl bg-white/3 border border-white/5 space-y-2">
                    <p class="text-sm font-medium text-slate-200">Réinitialiser les visites</p>
                    <p class="text-xs text-slate-500">Efface tout l'historique d'analytics. Action irréversible.</p>
                    <form action="{{ route('reset.visits') }}" method="POST" onsubmit="return confirm('Supprimer definitivement toutes les visites ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="mt-2 text-xs px-4 py-2 rounded-xl border border-red-400/30 text-red-400 hover:bg-red-400/10 transition-all font-medium">
                            Effacer l'historique
                        </button>
                    </form>
                </div>
                <div class="flex-1 p-4 rounded-xl bg-white/3 border border-white/5 space-y-2">
                    <p class="text-sm font-medium text-slate-200">Réinitialiser les messages</p>
                    <p class="text-xs text-slate-500">Supprime tous les messages de contact reçus.</p>
                    <form action="{{ route('reset.messages') }}" method="POST" onsubmit="return confirm('Supprimer definitivement tous les messages de contact ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="mt-2 text-xs px-4 py-2 rounded-xl border border-red-400/30 text-red-400 hover:bg-red-400/10 transition-all font-medium">
                            Effacer les messages
                        </button>
                    </form>
                </div>
            </div>
        </x-glass-card>
    </div>

    {{-- Dernières visites --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Dernières visites</h2>
            <span class="text-xs text-slate-500 font-mono">50 dernières</span>
        </div>
        <x-glass-card :hover="false" class="overflow-hidden p-0">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-xs text-slate-500 uppercase tracking-widest border-b border-white/10">
                    <tr>
                        <th class="px-5 py-4">Date</th>
                        <th class="px-5 py-4">IP Address</th>
                        <th class="px-5 py-4 hidden md:table-cell">User Agent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($stats['recent_visits']->take(50) as $visit)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="px-5 py-3 text-xs font-mono text-slate-400">
                                {{ $visit->created_at?->format('d/m/y H:i') ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-sm text-accent-primary font-mono">{{ $visit->ip_address }}</td>
                            <td class="px-5 py-3 text-xs text-slate-500 truncate max-w-xs hidden md:table-cell">{{ Str::limit($visit->user_agent, 60) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-slate-500 italic">Aucune visite enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-glass-card>
    </div>
</div>
@endsection
