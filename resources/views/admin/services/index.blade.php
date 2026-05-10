@extends('layouts.admin')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text">Services</h1>
            <p class="text-slate-400 mt-1 text-sm">Gérez les services que vous proposez sur votre portfolio.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="neon-btn text-sm py-2 px-5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter un service
        </a>
    </div>

    @if(session('success'))
        <div class="glass border border-accent-primary/30 text-accent-primary px-5 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Services list --}}
    @if($services->isEmpty())
        <div class="glass rounded-2xl p-12 text-center text-slate-500">
            Aucun service pour l'instant. Cliquez sur « Ajouter un service » pour commencer.
        </div>
    @else
        <div class="space-y-3">
            @foreach($services as $service)
                <div class="glass rounded-2xl p-5 flex items-center gap-5">
                    {{-- Icon preview --}}
                    <div class="w-12 h-12 rounded-xl flex-shrink-0 flex items-center justify-center
                        {{ $service->color === 'secondary' ? 'bg-accent-secondary/10 border border-accent-secondary/20' : 'bg-accent-primary/10 border border-accent-primary/20' }}">
                        @if($service->icon_svg)
                            <svg class="w-6 h-6 {{ $service->color === 'secondary' ? 'text-accent-secondary' : 'text-accent-primary' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $service->icon_svg !!}
                            </svg>
                        @else
                            <span class="text-xl">🛠</span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="font-semibold text-slate-100 truncate">{{ $service->title }}</h3>
                            @if(!$service->is_active)
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-700 text-slate-400">Masqué</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $service->description }}</p>
                        @if($service->tags)
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($service->tags as $tag)
                                    <span class="text-[10px] px-2 py-0.5 rounded-full
                                        {{ $service->color === 'secondary' ? 'bg-accent-secondary/10 text-accent-secondary' : 'bg-accent-primary/10 text-accent-primary' }}">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('admin.services.edit', $service) }}"
                           class="px-3 py-1.5 text-xs rounded-lg border border-white/10 text-slate-300 hover:bg-white/5 transition-all">
                            Modifier
                        </a>
                        <form action="{{ route('admin.services.delete', $service) }}" method="POST"
                              onsubmit="return confirm('Supprimer ce service ?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 text-xs rounded-lg border border-red-500/20 text-red-400 hover:bg-red-500/10 transition-all">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
